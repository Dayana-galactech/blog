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
    <title>Categories</title>
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-12 col-md-3 col-lg-2 me-0 px-3 text-center" href="https://dayana.galactech.cloud">Blog</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if (isset($_SESSION['user']['type'])) { ?>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <p class="fs-6 text-white pt-3 ps-2 ps-lg-0 text-uppercase">Hello <?php echo $_SESSION['user']['username'] ?></p>
                </div>
            </div><?php } ?>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
            <?php if (isset($_SESSION['user']['type'])) { ?>  <a class="nav-link px-3" href="?url=/users/logout">Sign out</a> <?php } else{ ?>
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
                            <a class="nav-link active" aria-current="page" href="?url=/pages/categories">
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
                                <a class="nav-link" href="?url=/pages/ManagePosts">
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
                        $secret = "secretKey";
                        $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                        $_SESSION['csrf_category'] = $csrf;
                        ?>
                        <?php if (isset($_SESSION['user']['type'])) { ?>
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
                                                        <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf_category'] ?>">
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
                        <?php } ?>
                        <section class="my-5">
                            <div class="container">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Category name</th>
                                                <th scope="col">Created By:</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php require_once('./controllers/get.php');
                                            $categories = getCategory();
                                            ?>
                                            <?php foreach ($categories as $category) : ?>
                                                <tr>
                                                    <td>> <?php echo $category['name'] ?></a></td>
                                                    <td><?php echo $category['username'] ?></td>

                                                <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                        <section class="my-5">
                            <div class="container text-center">
                                <div class="row">
                                    <div class="col-lg-3 fs-5 fw-bold mt-5 pe-lg-3 text-lg-end">
                                        Search Articles by Categories
                                    </div>

                                    <div class="col-lg-9 ps-lg-5 text-lg-start mt-5">
                                        <form method="POST" id="searchPosts" onsubmit="return searchPost();">
                                            <select name="categoryID">
                                                <option value="" selected disabled>Choose Category</option>
                                                <?php foreach ($categories as $category) : ?>
                                                    <option value="<?php echo $category['categoryID']; ?>">
                                                        <?php echo $category['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                                <?php $selected = $_POST['categoryID']; ?>
                                            </select>
                                            <button type="submit" name="submit" class="btn btn-primary ps-3">search</button>
                                    </div>
                                    </form>
                                </div>

                            </div>
                        </section>

                    </div>

                </section>
            </main>
        </div>
    </div>
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="js/cc.js"> </script>
    <script src="node_modules/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>