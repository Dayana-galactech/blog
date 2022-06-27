<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="/css/main.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body class="loginbg">
    <div class="container mt-5 pt-5 pb-0 mb-0 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <a href="https://dayana.galactech.cloud" class="blog-header-logo text-dark ps-5 pt-3">Blog</a>
                    <div class="card-body p-5 text-center">

                        <h3 class="mb-5">Sign in</h3>
                        <?php
                        if (session_id() == '') {
                            session_start();
                        }
                        $secret = "secretKey";
                        $csrf = hash_hmac('SHA256', uniqid(microtime()), $secret);
                        $_SESSION['csrf_token'] = $csrf;
                        ?>
                        <form method="POST" id="login" onsubmit="return login()">
                            <input type="hidden" name="csrf" value="<?php echo $csrf ?>">
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" aria-describedby="emailHelp" placeholder="Email" class="form-control form-control-lg" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-lg" />
                            </div>
                            <p class="py-3">No account?&nbsp;<a href="?url=/users/register">Create One </a></p>
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/login.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>