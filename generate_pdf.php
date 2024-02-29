<?php
    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');
    require('admin/inc/mpdf/vendor/autoload.php');

    session_start();

    if(!(isset($_SESSION['user']) && $_SESSION['user'] == true)){
        redirect('index.php');
    }
    
    if(isset($_GET['gen_pdf']) && isset($_GET['id']))
    {
        $frm_data = filteration($_GET);

        $query = "SELECT bo.*, bd.*, uc.email FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        INNER JOIN `users` uc ON bo.user_id = uc.id
        WHERE ((bo.booking_status ='thành công' AND bo.arrival =1) 
        OR (bo.booking_status ='hủy bỏ' AND bo.refund =1)
        OR (bo.booking_status ='thất bại'))
        AND bo.booking_id = '$frm_data[id]'";

        $res = mysqli_query($con, $query);

        $total_rows = mysqli_num_rows($res);

        if ($total_rows == 0)
        {
            header('location: index.php');
            exit;
        }

        $data = mysqli_fetch_assoc($res);
        $date = date("h:i A | d-m-Y", strtotime($data['datetime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $table_data = "
        <h2>HÓA ĐƠN ĐẶT PHÒNG</h2>
        <table border='1'>
            <tr>
                <td>ID đặt phòng: $data[order_id]</td>
                <td>Ngày đặt phòng: $date</td>
            </tr>
            <tr>
                <td>Trạng thái: $data[booking_status]</td>
            </tr>
            <tr>
                <td>Tên: $data[user_name]</td>
                <td>Email: $data[email]</td>
            </tr>
            <tr>
                <td>Số điện thoại: $data[phonenum]</td>
            </tr>
            <tr>
                <td>Tên phòng: $data[room_name]</td>
                <td>Giá: $data[price] VND/đêm</td>
            </tr>
            <tr>
                <td>Check-in: $checkin</td>
                <td>Check-out: $checkout</td>
            </tr>
        ";

        if($data['booking_status'] == 'hủy bỏ')
        {
            $refund = ($data['refund']) ? "Đã hoàn tiền" : "Chưa hoàn tiền";

            $table_data.="<tr>
                <td>Thanh toán: $data[trans_amt]</td>
                <td>Hoàn tiền: $refund</td>
            </td>";
        } 
        else if($data['booking_status'] == 'thất bại'){
            $table_data.="<tr>
                <td>Chuyển khoản: $data[trans_amt]</td>
                <td>Phản hồi: $data[trans_resp_code]</td>
            </td>";
        }
        else
        {
            $table_data.="<tr>
                <td>Số phòng: $data[room_no]</td>
                <td>Thanh toán: $data[trans_amt]</td>
            </td>";
        }

        $table_data.="</table>";

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->WriteHTML($table_data);

        $mpdf->Output($data['order_id'].'.pdf','D');
    }
    else{
        header('location: index.php');
    }
?>