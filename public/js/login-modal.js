// Smooth Scroll to About Section
document.addEventListener("DOMContentLoaded", function () {
    // Get the about link in navbar
    const aboutLink = document.querySelector('.navbar-nav a[href="#About"]');

    // Get the about section
    const aboutSection = document.getElementById("about");

    // Check if elements exist
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

// Login Modal JavaScript (Frontend Only)
document.addEventListener("DOMContentLoaded", function () {
    // Get the modal element
    const modal = document.getElementById("loginModal");

    // Get the navbar login button
    const navLoginBtn = document.getElementById("navLoginBtn");

    // Get the close button
    const closeBtn = document.querySelector(".close-modal");

    // Function to open the modal
    function openModal() {
        modal.style.display = "block";
        document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = "none";
        document.body.style.overflow = ""; // Restore scrolling
    }

    // Event listeners
    navLoginBtn.addEventListener("click", function (e) {
        e.preventDefault(); // Prevent the default anchor behavior
        openModal();
    });

    closeBtn.addEventListener("click", closeModal);

    // Close the modal if the user clicks outside of it
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close modal on escape key press
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal.style.display === "block") {
            closeModal();
        }
    });

    // Demo login function (frontend only)
    const loginForm = document.querySelector(".login-form");
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        // Just for demo, show an alert with the entered credentials
        alert(
            "Login demo (frontend only):\nEmail: " +
                email +
                "\nThis would normally be processed by the backend."
        );

        // Optionally close the modal after "login"
        // closeModal();
    });
});
