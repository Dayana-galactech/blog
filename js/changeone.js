function changeone(){
    var data = new FormData(document.getElementById("changeone"));
    fetch('http://localhost:8012/blog/?url=/posts/changeone', {
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