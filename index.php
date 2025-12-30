<?php
// =======================================================
// THÔNG TIN KẾT NỐI DATABASE
// Bạn hãy thay Endpoint của RDS Primary vào dòng dưới đây:
// =======================================================
$servername = "database-primary.cbez8vepzbog.us-east-1.rds.amazonaws.com"; 
$username = "admin";
$password = "12345678";
$dbname = "citydb";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Lỗi kết nối Database: " . $conn->connect_error);
}

// -------------------------------------------------------
// PHẦN 1: TÍNH TỔNG DÂN SỐ (Yêu cầu đề bài: Đưa lên đầu bảng)
// -------------------------------------------------------
$sql_sum = "SELECT SUM(Population) AS total FROM city";
$result_sum = $conn->query($sql_sum);
$row_sum = $result_sum->fetch_assoc();
$tong_dan_so = number_format($row_sum['total']);

// -------------------------------------------------------
// PHẦN 2: LẤY DANH SÁCH CHI TIẾT
// -------------------------------------------------------
$sql_list = "SELECT * FROM city";
$result_list = $conn->query($sql_list);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài Thi AWS - Task 6</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; }
        .container { width: 80%; margin: 20px auto; background: white; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        
        /* CSS cho ô Tổng dân số */
        .total-box {
            background-color: #e74c3c;
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* CSS cho Bảng */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #3498db; color: white; text-align: center; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        td.num { text-align: right; } /* Căn phải cho số liệu */
    </style>
</head>
<body>

<div class="container">
    <h1>BÁO CÁO DÂN SỐ THÀNH PHỐ</h1>

    <div class="total-box">
        TỔNG DÂN SỐ: <?php echo $tong_dan_so; ?> Người
    </div>

    <table>
        <tr>
            <th style="width: 50px;">ID</th>
            <th>Tên Thành Phố</th>
            <th>Mã Quốc Gia</th>
            <th>Quận / Huyện</th>
            <th>Dân Số</th>
        </tr>
        <?php
        if ($result_list->num_rows > 0) {
            while($row = $result_list->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='text-align:center'>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Name"] . "</td>";
                echo "<td style='text-align:center'>" . $row["CountryCode"] . "</td>";
                echo "<td>" . $row["District"] . "</td>";
                echo "<td class='num'>" . number_format($row["Population"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center'>Chưa có dữ liệu trong Database</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

</body>
</html>