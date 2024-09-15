<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>

<body>
    <h2>Thông Tin Các Đơn Đặt Hàng:</h2>
    <?php
    session_start();
    //1-Kết nối cơ sở dữ liệu
    include_once ("connect.php");

    if (isset($_SESSION["Role"]) && $_SESSION["Role"] != 1) {

        if (isset($_GET["category"])) {

            if ($_GET["category"] == 0) {

                $sql = "SELECT o.OrderID, o.DateTran, b.Title, b.Price, i.Prices, i.Quantity
                FROM orders o
                INNER JOIN order_items i ON o.OrderID = i.OrderID
                INNER JOIN accounts a ON o.AccountID = a.AccountID
                INNER JOIN books b ON i.ISBN = b.ISBN
                WHERE o.AccountID = " . $_SESSION['Account'] . "
                AND o.order_status = 0";

            } else {
                ?>
                <script>
                    alertMessange("Đã có lỗi xảy ra! Vui lòng thử lại.", "trangchu.php");
                </script>
                <?php
            }

        } else {

            $sql = "SELECT o.OrderID, o.DateTran, b.Title, b.Price, i.Prices, i.Quantity
            FROM orders o
            INNER JOIN order_items i ON o.OrderID = i.OrderID
            INNER JOIN accounts a ON o.AccountID = a.AccountID
            INNER JOIN books b ON i.ISBN = b.ISBN
            WHERE o.AccountID = " . $_SESSION['Account'] . "
            AND o.order_status BETWEEN 1 AND 2";

        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            ?>
            <table border="1px">
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Tên Sách</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </tr>

                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["OrderID"] ?></td>
                        <td><?php echo $row["DateTran"] ?></td>
                        <td><?php echo $row["Title"] ?></td>
                        <td><?php echo $row["Price"] ?></td>
                        <td><?php echo $row["Quantity"] ?></td>
                        <td><?php echo $row["Prices"] ?></td>
                        <td><a href="cancel_order.php?id=<?php echo $row["OrderID"] ?>"><button>Hủy đơn</button></a></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php

        }

    } else if (isset($_SESSION["Role"]) && $_SESSION["Role"] == 1) {

        $sql = "SELECT o.OrderID, a.Username, o.Amount, o.DateTran, i.ISBN, b.Title, b.Price, i.Prices, i.Quantity
        FROM orders o
        INNER JOIN order_items i ON o.OrderID = i.OrderID
        INNER JOIN accounts a ON o.AccountID = a.AccountID
        INNER JOIN books b ON i.ISBN = b.ISBN";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            ?>
                <table border="1px">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Người đặt</th>
                        <th>Địa chỉ</th>
                        <th>Ngày đặt</th>
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
                            <td></td>
                            <td><?php echo $row["DateTran"] ?></td>
                            <td><?php echo $row["Title"] ?></td>
                            <td><?php echo $row["Price"] ?></td>
                            <td><?php echo $row["Quantity"] ?></td>
                            <td><?php echo $row["Prices"] ?></td>
                            <td><a href="cancel_order.php?id=<?php echo $row["OrderID"] ?>"><button>Hủy đơn</button></a></td>
                            <td>
                                <a onclick="return confirm('Bạn có chắc xóa không?');"
                                    href="xoa_donhang.php?ma=<?php echo $row["OrderID"]; ?>">
                                    <img src="images/icons8-delete-24.png">
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
        }
    } else {
        echo "Không có đơn hàng nào.";
    }

    ?>
    <h3><a class="nav-link" href="trangchu.php">Quay Lại Trang chủ</a></h3>
    <?php
    $conn->close();
    ?>
</body>

</html>