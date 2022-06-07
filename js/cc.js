function cc(postID) {
    var data = new FormData(document.getElementById("cc"+postID));
    fetch('http://localhost:8012/blog/?url=/comments/cc', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
         window.location= window.location.href;
        })
        ;
        
    return false;
}