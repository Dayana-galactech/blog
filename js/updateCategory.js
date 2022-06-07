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