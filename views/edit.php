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
    <title>Update Posts</title>
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
                        if (isset($_SESSION['user']['type'])) {
                            $secret = "secretKey";
                            $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                            $_SESSION['csrf_post'] = $csrf;

                            require_once('./controllers/get.php');
                            $postID = $_SESSION['post']['postID'];

                            $posts = post($postID);


                            $users = getPostByYou($_SESSION['user']['userID']);
                            $categories = getCategory();
                            foreach ($posts as $post) :
                        ?>


                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Update Post</h4>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body text-center" id="<?php echo $post['postID'] ?>">
                                    <form method="POST" id="updatePost<?php echo $post['postID'] ?>" onsubmit="return updatePost(<?php echo $post['postID'] ?>);">
                                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                        <div class="col-mt-5">
                                            <select class="select" name="categoryID">
                                                <!-- <option value="" selected disabled>Choose Category</option> -->
                                                <?php foreach ($categories as $category) :
                                                    $select = getPostCategory($post['postID']);
                                                    foreach ($select as $selected) :
                                                ?>
                                                        <option value="<?php echo $selected['categoryID']; ?>" selected><?php echo $selected['name']; ?></option>
                                                    <?php endforeach; ?>
                                                    <option value="<?php echo $category['categoryID']; ?>">
                                                        <?php echo $category['name']; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col  mt-5"> <input type="text" class="select" name="title" id="title" value="<?php echo $post['title'] ?>" aria-describedby="postHelp"></div>
                                        <div class="col  mt-5"> <input type="hidden" id="postID" name="postID" value="<?php echo $post['postID'] ?>"></div>
                                        <div class="col mt-5 fw-bold fs-5"> <label>Featured image:</label></div>
                                        <div class="col mt-3 drag">
                                            <div class="drop-zone">
                                                <span class="drop-zone__prompt pt-3">Browse Image </br></br> OR </br></br> Drag and Drop Here </br></br> <i class="fa-solid fa-up-down-left-right pb-3"></i></span>
                                                <input type="file" name="image" class="drop-zone__input">
                                            </div>
                                        </div>
                                        <div class="col mt-5 fw-bold fs-5"> <label>Caption:</label></div>
                                        <div class="col mt-3"><textarea placeholder="body" name="body" id="body" class="caption"><?php echo $post['body'] ?></textarea>
                                            <div class="col my-3 fs-6"> <label for="published">Publish: &nbsp;
                                                    <?php if ($post['published'] == 1) { ?>
                                                        <input type="checkbox" name="published" checked>&nbsp;
                                                    <?php } else { ?>
                                                        <input type="checkbox" name="published">&nbsp;
                                                    <?php } ?>
                                                </label>
                                            </div>
                                            <hr class="bg-danger mt-5 border-1 border-top border-dark">
                                            <div class="col mt-1 text-center">
                                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                            </div>
                                    </form>
                                </div>


                            <?php endforeach;
                        } else {
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
    <script src="js/cc.js"> </script>
    <script src="https://kit.fontawesome.com/7f32366874.js" crossorigin="anonymous"></script>
    <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>