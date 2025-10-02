/**
 * Safe JavaScript for Authentication pages
 * This file contains only the essential JavaScript needed for auth pages
 * without the complex theme components that can cause errors
 */

// Simple page loader functionality
document.addEventListener('DOMContentLoaded', function() {
    // Hide any loading spinners
    const pageLoader = document.querySelector('.page-loader');
    if (pageLoader) {
        pageLoader.style.display = 'none';
    }
    
    // Add basic form validation feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        // Skip forms that have custom handlers
        if (form.dataset.customHandler === 'true') {
            return;
        }
        
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Processing...';
                
                // Re-enable after 10 seconds as failsafe
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Sign In';
                }, 10000);
            }
        });
    });
    
    // Initialize Bootstrap carousel manually if needed
    const carousel = document.querySelector('#carouselExampleIndicators');
    if (carousel && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
        try {
            new bootstrap.Carousel(carousel, {
                interval: 5000,
                wrap: true,
                pause: 'hover'
            });
        } catch (e) {
            console.log('Bootstrap carousel not available, using fallback');
            initFallbackCarousel();
        }
    } else {
        initFallbackCarousel();
    }
});

// Fallback carousel implementation
function initFallbackCarousel() {
    const carousel = document.querySelector('#carouselExampleIndicators');
    if (!carousel) return;
    
    const slides = carousel.querySelectorAll('.carousel-item');
    const indicators = carousel.querySelectorAll('.carousel-indicators button');
    const prevBtn = carousel.querySelector('.carousel-control-prev');
    const nextBtn = carousel.querySelector('.carousel-control-next');
    
    let currentSlide = 0;
    let autoSlideInterval;
    
    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        
        // Show current slide
        if (slides[index]) {
            slides[index].classList.add('active');
        }
        if (indicators[index]) {
            indicators[index].classList.add('active');
        }
        
        currentSlide = index;
    }
    
    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }
    
    function prevSlide() {
        const prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    }
    
    function startAutoSlide() {
        stopAutoSlide();
        autoSlideInterval = setInterval(nextSlide, 5000);
    }
    
    function stopAutoSlide() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
    }
    
    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            nextSlide();
            startAutoSlide(); // Restart auto-slide
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            prevSlide();
            startAutoSlide(); // Restart auto-slide
        });
    }
    
    // Indicator clicks
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', (e) => {
            e.preventDefault();
            showSlide(index);
            startAutoSlide(); // Restart auto-slide
        });
    });
    
    // Pause on hover
    carousel.addEventListener('mouseenter', stopAutoSlide);
    carousel.addEventListener('mouseleave', startAutoSlide);
    
    // Start auto-slide
    startAutoSlide();
}

// Mobile form handling
function handleMobileForm() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
    let initialViewportHeight = window.innerHeight;
    
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            if (window.innerWidth <= 768) {
                setTimeout(() => {
                    const currentViewportHeight = window.innerHeight;
                    const keyboardHeight = initialViewportHeight - currentViewportHeight;
                    
                    if (keyboardHeight > 100) {
                        const rect = this.getBoundingClientRect();
                        const inputBottom = rect.bottom;
                        
                        if (inputBottom > (currentViewportHeight - 50)) {
                            const scrollOffset = inputBottom - (currentViewportHeight - 100);
                            window.scrollBy(0, scrollOffset);
                        }
                    }
                }, 300);
            }
        });
    });
    
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            initialViewportHeight = window.innerHeight;
        }, 500);
    });
}

// Initialize mobile handling
document.addEventListener('DOMContentLoaded', handleMobileForm);

// Prevent common JavaScript errors
window.addEventListener('error', function(e) {
    if (e.message.includes('KT') || e.message.includes('bootstrap')) {
        e.preventDefault();
        console.log('Suppressed theme-related error:', e.message);
        return false;
    }
});