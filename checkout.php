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
$total = 0;

foreach ($cart as $product_id => $quantity) {
    if (isset($products[$product_id])) {
        $total += $products[$product_id]['price'] * $quantity;
    }
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_checkout'])) {
    if (empty($cart)) {
        $message = '<div class="alert-error">Keranjang belanja kosong!</div>';
    } else {
        $shipping_address = $_POST['shipping_address'] ?? '';
        $payment_method = $_POST['payment_method'] ?? '';
        
        $_SESSION['cart'] = [];
        
        $message = '<div class="success-message">
                        <div style="font-size: 50px; margin-bottom: 20px;">🎉</div>
                        <h3 style="color: #ff69b4; margin-bottom: 15px;">Pembayaran Berhasil!</h3>
                        <p>Pesanan Anda telah berhasil diproses.</p>
                        <p><strong>Metode Pembayaran:</strong> ' . htmlspecialchars($payment_method) . '</p>
                        <p><strong>Alamat Pengiriman:</strong> ' . nl2br(htmlspecialchars($shipping_address)) . '</p>
                        <p><strong>Total Pembayaran:</strong> Rp ' . number_format($total + 15000, 0, ',', '.') . '</p>
                        <p style="margin-top: 20px; color: #ff69b4; font-weight: 600;">Terima kasih telah berbelanja di Emina Skincare! 💖</p>
                    </div>';
        $cart = [];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Emina Skincare</title>
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
        
        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }
        
        .checkout-summary {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
        }
        
        .checkout-summary h3 {
            color: #ff69b4;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ffb6c1;
        }
        
        .order-items {
            margin-bottom: 20px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .order-totals {
            margin-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }
        
        .total-row.grand-total {
            font-size: 20px;
            font-weight: 600;
            color: #ff1493;
            border-top: 2px solid #ffb6c1;
            margin-top: 10px;
        }
        
        .checkout-form {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
        }
        
        .form-section {
            margin-bottom: 25px;
        }
        
        .form-section h3 {
            color: #ff69b4;
            margin-bottom: 15px;
        }
        
        .form-section textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #ffb6c1;
            border-radius: 10px;
            font-size: 15px;
            resize: vertical;
            min-height: 100px;
        }
        
        .form-section textarea:focus {
            outline: none;
            border-color: #ff69b4;
        }
        
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .payment-option {
            display: block;
            cursor: pointer;
        }
        
        .payment-option input {
            display: none;
        }
        
        .payment-content {
            background: #ffe4e9;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s;
        }
        
        .payment-option input:checked + .payment-content {
            background: white;
            border-color: #ff69b4;
            box-shadow: 0 5px 15px rgba(255,105,180,0.2);
        }
        
        .payment-content i {
            font-size: 30px;
            color: #ff69b4;
            margin-bottom: 10px;
        }
        
        .checkout-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 15px;
        }
        
        .btn-back {
            background: #a4b0be;
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }
        
        .btn-checkout {
            background: #2ed573;
            color: white;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-checkout:hover {
            background: #26c464;
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
        }
        
        .alert-error {
            background: #ffebee;
            color: #d32f2f;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success-message {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
            grid-column: 1 / -1;
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
                <a href="cart.php">Keranjang <span class="cart-count"><?php echo array_sum($_SESSION['cart'] ?? []); ?></span></a>
                <a href="checkout.php" class="active">Checkout</a>
                <a href="logout.php">Logout</a>
            </div>
            
            <div class="nav-user">
                <span>👤</span>
                <span><?php echo $_SESSION['full_name']; ?></span>
            </div>
        </div>
    </nav>

    <main class="container">
        <h1 class="page-title">Checkout Pembayaran</h1>
        
        <?php echo $message; ?>
        
        <?php if (empty($cart) && empty($message)): ?>
            <div class="empty-cart">
                <div>🛒</div>
                <h3>Keranjang belanja kosong</h3>
                <p>Tambahkan produk terlebih dahulu sebelum checkout</p>
                <a href="products.php" class="btn-pink">🛍️ Belanja Sekarang</a>
            </div>
        <?php elseif (empty($message)): ?>
            <div class="checkout-container">
                <div class="checkout-summary">
                    <h3>📋 Ringkasan Pesanan</h3>
                    
                    <div class="order-items">
                        <?php foreach ($cart as $product_id => $quantity): 
                            if (isset($products[$product_id])):
                                $product = $products[$product_id];
                        ?>
                        <div class="order-item">
                            <span><?php echo $product['name']; ?> x<?php echo $quantity; ?></span>
                            <span>Rp <?php echo number_format($product['price'] * $quantity, 0, ',', '.'); ?></span>
                        </div>
                        <?php endif; endforeach; ?>
                    </div>
                    
                    <div class="order-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                        </div>
                        <div class="total-row">
                            <span>Ongkos Kirim</span>
                            <span>Rp 15.000</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total Pembayaran</span>
                            <span>Rp <?php echo number_format($total + 15000, 0, ',', '.'); ?></span>
                        </div>
                    </div>
                </div>
                
                <form method="POST" class="checkout-form">
                    <div class="form-section">
                        <h3>🚚 Alamat Pengiriman</h3>
                        <textarea name="shipping_address" required placeholder="Masukkan alamat lengkap pengiriman..."></textarea>
                    </div>
                    
                    <div class="form-section">
                        <h3>💳 Metode Pembayaran</h3>
                        <div class="payment-methods">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="Bank Transfer" required>
                                <div class="payment-content">
                                    <div>🏦</div>
                                    <span>Bank Transfer</span>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="E-Wallet">
                                <div class="payment-content">
                                    <div>📱</div>
                                    <span>E-Wallet</span>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="COD">
                                <div class="payment-content">
                                    <div>💵</div>
                                    <span>Cash on Delivery</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="checkout-actions">
                        <a href="cart.php" class="btn-back">⬅ Kembali ke Keranjang</a>
                        <button type="submit" name="process_checkout" class="btn-checkout">✅ Proses Pembayaran</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; 2026 Emina Skincare. Semua hak dilindungi.</p>
    </footer>
</body>
</html>