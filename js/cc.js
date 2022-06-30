$(document).ready(function () {
    $(".owl-two").owlCarousel({
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
                margin: 0
            },
            980: {
                items: 3,
                nav: false,
                margin: 5,
            },

        }
    });
    $(".owl-one").owlCarousel({
        nav: true,
        loop: true,
        // autoplay: true,
        // autoplayTimeout: 5000,

        touchDrag: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                margin: 0
            },
            980: {
                items: 1,
                nav: false,
                margin: 5,
            },

        }
    });
    // $('.button-animate').addClass('animate__animated animate__zoomIn animate__infinite');
    // $('.title-animate').mouseenter(function () {
    //     $(this).addClass('animate__animated animate__flipInY');
    // }).mouseleave(function () {
    //     $(this).removeClass('animate__animated animate__flipInY');
    // });

});

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
        inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    dropZoneElement.addEventListener("drop", (e) => {
        e.preventDefault();

        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }

        dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // First time - remove the prompt
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // First time - there is no thumbnail element, so lets create it
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.dataset.label = file.name;

    // Show thumbnail for image files
    if (file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    } else {
        thumbnailElement.style.backgroundImage = null;
    }
}

function cc(postID) {
    var data = new FormData(document.getElementById("cc" + postID));
    fetch('?url=/comments/cc', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            // window.location = window.location.href;
        })
        ;

    return false;
}
function createCategory() {
    var data = new FormData(document.getElementById("createCategory"));
    fetch('?url=/categories/createCategory', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {

            window.location = "?url=/pages/ManageCategories";
        });

    return false;
}
function changeone() {
    var data = new FormData(document.getElementById("changeone"));
    fetch('?url=/posts/changeone', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            // console.log(txt);
            window.location = "https://dayana.galactech.cloud";
        });

    return false;
}
function searchPost() {
    var data = new FormData(document.getElementById("searchPosts"));
    fetch('?url=/posts/searchPosts', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/posts";
        });

    return false;
}
function edit(ID) {
   
    var data = new FormData(document.getElementById("edit"+ID));
    fetch('?url=/posts/edit', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/edit";
        });

    return false;
}
function searchPosts(ID) {
    console.log(ID);
    var data = new FormData(document.getElementById("searchPosts" + ID));
    fetch('?url=/posts/searchPosts', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/posts";
        });

    return false;
}

function createPosts() {
    var data = new FormData(document.getElementById("createPost"));
    fetch('?url=/posts/createPost', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            window.location = "?url=/pages/ManagePosts";
        });

    return false;
}
function deletecategory(categoryID) {
    var data = new FormData(document.getElementById("deleteRow" + categoryID));
    fetch('?url=/categories/deleteCategory', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/ManageCategories";
        });

    return false;
}
function deletePost(postID) {
    var data = new FormData(document.getElementById("deleteRow" + postID));
    fetch('?url=/posts/deletePost', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/ManagePosts";
        });

    return false;
}
function updateCategory(categoryID) {
    var data = new FormData(document.getElementById("updateCategory" + categoryID));
    fetch('?url=/categories/updateCategory', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/ManageCategories";
        });

    return false;
}
function updatePost(postID) {
    var data = new FormData(document.getElementById("updatePost" + postID));
    fetch('?url=/posts/updatePost', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            window.location = "?url=/pages/ManagePosts";
        });

    return false;
}
