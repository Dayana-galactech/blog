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