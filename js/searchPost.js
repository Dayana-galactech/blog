function searchPost() {
    var data = new FormData(document.getElementById("searchPosts"));
    fetch('http://localhost:8012/blog/?url=/posts/searchPosts', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
           window.location = "http://localhost:8012/blog/?url=/pages/posts";
        });
        
    return false;
}