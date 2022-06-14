<?php require_once('./controllers/get.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="http://localhost:8012/blog/css/main.min.css?ts=<?= time() ?>" rel="stylesheet">
    <title>Your Articles</title>
</head>

<body>

    <body>
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-12 col-md-3 col-lg-2 me-0 px-3 text-center" href="http://localhost:8012/blog">Blog</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <?php if (isset($_SESSION['user']['type'])) { ?> <a class="nav-link px-3" href="http://localhost:8012/blog/?url=/users/logout">Sign out</a> <?php } else { ?>
                        <a class="nav-link px-3" href="http://localhost:8012/blog/?url=/users/logout">Sign in</a> <?php } ?>
                </div>
            </div>
        </header>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column fs-5 pt-lg-5 my-5 ps-lg-3">
                            <li class="nav-item">
                                <a class="nav-link" href="http://localhost:8012/blog/?url=/pages/categories">
                                    <span data-feather="file"></span>
                                    All Categories
                                </a>
                            </li>
                            <?php if (isset($_SESSION['user']['type'])) { ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="http://localhost:8012/blog/?url=/pages/yourArticles">
                                        <span data-feather="shopping-cart"></span>
                                        Your Articles
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost:8012/blog/?url=/pages/ManageCategories">
                                        <span data-feather="users"></span>
                                        Manage Categories
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="http://localhost:8012/blog/?url=/pages/ManagePosts">
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
                        <?php
                        if (session_id() == '') {
                            session_start();
                        }
                        $secret = "secretKey";
                        $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                        $_SESSION['csrf_token'] = $csrf;
                        $userID = $_SESSION['user']['userID'];
                        $posts = getPostByYou($userID);
                        ?>
                        <section>
                            <div class="container-fluid">
                                <div class="row">
                                    <?php if (sizeof($posts) > 0) {
                                        foreach ($posts as $post) : ?>
                                            <article class="blog-post my-5 cardcolor">
                                                <h2 class="blog-post-title"><?php echo $post['title'] ?></h2>
                                                <p class="blog-post-meta"><?php echo 'Date:&nbsp;' . $post['createdAt'] . '&nbsp;&nbsp; by: &nbsp;' ?><a href="#"><?php echo $post['username'] ?></a></p>

                                                <p class="text"><?php echo $post['body']; ?></p>
                                                <button type="button" data-bs-target="#continueReading<?php echo $post['postID'] ?>" data-bs-toggle="modal" class="btn btn-link">Continue reading</button>
                                            </article>
                                            <!-- The Modal -->
                                            <div class="modal" id="continueReading<?php echo $post['postID'] ?>">
                                                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <?php
                                                            $categories = getPostCategory($post['postID']);
                                                            foreach ($categories as $category) : ?>
                                                                <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $post['title'] ?></h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            <?php endforeach; ?>

                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body text-center">
                                                            <div class="row">
                                                                <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $post['image'] ?>"></image>
                                                                <p><?php echo $post['body'] ?></p>
                                                            </div>
                                                            <div class="row">
                                                                <p class="fs-6 fw-bold text-start fst-italic">Author:&nbsp;<?php echo $post['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $post['createdAt'] ?></p>
                                                            </div>

                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col-md-12 col-lg-12">
                                                                    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                                        <div class="card-body p-4">
                                                                            <?php
                                                                            $comments = getComments($post['postID']);
                                                                            if (sizeof($comments) > 0) {
                                                                                foreach ($comments as $comment) :
                                                                            ?>
                                                                                    <div class="card mb-4">
                                                                                        <div class="card-body text-start">
                                                                                            <p><?php echo $comment['body'] ?></p>
                                                                                            <div class="d-flex justify-content-between">
                                                                                                <div class="d-flex flex-row align-items-center">
                                                                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(4).webp" alt="avatar" width="25" height="25" />
                                                                                                    <p class="small mb-0 ms-2"><?php echo $comment['username'] ?> </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php endforeach;
                                                                            } else {
                                                                                ?>
                                                                                <div class="card mb-4">
                                                                                    <div class="card-body text-start">
                                                                                        <p>No comments yet!</p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php } ?>
                                                                            <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                                                                <?php if (isset($_SESSION['user']['type'])) { ?>
                                                                                    <div class="d-flex flex-start w-100">
                                                                                        <img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="40" height="40" />
                                                                                        <div class="form-outline w-100" id="<?php echo $post['postID'] ?>">
                                                                                            <form method="POST" id="cc<?php echo $post['postID'] ?>" onsubmit="return cc(<?php echo $post['postID'] ?>);">
                                                                                                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                                                <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                                                                                <textarea class="form-control" placeholder="body" name="body" id="body" rows="4" style="background: #fff;"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="float-end mt-2 pt-1">
                                                                                        <button type="submit" name="submit" class="btn btn-primary btn-sm">Post comment</button>
                                                                                    </div>
                                                                                    </form>
                                                                                <?php } ?>
                                                                                <?php if (!isset($_SESSION['user']['type'])) { ?>
                                                                                    <h6 class="text-danger">Please SignIn to Comment on this Post!</h6>
                                                                                    <a href="http://localhost:8012/blog/?url=/users/login" class="text-danger">Click me to login</a>

                                                                                    <h6 class="text-primary mt-4">Don't have an Account?</br></h6>
                                                                                    <a href="http://localhost:8012/blog/?url=/users/register">Click me to register</a>

                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php } else { ?>
                                        <p class="h1 text-primary fw-bold text-center my-5"> No Articles Yet!</p>
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
        <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>

</html>