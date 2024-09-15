<script src="script.js"></script>
<?php
session_start();

include_once ("connect.php");

if (isset($_POST['sbThemhang'])) {

	$isbn = $_POST['txtISBN'];
	$soLuongMua = $_POST['txtSoLuongMua'];
	$sql = "SELECT Soluong FROM books WHERE ISBN = '$isbn'";
	$result = $conn->query($sql);

	if ($result) {
		$row = $result->fetch_assoc();
		$soLuongTon = $row['Soluong'];

		if ($soLuongMua > $soLuongTon) {
			echo '<script>alertMessange("So luong vuot qua gioi han! Vui long nhap lai","chitiet_sach.php", "txtISBN", ' . $isbn . ')</script>';
		}

		$dateTran = date("Y-m-d");
		$amount = "1";
		$accountId = $_SESSION["Account"];
		$name = $_SESSION["Name"];
	}
}
?>

<table class="table table-hover" style="text-align: center;" border="5">
	<tr>
		<th>Tài khoản đặt hàng</th>
		<th>ISBN</th>
		<th>Tựa đề</th>
		<th>Giá</th>
		<th>Số lượng tồn kho</th>
		<th>Số lượng đặt</th>
		<th>Thanh toán</th>
	</tr>
	<?php
	$sql = "SELECT * FROM books WHERE ISBN = '$isbn'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			echo "<td>" . $name . "</td>";
			echo "<td>" . $row["ISBN"] . "</td>";
			echo "<td>" . $row["Title"] . "</td>";
			echo "<td>" . $row["Price"] . "</td>";
			echo "<td>" . $row["Soluong"] . "</td>";
			echo "<td>" . $soLuongMua . "</td>";
			echo "<td>";
			?>

			<a href="hoadon_thanhtoan.php?ma=<?php echo $row["ISBN"]; ?>&slm=<?php echo $soLuongMua; ?>&gia=<?php echo $row["Price"]; ?>">
				Thanh toán
			</a>
			<?php
			echo "</td>";
			echo "</tr>";
		}
	} else {
		//0 có mẩu tin
		echo "0 có quyển sách nào trong giỏ";
	}

	?>

</table>
<h3><a class="btn btn-primary" href="trangchu.php">Quay lại trang chủ</a></h3>
