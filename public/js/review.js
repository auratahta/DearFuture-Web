// Add this to your app.js file
document.addEventListener("DOMContentLoaded", function () {
    // Testimonial animations
    const testimonialCards = document.querySelectorAll(".testimonial-card");

    testimonialCards.forEach((card, index) => {
        // Add fadeIn animation with delay based on index
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";
        card.style.transition = "opacity 0.8s ease, transform 0.8s ease";

        setTimeout(() => {
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, 300 + index * 200);

        // Add hover effect
        card.addEventListener("mouseenter", function () {
            this.style.borderLeftColor = "#5af7ff";
            this.style.transform = "translateX(5px)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.borderLeftColor = "transparent";
            this.style.transform = "translateX(0)";
        });
    });

    // Indicator functionality
    const indicators = document.querySelectorAll(".indicator");

    indicators.forEach((indicator, index) => {
        indicator.addEventListener("click", function () {
            // Remove active class from all indicators
            indicators.forEach((ind) => ind.classList.remove("active"));

            // Add active class to clicked indicator
            this.classList.add("active");

            // Here you can add code to switch between testimonials
            // This would be useful if you implement a mobile carousel

            // Example: Highlight the corresponding testimonial
            testimonialCards.forEach((card, cardIndex) => {
                if (cardIndex === index) {
                    card.style.borderLeftColor = "#5af7ff";
                    card.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                } else {
                    card.style.borderLeftColor = "transparent";
                }
            });
        });
    });

    // CTA button effect
    const ctaButton = document.querySelector(".cta-button");

    if (ctaButton) {
        ctaButton.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-3px)";
            this.style.boxShadow = "0 8px 25px rgba(90, 247, 255, 0.3)";
        });

        ctaButton.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
            this.style.boxShadow = "0 5px 15px rgba(90, 247, 255, 0.2)";
        });
    }
});
