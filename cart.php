<?php
include("includes/header.php");
session_start();

if(empty($_SESSION['cart'])) {
    echo '<div class="empty-cart">سبد خرید شما خالی است</div>';
    include("includes/footer.php");
    exit();
}

$link = mysqli_connect("localhost", "root", "", "shop_db");
if(mysqli_connect_errno()) {
    exit("خطای با شرح زیر رخ داده است:".mysqli_connect_error());
}
?>

<style>
    .cart-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .cart-title {
        text-align: center;
        font-size: 28px;
        color: var(--dark);
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--primary);
    }
    
    .cart-items {
        margin-bottom: 30px;
    }
    
    .cart-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #eee;
        gap: 20px;
    }
    
    .cart-item-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .cart-item-details {
        flex: 1;
    }
    
    .cart-item-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .cart-item-price {
        color: var(--danger);
        font-weight: bold;
    }
    
    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .cart-item-quantity input {
        width: 60px;
        text-align: center;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .remove-item {
        color: var(--danger);
        cursor: pointer;
        background: none;
        border: none;
        font-size: 16px;
    }
    
    .cart-summary {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        margin-top: 30px;
    }
    
    .cart-total {
        font-size: 20px;
        font-weight: bold;
        text-align: right;
        margin-top: 20px;
    }
    
    .cart-actions {
        display: flex;
        justify-content: space-between;
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
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary {
        background: linear-gradient(to right, var(--primary), var(--secondary));
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(to right, var(--secondary), var(--primary));
        transform: translateY(-3px);
    }
    
    .btn-secondary {
        background: #f1f1f1;
        color: var(--dark);
    }
    
    .btn-secondary:hover {
        background: #e1e1e1;
    }
</style>

<div class="cart-container">
    <h2 class="cart-title">سبد خرید شما</h2>
    
    <div class="cart-items">
        <?php
        $total = 0;
        foreach($_SESSION['cart'] as $product_id => $quantity):
            $query = "SELECT * FROM products WHERE pro_code='$product_id'";
            $result = mysqli_query($link, $query);
            $product = mysqli_fetch_array($result);
            
            if($product):
                $subtotal = $product['pro_price'] * $quantity;
                $total += $subtotal;
        ?>
            <div class="cart-item">
                <img src="images/products/<?php echo $product['pro_image']; ?>" class="cart-item-image" alt="<?php echo $product['pro_name']; ?>">
                
                <div class="cart-item-details">
                    <div class="cart-item-title"><?php echo $product['pro_name']; ?></div>
                    <div class="cart-item-price"><?php echo number_format($product['pro_price']); ?> ریال</div>
                </div>
                
                <div class="cart-item-quantity">
                    <form method="post" action="update_cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" max="<?php echo $product['pro_qty']; ?>">
                        <button type="submit" name="update_cart">بروزرسانی</button>
                    </form>
                </div>
                
                <div class="cart-item-subtotal"><?php echo number_format($subtotal); ?> ریال</div>
                
                <form method="post" action="remove_from_cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <button type="submit" class="remove-item">حذف</button>
                </form>
            </div>
        <?php 
            endif;
        endforeach;
        ?>
    </div>
    
    <div class="cart-summary">
        <div class="cart-total">جمع کل: <?php echo number_format($total); ?> ریال</div>
        
        <div class="cart-actions">
            <a href="index.php" class="btn btn-secondary">ادامه خرید</a>
            
            <?php if(isset($_SESSION["state_login"]) && $_SESSION["state_login"] === true): ?>
                <a href="checkout.php" class="btn btn-primary">تکمیل خرید</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary">ورود و تکمیل خرید</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>