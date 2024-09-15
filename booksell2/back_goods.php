<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <script src="script.js"></script>
    <?php
    include_once ('connect.php');

    if (isset($_GET['orderId'])) {

        $sql = "SELECT b.Title, b.Price, oi.Quantity, oi.Prices, o.DateTran 
            FROM books b, orders o, order_items oi
            WHERE b.ISBN = oi.ISBN AND o.OrderID = oi.OrderID AND o.OrderID = " . $_GET['orderId'] . "";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>

            <form action="" method="post">
                <table border="1px" style="margin: auto">
                    <tr>
                        <td>
                            <label for="">Mã đơn: </label>
                        </td>
                        <td>
                            <?php echo $_GET["orderId"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Mặt hàng: </label>
                        </td>
                        <td>
                            <?php echo $row['Title'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Đơn giá: </label>
                        </td>
                        <td>
                            <?php echo $row['Price'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Số lượng:</label>
                        </td>
                        <td>
                            <?php echo $row["Quantity"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Thành tiền:</label>
                        </td>
                        <td>
                            <?php echo $row["Prices"] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Lí do hoàn trả:</label>
                        </td>
                        <td>
                            <textarea name="ldht" id=""></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="">Hình ảnh:</label>
                        </td>
                        <td>
                            <input type="file" name="images" id="" multiple>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding: auto">
                            <a href="purchased_order.php"><button name="cancel">Hủy</button></a>
                            <button name="submit" type="submit">Xác nhận</button>
                        </td>
                    </tr>
                </table>
            </form>

            <?php
            if (isset($_POST["cancel"])) {
                ?>
                <script>
                    alertMessange("Đã hủy yêu cầu", "purchased_order.php");
                </script>
                <?php
            }

            if (isset($_POST["submit"])) {

                if ($_POST["ldht"] == null && $_POST["image"] == null) {
                    ?>
                    <script>
                        alert("Vui lòng cung cấp đầy đủ thông tin")
                    </script>
                    <?php
                } else {
                    $sql = "UPDATE orders SET order_status = '4' where OrderID = " . $_GET["orderId"] . "";
                    $result = $conn->query($sql);

                    if ($result === true) {
                        ?>
                        <script>
                            alertMessange("Đã gửi yêu cầu hoàn trả hàng, xin vui lòng đợi", "purchased_order.php")
                        </script>
                        <?php
                    } else {
                        ?>
                        <script>
                            alertMessange("Yêu cầu chưa được hoàn thành! Xin thử lại!", "purchased_order.php")
                        </script>
                        <?php
                    }
                }
            }
        }
    }
    ?>
</body>

</html>