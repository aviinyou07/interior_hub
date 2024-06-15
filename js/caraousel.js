const prevButton = document.getElementById('Prev');
const nextButton = document.getElementById('Next');
const carousel = document.querySelector('.carousel');
const images = document.querySelectorAll('.card');

let currentIndex = 0;

function updateCarousel() {
    const offset = -currentIndex * 100; 
    carousel.style.transform = `translateX(${offset}%)`;
}

prevButton.addEventListener('click', () => {
    currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
    updateCarousel();
});

nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
    updateCarousel();
});

// Initialize the carousel position
updateCarousel();
