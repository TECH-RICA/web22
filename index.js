function toggleDarkMode() {
   let white_header = document.getElementById("why-h3");
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    
}
if(localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
}
document.addEventListener('DOMContentLoaded', function() {
    const testimonialSection = document.querySelector('.testimonials-section');
    if (!testimonialSection) return; // Exit if not present

    const testimonials = testimonialSection.querySelectorAll('.testimonial');
    const leftArrow = testimonialSection.querySelector('.arrow.left');
    const rightArrow = testimonialSection.querySelector('.arrow.right');
    let currentIndex = 0;

    function showTestimonial(index) {
        testimonials.forEach((testimonial, i) => {
            testimonial.classList.toggle('active', i === index);
        });
    }

    showTestimonial(currentIndex);

    if (leftArrow && rightArrow) {
        leftArrow.addEventListener('click', function() {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : testimonials.length - 1;
            showTestimonial(currentIndex);
        });

        rightArrow.addEventListener('click', function() {
            currentIndex = (currentIndex < testimonials.length - 1) ? currentIndex + 1 : 0;
            showTestimonial(currentIndex);
        });
    }

    // Swipe support for mobile
    let startX = 0;
    let endX = 0;

    testimonialSection.addEventListener('touchstart', function(e) {
        startX = e.touches[0].clientX;
    }, false);

    testimonialSection.addEventListener('touchend', function(e) {
        endX = e.changedTouches[0].clientX;
        if (endX < startX - 30) {
            currentIndex = (currentIndex < testimonials.length - 1) ? currentIndex + 1 : 0;
            showTestimonial(currentIndex);
        } else if (endX > startX + 30) {
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : testimonials.length - 1;
            showTestimonial(currentIndex);
        }
    }, false);
});
