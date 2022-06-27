function login() {
    var data = new FormData(document.getElementById("login"));
    fetch('?url=/users/login', {
        method: 'POST',
        body: data,
    })
    .then(res => res.text())
    .then((txt) => {
        console.log(txt);
    //    window.location = "https://dayana.galactech.cloud";
    });
        
    return false;
}