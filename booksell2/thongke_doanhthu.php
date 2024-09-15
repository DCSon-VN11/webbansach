<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng doanh thu</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .doanhthu {
            background-color: #f4f4f4;
            padding: 10px;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h2>Thống kê doanh thu dự kiến trong tháng:</h2>
    <?php
    include_once ("connect.php");

    $sql = "SELECT o.OrderID, a.Username, o.Amount, o.DateTran, i.ISBN, b.Title, b.Price, i.Prices, i.Quantity
            FROM orders o
            INNER JOIN order_items i ON o.OrderID = i.OrderID
            INNER JOIN accounts a ON o.AccountID = a.AccountID
            INNER JOIN books b ON i.ISBN = b.ISBN
            WHERE o.order_status BETWEEN 0 AND 3";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $doanhthudukien = 0;
        ?>
        <table class="table">
            <tr>
                <th>OrderID</th>
                <th>Tên tài khoản đặt hàng</th>
                <th>Ngày đặt</th>
                <th>ISBN</th>
                <th>Tên Sách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["OrderID"] ?></td>
                    <td><?php echo $row["Username"] ?></td>
                    <td><?php echo $row["DateTran"] ?></td>
                    <td><?php echo $row["ISBN"] ?></td>
                    <td><?php echo $row["Title"] ?></td>
                    <td><?php echo $row["Price"] ?></td>
                    <td><?php echo $row["Quantity"] ?></td>
                    <td><?php echo $row["Prices"] ?></td>
                </tr>
                <?php

                $doanhthudukien += $row["Prices"]; // Cộng giá trị của cột "Tổng tiền" vào biến tổng doanh thu
            }
            ?>
        </table>
        <div class='doanhthu'>Tổng doanh thu: <?php echo number_format($doanhthudukien, 0, ',', '.') ?> vnd</div>
        <?php
    } else {
        echo "Không có đơn hàng nào.";
    }
    ?>
    <h2>Thống kê doanh thu trong tháng:</h2>
    <?php
    $sql = "SELECT o.OrderID, a.Username, o.Amount, o.DateTran, i.ISBN, b.Title, b.Price, i.Prices, i.Quantity
    FROM orders o
    INNER JOIN order_items i ON o.OrderID = i.OrderID
    INNER JOIN accounts a ON o.AccountID = a.AccountID
    INNER JOIN books b ON i.ISBN = b.ISBN
    WHERE o.order_status = 3";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $doanhthu = 0;
        ?>
        <table class="table">
            <tr>
                <th>OrderID</th>
                <th>Tên tài khoản đặt hàng</th>
                <th>Ngày đặt</th>
                <th>ISBN</th>
                <th>Tên Sách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["OrderID"] ?></td>
                    <td><?php echo $row["Username"] ?></td>
                    <td><?php echo $row["DateTran"] ?></td>
                    <td><?php echo $row["ISBN"] ?></td>
                    <td><?php echo $row["Title"] ?></td>
                    <td><?php echo $row["Price"] ?></td>
                    <td><?php echo $row["Quantity"] ?></td>
                    <td><?php echo $row["Prices"] ?></td>
                </tr>
                <?php

                $doanhthu += $row["Prices"]; // Cộng giá trị của cột "Tổng tiền" vào biến tổng doanh thu
            }
            ?>
        </table>
        <div class='doanhthu'>Tổng doanh thu: <?php echo number_format($doanhthu, 0, ',', '.') ?> vnd</div>
        <?php
    } else {
        echo "Không có đơn hàng nào.";
    }
    $conn->close() ?>
</body>

</html>