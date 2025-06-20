function toggleDarkMode() {
   var white_header = document.getElementById("why-h3");
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    
}
if(localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
}
