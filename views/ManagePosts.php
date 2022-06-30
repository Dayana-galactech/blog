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
    <title>Manage Posts</title>
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
                <?php if (isset($_SESSION['user']['type'])) { ?>
                    <section class="my-5">
                        <div class="container my-5 text-center">

                            <?php
                            $secret = "secretKey";
                            $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                            $_SESSION['csrf_post'] = $csrf;

                            require_once('./controllers/get.php');
                            $posts = getAllPost();
                            if (isset($_SESSION['user']['type'])) {
                                $users = getPostByYou($_SESSION['user']['userID']);
                            }
                            $categories = getCategory();
                            ?>
                            <a href="?url=/pages/createPost" class="bi bi-plus-circle-fill btn btn-primary my-5 ">
                                Create New Post
                            </a>
                            <?php if ($_SESSION['user']['type'] == 'Admin') {
                            ?>
                                <div class="overflow-auto text-nowrap table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Post ID</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Published</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($posts as $post) :
                                                $postcategories = getPostCategory($post['postID']);
                                                foreach ($postcategories as $postcategory) :
                                            ?>
                                                    <tr>
                                                        <td>><?php echo $post['postID'] ?></td>
                                                        <td><?php echo $post['title'] ?></td>
                                                        <td><?php echo $postcategory['name'] ?></td>
                                                    <?php endforeach; ?>
                                                    <td><?php echo $post['username'] ?></td>
                                                    <?php
                                                    if ($post['published'] == '0') {
                                                        $published = 'Not Yet';
                                                    } else {
                                                        $published = 'Yes';
                                                    }
                                                    ?>
                                                    <td><?php echo $published ?></td>
                                                    <td><?php echo $post['createdAt'] ?></td>
                                                    <form action="POST" id="edit<?php echo $post['postID'] ?>" onsubmit="return edit(<?php echo $post['postID'] ?>);">
                                                        <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                                        <td><button type="submit" class="btn btn-link"><i class="bi bi-pencil-square"></i></button></td>
                                                    </form>
                                </div>
                                <form id="deleteRow<?php echo $post['postID'] ?>" method="POST" onsubmit="return deletePost(<?php echo $post['postID'] ?>);">
                                    <input type="hidden" id="postID" name="postID" value="<?php echo $post['postID'] ?>">
                                    <td><button type="submit" name="submit" class="btn btn-link"><i class="bi bi-trash-fill"></i></button></td>
                                </form>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    <?php } else {
                                $userID = $_SESSION['user']['userID'];
                                $posts = getPostByYou($userID);
                    ?>
                        <div class="overflow-auto text-nowrap table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Post ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Published</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (sizeof($posts) > 0) {
                                        foreach ($posts as $post) :
                                            $postcategories = getPostCategory($post['postID']);
                                            foreach ($postcategories as $postcategory) :
                                    ?>
                                                <tr>
                                                    <td>><?php echo $post['postID'] ?></td>
                                                    <td><?php echo $post['title'] ?></td>
                                                    <td><?php echo $postcategory['name'] ?></td>
                                                <?php endforeach; ?>
                                                <td><?php echo $post['username'] ?></td>
                                                <?php
                                                if ($post['published'] == '0') {
                                                    $published = 'Not Yet';
                                                } else {
                                                    $published = 'Yes';
                                                }
                                                ?>
                                                <td><?php echo $published ?></td>
                                                <td><?php echo $post['createdAt'] ?></td>
                                                <form action="POST" id="edit<?php echo $post['postID'] ?>" onsubmit="return edit(<?php echo $post['postID'] ?>);">
                                                    <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                                    <td><button type="submit" class="btn btn-link"><i class="bi bi-pencil-square"></i></button></td>
                                                </form>
                                                <form id="deleteRow<?php echo $post['postID'] ?>" method="POST" onsubmit="return deletePost(<?php echo $post['postID'] ?>);">
                                                    <input type="hidden" id="postID" name="postID" value="<?php echo $post['postID'] ?>">
                                                    <td><button type="submit" name="submit" class="btn btn-link"><i class="bi bi-trash-fill"></i></button></td>
                                                </form>
                                                </tr>
                                            <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="h1 text-primary fw-bold text-center my-5"> No Articles Yet!</p>
                        <?php } ?>
                        </div>
                    <?php } ?>
        </div>
    </div>
    </section>
<?php } else { ?>
    <p>Sign in</p>
<?php } ?>
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