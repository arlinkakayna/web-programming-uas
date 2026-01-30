<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$products = [
    ['id' => 1, 'name' => 'Emina Bright Stuff Toner', 'price' => 45000, 'category' => 'Toner'],
    ['id' => 2, 'name' => 'Emina Sun Battle SPF 30', 'price' => 55000, 'category' => 'Sunscreen'],
    ['id' => 3, 'name' => 'Emina Magic Cream', 'price' => 65000, 'category' => 'Moisturizer'],
    ['id' => 4, 'name' => 'Emina Face Wash', 'price' => 35000, 'category' => 'Cleanser'],
    ['id' => 5, 'name' => 'Emina Lip Tint', 'price' => 35000, 'category' => 'Makeup'],
    ['id' => 6, 'name' => 'Emina Acne Solution', 'price' => 75000, 'category' => 'Serum'],
    ['id' => 7, 'name' => 'Emina Clay Mask', 'price' => 50000, 'category' => 'Mask'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    $message = "Produk berhasil ditambahkan ke keranjang!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Emina Skincare</title>
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
        
        .message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
            transition: transform 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-image {
            height: 180px;
            background: linear-gradient(135deg, #ffb6c1, #ff69b4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 50px;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-info h3 {
            color: #ff69b4;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .product-category {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .product-price {
            color: #ff1493;
            font-size: 20px;
            font-weight: 600;
            margin: 15px 0;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .qty-btn {
            width: 30px;
            height: 30px;
            background: #ff69b4;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
        }
        
        .qty-input {
            width: 50px;
            text-align: center;
            padding: 5px;
            border: 1px solid #ffb6c1;
            border-radius: 5px;
        }
        
        .add-to-cart {
            width: 100%;
            padding: 12px;
            background: #ff69b4;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .add-to-cart:hover {
            background: #ff1493;
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
                <a href="products.php" class="active">Produk</a>
                <a href="cart.php">Keranjang <span class="cart-count"><?php echo array_sum($_SESSION['cart'] ?? []); ?></span></a>
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
        <h1 class="page-title">Produk Skincare Emina</h1>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <span>💄</span>
                </div>
                
                <div class="product-info">
                    <h3><?php echo $product['name']; ?></h3>
                    <div class="product-category">Kategori: <?php echo $product['category']; ?></div>
                    <div class="product-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
                    
                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        
                        <div class="quantity-control">
                            <button type="button" class="qty-btn" onclick="changeQty(<?php echo $product['id']; ?>, -1)">-</button>
                            <input type="number" name="quantity" id="qty-<?php echo $product['id']; ?>" class="qty-input" value="1" min="1" readonly>
                            <button type="button" class="qty-btn" onclick="changeQty(<?php echo $product['id']; ?>, 1)">+</button>
                        </div>
                        
                        <button type="submit" class="add-to-cart">➕ Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 Emina Skincare. Semua hak dilindungi.</p>
    </footer>

    <script>
        function changeQty(productId, change) {
            const input = document.getElementById('qty-' + productId);
            let current = parseInt(input.value);
            let newValue = current + change;
            
            if (newValue >= 1) {
                input.value = newValue;
            }
        }
    </script>
</body>
</html>