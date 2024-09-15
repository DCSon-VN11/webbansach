<script src="script.js"></script>

<?php
include ("connect.php");
include ("control.php");

if (isset($_GET["id"]) && isset($_GET["required"])) {

    $getdata = new data();
    $xulidon = $getdata->cofim_yeucau($_GET["id"], $_GET["required"]);
    $category = $_GET["required"] - 1;

    switch ($_GET["required"]) {
        case 1: $mess = "Đã đóng gói";
        break;
        case 2: $mess = "Đã vận chuyển";
        break;
        case 3: $mess = "Đã giao hàng";         
        break;
        case 5: $mess = "Đã hoàn lại";  
        break;
        default: $mess = "";
        break;
    }
    ?>
    <script>
        alertMessange("<?php echo $mess; ?>", "quanli_donhang.php", "category", "<?php echo $category; ?>");
    </script>
    <?php
}
?>