<?php
include("includes/header.php");
//session_start();

$link = mysqli_connect("localhost", "root", "", "shop_db");
if(mysqli_connect_errno()) {
    exit("خطای با شرح زیر رخ داده است:".mysqli_connect_error());
}

// افزودن محصول به سبد خرید
if(isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if(isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    // نمایش پیام موفقیت
    $_SESSION['cart_message'] = 'محصول به سبد خرید اضافه شد';
    header('Location: '.$_SERVER['PHP_SELF']);
    exit();
}

$query = "SELECT * FROM `products`";
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
        --bg-color: #f5f7ff;
        --bg-accent: #e8ecff;
    }
    
    body {
        background: linear-gradient(135deg, var(--bg-color), var(--bg-accent));
        min-height: 100vh;
        font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .products-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .section-title {
        text-align: center;
        font-size: 32px;
        color: var(--dark);
        margin: 40px 0 30px;
        position: relative;
        font-family: 'IranNastaliq', Arial, sans-serif;
        background: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .section-title:after {
        content: "";
        display: block;
        width: 150px;
        height: 4px;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        margin: 15px auto;
        border-radius: 2px;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        padding: 20px 0;
    }
    
    .product-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        background: white;
    }
    
    .product-image-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-body {
        padding: 20px;
    }
    
    .product-title {
        font-size: 19px;
        font-weight: bold;
        color: var(--dark);
        margin-bottom: 12px;
        text-align: center;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .product-price {
        font-size: 22px;
        color: var(--danger);
        font-weight: bold;
        margin: 15px 0;
        text-align: center;
    }
    
    .product-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    
    .product-stock {
        background-color: var(--success);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 14px;
    }
    
    .product-code {
        color: var(--info);
        font-size: 14px;
    }
    
    .product-description {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        text-align: justify;
    }
    
    .product-actions {
        display: flex;
        gap: 10px;
    }
    
    .product-link {
        display: block;
        text-align: center;
        background: linear-gradient(to right, var(--primary), var(--secondary));
        color: white;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        font-size: 16px;
        position: relative;
        overflow: hidden;
        flex: 1;
    }
    
    .product-link:hover {
        background: linear-gradient(to right, var(--secondary), var(--primary));
        box-shadow: 0 5px 15px rgba(74, 107, 255, 0.4);
        letter-spacing: 0.5px;
    }
    
    .add-to-cart {
        background: linear-gradient(to right, var(--success), var(--info));
        color: white;
        border: none;
        padding: 12px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
        flex: 1;
    }
    
    .add-to-cart:hover {
        background: linear-gradient(to right, var(--info), var(--success));
        transform: translateY(-2px);
    }
    
    .cart-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--success);
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 1000;
        animation: slideIn 0.5s, fadeOut 0.5s 2.5s forwards;
    }
    
    .cart-info {
        position: fixed;
        top: 20px;
        left: 20px;
        background: var(--primary);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 1000;
    }
    
    .cart-info a {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }
    
    @keyframes slideIn {
        from { transform: translateY(-100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        
        .section-title {
            font-size: 28px;
            padding: 15px;
        }
        
        body {
            background: linear-gradient(135deg, var(--bg-color), var(--bg-accent));
        }
        
        .product-actions {
            flex-direction: column;
        }
        
        .cart-info {
            top: auto;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<div class="products-section">
    <?php if(isset($_SESSION['cart_message'])): ?>
        <div class="cart-message">
            <?php echo $_SESSION['cart_message']; unset($_SESSION['cart_message']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(!empty($_SESSION['cart'])): ?>
        <div class="cart-info">
            <span>تعداد محصولات در سبد: <?php echo count($_SESSION['cart']); ?></span>
            <a href="cart.php">مشاهده سبد خرید</a>
        </div>
    <?php endif; ?>
    
    <h2 class="section-title">محصولات ویژه ما</h2>
    
    <div class="products-grid">
        <?php while($row = mysqli_fetch_array($result)): ?>
            <div class="product-card">
                <div class="product-image-container">
                    <a href="product_detail.php?id=<?php echo $row['pro_code']; ?>">
                        <img src="images/products/<?php echo $row['pro_image']; ?>" class="product-image" alt="<?php echo $row['pro_name']; ?>">
                    </a>
                </div>
                <div class="product-body">
                    <h3 class="product-title"><?php echo $row['pro_name']; ?></h3>
                    <div class="product-price"><?php echo number_format($row['pro_price']); ?> ریال</div>
                    
                    <div class="product-meta">
                        <span class="product-stock">موجود: <?php echo $row['pro_qty']; ?> عدد</span>
                        <span class="product-code">کد: <?php echo $row['pro_code']; ?></span>
                    </div>
                    
                    <p class="product-description"><?php echo substr($row['pro_detail'], 0, 120); ?>...</p>
                    
                    <div class="product-actions">
                        <a href="product_detail.php?id=<?php echo $row['pro_code']; ?>" class="product-link">جزئیات محصول</a>
                        <form method="post" style="flex: 1;">
                            <input type="hidden" name="product_id" value="<?php echo $row['pro_code']; ?>">
                            <button type="submit" name="add_to_cart" class="add-to-cart">افزودن به سبد</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php
include("includes/footer.php");
?>