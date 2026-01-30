<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$products = [
    1 => ['name' => 'Emina Bright Stuff Toner', 'price' => 45000],
    2 => ['name' => 'Emina Sun Battle SPF 30', 'price' => 55000],
    3 => ['name' => 'Emina Magic Cream', 'price' => 65000],
    4 => ['name' => 'Emina Face Wash', 'price' => 35000],
    5 => ['name' => 'Emina Lip Tint', 'price' => 35000],
    6 => ['name' => 'Emina Acne Solution', 'price' => 75000],
    7 => ['name' => 'Emina Clay Mask', 'price' => 50000],
];

$cart = $_SESSION['cart'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id] = $quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        $cart = $_SESSION['cart'];
    } elseif (isset($_POST['remove_item'])) {
        $product_id = $_POST['product_id'];
        unset($_SESSION['cart'][$product_id]);
        $cart = $_SESSION['cart'];
    } elseif (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
        $cart = [];
    }
}

$total = 0;
foreach ($cart as $product_id => $quantity) {
    if (isset($products[$product_id])) {
        $total += $products[$product_id]['price'] * $quantity;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Emina Skincare</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #ffe4e9;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, #ff69b4, #db7093);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 24px;
            font-weight: 600;
        }
        
        .nav-menu {
            display: flex;
            gap: 20px;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            transition: background 0.3s;
        }
        
        .nav-menu a:hover, .nav-menu a.active {
            background: rgba(255,255,255,0.2);
        }
        
        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-count {
            background: white;
            color: #ff69b4;
            padding: 2px 8px;
            border-radius: 50%;
            font-size: 14px;
            margin-left: 5px;
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .page-title {
            color: #ff69b4;
            margin-bottom: 30px;
            font-size: 32px;
        }
        
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
        }
        
        .empty-cart i {
            font-size: 60px;
            color: #ffb6c1;
            margin-bottom: 20px;
        }
        
        .empty-cart h3 {
            color: #ff69b4;
            margin-bottom: 10px;
        }
        
        .btn-pink {
            display: inline-block;
            background: #ff69b4;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        
        .btn-pink:hover {
            background: #ff1493;
        }
        
        .cart-items {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
            margin-bottom: 30px;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
            gap: 20px;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ffb6c1, #ff69b4);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-details h3 {
            color: #ff69b4;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: #666;
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cart-item-quantity input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid #ffb6c1;
            border-radius: 5px;
        }
        
        .cart-item-subtotal {
            font-weight: 600;
            color: #ff1493;
            font-size: 18px;
        }
        
        .cart-item-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-remove {
            background: #ff4757;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
        }
        
        .cart-summary {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
        }
        
        .summary-details h3 {
            color: #ff69b4;
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .summary-row.total {
            font-size: 20px;
            font-weight: 600;
            color: #ff1493;
            border-bottom: none;
            margin-top: 10px;
        }
        
        .cart-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: flex-end;
        }
        
        .btn-update {
            background: #ffa502;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .btn-clear {
            background: #ff4757;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .btn-checkout {
            background: #2ed573;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <span>🌸</span>
                <span>Emina Skincare</span>
            </div>
            
            <div class="nav-menu">
                <a href="dashboard.php">Dashboard</a>
                <a href="products.php">Produk</a>
                <a href="cart.php" class="active">Keranjang <span class="cart-count"><?php echo array_sum($_SESSION['cart'] ?? []); ?></span></a>
                <a href="checkout.php">Checkout</a>
                <a href="logout.php">Logout</a>
            </div>
            
            <div class="nav-user">
                <span>👤</span>
                <span><?php echo $_SESSION['full_name']; ?></span>
            </div>
        </div>
    </nav>

    <main class="container">
        <h1 class="page-title">Keranjang Belanja</h1>
        
        <?php if (empty($cart)): ?>
            <div class="empty-cart">
                <div>🛒</div>
                <h3>Keranjang belanja kosong</h3>
                <p>Belum ada produk di keranjang belanja Anda</p>
                <a href="products.php" class="btn-pink">🛍️ Belanja Sekarang</a>
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="cart-items">
                    <?php foreach ($cart as $product_id => $quantity): 
                        if (isset($products[$product_id])):
                            $product = $products[$product_id];
                            $subtotal = $product['price'] * $quantity;
                    ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <span>💄</span>
                        </div>
                        
                        <div class="cart-item-details">
                            <h3><?php echo $product['name']; ?></h3>
                            <div class="cart-item-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
                        </div>
                        
                        <div class="cart-item-quantity">
                            <input type="number" name="quantity[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="1">
                        </div>
                        
                        <div class="cart-item-subtotal">
                            Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
                        </div>
                        
                        <div class="cart-item-actions">
                            <button type="submit" name="remove_item" class="btn-remove">🗑️</button>
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
                
                <div class="cart-summary">
                    <div class="summary-details">
                        <h3>Ringkasan Belanja</h3>
                        <div class="summary-row">
                            <span>Total Harga</span>
                            <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Ongkos Kirim</span>
                            <span>Rp 15.000</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Pembayaran</span>
                            <span>Rp <?php echo number_format($total + 15000, 0, ',', '.'); ?></span>
                        </div>
                    </div>
                    
                    <div class="cart-actions">
                        <button type="submit" name="update_cart" class="btn-update">🔄 Update Keranjang</button>
                        <button type="submit" name="clear_cart" class="btn-clear" onclick="return confirm('Hapus semua item?')">🗑️ Kosongkan</button>
                        <a href="checkout.php" class="btn-checkout">💳 Lanjut ke Checkout</a>
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2026 Emina Skincare. Semua hak dilindungi.</p>
    </footer>
</body>
</html>