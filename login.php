<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('https://images.pexels.com/photos/279746/pexels-photo-279746.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
        }  
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    $_SESSION['uId'] = $user['id'];
                    $_SESSION["uName"] = $user['full_name'];
                    $_SESSION["uIdencard"] = $user['idencard'];
                    $_SESSION["uPhone"] = $user['phonenum'];
                    header("Location: index.php");
                    die();
                }
                else{
                    echo "<div class='alert alert-danger'>Mật khẩu không đúng</div>";
                }
            }
            else{
                echo "<div class='alert alert-danger'>Email không tồn tại</div>";
            }
        }
        ?>
      <form action="login.php" method="post">
        <div class="form-group">
            <input type="email" required type="email" placeholder="Nhập Email:" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" required type="password" placeholder="Nhập mật khẩu:" name="password" class="form-control">
        </div>
        <div class="form-group" style="display: flex; justify-content: space-between; align-items: center">
            <input type="submit" value="Đăng nhập" name="login" class="btn btn-primary">
            <p><a href="forgot_password.php">Quên mật khẩu?</a></p>
        </div>
      </form>
     <div><p>Chưa có tài khoản? <a href="registration.php">Đăng ký tại đây</a></p></div>
    </div>
</body>
</html>