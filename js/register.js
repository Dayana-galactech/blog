
function fetchcall() {
    var data = new FormData(document.getElementById("register"));
    fetch('./users/register', {
        method: 'POST',
        body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
           window.location = "http://localhost:8012/blog";
        });
        
    return false;
}
