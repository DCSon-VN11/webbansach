<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    include_once ('connect.php');
    ?>
    <script src="script.js"></script>

    <table border="1px" , style="padding: 0px 5px 0px 5px;">
        <tr>
            <td>Mã đơn</td>
            <td>Sản phẩm</td>
            <td>Đơn giá</td>
            <td>Số lượng</td>
            <td>Thành tiền</td>
            <td>Thời gian</td>
            <td>Thời gian nhận hoàn lại</td>
            <td></td>
            <td></td>
        </tr>
        <?php
        $today = date("Y-m-d");
        $sql = "SELECT orders.OrderID, books.Title, books.Price, order_items.Quantity, order_items.Prices, orders.DateTran, DATEDIFF('$today', orders.DateTran) as Back
        FROM orders, order_items, books 
        WHERE books.ISBN = order_items.ISBN AND orders.OrderID = order_items.OrderID AND orders.order_status = '3' AND orders.AccountID = " . $_SESSION["Account"] . "
        ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <th><?php echo $row["OrderID"] ?></th>
                    <th><?php echo $row['Title'] ?></th>
                    <th><?php echo $row["Price"] ?></th>
                    <th><?php echo $row["Quantity"] ?></th>
                    <th><?php echo $row["Prices"] ?></th>
                    <th><?php echo $row["DateTran"] ?></th>
                    <th>
                        <?php
                        if ((50 - $row["Back"]) > 0) {
                            echo (50 - $row["Back"]);
                        } else {
                            echo 0;
                        } ?>
                    </th>
                    <th><a href=""></a><button name="buyAgain">Mua lại</button></th>
                    <th>
                        <?php
                        if ((50 - $row["Back"]) > 0) {
                            ?>
                            <a href="back_goods.php?orderId=<?php echo $row['OrderID'] ?>"><button name="back">Hoàn trả</button></a>
                            <?php
                        }
                        ?>
                    </th>

                    <?php
            }
        } else {
            ?>
                <script>
                    alertMessange("Không có đơn hàng nào", "trangchu.php");
                </script>
                <?php
        } ?>
    </table>
</body>

</html>