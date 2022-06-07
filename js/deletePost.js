function deletePost(postID) {
    var data = new FormData(document.getElementById("deleteRow"+postID));
    fetch('http://localhost:8012/blog/?url=/posts/deletePost', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "http://localhost:8012/blog/?url=/pages/ManagePosts";
        });

    return false;
}