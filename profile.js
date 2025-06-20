// Password strength meter
    document.addEventListener("DOMContentLoaded", function() {
        var np = document.getElementById('new_password');
        if(np) {
            np.addEventListener('input', function() {
                var val = this.value;
                var score = 0;
                if(val.length >= 8) score++;
                if(/[A-Z]/.test(val)) score++;
                if(/[0-9]/.test(val)) score++;
                if(/[^A-Za-z0-9]/.test(val)) score++;
                document.getElementById('strengthBar').value = score;
            });
        }
        // Auto-hide messages
        setTimeout(function() {
            var msg = document.querySelector('.success, .error');
            if(msg) msg.style.display = 'none';
        }, 4000);
    });
    // Profile image preview
    document.addEventListener("DOMContentLoaded", function() {
        var input = document.getElementById('profileInput');
        if(input) {
            input.addEventListener('change', function(e) {
                if(this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(ev) {
                        document.getElementById('profileImg').src = ev.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
    // Dark mode toggle
    function toggleDarkMode() {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    }
    if(localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
    // Show/hide password
    function togglePassword() {
        var fields = ['current_password', 'new_password', 'confirm_password'];
        fields.forEach(function(id) {
            var field = document.getElementById(id);
            if(field) field.type = field.type === 'password' ? 'text' : 'password';
        });
    }
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