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
    <link href="http://localhost:8012/blog/css/main.min.css?ts=<?= time() ?>" rel="stylesheet">
    <title>Manage Posts</title>
</head>

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
                            <a class="nav-link" href="http://localhost:8012/blog/?url=/pages/yourArticles">
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
                            <a class="nav-link active" aria-current="page" href="http://localhost:8012/blog/?url=/pages/ManagePosts">
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
                    <div class="container my-5 text-center">

                        <?php
                        $secret = "secretKey";
                        $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                        $_SESSION['csrf_token'] = $csrf;

                        require_once('./controllers/get.php');
                        $posts = getAllPost();
                        if (isset($_SESSION['user']['type'])) {
                            $users = getPostByYou($_SESSION['user']['userID']);
                        }
                        $categories = getCategory();
                        ?>

                        <button type="button" class="bi bi-plus-circle-fill btn btn-primary my-5 " data-bs-toggle="modal" data-bs-target="#addModal">
                            Create New Post
                        </button>

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
                                                <td><button type="submit" class="btn btn-link" data-bs-target="#updateModal<?php echo $post['postID'] ?>" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a></td>
                                                <!-- The Modal -->
                                                <div class="modal" id="updateModal<?php echo $post['postID'] ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Update Post</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body text-center" id="<?php echo $post['postID'] ?>">
                                                                <form method="POST" id="updatePost<?php echo $post['postID'] ?>" onsubmit="return updatePost(<?php echo $post['postID'] ?>);">
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
                                                                    <div class="col  mt-5"> <input type="text" name="title" id="title" value="<?php echo $post['title'] ?>" aria-describedby="postHelp"></div>
                                                                    <div class="col  mt-5"> <input type="hidden" id="postID" name="postID" value="<?php echo $post['postID'] ?>"></div>
                                                                    <div class="col  mt-5"> <label>Featured image:</label></div>
                                                                    <div class="col  mt-5"> <input type="file" class="text-center ms-5 ps-3" name="image"></div>
                                                                    <div class="col mt-5"><textarea placeholder="body" name="body" id="body" cols="30" rows="10"><?php echo $post['body'] ?></textarea>
                                                                        <div class="col my-3"> <label for="published">Publish
                                                                                <input type="checkbox" value="1" name="published">&nbsp;
                                                                            </label>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
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
                                        if(sizeof($posts)>0){
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
                                                <td><button type="submit" class="btn btn-link" data-bs-target="#updateModal<?php echo $post['postID'] ?>" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a></td>
                                                <!-- The Modal -->
                                                <div class="modal" id="updateModal<?php echo $post['postID'] ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Update Post</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <!-- Modal body -->
                                                            <div class="modal-body text-center" id="<?php echo $post['postID'] ?>">
                                                                <form method="POST" id="updatePost<?php echo $post['postID'] ?>" onsubmit="return updatePost(<?php echo $post['postID'] ?>);">
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
                                                                    <div class="col  mt-5"> <input type="text" name="title" id="title" value="<?php echo $post['title'] ?>" aria-describedby="postHelp"></div>
                                                                    <div class="col  mt-5"> <input type="hidden" id="postID" name="postID" value="<?php echo $post['postID'] ?>"></div>
                                                                    <div class="col  mt-5"> <label>Featured image:</label></div>
                                                                    <div class="col  mt-5"> <input type="file" class="text-center ms-5 ps-3" name="image"></div>
                                                                    <div class="col mt-5"><textarea placeholder="body" name="body" id="body" cols="30" rows="10"><?php echo $post['body'] ?></textarea>
                                                                        <div class="col my-3"> <label for="published">Publish
                                                                                <input type="checkbox" value="1" name="published">&nbsp;
                                                                            </label>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <form id="deleteRow<?php echo $post['postID'] ?>" method="POST" onsubmit="return deletePost(<?php echo $post['postID'] ?>);">
                                                    <input type="hidden" id="postID" name="postID" value="<?php echo $post['postID'] ?>">
                                                    <td><button type="submit" name="submit" class="btn btn-link"><i class="bi bi-trash-fill"></i></button></td>
                                                </form>
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php } else{ ?>
                                <p class="h1 text-primary fw-bold text-center my-5"> No Articles Yet!</p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- <form method="POST" id="createComment" onsubmit="return createComment();">
                        <input type="hidden" name="csrf" value="<?php echo $csrf ?>">

                        <div class="col mt-5"><textarea placeholder="body" name="comment" id="comment" cols="40" rows="10"></textarea></div>
                        <button type="submit" name="submit" class="btn btn-primary mb-5 text-center">Comment</button>
                    </form> -->


        </div>
        </section>
        </main>
    </div>
    </div>





    <script src="js/createComment.js"> </script>
    <script src="js/updatePost.js"> </script>
    <script src="js/deletePost.js"> </script>
    <script src="js/createPosts.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>