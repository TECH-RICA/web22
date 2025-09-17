
document.addEventListener('DOMContentLoaded', function() {
    var openBtn = document.getElementById('openVideoModal');
    var modal = document.getElementById('videoModal');
    var closeBtn = document.getElementById('closeVideoModal');

    if (openBtn && modal && closeBtn) {
        openBtn.onclick = function() {
            modal.style.display = 'flex';
        };
        closeBtn.onclick = function() {
            modal.style.display = 'none';
            var video = document.getElementById('aboutVideo');
            if (video) video.pause();
        };
        // Optional: close modal when clicking outside video
        modal.onclick = function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                var video = document.getElementById('aboutVideo');
                if (video) video.pause();
            }
        };
    }
});

document.querySelectorAll('.about-gallery-img').forEach(img => {
    img.addEventListener('mouseenter', function() {const openVideoBtn = document.getElementById('openVideoModal');
const closeVideoBtn = document.getElementById('closeVideoModal');
const videoModal = document.getElementById('videoModal');
const aboutVideo = document.getElementById('aboutVideo');

if (openVideoBtn && closeVideoBtn && videoModal) {
    openVideoBtn.onclick = function() {
        videoModal.style.display = 'flex';
        if (aboutVideo) {
            aboutVideo.currentTime = 0;
            aboutVideo.play();
        }
    };
    closeVideoBtn.onclick = function() {
        videoModal.style.display = 'none';
        if (aboutVideo) {
            aboutVideo.pause();
            aboutVideo.currentTime = 0;
        }
    };
    window.onclick = function(event) {
        if (event.target === videoModal) {
            videoModal.style.display = 'none';
            if (aboutVideo) {
                aboutVideo.pause();
                aboutVideo.currentTime = 0;
            }
        }
    };
}
        if (this.dataset.hover) this.src = this.dataset.hover;
    });
    img.addEventListener('mouseleave', function() {
        this.src = this.dataset.original;
    });
});




