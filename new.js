document.addEventListener('DOMContentLoaded', function() {
    // Hamburger menu logic
    const hamburger = document.querySelector('.hamburger');
    const close = document.querySelector('.close');
    const navLinks = document.querySelector('.nav-links');
    const menuToggle = document.querySelector('.menu-toggle');
    var hide = document.getElementById("intro");
    var hid = document.getElementById("hidden");

    function openMenu() {
        navLinks.classList.add('active');
        hamburger.style.display = 'none';
        close.style.display = 'block';
        hide.style.visibility = "hidden";
         hid.style.visibility = "hidden";
    }

    function closeMenu() {
        navLinks.classList.remove('active');
        hamburger.style.display = 'block';
        close.style.display = 'none';
        hide.style.visibility = "visible";
         hid.style.visibility = "visible";
        
    }

    if (hamburger && close && navLinks && menuToggle) {
        hamburger.addEventListener('click', function(e) {
            e.stopPropagation();
            openMenu();
        });

        close.addEventListener('click', function(e) {
            e.stopPropagation();
            closeMenu();
        });

        // Hide menu when clicking outside
        document.addEventListener('click', function(e) {
            if (
                navLinks.classList.contains('active') &&
                !navLinks.contains(e.target) &&
                !menuToggle.contains(e.target)
            ) {
                closeMenu();
            }
        });

        // Hide menu on resize if desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 767) {
                navLinks.classList.remove('active');
                hamburger.style.display = 'block';
                close.style.display = 'none';
            }
        });
    }

    // Navigation without href
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = this.getAttribute('data-page');
            if (page) {
                window.location.href = page;
            }
            closeMenu();
        });
    });

    // You can add more JS below as needed
});