<?php

    require('../inc/db_config.php');
    require('../inc/essentials.php');
    //adminLogin();

    if (isset($_POST['get_users'])) {
        $res = selectAll('users');
        $i = 1;

        $data = "";

        while ($row = mysqli_fetch_assoc($res)) {
            $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                <i class='bi bi-trash'></i> delete
            </button>";

            $data.="
                <tr>
                    <td>$i</td>
                    <td>$row[full_name]</td>
                    <td>$row[idencard]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[email]</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['remove_user'])) 
    {
        $frm_data = filteration($_POST);
        
        $res = delete("DELETE FROM `users` WHERE `id` =?", [$frm_data['user_id']], 'i');

        if ($res) {
            echo 1;
        }
        else {
            echo 0;
        }

    }

    if (isset($_POST['search_user'])) {
        $frm_data = filteration($_POST);

        $query = "SELECT * FROM `users` WHERE `full_name` LIKE ?";

        $res = select($query, ["%$frm_data[name]%"], 's');
        $i = 1;

        $data = "";

        while ($row = mysqli_fetch_assoc($res)) {
            $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                <i class='bi bi-trash'></i> delete
            </button>";

            $data.="
                <tr>
                    <td>$i</td>
                    <td>$row[full_name]</td>
                    <td>$row[idencard]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[email]</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }
?>