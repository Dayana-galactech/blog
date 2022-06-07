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
                    <a class="nav-link px-3" href="http://localhost:8012/blog/?url=/users/logout">Sign out</a>
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
                <?php
                if (session_id() == '') {
                    session_start();
                }
                $userID=$_SESSION['user']['userID'];
                $posts = getPostByYou($userID);
               ?>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <section>
                        <div class="container-fluid">
                            <div class="row">
                                <?php  if(sizeof($posts)>0){
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
                                                     $categories=getPostCategory($post['postID']);
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
                                                
                                                <div class="row">
                                                    <div class="col-lg-6">

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <?php if (isset($_SESSION['user']['type'])) { ?>

                                                            <div id="<?php echo $post['postID'] ?>">
                                                                <form method="POST" id="createComment<?php echo $post['postID'] ?>" onsubmit="return createComment(<?php echo $post['postID'] ?>);">
                                                                    <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                    <input type="hidden" name="postID" value="<?php echo $post['postID']; ?>">
                                                                    <div class="col mt-5"><textarea placeholder="body" name="comment" id="comment" cols="40" rows="10"></textarea></div>
                                                                    <button type="submit" name="submit" class="btn btn-primary mb-5 text-center">Comment</button>
                                                                </form>
                                                            </div>
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

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                <?php } else{ ?>
                                <p class="h1 text-primary fw-bold text-center my-5"> No Articles Yet!</p>
                                <?php } ?>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>

</html>