// FAQ toggle logic
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', function(e) {
        e.stopPropagation();
        // Hide all answers first
        document.querySelectorAll('.faq').forEach(faq => faq.classList.remove('show'));
        // Show the clicked one
        this.parentElement.classList.add('show');
    });
});

// Hide answer when clicking outside
document.addEventListener('click', function() {
    document.querySelectorAll('.faq').forEach(faq => faq.classList.remove('show'));
});