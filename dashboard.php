<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Emina Skincare</title>
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
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(255,105,180,0.1);
            transition: transform 0.3s;
            text-align: center;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-icon {
            font-size: 40px;
            color: #ff69b4;
            margin-bottom: 15px;
        }
        
        .card h3 {
            color: #ff69b4;
            margin-bottom: 10px;
        }
        
        .btn {
            display: inline-block;
            background: #ff69b4;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 15px;
            font-weight: 500;
        }
        
        .btn:hover {
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
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="products.php">Produk</a>
                <a href="cart.php">Keranjang</a>
                <a href="checkout.php">Checkout</a>
                <a href="logout.php">Logout</a>
            </div>
            
            <div class="nav-user">
                <span>👤</span>
                <span>Halo, <?php echo $_SESSION['full_name']; ?>!</span>
            </div>
        </div>
    </nav>

    <main class="container">
        <h1 class="page-title">Dashboard Emina Skincare</h1>
        
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon">🛍️</div>
                <h3>Produk Skincare</h3>
                <p>Temukan produk perawatan kulit terbaik</p>
                <a href="products.php" class="btn">Lihat Produk</a>
            </div>
            
            <div class="card">
                <div class="card-icon">🛒</div>
                <h3>Keranjang Belanja</h3>
                <p>Lihat produk yang akan dibeli</p>
                <a href="cart.php" class="btn">Lihat Keranjang</a>
            </div>
            
            <div class="card">
                <div class="card-icon">💳</div>
                <h3>Checkout</h3>
                <p>Selesaikan pembelian Anda</p>
                <a href="checkout.php" class="btn">Proses Checkout</a>
            </div>
            
            <div class="card">
                <div class="card-icon">💖</div>
                <h3>Tips Skincare</h3>
                <p>Tips perawatan kulit dengan Emina</p>
                <button class="btn" onclick="alert('💖 Tips: Selalu gunakan sunscreen setiap hari!')">Lihat Tips</button>
            </div>
        </div>
        
        <div class="card">
            <h3 style="color: #ff69b4; margin-bottom: 15px;">✨ Kenapa Pilih Emina?</h3>
            <p>Emina Skincare dirancang khusus untuk kulit remaja dan dewasa muda Indonesia dengan formula yang aman dan efektif.</p>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 Emina Skincare. Semua hak dilindungi.</p>
    </footer>
</body>
</html>