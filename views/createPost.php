<!DOCTYPE html>
<html lang="en">
<?php
if (session_id() == '') {
    session_start();
} ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="css/main.min.css?ts=<?= time() ?>" rel="stylesheet">
    <title>Create Posts</title>
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-12 col-md-3 col-lg-2 me-0 px-3 text-center" href="https://dayana.galactech.cloud">Blog</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <?php if (isset($_SESSION['user']['type'])) { ?> <a class="nav-link px-3" href="?url=/users/logout">Sign out</a> <?php } else { ?>
                    <a class="nav-link px-3" href="?url=/users/logout">Sign in</a> <?php } ?>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column fs-5 pt-lg-5 my-5 ps-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="?url=/pages/categories">
                                <span data-feather="file"></span>
                                All Categories
                            </a>
                        </li>
                        <?php if (isset($_SESSION['user']['type'])) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="?url=/pages/yourArticles">
                                    <span data-feather="shopping-cart"></span>
                                    Your Articles
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="?url=/pages/ManageCategories">
                                    <span data-feather="users"></span>
                                    Manage Categories
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="?url=/pages/ManagePosts">
                                    <span data-feather="bar-chart-2"></span>
                                    Manage Posts
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="layers"></span>
                                    Manage Profile
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <section class="my-5">
                    <div class="container mx-md-5 my-5 text-center">

                        <?php
                        $secret = "secretKey";
                        $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                        $_SESSION['csrf_post'] = $csrf;

                        require_once('./controllers/get.php');
                        $posts = getAllPost();
                        if (isset($_SESSION['user']['type'])) {
                            $categories = getCategory();
                        ?>
                            <div class="modal-header">
                                <h4 class="modal-title">Create New Post</h4>
                            </div>
                            <div class="modal-body mx-md-5 px-md-5">
                                <form method="POST" id="createPost" onsubmit="return createPosts();">
                                    <input type="hidden" id="csrf" name="csrf" value="<?php echo $csrf ?>">
                                    <div class="col mt-5">
                                        <select class="select" name="categoryID" id="categoryID">
                                            <option value="" selected disabled>Choose Category</option>
                                            <?php foreach ($categories as $category) : ?>
                                                <option value="<?php echo $category['categoryID']; ?>">
                                                    <?php echo $category['name']; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="col mt-5"> <input class="select" type="text" name="title" id="title" placeholder="Title"></div>
                                    <div class="col mt-5 fw-bold fs-5"> <label>Featured image:</label></div>
                                    <div class="col mt-5 drag">
                                        <div class="drop-zone">
                                            <span class="drop-zone__prompt pt-3">Browse Image </br></br> OR </br></br> Drag and Drop Here </br></br> <i class="fa-solid fa-up-down-left-right pb-3"></i></span>
                                            <input type="file" name="image" id="image" class="drop-zone__input">
                                        </div>
                                    </div>
                                    <div class="col mt-5 fw-bold fs-5"> <label>Caption:</label></div>
                                    <div class="col mt-5"><textarea placeholder="body" name="body" id="body" class="caption"></textarea></div>
                                    <div class="col mt-5 fs-5"> <label for="published">Publish: &nbsp;
                                            <input type="checkbox" value="1" name="published" id="published">&nbsp;
                                        </label>
                                    </div>
                                    <hr class="bg-danger mt-5 border-1 border-top border-dark">
                                    <div class="col mt-1 text-center">
                                        <button type="submit" name="submit" class="btn btn-primary text-center">Create</button>
                                    </div>
                                </form>
                            </div>
                        <?php } else {
                        ?>
                            <p>Sign in</p>
                        <?php } ?>
                    </div>
        </div>
    </div>
    </div>
    </div>
    </section>
    </main>
    </div>
    </div>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/l57m0aiuotugf5nvel03r8aqjckg7mb6plkqpi4bwan39iy9/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#body',
        plugins: [
          'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
          'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
          'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
        ],
        toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
      });
      function createPosts() {
    var data = new FormData;
    // var data = new FormData(document.getElementById("createPost"));
    data.append("csrf", document.getElementById("csrf").value);
    data.append("categoryID", document.getElementById("categoryID").value);
    data.append("title", document.getElementById("title").value);
    data.append("image", document.getElementById("image").value);
    data.append("published", document.getElementById("published").value);
    data.append("body", tinyMCE.get('body').getContent());
    fetch('?url=/posts/createPost', {
        method: 'POST',
        body: data,
    })
        .then(res => res.text())
        .then((txt) => {
            console.log(txt);
            // window.location = "?url=/pages/ManagePosts";
        });

    return false;
}
    </script>
    <script src="js/cc.js"> </script>
    <script src="https://kit.fontawesome.com/7f32366874.js" crossorigin="anonymous"></script>
    <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>