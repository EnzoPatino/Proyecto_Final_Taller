document.addEventListener('DOMContentLoaded', () => {
    const carouselSlide = document.querySelector('.carousel-slide');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    
    let counter = 0;
    const itemWidth = 50; // 50% of container width
    
    // Set initial position
    updateCarousel();
    
    // Next button
    nextBtn.addEventListener('click', () => {
        if (counter >= carouselItems.length - 2) return;
        carouselSlide.style.transition = 'transform 0.5s ease-in-out';
        counter++;
        updateCarousel();
    });
    
    // Previous button
    prevBtn.addEventListener('click', () => {
        if (counter <= 0) return;
        carouselSlide.style.transition = 'transform 0.5s ease-in-out';
        counter--;
        updateCarousel();
    });
    
    function updateCarousel() {
        const offset = -counter * itemWidth;
        carouselSlide.style.transform = `translateX(${offset}%)`;
        
        // Update button states
        prevBtn.style.display = counter === 0 ? 'none' : 'flex';
        nextBtn.style.display = counter >= carouselItems.length - 2 ? 'none' : 'flex';
    }
    
    // Touch support for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    
    carouselSlide.addEventListener('touchstart', e => {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });
    
    carouselSlide.addEventListener('touchmove', e => {
        touchEndX = e.touches[0].clientX;
    }, { passive: true });
    
    carouselSlide.addEventListener('touchend', () => {
        handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
        const diff = touchStartX - touchEndX;
        const swipeThreshold = 50;
        
        if (diff > swipeThreshold && counter < carouselItems.length - 2) {
            // Swipe left - go to next
            carouselSlide.style.transition = 'transform 0.5s ease-in-out';
            counter++;
            updateCarousel();
        } else if (diff < -swipeThreshold && counter > 0) {
            // Swipe right - go to previous
            carouselSlide.style.transition = 'transform 0.5s ease-in-out';
            counter--;
            updateCarousel();
        }
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
        updateCarousel();
    });
    
    // Initialize buttons
    updateCarousel();
});
