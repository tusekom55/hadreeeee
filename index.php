<?php
require_once 'includes/functions.php';

$page_title = getCurrentLang() == 'tr' ? 'Ana Sayfa' : 'Home';

// Get some market data for the landing page
$database = new Database();
$db = $database->getConnection();

// Get top 6 cryptocurrencies for display
$top_markets = getMarketData('crypto_tl', 6);

// Get some statistics
$query = "SELECT COUNT(*) as total_markets FROM markets";
$stmt = $db->prepare($query);
$stmt->execute();
$total_markets = $stmt->fetchColumn();

$query = "SELECT COUNT(*) as total_users FROM users";
$stmt = $db->prepare($query);
$stmt->execute();
$total_users = $stmt->fetchColumn();

$query = "SELECT COALESCE(SUM(total), 0) as total_volume FROM transactions";
$stmt = $db->prepare($query);
$stmt->execute();
$total_volume = $stmt->fetchColumn();

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'Türkiye\'nin En Güvenilir<br><span class="text-primary">Kripto Borsası</span>' : 
                            'Turkey\'s Most Trusted<br><span class="text-primary">Crypto Exchange</span>'; ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'Bitcoin, Ethereum ve 50+ kripto para ile güvenli alım-satım yapın. Düşük komisyon, hızlı işlemler ve 7/24 destek.' : 
                            'Trade Bitcoin, Ethereum and 50+ cryptocurrencies safely. Low fees, fast transactions and 24/7 support.'; ?>
                    </p>
                    <div class="hero-buttons">
                        <?php if (!isLoggedIn()): ?>
                        <a href="register.php" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-rocket me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Hemen Başla' : 'Get Started'; ?>
                        </a>
                        <a href="markets.php" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-chart-line me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Piyasaları İncele' : 'View Markets'; ?>
                        </a>
                        <?php else: ?>
                        <a href="markets.php" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-chart-line me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Piyasalar' : 'Markets'; ?>
                        </a>
                        <a href="wallet.php" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-wallet me-2"></i>
                            <?php echo getCurrentLang() == 'tr' ? 'Cüzdan' : 'Wallet'; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <div class="crypto-animation">
                        <div class="floating-card">
                            <i class="fab fa-bitcoin text-warning"></i>
                            <span>Bitcoin</span>
                        </div>
                        <div class="floating-card">
                            <i class="fab fa-ethereum text-info"></i>
                            <span>Ethereum</span>
                        </div>
                        <div class="floating-card">
                            <i class="fas fa-coins text-success"></i>
                            <span>Altcoins</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">
                    <?php echo getCurrentLang() == 'tr' ? 'Neden GlobalBorsa?' : 'Why GlobalBorsa?'; ?>
                </h2>
                <p class="section-subtitle">
                    <?php echo getCurrentLang() == 'tr' ? 
                        'Kripto para ticaretinde güvenilir ortağınız' : 
                        'Your trusted partner in cryptocurrency trading'; ?>
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt text-success"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? 'Güvenli İşlemler' : 'Secure Trading'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'SSL şifreleme ve çok katmanlı güvenlik sistemi' : 
                        'SSL encryption and multi-layer security system'; ?></p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-percentage text-primary"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? 'Düşük Komisyon' : 'Low Fees'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'Sadece %0.25 işlem komisyonu' : 
                        'Only 0.25% trading commission'; ?></p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? '7/24 Destek' : '24/7 Support'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'Kesintisiz müşteri hizmetleri' : 
                        'Uninterrupted customer service'; ?></p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt text-info"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? 'Mobil Uyumlu' : 'Mobile Friendly'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'Her cihazdan kolay erişim' : 
                        'Easy access from any device'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Cryptocurrencies -->
<?php if (!empty($top_markets)): ?>
<section class="popular-crypto py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">
                    <?php echo getCurrentLang() == 'tr' ? 'Popüler Kripto Paralar' : 'Popular Cryptocurrencies'; ?>
                </h2>
                <p class="section-subtitle">
                    <?php echo getCurrentLang() == 'tr' ? 
                        'En çok işlem gören kripto paraları keşfedin' : 
                        'Discover the most traded cryptocurrencies'; ?>
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php foreach ($top_markets as $market): ?>
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card" onclick="window.location.href='<?php echo isLoggedIn() ? 'trading.php?pair=' . $market['symbol'] : 'login.php'; ?>'">
                    <div class="crypto-header">
                        <?php if ($market['logo_url']): ?>
                        <img src="<?php echo $market['logo_url']; ?>" alt="<?php echo $market['name']; ?>" class="crypto-logo">
                        <?php else: ?>
                        <div class="crypto-logo-placeholder">
                            <i class="fas fa-coins"></i>
                        </div>
                        <?php endif; ?>
                        <div class="crypto-info">
                            <h6 class="crypto-symbol"><?php echo $market['symbol']; ?></h6>
                            <small class="crypto-name"><?php echo $market['name']; ?></small>
                        </div>
                    </div>
                    <div class="crypto-price">
                        <div class="price"><?php echo formatPrice($market['price']); ?> TL</div>
                        <div class="change <?php echo $market['change_24h'] >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo ($market['change_24h'] >= 0 ? '+' : '') . formatNumber($market['change_24h'], 2); ?>%
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="markets.php" class="btn btn-primary">
                <?php echo getCurrentLang() == 'tr' ? 'Tüm Piyasaları Gör' : 'View All Markets'; ?>
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- How to Start -->
<section class="how-to-start py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">
                    <?php echo getCurrentLang() == 'tr' ? 'Nasıl Başlarım?' : 'How to Get Started?'; ?>
                </h2>
                <p class="section-subtitle">
                    <?php echo getCurrentLang() == 'tr' ? 
                        '3 basit adımda kripto para ticaretine başlayın' : 
                        'Start cryptocurrency trading in 3 simple steps'; ?>
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? 'Hesap Oluştur' : 'Create Account'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'Hızlı ve kolay kayıt işlemi' : 
                        'Quick and easy registration process'; ?></p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? 'Para Yatır' : 'Deposit Money'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'IBAN veya Papara ile güvenli para yatırma' : 
                        'Secure deposit via IBAN or Papara'; ?></p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h5><?php echo getCurrentLang() == 'tr' ? 'İşlem Yap' : 'Start Trading'; ?></h5>
                    <p><?php echo getCurrentLang() == 'tr' ? 
                        'Kripto para alım-satımına başlayın' : 
                        'Start buying and selling cryptocurrencies'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="statistics py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="stat-number"><?php echo number_format($total_users); ?>+</h3>
                    <p class="stat-label"><?php echo getCurrentLang() == 'tr' ? 'Kullanıcı' : 'Users'; ?></p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="stat-number"><?php echo $total_markets; ?>+</h3>
                    <p class="stat-label"><?php echo getCurrentLang() == 'tr' ? 'Kripto Para' : 'Cryptocurrencies'; ?></p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="stat-number"><?php echo formatVolume($total_volume); ?></h3>
                    <p class="stat-label"><?php echo getCurrentLang() == 'tr' ? 'İşlem Hacmi' : 'Trading Volume'; ?></p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h3 class="stat-number">%0.25</h3>
                    <p class="stat-label"><?php echo getCurrentLang() == 'tr' ? 'Komisyon' : 'Commission'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<?php if (!isLoggedIn()): ?>
<section class="cta-section py-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="cta-title">
                    <?php echo getCurrentLang() == 'tr' ? 
                        'Kripto Para Ticaretine Bugün Başlayın!' : 
                        'Start Cryptocurrency Trading Today!'; ?>
                </h2>
                <p class="cta-subtitle">
                    <?php echo getCurrentLang() == 'tr' ? 
                        'Hesap açın ve 1.000 TL hoş geldin bonusu kazanın' : 
                        'Open an account and earn 1,000 TL welcome bonus'; ?>
                </p>
                <div class="cta-buttons">
                    <a href="register.php" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-user-plus me-2"></i>
                        <?php echo getCurrentLang() == 'tr' ? 'Ücretsiz Hesap Aç' : 'Open Free Account'; ?>
                    </a>
                    <a href="login.php" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        <?php echo getCurrentLang() == 'tr' ? 'Giriş Yap' : 'Login'; ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 100px 0;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-buttons .btn {
    padding: 12px 30px;
    font-weight: 600;
}

.crypto-animation {
    position: relative;
    height: 400px;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    animation: float 6s ease-in-out infinite;
}

.floating-card:nth-child(1) {
    top: 50px;
    right: 100px;
    animation-delay: 0s;
}

.floating-card:nth-child(2) {
    top: 200px;
    right: 50px;
    animation-delay: 2s;
}

.floating-card:nth-child(3) {
    top: 150px;
    right: 200px;
    animation-delay: 4s;
}

.floating-card i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 0;
}

.feature-card {
    text-align: center;
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon i {
    font-size: 2rem;
}

.crypto-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    cursor: pointer;
    height: 100%;
}

.crypto-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.crypto-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.crypto-logo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 1rem;
}

.crypto-logo-placeholder {
    width: 40px;
    height: 40px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
}

.crypto-symbol {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.crypto-name {
    color: #6c757d;
}

.crypto-price .price {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.crypto-price .change {
    font-weight: 600;
}

.crypto-price .change.positive {
    color: #28a745;
}

.crypto-price .change.negative {
    color: #dc3545;
}

.step-card {
    text-align: center;
    padding: 2rem;
    position: relative;
}

.step-number {
    position: absolute;
    top: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 40px;
    background: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.2rem;
}

.step-icon {
    width: 80px;
    height: 80px;
    margin: 2rem auto 1.5rem;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.step-icon i {
    font-size: 2rem;
    color: #007bff;
}

.stat-item {
    padding: 1rem;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.cta-section {
    background: #f8f9fa;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 2rem;
}

.min-vh-75 {
    min-height: 75vh;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .crypto-animation {
        height: 200px;
    }
    
    .floating-card {
        position: relative;
        margin-bottom: 1rem;
        top: auto !important;
        right: auto !important;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
