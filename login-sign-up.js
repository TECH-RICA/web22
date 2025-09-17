document.addEventListener('DOMContentLoaded', function() {
    function initRegisterFormJS() {
        let passwordInput = document.getElementById('signup-password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                let val = this.value;
                let score = 0;
                if(val.length >= 8) score++;
                if(/[A-Z]/.test(val)) score++;
                if(/[0-9]/.test(val)) score++;
                if(/[^A-Za-z0-9]/.test(val)) score++;
                let strengthBar = document.getElementById('strengthBar');
                if (strengthBar) strengthBar.value = score;
            });
        }
    }

    var showRegister = document.getElementById('show-register');
    var socialOptions = document.getElementById('social-register-options');
    var registerForm = document.getElementById('register-form');
    var loginForm = document.getElementById('login-form');
    var forgotForm = document.getElementById('forgot-form');
    var chooseEmailBtn = document.getElementById('choose-email-btn');
    var backToSocial = document.getElementById('back-to-social');

    if (showRegister && socialOptions && registerForm && loginForm && forgotForm) {
        showRegister.onclick = function(e) {
            e.preventDefault();
            loginForm.style.display = 'none';
            forgotForm.style.display = 'none';
            socialOptions.style.display = 'block';
            registerForm.style.display = 'none';
        };
    }
    if (chooseEmailBtn && registerForm && socialOptions) {
        chooseEmailBtn.onclick = function() {
            socialOptions.style.display = 'none';
            registerForm.style.display = 'block';
        };
    }
    if (backToSocial && registerForm && socialOptions) {
        backToSocial.onclick = function(e) {
            e.preventDefault();
            registerForm.style.display = 'none';
            socialOptions.style.display = 'block';
        };
    }
    // Toggle password function stays the same
});

function togglePassword(event, inputId, toggleElem) {
    event.preventDefault();
    event.stopPropagation();
    const input = document.getElementById(inputId);
    const icon = toggleElem.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
        toggleElem.classList.add('active');
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
        toggleElem.classList.remove('active');
    }
}
