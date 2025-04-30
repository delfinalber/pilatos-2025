/* Ejemplo de prefijos para compatibilidad */



document.addEventListener('DOMContentLoaded', function() {
    const carousels = document.querySelectorAll('.carousel');
    M.Carousel.init(carousels, {
        fullWidth: true,
        indicators: true
    });
});

function moveCarousel(carouselId, direction) {
    const carousel = document.getElementById(carouselId);
    const instance = M.Carousel.getInstance(carousel);
    if (direction === 1) {
        instance.next();
    } else {
        instance.prev();
    }
}



