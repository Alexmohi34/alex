<?php
include ("includes/header.php");
if (!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true && $_SESSION["user_type"] ==
    "admin")) {
?>
<script type="text/javascript">
<!--
location.replace("index.php");
-->
</script>
<?php
} 
$link = mysqli_connect("localhost", "root", "", "shop_db");  

if (mysqli_connect_errno())
    exit("خطاي با شرح زير رخ داده است :" . mysqli_connect_error());

?>

  <br />
                    
<?php

$query = "SELECT * FROM orders";
$result = mysqli_query($link, $query);

?>

<table border="1px" style="width: 100%;" >



<?php
while ($row = mysqli_fetch_array($result)) {
?>
<tr  bgcolor="<?php if($row['state']=='3') echo ("#FF3333"); else echo ("#C7CAF1"); ?>" >
	<td>كد سفارش</td>
	<td>نام خریدار</td>
	<td>نام محصول</td>
	<td>تاریخ سفارش</td>
	<td>تعداد سفارش</td>
	<td>قيمت كالا</td>
	<td>قیمت نهایی</td>
</tr>
<tr>
	<td><?php echo ($row['id']) ?></td>
	<td>
       <?php
	       $query = "SELECT * FROM users  WHERE username='{$row['username']}'";
           $result2 = mysqli_query($link, $query);
           $row_user = mysqli_fetch_array($result2);
	      echo ($row_user['realname']) 	
		?>
	</td>
	<td>
        <?php
	       $query = "SELECT * FROM products WHERE pro_code='{$row['pro_code']}'";
           $result2 = mysqli_query($link, $query);
           $row_product = mysqli_fetch_array($result2);
	      echo ($row_product['pro_name']) 	
		?>
	</td>
	<td><?php echo ($row['orderdate']) ?></td>
	<td><?php echo ($row['pro_qty']) ?></td>
	<td><?php echo ($row['pro_price']) ?>&nbsp; ريال</td>
	<td>
	   <?php 
			  echo ($row['pro_qty']*$row['pro_price']);
		?>
		&nbsp; ريال</td>
</tr>
<tr>
	<td>شماره تماس</td>
	<td>آدرس</td>
	<td>کد مرسوله پستی</td>
	<td>وضعیت سفارش</td>
	<td  colspan="3">ابزار مديريتی</td>
</tr>
<tr>
	<td><?php echo ($row['mobile']) ?></td>
    <td><?php echo ($row['address']) ?></td>
    <td><?php echo ($row['trackcode']) ?></td>
    <td>
    <?php 
	switch ($row['state']) {
		case 0: echo("تحت بررسی");
			break;
		case 1: echo("آماده برای ارسال");
			break;
		case 2: echo("ارسال شده ");
			break;
		case 3: echo("سفارش لغو شده است");
			break;
	}
   ?>
  	</td>

  	<td colspan="3">
     <b><a href="action_admin_manage_order.php?id=<?php echo ($row['id']) ?>&action=BARASI" style="text-decoration: none;">تحت بررسی</a></b>    
     </br>
     <b><a href="action_admin_manage_order.php?id=<?php echo ($row['id']) ?>&action=AMADEHERSAL" style="text-decoration: none;">آماده برای ارسال</a></b>    
 
     </br>
     
    <b><a href="action_admin_manage_order.php?id=<?php echo ($row['id']) ?>&action=ERSALSHODEH" style="text-decoration: none;">ارسال شده</a></b>    
     </br>
     <br />
     <b ><a href="action_admin_manage_order.php?id=<?php echo ($row['id']) ?>&action=LAGHV" style="text-decoration: none; color:#F00">سفارش لغو شده</a></b>
         
	</td>

	
	
</tr>

<tr style="height: 10px;">
	<td colspan="7"></td>
</tr>
<?php
} 
?>

</table>

<?php
include ("includes/footer.php");
?>
   
