// DearFuture Main JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // ======== SMOOTH SCROLL FUNCTIONALITY ========
    // Get the about link in navbar
    const aboutLink = document.querySelector('.navbar-nav a[href="#About"]');

    // Get the about section
    const aboutSection = document.getElementById("about");

    // Handle about link click for smooth scrolling
    if (aboutLink && aboutSection) {
        aboutLink.addEventListener("click", function (e) {
            e.preventDefault();

            // Get the navbar height to offset the scroll position
            const navbarHeight = document.querySelector(".navbar").offsetHeight;

            // Calculate the scroll position
            const aboutPosition = aboutSection.offsetTop - navbarHeight;

            // Smooth scroll to the about section
            window.scrollTo({
                top: aboutPosition,
                behavior: "smooth",
            });
        });
    }
});

// ======== MODAL FUNCTIONALITY ========
// Get modal elements
const loginModal = document.getElementById("loginModal");
const signupModal = document.getElementById("signupModal");

// Get trigger buttons
const navLoginBtn = document.getElementById("navLoginBtn");
const openSignupBtn = document.getElementById("openSignupModal");
const switchToLoginBtn = document.getElementById("switchToLogin");

// Get close buttons
const closeLoginBtn = document.querySelector(".close-modal");
const closeSignupBtn = document.querySelector(".close-signup-modal");

// Get forms
const loginForm = document.querySelector(".login-form");
const signupForm = document.querySelector(".signup-form");

// ======== MODAL CONTROL FUNCTIONS ========
// Function to open login modal
function openLoginModal() {
    loginModal.style.display = "block";
    document.body.style.overflow = "hidden"; // Prevent background scrolling
}

// Function to close login modal
function closeLoginModal() {
    loginModal.style.display = "none";
    document.body.style.overflow = ""; // Restore scrolling
}

// Function to open signup modal
function openSignupModal() {
    signupModal.style.display = "block";
    loginModal.style.display = "none"; // Hide login modal
    document.body.style.overflow = "hidden"; // Prevent background scrolling
}

// Function to close signup modal
function closeSignupModal() {
    signupModal.style.display = "none";
    document.body.style.overflow = ""; // Restore scrolling
}

// ======== EVENT LISTENERS ========
// Login button in navbar
if (navLoginBtn) {
    navLoginBtn.addEventListener("click", function (e) {
        e.preventDefault();
        openLoginModal();
    });
}

// Close login modal button
if (closeLoginBtn) {
    closeLoginBtn.addEventListener("click", closeLoginModal);
}

// Open signup modal from login modal
if (openSignupBtn) {
    openSignupBtn.addEventListener("click", function (e) {
        e.preventDefault();
        openSignupModal();
    });
}

// Close signup modal button
if (closeSignupBtn) {
    closeSignupBtn.addEventListener("click", closeSignupModal);
}

// Switch back to login from signup
if (switchToLoginBtn) {
    switchToLoginBtn.addEventListener("click", function (e) {
        e.preventDefault();
        closeSignupModal();
        openLoginModal();
    });
}

// Close modal when clicking outside
window.addEventListener("click", function (event) {
    if (event.target === loginModal) {
        closeLoginModal();
    }
    if (event.target === signupModal) {
        closeSignupModal();
    }
});

// Close modal with Escape key
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        if (loginModal.style.display === "block") {
            closeLoginModal();
        }
        if (signupModal.style.display === "block") {
            closeSignupModal();
        }
    }

    // ======== FORM SUBMISSIONS ========
    // Login form submission
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            // Simulasi login sukses (karena kamu hanya mengerjakan frontend)
            // Kamu bisa ganti ini nanti dengan validasi backend
            window.location.href = "/views/subject.blade.php";
        });
    }

    // Signup form submission
    if (signupForm) {
        signupForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const name = document.getElementById("signup-name").value;
            const email = document.getElementById("signup-email").value;

            // Close signup modal and go back to login modal
            closeSignupModal();
            openLoginModal();
        });
    }
});
