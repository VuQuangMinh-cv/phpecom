<?php
include('config/dbcon.php');

$query = "SELECT id, name, email, phone, role_as FROM users";
$query_run = mysqli_query($con, $query);

if ($query_run) {
    $file = fopen("user_data.txt", "w");

    if ($file) {
        fwrite($file, "ID\tTên\tEmail\tSố điện thoại\tVai trò\n");
        fwrite($file, "---------------------------------------------\n");

        while ($row = mysqli_fetch_assoc($query_run)) {
            $id = $row['id'];
            $name = $row['name'];
            $email = $row['email'];
            $phone = $row['phone'];
            $role_as = $row['role_as'] == 1 ? 'Admin' : 'User';

            $line = "$id\t$name\t$email\t$phone\t$role_as\n";
            fwrite($file, $line);
        }

        fclose($file);

        echo "Dữ liệu đã được lưu vào file user_data.txt";
    } else {
        echo "Không thể mở file để ghi dữ liệu.";
    }
} else {
    echo "Lỗi khi truy vấn cơ sở dữ liệu.";
}
?>
