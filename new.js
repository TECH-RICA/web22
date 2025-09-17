document.addEventListener('DOMContentLoaded', function() {
    console.log('new.js loaded and DOMContentLoaded fired');
    window.onerror = function(message, source, lineno, colno, error) {
        console.error('Global JS error:', message, 'at', source + ':' + lineno + ':' + colno, error);
    };
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
        if (hide) hide.style.visibility = "hidden";
        if (hid) hid.style.visibility = "hidden";
    }

    function closeMenu() {
        navLinks.classList.remove('active');
        hamburger.style.display = 'block';
        close.style.display = 'none';
        if (hide) hide.style.visibility = "visible";
        if (hid) hid.style.visibility = "visible";
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

    /*
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            console.log('Nav link clicked');
            e.preventDefault();
            const page = this.getAttribute('data-page');
            console.log('data-page:', page);
            if (page) {
                // Use BASE_URL if available, else just navigate to the page
                const baseUrl = (typeof BASE_URL !== 'undefined') ? BASE_URL : '/web22/';
                console.log('Navigating to:', baseUrl + page);
                window.location.href = baseUrl + page;
            }
            closeMenu();
        });
    });


});
*/
document.querySelectorAll('.nav-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        var page = link.getAttribute('data-page');
        window.location.href = '../' + page; // or use AJAX to load content
    });
});




if ('scrollRestoration' in history) {
    history.scrollRestoration = 'auto';
}