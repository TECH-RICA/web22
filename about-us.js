// Slider for each member
document.querySelectorAll('.member-box').forEach(function(box) {
    let slides = box.querySelectorAll('.member-img-slide');
    let current = 0;

    function showSlide(idx) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === idx);
        });
    }

    box.querySelector('.member-arrow.left').addEventListener('click', function() {
        current = (current > 0) ? current - 1 : slides.length - 1;
        showSlide(current);
    });
    box.querySelector('.member-arrow.right').addEventListener('click', function() {
        current = (current < slides.length - 1) ? current + 1 : 0;
        showSlide(current);
    });
    showSlide(current);
});

// Modal for full image
const modal = document.getElementById('imgModal');
const modalImg = document.getElementById('imgModalFull');
const modalClose = document.querySelector('.img-modal-close');

document.querySelectorAll('.member-thumb').forEach(img => {
    img.addEventListener('click', function() {
        modal.style.display = 'flex';
        modalImg.src = this.src;
    });
});

// Close modal on click of close button or outside image
modalClose.onclick = function() { modal.style.display = 'none'; }
modal.onclick = function(e) { if (e.target === modal) modal.style.display = 'none'; }

// Prevent right-click on images
document.querySelectorAll('.member-thumb, .img-modal-content').forEach(img => {
    img.addEventListener('contextmenu', e => e.preventDefault());
});

// Prevent drag
document.querySelectorAll('.member-thumb, .img-modal-content').forEach(img => {
    img.setAttribute('draggable', 'false');
});

const memberSlides = document.querySelectorAll('.member-slide');
const leftMemberArrow = document.querySelector('.member-arrow.left');
const rightMemberArrow = document.querySelector('.member-arrow.right');
let memberIndex = 0;

function showMemberSlide(index) {
    memberSlides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
    });
}

leftMemberArrow.addEventListener('click', () => {
    memberIndex = (memberIndex > 0) ? memberIndex - 1 : memberSlides.length - 1;
    showMemberSlide(memberIndex);
});

rightMemberArrow.addEventListener('click', () => {
    memberIndex = (memberIndex < memberSlides.length - 1) ? memberIndex + 1 : 0;
    showMemberSlide(memberIndex);
});

// Initialize
showMemberSlide(memberIndex);