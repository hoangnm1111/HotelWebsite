<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
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
        session_start();
        require_once "database.php";

        if (isset($_POST["check_email"])) {
            $email = $_POST["email"];
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                $_SESSION["email"] = $email;
                $_SESSION["reset_stage"] = "check_otp";
            } else {
                echo "<div class='alert alert-danger'>Email không tồn tại</div>";
            }
        }

        if (isset($_POST["check_otp"])) {
            $otp = $_POST["otp"];
            if ($otp == '789789') {
                $_SESSION["reset_stage"] = "reset_password";
            } 
            else {
                echo "<div class='alert alert-danger'>Mã OTP không đúng</div>";
            }
        }

        if (isset($_POST["reset_password"]) && isset($_SESSION["email"])) {
            $email = $_SESSION["email"];
            $new_password = $_POST["new_password"];
            $confirm_password = $_POST["confirm_password"];
            if (strlen($new_password) < 6) {
                echo "<div class='alert alert-danger'>Mật khẩu phải có ít nhất 6 ký tự</div>";
            }
            else if ($new_password == $confirm_password) {
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = '$new_password_hash' WHERE email = '$email'";
                if (mysqli_query($conn, $sql)) {
                    unset($_SESSION["email"]);
                    unset($_SESSION["reset_stage"]);
                    header("Location: login.php");
                    die();
                } 
                else {
                    echo "<div class='alert alert-danger'>Có lỗi xảy ra</div>";
                }
            } 
            else {
                echo "<div class='alert alert-danger'>Mật khẩu không khớp</div>";
            }
        }

        if (!isset($_SESSION["reset_stage"])) {
            $_SESSION["reset_stage"] = "check_email";
        }

        if ($_SESSION["reset_stage"] == "check_email") {
            echo '
                <form action="forgot_password.php" method="post">
                    <div class="form-group">
                        <input type="email" required type="email" placeholder="Nhập Email khôi phục:" name="email" class="form-control">
                    </div>
                    <div class="form-btn">
                        <input type="submit" value="Gửi mã OTP" name="check_email" class="btn btn-primary">
                    </div>
                </form>
            ';
        } 
        else if ($_SESSION["reset_stage"] == "check_otp") {
            echo '
                <form action="forgot_password.php" method="post">
                    <div>
                        <p>Hệ thống đã gửi mã OTP đến email của bạn. Vui lòng kiểm tra!</p>
                    </div>
                    <div class="form-group">
                        <input type="number" required type="number" placeholder="Nhập mã OTP:" name="otp" class="form-control">
                    </div>
                    <div class="form-btn">
                        <input type="submit" value="Xác nhận" name="check_otp" class="btn btn-primary">
                    </div>
                </form>
            ';
        } 
        else if ($_SESSION["reset_stage"] == "reset_password") {
            $email = $_SESSION["email"];
            echo '
                <form action="forgot_password.php" method="post">
                    <div>
                        <p>Đặt lại mật khẩu cho tài khoản '.$email.'</p>
                    </div>
                    <div class="form-group">
                        <input type="password" required type="password" placeholder="Nhập mật khẩu mới:" name="new_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" required type="password" placeholder="Xác nhận mật khẩu mới:" name="confirm_password" class="form-control">
                    </div>
                    <div class="form-btn">
                        <input type="submit" value="Xác nhận" name="reset_password" class="btn btn-primary">
                    </div>
                </form>
            ';
        }
        ?>
    </div>
</body>
</html>
