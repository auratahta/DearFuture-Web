<?php
// File: app/Http/Controllers/Admin/NewsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    /**
     * Display a listing of the news
     */
    public function index(Request $request)
    {
        $query = News::with('author');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Status filter
        if ($request->has('status') && $request->status) {
            $query->byStatus($request->status);
        }

        // Order by latest
        $news = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get statistics
        $stats = [
            'total' => News::count(),
            'published' => News::where('status', 'published')->count(),
            'draft' => News::where('status', 'draft')->count(),
            'announcements' => News::byCategory('announcements')->count(),
            'events' => News::byCategory('events')->count(),
            'academic' => News::byCategory('academic')->count(),
            'featured' => News::featured()->count(),
        ];

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'news' => $news,
                'stats' => $stats,
                'html' => view('admin.news.partials.news-grid', compact('news'))->render()
            ]);
        }

        return view('admin.news.index', compact('news', 'stats'));
    }

    /**
     * Show the form for creating a new news
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news in storage
     */
    public function store(Request $request)
    {
        // Log untuk debugging
        Log::info('=== NEWS STORE START ===');
        Log::info('User Info:', [
            'authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'no email',
            'user_role' => Auth::user()->role ?? 'no role'
        ]);
        Log::info('Request Data:', $request->except(['_token']));

        // Validasi
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|in:announcements,events,academic',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:published,draft',
            'publish_date' => 'required|date',
            'featured' => 'boolean',
            'tags' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Log::error('Validation Failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Validation Passed');

        try {
            // PERBAIKAN: Siapkan semua data yang diperlukan
            $newsData = [
                'title' => $request->title,
                'category' => $request->category,
                'excerpt' => $request->excerpt,
                'content' => $request->content,
                'status' => $request->status,
                'publish_date' => $request->publish_date,
                'author_id' => Auth::id(),
                'featured' => $request->has('featured') ? true : false,
                'views' => 0, // PERBAIKAN: Tambahkan field views
                'tags' => $request->tags // PERBAIKAN: Handle tags langsung
            ];

            Log::info('Basic News Data:', $newsData);

            // Handle image upload
            if ($request->hasFile('image')) {
                Log::info('Processing image upload...');
                
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                // Store original image
                $imagePath = $image->storeAs('news', $imageName, 'public');
                $newsData['image'] = $imagePath;
                
                Log::info('Image uploaded:', ['path' => $imagePath]);
            }

            Log::info('Final News Data:', $newsData);

            // PERBAIKAN: Create news dengan semua data
            Log::info('Creating news in database...');
            $news = News::create($newsData);

            Log::info('News creation result:', [
                'success' => $news ? true : false,
                'news_id' => $news ? $news->id : 'failed',
                'news_title' => $news ? $news->title : 'failed'
            ]);

            // Verifikasi data tersimpan
            $totalNews = News::count();
            $createdNews = News::find($news->id);
            
            Log::info('Verification:', [
                'total_news_count' => $totalNews,
                'created_news_found' => $createdNews ? 'YES' : 'NO'
            ]);

            Log::info('=== NEWS STORE SUCCESS ===');

            if ($request->has('save_and_continue')) {
                return redirect()->route('admin.news.create')
                    ->with('success', 'News berhasil dibuat! ID: ' . $news->id . '. Anda bisa menambahkan news lain.');
            }

            return redirect()->route('admin.news.index')
                ->with('success', 'News berhasil dibuat! ID: ' . $news->id);

        } catch (\Exception $e) {
            Log::error('=== NEWS STORE ERROR ===');
            Log::error('Error Details:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal membuat news: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified news
     */
    public function show($id)
    {
        try {
            $news = News::with('author')->findOrFail($id);
            return view('admin.news.show', compact('news'));

        } catch (\Exception $e) {
            return redirect()->route('admin.news.index')
                ->with('error', 'News not found');
        }
    }

    /**
     * Show the form for editing the specified news
     */
    public function edit($id)
    {
        try {
            $news = News::findOrFail($id);
            return view('admin.news.edit', compact('news'));

        } catch (\Exception $e) {
            return redirect()->route('admin.news.index')
                ->with('error', 'News not found');
        }
    }

    /**
     * Update the specified news in storage
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|in:announcements,events,academic',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:published,draft',
            'publish_date' => 'required|date',
            'featured' => 'boolean',
            'tags' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $news = News::findOrFail($id);
            
            // PERBAIKAN: Siapkan data update yang lengkap
            $newsData = [
                'title' => $request->title,
                'category' => $request->category,
                'excerpt' => $request->excerpt,
                'content' => $request->content,
                'status' => $request->status,
                'publish_date' => $request->publish_date,
                'featured' => $request->has('featured') ? true : false,
                'tags' => $request->tags
            ];

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($news->image) {
                    Storage::disk('public')->delete($news->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('news', $imageName, 'public');
                
                $newsData['image'] = $imagePath;
            }

            $news->update($newsData);

            return redirect()->route('admin.news.show', $news->id)
                ->with('success', 'News updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating news: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified news from storage
     */
    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);
            
            // Delete image file
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $news->delete();

            return redirect()->route('admin.news.index')
                ->with('success', 'News deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('admin.news.index')
                ->with('error', 'Error deleting news: ' . $e->getMessage());
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        try {
            $news = News::findOrFail($id);
            $news->featured = !$news->featured;
            $news->save();

            return redirect()->back()
                ->with('success', 'Featured status updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating featured status');
        }
    }

    /**
     * Bulk actions (delete, change status, etc.)
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,publish,draft,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'exists:news,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $count = 0;
            
            switch ($request->action) {
                case 'delete':
                    $news = News::whereIn('id', $request->ids)->get();
                    foreach ($news as $item) {
                        if ($item->image) {
                            Storage::disk('public')->delete($item->image);
                        }
                    }
                    $count = News::whereIn('id', $request->ids)->delete();
                    break;
                    
                case 'publish':
                    $count = News::whereIn('id', $request->ids)->update([
                        'status' => 'published',
                        'publish_date' => now()
                    ]);
                    break;
                    
                case 'draft':
                    $count = News::whereIn('id', $request->ids)->update(['status' => 'draft']);
                    break;
                    
                case 'feature':
                    $count = News::whereIn('id', $request->ids)->update(['featured' => true]);
                    break;
                    
                case 'unfeature':
                    $count = News::whereIn('id', $request->ids)->update(['featured' => false]);
                    break;
            }

            return response()->json([
                'success' => true,
                'message' => "Bulk action completed successfully! {$count} items affected."
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error performing bulk action: ' . $e->getMessage()
            ], 500);
        }
    }
}