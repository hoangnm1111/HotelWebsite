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
    <title>Form Đăng ký</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('https://images.pexels.com/photos/338504/pexels-photo-338504.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
        }  
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $idencard = $_POST["idencard"]; // Số cccd
           $phonenum = $_POST["phonenum"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
       
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (!ctype_digit($idencard) || strlen($idencard) != 12) {
            array_push($errors, "Chỉ chấp nhận số CCCD đúng 12 chữ số");
           }
           if (!ctype_digit($phonenum) || strlen($phonenum) != 10) {
            array_push($errors, "Chỉ chấp nhận SĐT đúng 10 chữ số");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email không hợp lệ");
           }    
           if (strlen($password) < 6) {
            array_push($errors, "Mật khẩu phải có ít nhất 6 ký tự");
           }
           if ($password != $passwordRepeat) {
            array_push($errors, "Mật khẩu không khớp");
           }
           require_once "database.php";
           
           $sql = "SELECT * FROM users WHERE email = '$email'";      
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount > 0) {
                array_push($errors,"Email đã tồn tại!");
           }

           $sql2 = "SELECT * FROM users WHERE phonenum = '$phonenum'";
           $result2 = mysqli_query($conn, $sql2);
           $rowCount2 = mysqli_num_rows($result2);
           if ($rowCount2 > 0) {
                array_push($errors,"SĐT đã tồn tại!");
           }
                
            if (count($errors)>0) 
           {
                foreach ($errors as  $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
           } 
           
           else
           { 
                $sql = "INSERT INTO users (full_name, idencard, phonenum, email, password) VALUES ( ?, ?, ?, ?, ? )";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt,"sssss",$fullName, $idencard, $phonenum, $email, $passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>Đăng ký thành công.</div>";
                } else{
                    die("Đã có sự cố");
                }
           }       
        }
        ?>
        
        <form action="registration.php" method="post">
            <span class="badge rounded-pill bg-warning text-dark mb-3 text-wrap lh-base">
                Chú ý: Nhập đúng thông tin cá nhân, khi check-in trực tiếp chúng tôi sẽ kiểm tra
            </span>
            <div class="form-group">
                <input type="text" required type="text" class="form-control" name="fullname" placeholder="Họ và tên:">
            </div>
            <div class="form-group">
                <input type="number" required type="number" class="form-control" name="idencard" placeholder="Số Căn cước công dân:">
            </div>
            <div class="form-group">
                <input type="number" required type="number" class="form-control" name="phonenum" placeholder="Số điện thoại:">
            </div>
            <div class="form-group">
                <input type="email" required type="email" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" required type="password" class="form-control" name="password" placeholder="Mật khẩu:">
            </div>
            <div class="form-group">
                <input type="password" required type="password" class="form-control" name="repeat_password" placeholder="Nhập lại mật khẩu:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Đăng ký" name="submit">
            </div><br>
        </form>
        <div>
            <div>
                <p>Đã có tài khoản? <a href="login.php">Đăng nhập tại đây</a></p>
            </div>
        </div>
    </div>
</body>
</html>