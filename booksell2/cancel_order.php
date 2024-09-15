<script src="script.js"></script>
<?php  
    include_once ("connect.php");
    include ("control.php");

    if (isset($_GET["id"])) {

        $getdata = new data();

        $result = $getdata->cofim_yeucau($_GET["id"], 7);
        if ($result==true) {
            ?>
            <script>
                alertMessange("Đơn hàng đã bị hủy!", "donhang.php", "category", 0);
            </script>
            <?php
        }

    }

?>