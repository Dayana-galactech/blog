function deletecategory(categoryID) {
    var data = new FormData(document.getElementById("deleteRow"+categoryID));
    fetch('http://localhost:8012/blog/?url=/categories/deleteCategory', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "http://localhost:8012/blog/?url=/users/admin_manageCategories";
        });

    return false;
}