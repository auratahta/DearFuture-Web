<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of published news for students
     */
    public function index(Request $request)
    {
        $query = News::with('author')->where('status', 'published');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        // Get featured news (for hero section)
        $featuredNews = News::with('author')
            ->where('status', 'published')
            ->where('featured', true)
            ->first();

        // Get regular news (excluding featured if it exists)
        if ($featuredNews) {
            $query->where('id', '!=', $featuredNews->id);
        }

        // Order by latest publish date
        $news = $query->orderBy('created_at', 'desc')->paginate(6);

        // AJAX request for search/filter
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('student.news.partials.news-grid', compact('news'))->render(),
                'pagination' => $news->links()->render()
            ]);
        }

        // Return view dengan path yang benar sesuai struktur file
        return view('student.index', compact('news', 'featuredNews'));
    }

    /**
     * Display the specified news
     */
    public function show($id)
    {
        try {
            $news = News::with('author')
                ->where('status', 'published')
                ->findOrFail($id);
            
            // Increment views if method exists
            if (method_exists($news, 'incrementViews')) {
                $news->incrementViews();
            } else {
                // Alternative: manual increment
                $news->increment('views');
            }
            
            // Get related news (same category, excluding current)
            $relatedNews = News::with('author')
                ->where('status', 'published')
                ->where('category', $news->category)
                ->where('id', '!=', $news->id)
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();

            return view('student.news.show', compact('news', 'relatedNews'));

        } catch (\Exception $e) {
            return redirect()->route('student.news.index')
                ->with('error', 'News not found or not available');
        }
    }

    /**
     * Search news (AJAX)
     */
    public function search(Request $request)
    {
        $query = News::with('author')->where('status', 'published');
        
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('category') && $request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(6);

        return response()->json([
            'success' => true,
            'html' => view('student.news.partials.news-grid', compact('news'))->render(),
            'pagination' => $news->links()->render()
        ]);
    }

    /**
     * Get news by category (optional helper method)
     */
    public function getByCategory($category)
    {
        $news = News::with('author')
            ->where('status', 'published')
            ->where('category', $category)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return response()->json([
            'success' => true,
            'data' => $news
        ]);
    }
}