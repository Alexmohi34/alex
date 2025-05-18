<?php
session_start();
?>
<title>سفارش محصول</title>


<?php

$link=mysqli_connect("localhost","root","","shop_db");
if(mysqli_connect_error())
	exit("خطایی با شرح زیر رخ داده است:" .mysqli_connect_errno());
$pro_code=0;
if(isset($_GET["id"]))
	$pro_code=$_GET["id"];
if(!(isset($_SESSION["state_login"])&& $_SESSION["state_login"]===true)){
	?>
	<br/>
	<span style='color: red;'><b>برای خرید پستی محصول انتخاب شده باید وارد سایت شوید</b></span>
	<br/><br/>
	در صورتی که عضو فروشگاه هستید برای ورود
	<a href="login.php" style="text-decoration: none;"><span style='color: blue;'><b>اینجا</b></span></a>
	کلیک کنید
	<br/>
	و در صورتی که عضو نیستید برای ثبت نام در سایت
	<a href='register.php' style='text-decoration: none;'><span style='color: green;'><b>اینجا</b></span></a>
	کلیک کنید
	<br/><br/>
	<?php
	exit();
}
mysqli_query($link,"SET CHARACTER SET utf8");
$query="SELECT * FROM products WHERE pro_code='$pro_code'";
$result=mysqli_query($link,$query);
?>
<link rel="stylesheet" type="text/css" href="engine1/style.css" />
<script type="text/javascript" src="engine1/jquery.js"></script>
<!-- End WOWSlider.com HEAD section -->

<style type="text/css">
	.set_link{text-decoration: none;font-weight: bold;}
	
	</style>
<link href="s.css" rel="stylesheet" type="text/css">
<link href="ihover.css" rel="stylesheet" type="text/css">
<!--<link href="style_menu.css" rel="stylesheet" type="text/css">-->

</head>

<body>
<div class="topmenu">
<table style="width: 100%;" border="0" dir="rtl">
				<tr style="text-align: center;">
					<td><a href="index.php" class="set_link">صفحه اصلی</a></td>
					<td><a href="#" class="set_link">ارتباط با ما</a></td>
					<td><a href="#" class="set_link">تماس با ما</a></td>
					<?php
					if(isset($_SESSION["state_login"]) && $_SESSION["state_login"]===true)
					{
					?>
					<td><a href="logout.php" class="set_link">خروج از سایت<?php echo("({$_SESSION["realname"]})")?>
					</a></td>
					<?php
					}
					else
					{
					?>
					<form action="action_login.php" method="post">
					<td><label style="color: #ffffff;">نام کاربری</label>
					<input type="text" name="username">
					
					
					
					</td>
					<td><label style="color: #ffffff;">رمز عبور</label>
					<input type="password" name="password">
					
					</td>
					<td ><a href="action_login.php" class="set_link"><input type="submit" name="btnlogin" value="ورود" class="b1"></a>
					<a href="#" class="set_link"><input type="submit" name="btn" value="عضویت در سایت" class="b2"></a></td>
					</form>
					
					
					<?php
					}
					?>
					
					<?php
					if(isset($_SESSION["state_login"]) && $_SESSION["state_login"]===true && $_SESSION["user_type"]=="admin")
					{
						?>
						<td><a href="admin_products.php" class="set_link">مدیریت محصولات</a></td>
						
						<?php
					}
					?>
						
					
					
				</tr>
			</table>
</div>
<div class="khat">
	
	
</div>
<div class="aks">
	<img src="New folder/aks.png">
	<div class="aks1"><img src="New folder/basket.png"></div>
	
	
</div>
<div class="khat1">
	
	
	
	
</div>
<form name="order" action="action_order.php" method="POST">
<table style="width: 100%;" border="1px" dir="rtl">
<tr><td style="width: 60%;">
<?php
	if($row = mysqli_fetch_array($result)){
		?>
		<br/>
		<table style="width: 100%;" border="0" style="margin-right: auto;">
		<tr>
			<td style="width: 22%;">کد کالا<span style="color: red;">*</span></td>
			<td style="width: 78%;"><input type="text" id="pro_code" name="pro_code" value="<?php echo($pro_code);?>" style="background-color: lightgray;text-align: center;" readonly /></td>
		</tr>	
		<tr>
			<td>نام کالا<span style="color: red">*</span></td>
			<td><input type="text" style="text-align: right;background-color: lightgray;" id="pro_name" name="pro_name" value="<?php echo($row['pro_name']);?>" readonly /></td>
		</tr>	
		<tr>
			<td >تعداد یا مقدار درخواستی<span style="color: red">*</span></td>
			<td><input type="text" style="text-align: center;" id="pro_qty" name="pro_qty" onChange="calc_price();" /></td>
		</tr>
		<tr>
			<td>قیمت واحد کالا<span style="color: red">*</span></td>
			<td><input type="text" style="text-align: left;background-color: lightgray;" id="pro_price" name="pro_price" value="<?php echo($row['pro_price']);?>" readonly /> ریال </td>
		</tr>
		<tr>
			<td>مبلغ قابل پرداخت<span style="color: red">*</span></td>
			<td><input type="text" style="text-align: center;background-color: lightgray;" id="total_price" name="total_price" value="0" readonly /> ریال </td>
		</tr>	
		<script type="text/javascript">
                    function calc_price() {
                        var pro_qty =<?php echo $row['pro_qty']?>;

                        var price = document.getElementById('pro_price').value;

                        var count = document.getElementById('pro_qty').value;
                        var total_price;
                        if (count > pro_qty) {
                            alert('تعداد موجودی انبارکمتر از درخواست شماست');
                            document.getElementById('pro_qty').value = 0;
                            count = 0;
                        }
                        if (count == 0 || count == '') {
                            total_price = 0;
                        }
                        else
                            total_price = count * price;
                        document.getElementById('total_price').value = total_price;
                    }
                </script>	
			<?php
			mysqli_query($link,"SET CHARACTER SET utf8");
		$query="SELECT * FROM users WHERE username='{$_SESSION['username']}'";
		$result=mysqli_query($link,$query);
		$user_row=mysqli_fetch_array($result);
		?>
		<tr>
			<td><br/><br/><br/><br/></td>
			<td></td>
		</tr>
		<tr>
			<td style="width: 40%;">نام خریدار <span style="color: red;">*</span></td>
			<td style="width: 60%";>
				<input type="text" id="realname" name="realname" value="<?php echo($user_row['realname']); ?>" style="background-color: lightgray;" readonly />
			</td>
		</tr>
		<tr>
			<td>پست الکترونیکی<span style="color: red;">*</span></td>
			<td><input type="text" id="email" name="email" value="<?php echo($user_row['email']); ?>" style="text-align: left;background-color: lightgray;" readonly /></td>
		</tr>
		<tr>
			<td>شماره تلفن همراه<span style="color: red;">*</span></td>
			<td><input type="text" id="mobile" name="mobile" value="09" style="text-align: left"/></td>
		</tr>
		<tr>
			<td>آدرس دقیق پستی جهت دریافت محصول<span style="color: red;">*</span></td>
			<td><textarea style="text-align: right;font-family: Arial;" id="address" name="address" cols="30" rows="3" wrap="virtual"></textarea></td>
		</tr>
		<tr>
			<td><br/><br/><br/><br/></td>
			<td><input type="button" value="خرید محصول" onclick="check_input();"></td>
		</tr>
	</table>
	</td>
	<td>
		<script>
    function check_input() {
        var r=confirm("از صحت اطلاعات وارد شده اطمینان دارید");
        if(r==true){
            var validation=true;
            var count=document.getElementById('pro_qty').value;
            var mobile=document.getElementById('mobile').value;
            var address=document.getElementById('address').value;

            if (count ==0 || count=='')
                validation=false;
            if(mobile.length<11)
                validation=false;
            if (address.length<15)
                validation=false;
            if(validation)
                document.order.submit();
			else 
				alert('برخی از ورودی های فرم سفارش محصول به درستی پر نشده اند');
        }
    }
</script>
		<table>
			<tr>
                <td style="border-style: dotted dashed;vertical-align: top;width: 33%;">
                	<h4 style="color: red;"><?php echo($row['pro_name'])?></h4>
               <img src="images/products/<?php echo($row['pro_image'])?>" width="500px" height="300px" />
               <br/>
               قیمت واحد : <?php echo($row['pro_price'])?>&nbsp; ریال
               <br/>
               مقدار موجودی : <span style="color: red;"><?php echo($row['pro_qty'])?></span>
               <br/>
               توضیحات : <span style="color: green; font-family: Tahoma;">
						<?php
			$count=strlen($row['pro_detail']);
		echo(substr($row['pro_detail'],0,(int)($count / 4)));
		?>
					...</span>
					<br/><br/>
				</td>
			</tr>
		</table>
	</tr>
	</table>
</form>
<?php
	}

