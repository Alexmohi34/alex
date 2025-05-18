<?php
include("includes/header.php");

$link = mysqli_connect("localhost", "root", "", "shop_db");
if(mysqli_connect_errno()) {
    exit("خطای با شرح زیر رخ داده است:".mysqli_connect_error());
}

$pro_code = 0;
if(isset($_GET['id'])) {
    $pro_code = $_GET['id'];
}

// بررسی لاگین بودن کاربر
if(!(isset($_SESSION["state_login"]) && $_SESSION["state_login"] == true)) {
    echo '
    <div class="auth-alert">
        <div class="alert-content">
            <h3>برای خرید محصول باید وارد حساب کاربری خود شوید</h3>
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-primary">ورود به حساب کاربری</a>
                <a href="register.php" class="btn btn-secondary">ثبت نام در فروشگاه</a>
            </div>
        </div>
    </div>';
    include("includes/footer.php");
    exit();
}

$query = "SELECT * FROM products WHERE pro_code='$pro_code'";
$result = mysqli_query($link, $query);
?>

<style>
    :root {
        --primary: #4a6bff;
        --secondary: #ff6b6b;
        --dark: #2c3e50;
        --light: #f8f9fa;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #fd7e14;
        --info: #17a2b8;
    }
    
    body {
        font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }
    
    .order-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .order-title {
        text-align: center;
        font-size: 28px;
        color: var(--dark);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary);
    }
    
    .order-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }
    
    .order-form {
        flex: 1;
        min-width: 500px;
    }
    
    .product-summary {
        flex: 1;
        min-width: 300px;
        background: rgba(245, 247, 250, 0.7);
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #eee;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: var(--dark);
    }
    
    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
        outline: none;
    }
    
    .form-input[readonly] {
        background-color: #f5f5f5;
        color: #666;
    }
    
    textarea.form-input {
        min-height: 100px;
        resize: vertical;
    }
    
    .required-star {
        color: var(--danger);
        margin-right: 5px;
    }
    
    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        font-size: 16px;
        text-align: center;
    }
    
    .btn-primary {
        background: linear-gradient(to right, var(--primary), var(--secondary));
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary), var(--primary));
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-block {
        display: block;
        width: 100%;
    }
    
    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .product-name {
        font-size: 20px;
        color: var(--danger);
        margin-bottom: 10px;
    }
    
    .product-price {
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .product-stock {
        color: var(--success);
        font-weight: bold;
    }
    
    .product-description {
        color: #555;
        line-height: 1.6;
    }
    
    .auth-alert {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    .auth-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }
    
    .btn-secondary {
        background: #f1f1f1;
        color: var(--dark);
    }
    
    .btn-secondary:hover {
        background: #e1e1e1;
    }
    
    @media (max-width: 768px) {
        .order-container {
            padding: 20px;
        }
        
        .order-form, .product-summary {
            min-width: 100%;
        }
    }
</style>

<script>
    function calc_price() {
        var pro_qty = <?php echo $row['pro_qty'] ?? 0; ?>;
        var price = document.getElementById('pro_price').value;
        var count = document.getElementById('pro_qty').value;
        var total_price;
        
        if (count > pro_qty) {
            alert('تعداد موجودی انبار کمتر از درخواست شماست');
            document.getElementById('pro_qty').value = 0;
            count = 0;
        }
        
        if (count == 0 || count == '') {
            total_price = 0;
        } else {
            total_price = count * price;
        }
        
        document.getElementById('total_price').value = total_price.toLocaleString();
    }
    
    function check_input() {
        var count = document.getElementById('pro_qty').value;
        var mobile = document.getElementById('mobile').value;
        var address = document.getElementById('address').value;
        
        if (count == 0 || count == '') {
            alert('لطفا تعداد مورد نظر را وارد کنید');
            return false;
        }
        
        if (mobile.length < 11 || !mobile.startsWith('09')) {
            alert('لطفا شماره تلفن همراه معتبر وارد کنید (شروع با 09 و 11 رقمی)');
            return false;
        }
        
        if (address.length < 15) {
            alert('لطفا آدرس دقیق پستی را وارد کنید (حداقل 15 کاراکتر)');
            return false;
        }
        
        var r = confirm("آیا از صحت اطلاعات وارد شده اطمینان دارید؟");
        if (r == true) {
            document.order.submit();
        }
    }
</script>

<div class="order-container">
    <h2 class="order-title">فرم سفارش محصول</h2>
    
    <?php if($row = mysqli_fetch_array($result)): ?>
    <div class="order-wrapper">
        <form name="order" action="action_order.php" method="POST" class="order-form">
            <input type="hidden" id="pro_code" name="pro_code" value="<?php echo $pro_code; ?>">
            
            <div class="form-group">
                <label for="pro_name" class="form-label">
                    <span class="required-star">*</span>نام محصول
                </label>
                <input type="text" id="pro_name" name="pro_name" value="<?php echo $row['pro_name']; ?>" class="form-input" readonly>
            </div>
            
            <div class="form-group">
                <label for="pro_qty" class="form-label">
                    <span class="required-star">*</span>تعداد درخواستی
                </label>
                <input type="number" id="pro_qty" name="pro_qty" class="form-input" onchange="calc_price()" min="1" max="<?php echo $row['pro_qty']; ?>">
            </div>
            
            <div class="form-group">
                <label for="pro_price" class="form-label">
                    <span class="required-star">*</span>قیمت واحد
                </label>
                <input type="text" id="pro_price" name="pro_price" value="<?php echo $row['pro_price']; ?>" class="form-input" readonly>
            </div>
            
            <div class="form-group">
                <label for="total_price" class="form-label">
                    <span class="required-star">*</span>مبلغ قابل پرداخت
                </label>
                <input type="text" id="total_price" name="total_price" value="0" class="form-input" readonly>
            </div>
            
            <?php
            mysqli_query($link, "SET CHARACTER SET utf8");
            $query = "SELECT * FROM users WHERE username='{$_SESSION['username']}'";
            $result = mysqli_query($link, $query);
            $user_row = mysqli_fetch_array($result);
            ?>
            
            <div class="form-group">
                <label for="realname" class="form-label">
                    <span class="required-star">*</span>نام خریدار
                </label>
                <input type="text" id="realname" name="realname" value="<?php echo $user_row['realname']; ?>" class="form-input" readonly>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">
                    <span class="required-star">*</span>پست الکترونیکی
                </label>
                <input type="email" id="email" name="email" value="<?php echo $user_row['email']; ?>" class="form-input" readonly>
            </div>
            
            <div class="form-group">
                <label for="mobile" class="form-label">
                    <span class="required-star">*</span>شماره تلفن همراه
                </label>
                <input type="tel" id="mobile" name="mobile" value="09" class="form-input" placeholder="09123456789" pattern="09[0-9]{9}">
            </div>
            
            <div class="form-group">
                <label for="address" class="form-label">
                    <span class="required-star">*</span>آدرس دقیق پستی
                </label>
                <textarea id="address" name="address" class="form-input" placeholder="آدرس کامل شامل استان، شهر، خیابان، پلاک و ..."></textarea>
            </div>
            
            <button type="button" onclick="check_input()" class="btn btn-primary btn-block">تایید و پرداخت</button>
        </form>
        
        <div class="product-summary">
            <img src="images/products/<?php echo $row['pro_image']; ?>" class="product-image" alt="<?php echo $row['pro_name']; ?>">
            <h3 class="product-name"><?php echo $row['pro_name']; ?></h3>
            <div class="product-price">قیمت: <?php echo number_format($row['pro_price']); ?> ریال</div>
            <div class="product-stock">موجودی: <?php echo $row['pro_qty']; ?> عدد</div>
            <p class="product-description">
                <?php echo substr($row['pro_detail'], 0, (int)(strlen($row['pro_detail']) / 4)); ?>...
            </p>
        </div>
    </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h3>محصول مورد نظر یافت نشد</h3>
            <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">بازگشت به فروشگاه</a>
        </div>
    <?php endif; ?>
</div>

<?php
include("includes/footer.php");
?>