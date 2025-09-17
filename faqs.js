// FAQ toggle logic
/*document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', function(e) {
        e.stopPropagation();
        // Hide all answers first
        document.querySelectorAll('.faq').forEach(faq => faq.classList.remove('show'));
        // Show the clicked one
        this.parentElement.classList.add('show');
    });
});
*/

// Hide answer when clicking outside
document.addEventListener('click', function() {
    document.querySelectorAll('.faq').forEach(faq => faq.classList.remove('show'));
});

document.querySelectorAll('.faq-question').forEach(q => {
    q.addEventListener('click', function() {
        // Close all open answers except the one clicked
        document.querySelectorAll('.faq').forEach(f => {
            if (f !== this.parentElement) f.classList.remove('active');
        });
        // Toggle current
        this.parentElement.classList.toggle('active');
    });
});