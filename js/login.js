function login() {
    var data = new FormData(document.getElementById("login"));
    fetch('./users/login', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
        //    window.location = "http://localhost:8012/blog/";
        });
        
    return false;
}