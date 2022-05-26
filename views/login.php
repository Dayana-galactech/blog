<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="css/main.min.css" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="container pt-5 mt-5">
        <div id="responselogin"></div>
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
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class=" text-center ">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>

    <script src="../js/login.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>