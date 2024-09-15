<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script src="script.js"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION["Account"]) && $_SESSION["Account"] == 1) {

        include ("connect.php");
        include ("control.php");

        if (isset($_GET["category"])) {
            $required = $_GET["category"];
        } else {
            ?>
            <script>alertMessange("Có lỗi xảy ra!", "quantri.php")</script>
            <?php
        }
        $sql = "SELECT * FROM orders, order_items, books, accounts
        WHERE orders.OrderID = order_items.OrderID 
        AND accounts.AccountID = orders.AccountID
        AND order_items.ISBN = books.ISBN
        AND orders.order_status = $required";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            ?>
            <a href="quantri.php" role="buttons"><button>Quay về trang quản trị</button></a>

            <table class="table">
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
                        <?php
                        if ($required < 3) {
                            ?>
                            <td>
                                <a href="xulidon.php?id=<?php echo $row["OrderID"] ?>&required=<?php if ($required <= 2)
                                       echo $required + 1 ?>"
                                        onclick=" return confirm('Xác nhận?')">
                                        <button>
                                        <?php switch ($required) {
                                       case '0':
                                           echo "Đã dóng gói";
                                           break;
                                       case '1':
                                           echo "Đã vận chuyển";
                                           break;
                                       case '2':
                                           echo "Đã giao hàng";
                                           break;
                                       default:

                                   }
                                   ?>
                                    </button>
                                </a>
                            </td>
                            <?php
                        }

                        if (!in_array($_GET["category"], [3, 4, 6])) {
                            ?>
                            <td>
                                <a href="xulidon.php?id=<?php echo $row["OrderID"] ?>&required=7"
                                    onclick=" return confirm('Xác nhận hủy đơn?')"><button>Hủy đơn</button></a>
                            </td>
                            <td>
                                <a onclick="return confirm('Bạn có chắc xóa không?');"
                                    href="xoa_donhang.php?ma=<?php echo $row["OrderID"]; ?>">
                                    <img src="images/icons8-delete-24.png">
                                </a>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php

        } else {
            ?>
            <script>
                alertMessange("Không có đơn hàng nào", "quantri.php");
            </script>
            <?php
        }

    } else {
        ?>
        <script>
            alert("Lỗi đăng nhập");
        </script>
        <?php
    }

    ?>
</body>

</html>