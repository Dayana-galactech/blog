<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="http://localhost:8012/blog/css/main.min.css?ts=<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" href="http://localhost:8012/blog/node_modules/owl.carousel/dist/assets/owl.carousel.min.css?ts=<?= time() ?>">
    <link rel="stylesheet" href="http://localhost:8012/blog/node_modules/owl.carousel/dist/assets/owl.theme.default.min.css?ts=<?= time() ?>">

    <title>Blog</title>
</head>

<body>
    <?php
    if (session_id() == '') {
        session_start();
    }
    $secret = "secretKey";
    $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
    $_SESSION['csrf_token'] = $csrf;
    require_once('./controllers/get.php');
    $posts = getPost();
    if (isset($_SESSION['user']['type'])) {
        $users = getPostByYou($_SESSION['user']['userID']);
    }
    $categories = getCategory();
    ?>
    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a class="blog-header-logo text-dark" href="http://localhost:8012/blog/">Blog</a>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <?php if (!isset($_SESSION['user']['type'])) { ?>
                        <a class="btn btn-sm btn-outline-secondary" href="http://localhost:8012/blog/?url=/users/login">Sign in</a>
                    <?php } else { ?>
                        <a class="btn btn-sm btn-outline-secondary" href="http://localhost:8012/blog/?url=/users/logout">Sign out</a>
                    <?php } ?>
                </div>
            </div>
        </header>

        <div class="nav-scroller px-1 py-1 mb-2 ">
            <nav class="nav d-flex justify-content-between">
                <?php $categories = getCategory();
                $num = 0;
                foreach ($categories as $category) :
                    $num++; ?>
                    <form method="POST" id="searchPosts<?php echo $category['categoryID'] ?>" onsubmit="return searchPosts(<?php echo $category['categoryID'] ?>);">
                        <input type="hidden" name="categoryID" value=<?php echo $category['categoryID'] ?>>
                        <button type="submit" name="submit" class="btn btn-link ps-3"><?php echo $category['name'] ?></button>
                    </form>
                <?php
                    if ($num >= 10) {
                        break;
                    }
                endforeach ?>
            </nav>
        </div>

    </div>

    <main class="container">
        <div class="p-4 p-md-5 mb-4 text-white rounded  cardcolor">
            <div class="col-md-6 px-0">
                <?php

                $postsID = changeone();
                ?>
                <?php $numm = 0;
                foreach ($postsID as $postID) :
                    $numm++;
                    if ($numm == sizeof($postsID)) {
                        $byPostsID = getPostByID($postID['postID']);
                        $categories = getPostCategory($postID['postID']);
                        if (isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == 'Admin') {
                            $posts = getPost();
                            foreach ($byPostsID as $byPostID) :
                                foreach ($categories as $category) :
                ?>
                                    <h1 class="display-4 fst-italic text-dark"><?php echo $byPostID['title'] ?></h1>
                                    <div class="text text-dark"><?php echo $byPostID['body'] ?></div>
                                    <button type="button" data-bs-target="#continueReading1<?php echo $byPostID['postID'] ?>" data-bs-toggle="modal" class="btn btn-link text-dark fs-5 fw-bold fst-italic">Continue reading</button>
                                    <form method="POST" id="changeone" onsubmit="return changeone();">
                                        <select name="postID">
                                            <option value="" selected disabled>Choose Article ID</option>
                                            <?php foreach ($posts as $post) : ?>
                                                <option value="<?php echo $post['postID']; ?>">
                                                    <?php echo $post['postID']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <?php $selected = $post['postID']; ?>
                                        </select>
                                        <button type="submit" name="submit" class="btn btn-primary">Change</button>
                                    </form>

                                    <!-- The Modal -->
                                    <div class="modal" id="continueReading1<?php echo $byPostID['postID'] ?>">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $byPostID['title'] ?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body text-center">
                                                    <div class="row">
                                                        <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $byPostID['image'] ?>"></image>
                                                        <p class="text-dark"><?php echo $byPostID['body'] ?></p>
                                                    </div>
                                                    <div class="row">
                                                        <p class="fs-6 fw-bold text-start text-dark fst-italic">Author:&nbsp;<?php echo $byPostID['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $byPostID['createdAt'] ?></p>
                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-12 col-lg-12">
                                                            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                                <div class="card-body p-4">
                                                                    <?php
                                                                    $comments = getComments($byPostID['postID']);
                                                                    if (sizeof($comments) > 0) {
                                                                        foreach ($comments as $comment) :
                                                                    ?>
                                                                            <div class="card mb-4">
                                                                                <div class="card-body text-start">
                                                                                    <p class="text-dark"><?php echo $comment['body'] ?></p>
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <div class="d-flex flex-row align-items-center">
                                                                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(4).webp" alt="avatar" width="25" height="25" />
                                                                                            <p class="small mb-0 ms-2 text-dark"><?php echo $comment['username'] ?> </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach;
                                                                    } else {
                                                                        ?>
                                                                        <div class="card mb-4">
                                                                            <div class="card-body text-start text-dark">
                                                                                <p>No comments yet!</p>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                                                        <?php if (isset($_SESSION['user']['type'])) { ?>
                                                                            <div class="d-flex flex-start w-100">
                                                                                <img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="40" height="40" />
                                                                                <div class="form-outline w-100" id="<?php echo $post['postID'] ?>">
                                                                                    <form method="POST" id="cc<?php echo $byPostID['postID'] ?>" onsubmit="return cc(<?php echo $byPostID['postID'] ?>);">
                                                                                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                                        <input type="hidden" name="postID" value="<?php echo $byPostID['postID']; ?>">
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

                                <?php endforeach;
                            endforeach;
                        } else {

                            foreach ($byPostsID as $byPostID) :
                                foreach ($categories as $category) :
                                ?>
                                    <h1 class="display-4 fst-italic text-dark"><?php echo $byPostID['title'] ?></h1>
                                    <div class="text text-dark"><?php echo $byPostID['body'] ?></div>
                                    <button type="button" data-bs-target="#continueReading1<?php echo $byPostID['postID'] ?>" data-bs-toggle="modal" class="btn btn-link text-dark fs-5 fw-bold fst-italic">Continue reading</button>
                                    <!-- The Modal -->
                                    <div class="modal" id="continueReading1<?php echo $byPostID['postID'] ?>">
                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $byPostID['title'] ?></h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body text-center">
                                                    <div class="row">
                                                        <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $byPostID['image'] ?>"></image>
                                                        <p class="text-dark"><?php echo $byPostID['body'] ?></p>
                                                    </div>
                                                    <div class="row">
                                                        <p class="fs-6 fw-bold text-start text-dark fst-italic">Author:&nbsp;<?php echo $byPostID['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $byPostID['createdAt'] ?></p>
                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-12 col-lg-12">
                                                            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                                <div class="card-body p-4">
                                                                    <?php
                                                                    $comments = getComments($byPostID['postID']);
                                                                    if (sizeof($comments) > 0) {
                                                                        foreach ($comments as $comment) :
                                                                    ?>
                                                                            <div class="card mb-4">
                                                                                <div class="card-body text-start">
                                                                                    <p class="text-dark"><?php echo $comment['body'] ?></p>
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <div class="d-flex flex-row align-items-center">
                                                                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(4).webp" alt="avatar" width="25" height="25" />
                                                                                            <p class="small mb-0 ms-2 text-dark"><?php echo $comment['username'] ?> </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        <?php endforeach;
                                                                    } else {
                                                                        ?>
                                                                        <div class="card mb-4">
                                                                            <div class="card-body text-start text-dark">
                                                                                <p>No comments yet!</p>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                                                        <?php if (isset($_SESSION['user']['type'])) { ?>
                                                                            <div class="d-flex flex-start w-100">
                                                                                <img class="rounded-circle shadow-1-strong me-3" src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="40" height="40" />
                                                                                <div class="form-outline w-100" id="<?php echo $post['postID'] ?>">
                                                                                    <form method="POST" id="cc<?php echo $byPostID['postID'] ?>" onsubmit="return cc(<?php echo $byPostID['postID'] ?>);">
                                                                                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                                        <input type="hidden" name="postID" value="<?php echo $byPostID['postID']; ?>">
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

                <?php endforeach;
                            endforeach;
                        }
                    }
                endforeach; ?>
            </div>
        </div>

        <div class="row mb-2">
            <?php $posts = getPostLimit();
            ?>
            <div class="owl-carousel owl-theme">
                <?php foreach ($posts as $post) : ?>
                    <div class="item">
                        <img src="http://localhost:8012/blog/images/<?php echo $post['image'] ?>" class="img-thumbnail" alt="<?php $post['title'] ?>">
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
        <div class="row g-5">
            <div class="col-md-8">
                <section>
                    <?php
                    $categorynum = 0;
                    $categories = getCategory();
                    foreach ($categories as $category) :
                        $categorynum++;
                        $postsnum = 0;
                        $byCategoriesID = getPostByCategory($category['categoryID']);
                        foreach ($byCategoriesID as $byCategoryID) :
                            $postsnum++;
                    ?>
                            <h3 class="pb-4 mb-4 fst-italic border-bottom categoryname">
                                <?php echo $category['name']; ?>
                            </h3>
                            <article class="blog-post my-5 cardcolor">
                                <h2 class="blog-post-title"><?php echo $byCategoryID['title'] ?></h2>
                                <?php
                                $authors = getPostByID($byCategoryID['postID']);
                                foreach ($authors as $author) : ?>
                                    <p class="blog-post-meta"><?php echo 'Date:&nbsp;' . $byCategoryID['createdAt'] . '&nbsp;&nbsp; by: &nbsp;' ?><a href="#"><?php echo $author['username'] ?></a></p>
                                <?php endforeach ?>
                                <p class="text"><?php echo $byCategoryID['body']; ?></p>
                                <button type="button" data-bs-target="#continueReading<?php echo $byCategoryID['postID'] ?>" data-bs-toggle="modal" class="btn btn-link">Continue reading</button>
                            </article>

                            <!-- The Modal -->
                            <div class="modal" id="continueReading<?php echo $byCategoryID['postID'] ?>">
                                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $byCategoryID['title'] ?></h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body text-center">
                                            <div class="row">
                                                <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $byCategoryID['image'] ?>"></image>
                                                <p><?php echo $byCategoryID['body'] ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="fs-6 fw-bold text-start fst-italic">Author:&nbsp;<?php echo $author['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $byCategoryID['createdAt'] ?></p>
                                            </div>

                                            <div class="row d-flex justify-content-center">
                                                <div class="col-md-12 col-lg-12">
                                                    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                        <div class="card-body p-4">
                                                            <?php
                                                            $comments = getComments($byCategoryID['postID']);
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
                                                                            <form method="POST" id="cc<?php echo $byCategoryID['postID'] ?>" onsubmit="return cc(<?php echo $byCategoryID['postID'] ?>);">
                                                                                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                                <input type="hidden" name="postID" value="<?php echo $byCategoryID['postID']; ?>">
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
                    <?php
                            if ($postsnum >= 1) {
                                break;
                            }
                        endforeach;
                        if ($categorynum >= 4) {
                            break;
                        }
                    endforeach;

                    ?>
                </section>
                <section>
                    <?php if (isset($_SESSION['user']['type'])) { ?>
                        <h3 class="fs-bold text-center">Add Your own Articles</h3>
                        <div class="row">
                            <div class="col-lg-6 text-center">
                                <button type="button" class="bi bi-plus-circle-fill btn btn-primary my-5" data-bs-toggle="modal" data-bs-target="#addCategory">
                                    Create New Category
                                </button>
                            </div>
                            <div class="col-lg-6 text-center">

                                <button type="button" class="bi bi-plus-circle-fill btn btn-primary my-5 " data-bs-toggle="modal" data-bs-target="#addModal">
                                    Create New Post
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!isset($_SESSION['user']['type'])) { ?>
                        <h3 class="fs-bold text-center">You want to Add your Own Articles?</h3>
                        <div class="row">
                            <div class="col-md-6 text-center my-4">
                                <h5 class="text-primary">Please Sign In </h5>
                                <a href="http://localhost:8012/blog/?url=/users/login" class="text-primary">Click me to login</a>
                            </div>
                            <div class="col-md-6 text-center my-4">
                                <h5 class="text-primary">Don't have an Account?</br></h5>
                                <a href="http://localhost:8012/blog/?url=/users/register">Click me to register</a>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- The Modal -->
                    <div class="modal" id="addCategory">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Create New Category</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form method="POST" id="createCategory" onsubmit="return createCategory();">
                                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                        <div class="row">
                                            <div class="text-center">
                                                <div class="my-4 ">
                                                    <label for="name" class=" fs-5 fw-bold mt-5 text-center">Category Name:</label>
                                                </div>
                                                <div class="my-4">
                                                    <input type="text" class=" text-center  rounded-3 my-3 " id="name" name="name" aria-describedby="categoryHelp">
                                                </div>
                                                <div>
                                                    <button type="submit" name="submit" class="btn btn-primary mb-5 text-center">Create</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Create Post -->
                    <div class="modal text-center" id="addModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Create New Post</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <form method="POST" id="createPost" onsubmit="return createPosts();">
                                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                        <div class="col-mt-5">
                                            <select name="categoryID">
                                                <option value="" selected disabled>Choose Category</option>
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?php echo $category['categoryID']; ?>">
                                                        <?php echo $category['name']; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="col  mt-5"> <input type="text" name="title" placeholder="Title"></div>
                                        <div class="col  mt-5"> <label>Featured image:</label></div>
                                        <div class="col  mt-5"> <input type="file" class="text-center ms-5 ps-3" name="image">
                                        </div>
                                        <div class="col mt-5"><textarea placeholder="body" name="body" id="body" cols="30" rows="10"></textarea></div>
                                        <div class="col my-3"> <label for="published">Publish
                                                <input type="checkbox" value="1" name="published">&nbsp;
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="submit" class="btn btn-primary text-center">Create</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="p-4 mb-3 bg-light rounded">
                        <h4 class="fst-italic">About</h4>
                        <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                    </div>

                    <div class="p-4">
                        <h4 class="fst-italic">Articles</h4>
                        <ol class="list-unstyled mb-0">
                            <li><a href="http://localhost:8012/blog/?url=/pages/categories">All Categories</a></li>
                            <?php if (isset($_SESSION['user']['type'])) { ?>
                                <li><a href="http://localhost:8012/blog/?url=/pages/yourArticles">Your Articles</a></li>

                                <li><a href="http://localhost:8012/blog/?url=/pages/ManageCategories">Manage Categories</a></li>
                                <li><a href="http://localhost:8012/blog/?url=/pages/ManagePosts">Manage Posts</a></li>
                            <?php } ?>
                        </ol>
                    </div>

                    <div class="p-4">
                        <h4 class="fst-italic">Elsewhere</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                            <li><a href="#">Instagram</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="blog-footer">
        <p>Blog </a></p>
        <p>
            <a href="#">Back to top</a>
        </p>
    </footer>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/cc.js"> </script>
    <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>