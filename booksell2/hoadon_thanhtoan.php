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
    include_once ("connect.php");

    $amonut = "1";
    $orderid = "";
    if (isset($_GET['ma'])) {

        $isbn = $_GET['ma'];
        $soLuongMua = $_GET['slm'];
        $gia = $_GET['gia'];
        $tongtien = $soLuongMua * $gia;

        $accountId = $_SESSION["Account"];
        $name = $_SESSION["Name"];

        $sql = "SELECT Title FROM books WHERE ISBN='".$isbn."' ";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
            ?>

        <form action="" method="POST">
            <label for="">Sản phẩm: </label> <?php echo $row["Title"] ?> <br>
            <label for="">Đơn giá: </label> <?php echo $gia ?> <br>
            <label for="">Số lượng: </label> <?php echo $soLuongMua ?> <br>
            <label for="">Thành tiền: </label> <?php echo $tongtien ?> <br>
            <label for="">Phương thức thanh toán: </label>Thanh toán khi nhận hàng <br>
            <label for="">Người mua: </label> <?php echo $name ?> <br>
            <label for="">Địa chỉ: </label> <input type="text" name="address" id="" required> <br>
            
            <button name="cancel">Hủy</button>
            <button type="submit" name="submit">Xác nhận thanh toán</button>
        </form>

        <?php
        if (isset($_POST["cancel"])) {
            header("Location:trangchu.php");
        }

        if (isset($_POST["submit"])) {

            $dateTran = date("Y-m-d");
            $sql_dathang = "INSERT INTO orders(AccountID, Amount, DateTran) VALUES('$accountId','$amonut','$dateTran')";

            if ($conn->query($sql_dathang) === TRUE) {
                $orderid = $conn->insert_id;
            } else {
                echo '<script>
                    alert("Thanh toan thanh cong")
                </script>';
                header("Location:trangchu.php");
            }

            $sql_hoadon = "INSERT INTO order_items (ISBN, OrderID, Prices, Quantity) VALUES ('$isbn','$orderid', '$tongtien', '$soLuongMua')";
            if ($conn->query($sql_hoadon) === TRUE) {
                echo "Thêm đơn hàng thành công!";
            } else {
                echo "Lỗi: " . $sql_hoadon . "<br>" . $conn->error;
            }

            // Cập nhật số lượng tồn trong bảng "books"
            $sql_soluong = "UPDATE books SET Soluong = Soluong - '$soLuongMua' WHERE ISBN = '$isbn'";
            if ($conn->query($sql_soluong) === TRUE) {
                echo "
                <script>
                    alert('Dat hang thanh cong');
                    window.location.href = 'donhang.php';
                </script>
                ";
            } else {
                echo "Error: " . $sql_soluong . "<br>" . $conn->error;
            }
        }

    } else {
        echo "Không có mã ISBN được gửi!";
    }

    $conn->close();
    ?>
</body>

</html>