<?php
if(session_id() == ''){
    session_start();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="css/main.min.css" rel="stylesheet">
    <title>Blog</title>
</head>

<body>

<p>HELLO <?= $_SESSION['user']['username'] ?></p>
    <p></br>Your email is: <?= $_SESSION['user']['email'] ?></p>
    <p></br> Click here to <a href="http://localhost:8012/blog/?url=/users/logout" tite="Logout">Logout.</p>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>