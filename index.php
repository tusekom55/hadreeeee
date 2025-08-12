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
/* Modern Professional Design */
:root {
    --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    --secondary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --accent-color: #00d4ff;
    --success-color: #00c851;
    --danger-color: #ff4444;
    --dark-bg: #0f1419;
    --card-bg: rgba(255, 255, 255, 0.95);
    --text-primary: #1a1a1a;
    --text-secondary: #6c757d;
    --border-radius: 20px;
    --shadow-light: 0 10px 40px rgba(0, 0, 0, 0.1);
    --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.15);
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    overflow-x: hidden;
}

/* Hero Section - Modern Design */
.hero-section {
    background: var(--primary-gradient);
    position: relative;
    padding: 120px 0 80px;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    color: white;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
}

.hero-title .text-primary {
    background: linear-gradient(45deg, var(--accent-color), #00ff88);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 2.5rem;
    opacity: 0.95;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.6;
    max-width: 600px;
}

.hero-buttons .btn {
    padding: 15px 35px;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 50px;
    margin: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hero-buttons .btn-primary {
    background: linear-gradient(45deg, var(--accent-color), #00ff88);
    box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
}

.hero-buttons .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 212, 255, 0.4);
}

.hero-buttons .btn-outline-primary {
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    backdrop-filter: blur(10px);
}

.hero-buttons .btn-outline-primary:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
}

/* Crypto Animation - Enhanced */
.crypto-animation {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    padding: 25px;
    text-align: center;
    animation: float 8s ease-in-out infinite;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.floating-card:hover {
    transform: scale(1.05) translateY(-10px);
    background: rgba(255, 255, 255, 0.25);
}

.floating-card:nth-child(1) {
    top: 80px;
    right: 120px;
    animation-delay: 0s;
}

.floating-card:nth-child(2) {
    top: 250px;
    right: 60px;
    animation-delay: 2.5s;
}

.floating-card:nth-child(3) {
    top: 180px;
    right: 220px;
    animation-delay: 5s;
}

.floating-card i {
    font-size: 2.5rem;
    margin-bottom: 15px;
    display: block;
    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
}

.floating-card span {
    font-weight: 600;
    font-size: 1.1rem;
    color: white;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-15px) rotate(1deg); }
    50% { transform: translateY(-25px) rotate(0deg); }
    75% { transform: translateY(-10px) rotate(-1deg); }
}

/* Section Styling */
.section-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--text-primary);
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(45deg, var(--accent-color), #00ff88);
    border-radius: 2px;
}

.section-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 0;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Feature Cards - Premium Design */
.feature-card {
    text-align: center;
    padding: 3rem 2rem;
    background: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    transition: all 0.4s ease;
    height: 100%;
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(45deg, var(--accent-color), #00ff88);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-heavy);
}

.feature-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.feature-icon::before {
    content: '';
    position: absolute;
    inset: 3px;
    background: white;
    border-radius: 50%;
}

.feature-icon i {
    font-size: 2.5rem;
    position: relative;
    z-index: 1;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.feature-card h5 {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

/* Crypto Cards - Enhanced */
.crypto-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 2rem;
    box-shadow: var(--shadow-light);
    transition: all 0.4s ease;
    cursor: pointer;
    height: 100%;
    border: 1px solid rgba(255, 255, 255, 0.8);
    position: relative;
    overflow: hidden;
}

.crypto-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.crypto-card:hover::before {
    opacity: 0.05;
}

.crypto-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-heavy);
}

.crypto-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 1;
}

.crypto-logo {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 1rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.crypto-logo-placeholder {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: white;
    box-shadow: 0 5px 15px rgba(0, 212, 255, 0.3);
}

.crypto-symbol {
    font-weight: 800;
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.crypto-name {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.crypto-price {
    position: relative;
    z-index: 1;
}

.crypto-price .price {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.crypto-price .change {
    font-weight: 700;
    font-size: 1.1rem;
    padding: 5px 12px;
    border-radius: 20px;
    display: inline-block;
}

.crypto-price .change.positive {
    color: var(--success-color);
    background: rgba(0, 200, 81, 0.1);
}

.crypto-price .change.negative {
    color: var(--danger-color);
    background: rgba(255, 68, 68, 0.1);
}

/* Statistics Section */
.statistics {
    background: var(--primary-gradient);
    position: relative;
}

.statistics::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="b" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23ffffff" stop-opacity="0"/></radialGradient></defs><circle cx="100" cy="100" r="80" fill="url(%23b)"/><circle cx="900" cy="200" r="120" fill="url(%23b)"/><circle cx="300" cy="800" r="100" fill="url(%23b)"/></svg>');
    opacity: 0.2;
}

.stat-item {
    padding: 2rem 1rem;
    position: relative;
    z-index: 1;
}

.stat-number {
    font-size: 3.5rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
    color: white;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
}

.stat-label {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 0;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

/* CTA Section */
.cta-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
}

.cta-title {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    color: var(--text-primary);
}

.cta-subtitle {
    font-size: 1.3rem;
    color: var(--text-secondary);
    margin-bottom: 2.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons .btn {
    padding: 15px 35px;
    font-weight: 600;
    font-size: 1.1rem;
    border-radius: 50px;
    margin: 0.5rem;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Step Cards */
.step-card {
    text-align: center;
    padding: 3rem 2rem;
    position: relative;
    background: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
    transition: all 0.3s ease;
    height: 100%;
    margin-top: 30px;
}

.step-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-heavy);
}

.step-number {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1.4rem;
    box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
}

.step-icon {
    width: 100px;
    height: 100px;
    margin: 2rem auto 1.5rem;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.step-icon::before {
    content: '';
    position: absolute;
    inset: 3px;
    background: white;
    border-radius: 50%;
}

.step-icon i {
    font-size: 2.5rem;
    position: relative;
    z-index: 1;
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.min-vh-75 {
    min-height: 75vh;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .crypto-animation {
        height: 300px;
    }
    
    .floating-card {
        position: relative;
        margin-bottom: 1rem;
        top: auto !important;
        right: auto !important;
        animation: none;
    }
    
    .hero-buttons .btn {
        display: block;
        width: 100%;
        margin: 0.5rem 0;
    }
    
    .feature-card,
    .crypto-card,
    .step-card {
        margin-bottom: 2rem;
    }
}

/* Loading Animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.loading {
    animation: pulse 2s infinite;
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--accent-color), #00ff88);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #00b8e6, #00e67a);
}
</style>

<?php include 'includes/footer.php'; ?>
