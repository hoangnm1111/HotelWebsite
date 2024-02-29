<?php 
    $hname = "localhost";
    $uname = "root";
    $pass = "";
    $db = "hotelwebsite";

    $con = mysqli_connect($hname, $uname, $pass, $db);

    if(!$con) 
    {
        die("Không thể kết nối tới database".mysqli_connect_error());
    }

    function filteration($data)
    {
        foreach($data as $key => $value)
        {
            $value = trim($value);
            $value = stripcslashes($value);
            $value = htmlspecialchars($value);
            $value = strip_tags($value);
            $data[$key] = $value;
        }
        return $data;
    }

    function selectAll($table) {
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if ($statement = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($statement, $datatypes, ...$values);
            if (mysqli_stmt_execute($statement)) {
                $res = mysqli_stmt_get_result($statement);
                mysqli_stmt_close($statement);
                return $res;
            }
            else {
                mysqli_stmt_close($statement);
                die("Câu truy vấn select không thực hiện được");
            }
        }
        else {
            die("Câu truy vấn select không thực hiện được");
        }
    }

    function update($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if ($statement = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($statement, $datatypes, ...$values);
            if (mysqli_stmt_execute($statement)) {
                $res = mysqli_stmt_affected_rows($statement);
                mysqli_stmt_close($statement);
                return $res;
            }
            else {
                mysqli_stmt_close($statement);
                die("Câu truy vấn select không thực hiện được - Cập nhật");
            }
        }
        else {
            die("Câu truy vấn select không thực hiện được - Cập nhật");
        }
    }

    function insert($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if ($statement = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($statement, $datatypes, ...$values);
            if (mysqli_stmt_execute($statement)) {
                $res = mysqli_stmt_affected_rows($statement);
                mysqli_stmt_close($statement);
                return $res;
            }
            else {
                mysqli_stmt_close($statement);
                die("Câu truy vấn select không thực hiện được - Thêm");
            }
        }
        else {
            die("Câu truy vấn select không thực hiện được - Thêm");
        }
    }

    function delete($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if ($statement = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($statement, $datatypes, ...$values);
            if (mysqli_stmt_execute($statement)) {
                $res = mysqli_stmt_affected_rows($statement);
                mysqli_stmt_close($statement);
                return $res;
            }
            else {
                mysqli_stmt_close($statement);
                die("Câu truy vấn không thực hiện được - Xóa");
            }
        }
        else {
            die("Câu truy vấn không thực hiện được - Xóa");
        }
    }
?>