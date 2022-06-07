<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="http://localhost:8012/blog/css/main.min.css?ts=<?= time() ?>" rel="stylesheet">
    <title>Manage Categories</title>
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
                                <a class="nav-link active" aria-current="page" href="http://localhost:8012/blog/?url=/pages/ManageCategories">
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
                <section class="my-5">
                    <div class="container my-5">
                        <?php
                        if (session_id() == '') {
                            session_start();
                        }
                        $secret = "secretKey";
                        $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                        $_SESSION['csrf_token'] = $csrf;
                        ?>
                        <section>
                            <div class="container text-center">
                                <button type="button" class="bi bi-plus-circle-fill btn btn-primary my-5" data-bs-toggle="modal" data-bs-target="#addModal">
                                    Create New Category
                                </button>
                                <!-- The Modal -->
                                <div class="modal" id="addModal">
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
                            </div>
                        </section>
                        <?php if ($_SESSION['user']['type'] == 'Admin') {
                                ?>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Category name</th>
                                        <th scope="col">Created By:</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php require_once('./controllers/get.php');
                                    $categories = getCategory();
                                    $user = getCategoryByYou();
                                    ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <tr>
                                            <td>><?php echo $category['name'] ?></td>
                                            <td><?php echo $category['username'] ?></td>
                                            <td><button type="submit" class="btn btn-link" data-bs-target="#updateModal<?php echo $category['categoryID'] ?>" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a></td>
                                            <!-- The Modal -->
                                            <div class="modal" id="updateModal<?php echo $category['categoryID'] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Category</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body" id="<?php echo $category['categoryID'] ?>">
                                                            <form method="POST" id="updateCategory<?php echo $category['categoryID'] ?>" onsubmit="return updateCategory(<?php echo $category['categoryID'] ?>);">
                                                                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                <div class="row">
                                                                    <div class="text-center">
                                                                        <div class="my-4 ">
                                                                            <label for="name" class=" fs-5 fw-bold mt-5 text-center">Category Name:</label>
                                                                        </div>
                                                                        <div class="my-4">
                                                                            <input type="text" class=" text-center  rounded-3 my-3 " id="name" name="name" value="<?php echo $category['name'] ?>" aria-describedby="categoryHelp">
                                                                            <input type="hidden" id="categoryID" name="categoryID" value="<?php echo $category['categoryID'] ?>">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" name="submit" class="btn btn-primary mb-5 text-center">Update</button>
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
                                            <form id="deleteRow<?php echo $category['categoryID'] ?>" method="POST" onsubmit="return deletecategory(<?php echo $category['categoryID'] ?>);">
                                                <input type="hidden" id="categoryID" name="categoryID" value="<?php echo $category['categoryID'] ?>">
                                                <td><button type="submit" name="submit" class="btn btn-link"><i class="bi bi-trash-fill"></i></button></td>
                                            </form>
                                        </tr>

                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php }
                        else{ ?>
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Category name</th>
                                        <th scope="col">Created By:</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $users = getCategoryByYou();
                                    ?>
                                    <?php
                                    if(sizeof($users)>0){
                                     foreach ($users as $user) : ?>
                                        <tr>
                                            <td>><?php echo $user['name'] ?></td>
                                            <td><?php echo $user['username'] ?></td>
                                            <td><button type="submit" class="btn btn-link" data-bs-target="#updateModal<?php echo $user['categoryID'] ?>" data-bs-toggle="modal"><i class="bi bi-pencil-square"></i></a></td>
                                            <!-- The Modal -->
                                            <div class="modal" id="updateModal<?php echo $user['categoryID'] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Update Category</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <!-- Modal body -->
                                                        <div class="modal-body" id="<?php echo $user['categoryID'] ?>">
                                                            <form method="POST" id="updateCategory<?php echo $user['categoryID'] ?>" onsubmit="return updateCategory(<?php echo $user['categoryID'] ?>);">
                                                                <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                                                                <div class="row">
                                                                    <div class="text-center">
                                                                        <div class="my-4 ">
                                                                            <label for="name" class=" fs-5 fw-bold mt-5 text-center">Category Name:</label>
                                                                        </div>
                                                                        <div class="my-4">
                                                                            <input type="text" class=" text-center  rounded-3 my-3 " id="name" name="name" value="<?php echo $user['name'] ?>" aria-describedby="categoryHelp">
                                                                            <input type="hidden" id="categoryID" name="categoryID" value="<?php echo $user['categoryID'] ?>">
                                                                        </div>
                                                                        <div>
                                                                            <button type="submit" name="submit" class="btn btn-primary mb-5 text-center">Update</button>
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
                                            <form id="deleteRow<?php echo $user['categoryID'] ?>" method="POST" onsubmit="return deletecategory(<?php echo $user['categoryID'] ?>);">
                                                <input type="hidden" id="categoryID" name="categoryID" value="<?php echo $user['categoryID'] ?>">
                                                <td><button type="submit" name="submit" class="btn btn-link"><i class="bi bi-trash-fill"></i></button></td>
                                            </form>
                                        </tr>

                                    <?php endforeach; 
                                    }else {
                                    ?>
                                </tbody>
                            </table>
                            <p class="h1 text-primary fw-bold text-center my-5"> No Categories Yet!</p>
                                <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <!-- <script src="js/displayCategory.js"></script> -->
    <script src="js/updateCategory.js"></script>
    <script src="js/deleteCategory.js"></script>
    <script src="js/createCategory.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>