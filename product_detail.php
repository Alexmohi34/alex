<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>جزئیات محصول - فروشگاه ایرانیان</title>
<style type="text/css">
    :root {
        --primary: #4a6bff;
        --secondary: #ff6b6b;
        --dark: #2c3e50;
        --light: #f8f9fa;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #fd7e14;
        --info: #17a2b8;
        --gold: #FFD700;
    }
    
    body {
        font-family: 'Vazir', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
        color: #333;
    }
    
    .product-detail-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .product-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
    }
    
    .product-image-container {
        flex: 1;
        min-width: 300px;
        text-align: center;
    }
    
    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.02);
    }
    
    .product-info {
        flex: 1;
        min-width: 300px;
    }
    
    .product-title {
        font-size: 28px;
        color: var(--dark);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--primary);
    }
    
    .product-price {
        font-size: 24px;
        color: var(--danger);
        font-weight: bold;
        margin: 20px 0;
    }
    
    .product-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .product-stock {
        background-color: var(--success);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 16px;
    }
    
    .product-code {
        color: var(--info);
        font-size: 16px;
    }
    
    .product-description {
        line-height: 1.8;
        font-size: 16px;
        margin-bottom: 30px;
        text-align: justify;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .btn {
        display: inline-block;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .btn-primary {
        background: linear-gradient(to right, var(--primary), var(--secondary));
        color: white;
        box-shadow: 0 4px 15px rgba(74, 107, 255, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary), var(--primary));
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(74, 107, 255, 0.4);
    }
    
    .btn-secondary {
        background: white;
        color: var(--primary);
        border: 2px solid var(--primary);
    }
    
    .btn-secondary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
    }
    
    .price-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .price-currency {
        font-size: 18px;
        color: var(--dark);
    }
    
    @media (max-width: 768px) {
        .product-wrapper {
            flex-direction: column;
        }
        
        .product-title {
            font-size: 24px;
        }
        
        .product-price {
            font-size: 20px;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
</head>

<body>
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
$query = "SELECT * FROM `products` WHERE pro_code='$pro_code'";
$result = mysqli_query($link, $query);
?>

<div class="product-detail-container">
    <?php if($row = mysqli_fetch_array($result)): ?>
        <div class="product-wrapper">
            <div class="product-image-container">
                <img src="images/products/<?php echo $row['pro_image']; ?>" class="product-image" alt="<?php echo $row['pro_name']; ?>">
            </div>
            
            <div class="product-info">
                <h1 class="product-title"><?php echo $row['pro_name']; ?></h1>
                
                <div class="price-container">
                    <div class="product-price"><?php echo number_format($row['pro_price']); ?></div>
                    <div class="price-currency">ریال</div>
                </div>
                
                <div class="product-meta">
                    <span class="product-stock">موجود: <?php echo $row['pro_qty']; ?> عدد</span>
                    <span class="product-code">کد محصول: <?php echo $row['pro_code']; ?></span>
                </div>
                
                <div class="product-description">
                    <?php echo nl2br($row['pro_detail']); ?>
                </div>
                
                <div class="action-buttons">
                    <a href="order.php?id=<?php echo $row['pro_code']; ?>" class="btn btn-primary">سفارش و خرید پستی</a>
                    <a href="index.php" class="btn btn-secondary">بازگشت به فروشگاه</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h2>محصول مورد نظر یافت نشد</h2>
            <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">بازگشت به فروشگاه</a>
        </div>
    <?php endif; ?>
</div>

<?php
include("includes/footer.php");
?>
</body>
</html>