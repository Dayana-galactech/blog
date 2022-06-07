function changetwo(){
    var data = new FormData(document.getElementById("changetwo"));
    fetch('http://localhost:8012/blog/?url=/posts/changetwo', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "http://localhost:8012/blog";
        });

    return false;
}