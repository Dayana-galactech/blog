
function fetchcall() {
    var data = new FormData(document.getElementById("register"));
    fetch('?url=/users/register', {
        method: 'POST',
        body: data,
    })  
        // .then(res => res.text())
        // .then((txt) => {
        //     console.log(txt);
        // //    window.location = "http://localhost:8012/blog";
        // });
        
    return false;
}
