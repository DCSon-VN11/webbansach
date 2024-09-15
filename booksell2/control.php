<?php 
include("connect.php");

class data
{
    function cofim_yeucau($id, $required){
        global $conn;
        $sql = "UPDATE orders SET order_status = $required WHERE OrderID = $id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

}
?>