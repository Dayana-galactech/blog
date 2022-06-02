function createPosts() {
    var data = new FormData(document.getElementById("createPost"));
    fetch('http://localhost:8012/blog/?url=/posts/createPost', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
           window.location = "http://localhost:8012/blog/?url=/users/admin_managePosts";
        });
        
    return false;
}