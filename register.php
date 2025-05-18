<?php
include("includes/header.php");

// اگر کاربر قبلا لاگین کرده باشد، به صفحه اصلی هدایت شود
if(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true) {
   // header("Location: index.php");
    exit();
}

// نمایش پیام موفقیت آمیز بودن ثبت نام
if(isset($_GET['success']) && $_GET['success'] == '1') {
    echo '<div class="success-message">ثبت نام شما با موفقیت انجام شد!</div>';
}

// نمایش پیام خطا در صورت وجود
if(isset($_GET['error'])) {
    $error = "";
    switch($_GET['error']) {
        case 'username_exists':
            $error = "نام کاربری قبلا ثبت شده است";
            break;
        case 'email_exists':
            $error = "ایمیل قبلا ثبت شده است";
            break;
        case 'password_mismatch':
            $error = "کلمه عبور و تکرار آن مطابقت ندارند";
            break;
        case 'empty_fields':
            $error = "پر کردن تمام فیلدهای الزامی ضروری است";
            break;
        default:
            $error = "خطایی در ثبت نام رخ داده است";
    }
    echo '<div class="error-message">'.$error.'</div>';
}
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
    
    .register-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .register-title {
        text-align: center;
        font-size: 28px;
        color: var(--dark);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary);
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
    
    .required-star {
        color: var(--danger);
        margin-right: 5px;
    }
    
    .button-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        font-size: 16px;
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
    
    .btn-reset {
        background: #f1f1f1;
        color: var(--dark);
    }
    
    .btn-reset:hover {
        background: #e1e1e1;
        transform: translateY(-3px);
    }
    
    .success-message {
        background-color: var(--success);
        color: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin: 20px auto;
        max-width: 600px;
        animation: fadeIn 0.5s ease;
    }
    
    .error-message {
        background-color: var(--danger);
        color: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin: 20px auto;
        max-width: 600px;
        animation: fadeIn 0.5s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
        .register-container {
            margin: 20px;
            padding: 20px;
        }
        
        .register-title {
            font-size: 24px;
        }
    }
</style>

<script>
    function validateForm() {
        // بررسی پر بودن فیلدهای الزامی
        const requiredFields = ['realname', 'username', 'password', 'repassword', 'email'];
        for (const field of requiredFields) {
            const value = document.getElementById(field).value.trim();
            if (value === "") {
                alert('پر کردن فیلد ' + document.querySelector(`label[for="${field}"]`).textContent + ' الزامی است');
                document.getElementById(field).focus();
                return false;
            }
        }
        
        // بررسی تطابق رمز عبور
        const password = document.getElementById('password').value;
        const repassword = document.getElementById('repassword').value;
        if (password !== repassword) {
            alert('کلمه عبور و تکرار آن مطابقت ندارند');
            return false;
        }
        
        // بررسی ایمیل
        const email = document.getElementById('email').value;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert('لطفا یک ایمیل معتبر وارد کنید');
            return false;
        }
        
        // تایید نهایی کاربر
        return confirm("آیا از صحت اطلاعات وارد شده اطمینان دارید؟");
    }
</script>

<div class="register-container">
    <h2 class="register-title">فرم ثبت نام</h2>
    
    <form name="register" action="action_register.php" method="post" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="realname" class="form-label">
                <span class="required-star">*</span>نام واقعی
            </label>
            <input type="text" id="realname" name="realname" class="form-input" placeholder="نام و نام خانوادگی خود را وارد کنید">
        </div>
        
        <div class="form-group">
            <label for="username" class="form-label">
                <span class="required-star">*</span>نام کاربری
            </label>
            <input type="text" id="username" name="username" class="form-input" placeholder="نام کاربری مورد نظر خود را وارد کنید">
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">
                <span class="required-star">*</span>کلمه عبور
            </label>
            <input type="password" id="password" name="password" class="form-input" placeholder="کلمه عبور خود را وارد کنید">
        </div>
        
        <div class="form-group">
            <label for="repassword" class="form-label">
                <span class="required-star">*</span>تکرار کلمه عبور
            </label>
            <input type="password" id="repassword" name="repassword" class="form-input" placeholder="کلمه عبور را مجددا وارد کنید">
        </div>
        
        <div class="form-group">
            <label for="email" class="form-label">
                <span class="required-star">*</span>پست الکترونیکی
            </label>
            <input type="email" id="email" name="email" class="form-input" placeholder="ایمیل خود را وارد کنید">
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">ثبت نام</button>
            <button type="reset" class="btn btn-reset">پاک کردن</button>
        </div>
    </form>
</div>

<?php
include("includes/footer.php");
?>