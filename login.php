<?php
include("includes/header.php");

// اگر کاربر قبلا لاگین کرده باشد، به صفحه اصلی هدایت شود
if(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true) {
    header("Location: index.php");
    exit();
}

// نمایش پیام خطا در صورت وجود
if(isset($_GET['error'])) {
    $error = "نام کاربری یا کلمه عبور اشتباه است";
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
    }
    
    body {
        font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }
    
    .login-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 40px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .login-title {
        text-align: center;
        font-size: 28px;
        color: var(--dark);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary);
    }
    
    .form-group {
        margin-bottom: 25px;
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
    
    .error-message {
        background-color: var(--danger);
        color: white;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        margin: 20px auto;
        max-width: 500px;
        animation: fadeIn 0.5s ease;
    }
    
    .forgot-password {
        text-align: center;
        margin-top: 20px;
    }
    
    .forgot-password a {
        color: var(--primary);
        text-decoration: none;
    }
    
    .forgot-password a:hover {
        text-decoration: underline;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 768px) {
        .login-container {
            margin: 20px;
            padding: 30px;
        }
        
        .login-title {
            font-size: 24px;
        }
    }
</style>

<script>
    function validateForm() {
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();
        
        if (username === "" || password === "") {
            alert('لطفا نام کاربری و کلمه عبور را وارد کنید');
            return false;
        }
        
        return true;
    }
</script>

<div class="login-container">
    <h2 class="login-title">ورود به حساب کاربری</h2>
    
    <form name="login" action="action_login.php" method="post" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="username" class="form-label">
                <span class="required-star">*</span>نام کاربری
            </label>
            <input type="text" id="username" name="username" class="form-input" placeholder="نام کاربری خود را وارد کنید">
        </div>
        
        <div class="form-group">
            <label for="password" class="form-label">
                <span class="required-star">*</span>کلمه عبور
            </label>
            <input type="password" id="password" name="password" class="form-input" placeholder="کلمه عبور خود را وارد کنید">
        </div>
        
        <div class="button-group">
            <button type="submit" class="btn btn-primary">ورود</button>
            <button type="reset" class="btn btn-reset">پاک کردن</button>
        </div>
        
        <div class="forgot-password">
            <a href="forgot_password.php">رمز عبور خود را فراموش کرده‌اید؟</a>
        </div>
    </form>
</div>

<?php
include("includes/footer.php");
?>