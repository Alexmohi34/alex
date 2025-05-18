<?php
include ("includes/header.php");
if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true && $_SESSION["user_type"] ==
    "admin")) {
?>
<script type="text/javascript">
<!--
location.replace("index.php");	 // منتقل شود index.php به صفحه
-->
</script>
<?php
} // if پایان

$link = mysqli_connect("localhost", "root", "", "shop_db");  // اتصال به پايگاه داده shop_db

if (mysqli_connect_errno())
    exit("خطاي با شرح زير رخ داده است :" . mysqli_connect_error());

if (isset($_GET['action'])) {

    $id = $_GET['id'];
	
    switch ($_GET['action']) {
        case 'BARASI'://ویرایش اطلاعات محصول انتخابی
            $query = "UPDATE orders SET
             state='0'          
             WHERE id='$id'";

            break;
			
        case 'AMADEHERSAL':
			$query = "UPDATE orders SET
             state='1'          
             WHERE id='$id'";

            break;
			
			case 'ERSALSHODEH':
			$query = "UPDATE orders SET
             state='2'          
             WHERE id='$id'";

			break;
			case 'LAGHV':
			$query = "UPDATE orders SET
             state='3'          
             WHERE id='$id'";

			break;
			
    } //switch
	
	mysqli_query($link, $query);
           
    mysqli_close($link);// بستن اتصال
	
			
} //if

?>
<script type="text/javascript">
<!--
location.replace("admin_manage_order.php");	 // منتقل شود index.php به صفحه
-->
</script>