$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        nav: true,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        
        touchDrag: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                margin:0
            },
            980: {
                items: 3,
                nav: false,
                margin: 5,
            },
           
        }
    });
});
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
function createCategory() {
    var data = new FormData(document.getElementById("createCategory"));
    fetch('http://localhost:8012/blog/?url=/categories/createCategory', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
        
           window.location = "http://localhost:8012/blog/?url=/pages/ManageCategories";
        });
        
    return false;
}
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
function searchPosts(ID) {
    console.log(ID);
    var data = new FormData(document.getElementById("searchPosts"+ID));
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
function createPosts() {
    var data = new FormData(document.getElementById("createPost"));
    fetch('http://localhost:8012/blog/?url=/posts/createPost', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
           window.location = "http://localhost:8012/blog/?url=/pages/ManagePosts";
        });
        
    return false;
}
function changethree(){
    var data = new FormData(document.getElementById("changethree"));
    fetch('http://localhost:8012/blog/?url=/posts/changethree', {
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
function deletecategory(categoryID) {
    var data = new FormData(document.getElementById("deleteRow"+categoryID));
    fetch('http://localhost:8012/blog/?url=/categories/deleteCategory', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "http://localhost:8012/blog/?url=/pages/ManageCategories";
        });

    return false;
}
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
function updateCategory(categoryID) {
    var data = new FormData(document.getElementById("updateCategory"+categoryID));
    fetch('http://localhost:8012/blog/?url=/categories/updateCategory', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
           window.location = "http://localhost:8012/blog/?url=/pages/ManageCategories";
        });
        
    return false;
}
function updatePost(postID) {
    var data = new FormData(document.getElementById("updatePost"+postID));
    fetch('http://localhost:8012/blog/?url=/posts/updatePost', {
       method:'POST',
       body: data,
    })  
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
           window.location = "http://localhost:8012/blog/?url=/pages/ManageCategories";
        });
        
    return false;
}