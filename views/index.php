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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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

        <div class="owl-one owl-carousel owl-theme">
            <div class="item ">
                <div class="p-4 p-md-5 mb-4 text-white rounded  cardcolor">
                    <!-- <div class="col-md-6 px-0"> -->
                    <?php

                    $postsID = changeone();
                    ?>
                    <?php $numm = 0;
                    foreach ($postsID as $postID) :
                        $numm++;
                        if ($numm == sizeof($postsID)) {
                            $byPostsID = getPostByID($postID['post1ID']);
                            $categories = getPostCategory($postID['post1ID']);
                            if (isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == 'Admin') {
                                $posts = getPost();
                                foreach ($byPostsID as $byPostID) :
                                    foreach ($categories as $category) :
                    ?>
                                        <div class="row ">
                                            <div class="col-md-6">
                                                <h1 class="title-animate animate__animated animate__flipInY animate__infinite display-4 fst-italic text-center text-md-start text-dark"><?php echo $byPostID['title'] ?></h1>
                                                <div class="text text-dark text-center text-md-start"><?php echo $byPostID['body'] ?></div>
                                                <div class="text-center text-md-start">
                                                    <button type="button" data-bs-target="#continueReading<?php echo $byPostID['postID'] ?>" data-bs-toggle="modal" class="hvr-grow btn btn-link text-dark fs-5 fw-bold text-center text-md-start fst-italic">Continue reading</button>
                                                </div>
                                            </div>
                                            <div class="hvr-grow col-md-6 text-center my-0 d-md-flex justify-content-md-center align-self-md-center">
                                                <form method="POST" id="changeone" onsubmit="return changeone();">
                                                    <select name="post1ID" class="bg-transparent border border-primary mt-1">
                                                        <option value="" selected disabled>First Article</option>
                                                        <?php foreach ($posts as $post) : ?>
                                                            <option value="<?php echo $post['postID']; ?>">
                                                                <?php echo $post['postID']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <select name="post2ID" class="bg-transparent border border-primary mt-1">
                                                        <option value="" selected disabled>Second Article</option>
                                                        <?php foreach ($posts as $post) : ?>
                                                            <option value="<?php echo $post['postID']; ?>">
                                                                <?php echo $post['postID']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <select name="post3ID" class="bg-transparent border border-primary mt-1">
                                                        <option value="" selected disabled>Third Article</option>
                                                        <?php foreach ($posts as $post) : ?>
                                                            <option value="<?php echo $post['postID']; ?>">
                                                                <?php echo $post['postID']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="row justify-content-center">
                                                        <button type="submit" name="submit" class=" btn btn-primary mt-1 w-25">Change</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                    <?php endforeach;
                                endforeach;
                            } else {

                                foreach ($byPostsID as $byPostID) :
                                    ?>
                                    <div class="row mt-md-4 mb-md-5 my-5 ">
                                        <div class="col-md-6 text-center ps-md-5">
                                            <h1 class="title-animate animate__animated animate__flipInY animate__infinite display-4 fst-italic text-dark"><?php echo $byPostID['title'] ?></h1>
                                        </div>
                                        <div class="col-md-6 text-center mt-2 pe-md-5">
                                            <div class="text text-dark"><?php echo $byPostID['body'] ?></div>
                                            <button type="button" data-bs-target="#continueReading<?php echo $byPostID['postID'] ?>" data-bs-toggle="modal" class="hvr-grow btn btn-link text-dark fs-5 fw-bold fst-italic">Continue reading</button>
                                        </div>
                                    </div>

                    <?php endforeach;
                            }
                        }
                    endforeach; ?>
                    <!-- </div> -->
                </div>
            </div>
            <div class="item ">
                <div class="p-4 p-md-5 mb-4 text-white rounded  cardcolor">

                    <?php
                    $posts2ID = changeone();
                    ?>
                    <?php $numm2 = 0;
                    foreach ($posts2ID as $post2ID) :
                        $numm2++;
                        if ($numm2 == sizeof($posts2ID)) { ?>

                            <?php $byPosts2ID = getPostByID($post2ID['post2ID']);
                            $categories2 = getPostCategory($post2ID['post2ID']);
                            foreach ($byPosts2ID as $byPost2ID) :  ?>
                                <div class="row mt-md-4 mb-md-5 my-5 ">
                                    <div class="col-md-6 text-center text-md-center ps-md-5">
                                        <h1 class="title-animate animate__animated animate__flipInY animate__infinite animate__slower display-4 fst-italic text-dark"><?php echo $byPost2ID['title'] ?></h1>
                                    </div>
                                    <div class="col-md-6 text-center mt-2 pe-md-5">
                                        <div class="text text-dark"><?php echo $byPost2ID['body'] ?></div>
                                        <button type="button" data-bs-target="#continueReading<?php echo $byPost2ID['postID'] ?>" data-bs-toggle="modal" class="hvr-grow btn btn-link text-dark fs-5 fw-bold fst-italic">Continue reading</button>
                                    </div>
                                </div>
                    <?php endforeach;
                        }
                    endforeach; ?>
                </div>
            </div>
            <div class="item ">
                <div class="p-4 p-md-5 mb-4 text-white rounded  cardcolor">

                    <?php

                    $posts3ID = changeone();
                    ?>
                    <?php $numm3 = 0;
                    foreach ($posts3ID as $post3ID) :
                        $numm3++;
                        if ($numm3 == sizeof($posts3ID)) {
                            $byPosts3ID = getPostByID($post3ID['post3ID']);
                            $categories3 = getPostCategory($post3ID['post3ID']);
                            foreach ($byPosts3ID as $byPost3ID) : ?>
                                <div class="row mt-md-4 mb-md-5 my-5 ">
                                    <div class="col-md-6 text-center text-md-center ps-md-5">
                                        <h1 class="title-animate animate__animated animate__flipInY animate__infinite animate__slower display-4 fst-italic text-dark"><?php echo $byPost3ID['title'] ?></h1>
                                    </div>
                                    <div class="col-md-6 text-center mt-2 pe-md-5">
                                        <div class="text text-dark"><?php echo $byPost3ID['body'] ?></div>
                                        <button type="button" data-bs-target="#continueReading<?php echo $byPost3ID['postID'] ?>" data-bs-toggle="modal" class="hvr-grow btn btn-link text-dark fs-5 fw-bold fst-italic">Continue reading</button>
                                    </div>
                                </div>
                    <?php endforeach;
                        }
                    endforeach; ?>

                </div>
            </div>
        </div>
        <?php

        $posts4ID = changeone();
        ?>
        <?php $numm4 = 0;
        foreach ($posts4ID as $post4ID) :
            $numm4++;
            if ($numm4 == sizeof($posts4ID)) {
                $byPosts4ID = getPostByID($post4ID['post1ID']);
                $categories4 = getPostCategory($post4ID['post1ID']);
                $posts4 = getPost();
                foreach ($byPosts4ID as $byPost4ID) :
                    foreach ($categories4 as $category4) :
        ?>
                        <!-- The Modal -->
                        <div class="modal" id="continueReading<?php echo $byPost4ID['postID'] ?>">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category4['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $byPost4ID['title'] ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $byPost4ID['image'] ?>"></image>
                                            <p class="text-dark"><?php echo $byPost4ID['body'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="fs-6 fw-bold text-start text-dark fst-italic">Author:&nbsp;<?php echo $byPost4ID['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $byPost4ID['createdAt'] ?></p>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                    <div class="card-body p-4">
                                                        <?php
                                                        $comments = getComments($byPost4ID['postID']);
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
                                                                    <div class="form-outline w-100" id="<?php echo $post4['postID'] ?>">
                                                                        <form method="POST" id="cc<?php echo $byPost4ID['postID'] ?>" onsubmit="return cc(<?php echo $byPost4ID['postID'] ?>);">
                                                                            <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                            <input type="hidden" name="postID" value="<?php echo $byPost4ID['postID']; ?>">
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
        endforeach; ?>


        <?php
        $posts5ID = changeone();
        $numm5 = 0;
        foreach ($posts5ID as $post5ID) :
            $numm5++;
            if ($numm5 == sizeof($posts5ID)) {
                $byPosts5ID = getPostByID($post5ID['post2ID']);
                $categories5 = getPostCategory($post5ID['post2ID']);
                $posts5 = getPost();
                foreach ($byPosts5ID as $byPost5ID) :
                    foreach ($categories5 as $category5) :
        ?>
                        <!-- The Modal -->
                        <div class="modal" id="continueReading<?php echo $byPost5ID['postID'] ?>">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category5['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $byPost5ID['title'] ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $byPost5ID['image'] ?>"></image>
                                            <p class="text-dark"><?php echo $byPost4ID['body'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="fs-6 fw-bold text-start text-dark fst-italic">Author:&nbsp;<?php echo $byPost5ID['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $byPost5ID['createdAt'] ?></p>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                    <div class="card-body p-4">
                                                        <?php
                                                        $comments2 = getComments($byPost5ID['postID']);
                                                        if (sizeof($comments2) > 0) {
                                                            foreach ($comments2 as $comment2) :
                                                        ?>
                                                                <div class="card mb-4">
                                                                    <div class="card-body text-start">
                                                                        <p class="text-dark"><?php echo $comment2['body'] ?></p>
                                                                        <div class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row align-items-center">
                                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(4).webp" alt="avatar" width="25" height="25" />
                                                                                <p class="small mb-0 ms-2 text-dark"><?php echo $comment2['username'] ?> </p>
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
                                                                    <div class="form-outline w-100" id="<?php echo $post5['postID'] ?>">
                                                                        <form method="POST" id="cc<?php echo $byPost5ID['postID'] ?>" onsubmit="return cc(<?php echo $byPost5ID['postID'] ?>);">
                                                                            <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                            <input type="hidden" name="postID" value="<?php echo $byPost5ID['postID']; ?>">
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
        endforeach; ?>

        <?php
        $posts6ID = changeone();
        $numm6 = 0;
        foreach ($posts6ID as $post6ID) :
            $numm6++;
            if ($numm6 == sizeof($posts5ID)) {
                $byPosts6ID = getPostByID($post6ID['post3ID']);
                $categories6 = getPostCategory($post6ID['post3ID']);
                $posts6 = getPost();
                foreach ($byPosts6ID as $byPost6ID) :
                    foreach ($categories6 as $category6) :
        ?>
                        <!-- The Modal -->
                        <div class="modal" id="continueReading<?php echo $byPost6ID['postID'] ?>">
                            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title categoryname">Category:&nbsp;<?php echo $category6['name'] ?>&nbsp;&nbsp;&nbsp; Title:&nbsp;<?php echo $byPost6ID['title'] ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body text-center">
                                        <div class="row">
                                            <image class="my-3" src="http://localhost:8012/blog/images/<?php echo $byPost6ID['image'] ?>"></image>
                                            <p class="text-dark"><?php echo $byPost6ID['body'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="fs-6 fw-bold text-start text-dark fst-italic">Author:&nbsp;<?php echo $byPost6ID['username'] ?>&nbsp;&nbsp;&nbsp; Date:&nbsp;<?php echo $byPost5ID['createdAt'] ?></p>
                                        </div>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-12 col-lg-12">
                                                <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                                    <div class="card-body p-4">
                                                        <?php
                                                        $comments3 = getComments($byPost6ID['postID']);
                                                        if (sizeof($comments3) > 0) {
                                                            foreach ($comments3 as $comment3) :
                                                        ?>
                                                                <div class="card mb-4">
                                                                    <div class="card-body text-start">
                                                                        <p class="text-dark"><?php echo $comment3['body'] ?></p>
                                                                        <div class="d-flex justify-content-between">
                                                                            <div class="d-flex flex-row align-items-center">
                                                                                <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(4).webp" alt="avatar" width="25" height="25" />
                                                                                <p class="small mb-0 ms-2 text-dark"><?php echo $comment3['username'] ?> </p>
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
                                                                    <div class="form-outline w-100" id="<?php echo $post6['postID'] ?>">
                                                                        <form method="POST" id="cc<?php echo $byPost6ID['postID'] ?>" onsubmit="return cc(<?php echo $byPost5ID['postID'] ?>);">
                                                                            <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                            <input type="hidden" name="postID" value="<?php echo $byPost6ID['postID']; ?>">
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
        endforeach; ?>

        <div class="row mb-2">
            <?php $posts = getPostLimit();
            ?>
            <div class="owl-two owl-carousel owl-theme">
                <?php foreach ($posts as $post) : ?>
                    <div class="item">
                        <a href="http://localhost:8012/blog/?url=/pages/categories"> <img src="http://localhost:8012/blog/images/<?php echo $post['image'] ?>" class="img-thumbnail" alt="<?php $post['title'] ?>"></a>
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
                            <div data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine" data-aos-duration="3000">
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
                            </div>

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
                                <a href="http://localhost:8012/blog/?url=/pages/createPost" class="bi bi-plus-circle-fill btn btn-primary my-5 ">
                                    Create New Post
                                </a>
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="js/cc.js"> </script>
    <script>
        const element = document.querySelector('.title-animate');
        element.style.setProperty('--animate-duration', '5s');
    </script>
    <script src="https://kit.fontawesome.com/7f32366874.js" crossorigin="anonymous"></script>
    <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>