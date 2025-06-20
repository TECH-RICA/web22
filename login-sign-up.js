document.getElementById('password').addEventListener('input', function() {
    var val = this.value;
    var score = 0;
    if(val.length >= 8) score++;
    if(/[A-Z]/.test(val)) score++;
    if(/[0-9]/.test(val)) score++;
    if(/[^A-Za-z0-9]/.test(val)) score++;
    document.getElementById('strengthBar').value = score;
});

// Simple JS to switch forms
    document.getElementById('show-register').onclick = function() {
        document.getElementById('login-form').classList.remove('active');
        document.getElementById('register-form').classList.add('active');
        document.getElementById('forgot-form').classList.remove('active');
        return false;
    };
    document.getElementById('show-login-from-register').onclick = function() {
        document.getElementById('login-form').classList.add('active');
        document.getElementById('register-form').classList.remove('active');
        document.getElementById('forgot-form').classList.remove('active');
        return false;
    };
    document.getElementById('show-forgot').onclick = function() {
        document.getElementById('login-form').classList.remove('active');
        document.getElementById('register-form').classList.remove('active');
        document.getElementById('forgot-form').classList.add('active');
        return false;
    };
    document.getElementById('show-login-from-forgot').onclick = function() {
        document.getElementById('login-form').classList.add('active');
        document.getElementById('register-form').classList.remove('active');
        document.getElementById('forgot-form').classList.remove('active');
        return false;
    };
      function togglePass() {
    var fields = ['pass',];
    fields.forEach(function(id) {
        var field = document.getElementById(id);
        if(field) field.type = field.type === 'password' ? 'text' : 'password';
    });
}
function togglePassword() {
    var fields = ['password',  'confirmPassword'];
    fields.forEach(function(id) {
        var field = document.getElementById(id);
        if(field) field.type = field.type === 'password' ? 'text' : 'password';
    });
}