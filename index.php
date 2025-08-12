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
/* Ultra Luxury Minimalist Design */
:root {
    --primary-white: #ffffff;
    --secondary-white: #fafafa;
    --accent-gold: #ffd700;
    --accent-yellow: #ffeb3b;
    --warm-gold: #f4c430;
    --light-gold: #fff8dc;
    --text-primary: #1a1a1a;
    --text-secondary: #666666;
    --text-light: #999999;
    --border-light: #f0f0f0;
    --shadow-subtle: 0 2px 20px rgba(0, 0, 0, 0.04);
    --shadow-medium: 0 8px 40px rgba(0, 0, 0, 0.08);
    --shadow-heavy: 0 20px 60px rgba(0, 0, 0, 0.12);
    --border-radius: 16px;
    --success-color: #4caf50;
    --danger-color: #f44336;
}

body {
    font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: var(--primary-white);
    color: var(--text-primary);
    overflow-x: hidden;
    font-weight: 400;
    line-height: 1.6;
}

/* Hero Section - Ultra Minimalist */
.hero-section {
    background: linear-gradient(135deg, var(--primary-white) 0%, var(--light-gold) 100%);
    position: relative;
    padding: 140px 0 100px;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255, 215, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(255, 235, 59, 0.06) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 4.5rem;
    font-weight: 300;
    margin-bottom: 2rem;
    line-height: 1.1;
    color: var(--text-primary);
    letter-spacing: -0.02em;
}

.hero-title .text-primary {
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 400;
}

.hero-subtitle {
    font-size: 1.4rem;
    margin-bottom: 3rem;
    color: var(--text-secondary);
    line-height: 1.7;
    max-width: 580px;
    font-weight: 300;
}

.hero-buttons .btn {
    padding: 18px 40px;
    font-weight: 500;
    font-size: 1rem;
    border-radius: 12px;
    margin: 0.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    letter-spacing: 0.3px;
    text-transform: none;
}

.hero-buttons .btn-primary {
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    color: var(--text-primary);
    box-shadow: var(--shadow-medium);
}

.hero-buttons .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-heavy);
    background: linear-gradient(135deg, var(--warm-gold), var(--accent-gold));
}

.hero-buttons .btn-outline-primary {
    border: 1px solid var(--border-light);
    color: var(--text-primary);
    background: var(--primary-white);
    backdrop-filter: blur(20px);
}

.hero-buttons .btn-outline-primary:hover {
    background: var(--secondary-white);
    transform: translateY(-2px);
    box-shadow: var(--shadow-medium);
}

/* Crypto Animation - Minimalist */
.crypto-animation {
    position: relative;
    height: 450px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-card {
    position: absolute;
    background: var(--primary-white);
    border: 1px solid var(--border-light);
    border-radius: var(--border-radius);
    padding: 30px;
    text-align: center;
    animation: float 12s ease-in-out infinite;
    box-shadow: var(--shadow-subtle);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.floating-card:hover {
    transform: scale(1.02) translateY(-5px);
    box-shadow: var(--shadow-medium);
}

.floating-card:nth-child(1) {
    top: 60px;
    right: 100px;
    animation-delay: 0s;
}

.floating-card:nth-child(2) {
    top: 220px;
    right: 40px;
    animation-delay: 4s;
}

.floating-card:nth-child(3) {
    top: 140px;
    right: 180px;
    animation-delay: 8s;
}

.floating-card i {
    font-size: 2.2rem;
    margin-bottom: 12px;
    display: block;
}

.floating-card span {
    font-weight: 500;
    font-size: 1rem;
    color: var(--text-primary);
    letter-spacing: 0.3px;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
}

/* Section Styling - Minimalist */
.section-title {
    font-size: 2.8rem;
    font-weight: 300;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    letter-spacing: -0.01em;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 2px;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    border-radius: 1px;
}

.section-subtitle {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 0;
    max-width: 520px;
    margin-left: auto;
    margin-right: auto;
    font-weight: 300;
    line-height: 1.7;
}

/* Feature Cards - Ultra Minimalist */
.feature-card {
    text-align: center;
    padding: 3.5rem 2.5rem;
    background: var(--primary-white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-subtle);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    border: 1px solid var(--border-light);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-medium);
}

.feature-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 2.5rem;
    background: linear-gradient(135deg, var(--light-gold), var(--accent-gold));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.feature-icon::before {
    content: '';
    position: absolute;
    inset: 2px;
    background: var(--primary-white);
    border-radius: 50%;
}

.feature-icon i {
    font-size: 2rem;
    position: relative;
    z-index: 1;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.feature-card h5 {
    font-size: 1.3rem;
    font-weight: 500;
    margin-bottom: 1.2rem;
    color: var(--text-primary);
    letter-spacing: 0.3px;
}

.feature-card p {
    color: var(--text-secondary);
    font-weight: 300;
    line-height: 1.6;
}

/* Crypto Cards - Ultra Minimalist */
.popular-crypto {
    background: var(--secondary-white) !important;
}

.crypto-card {
    background: var(--primary-white);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    box-shadow: var(--shadow-subtle);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    height: 100%;
    border: 1px solid var(--border-light);
    position: relative;
    overflow: hidden;
}

.crypto-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    transform: scaleX(0);
    transition: transform 0.4s ease;
}

.crypto-card:hover::before {
    transform: scaleX(1);
}

.crypto-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-medium);
}

.crypto-header {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    position: relative;
    z-index: 1;
}

.crypto-logo {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    margin-right: 1rem;
    box-shadow: var(--shadow-subtle);
}

.crypto-logo-placeholder {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    color: var(--primary-white);
    box-shadow: var(--shadow-subtle);
}

.crypto-symbol {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
    letter-spacing: 0.3px;
}

.crypto-name {
    color: var(--text-secondary);
    font-size: 0.85rem;
    font-weight: 300;
}

.crypto-price {
    position: relative;
    z-index: 1;
}

.crypto-price .price {
    font-size: 1.6rem;
    font-weight: 600;
    margin-bottom: 0.8rem;
    color: var(--text-primary);
    letter-spacing: -0.01em;
}

.crypto-price .change {
    font-weight: 500;
    font-size: 0.95rem;
    padding: 6px 14px;
    border-radius: 12px;
    display: inline-block;
    letter-spacing: 0.2px;
}

.crypto-price .change.positive {
    color: var(--success-color);
    background: rgba(76, 175, 80, 0.08);
}

.crypto-price .change.negative {
    color: var(--danger-color);
    background: rgba(244, 67, 54, 0.08);
}

/* Statistics Section - Gold Theme */
.statistics {
    background: linear-gradient(135deg, var(--accent-gold) 0%, var(--warm-gold) 100%);
    position: relative;
}

.statistics::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
}

.stat-item {
    padding: 3rem 1rem;
    position: relative;
    z-index: 1;
}

.stat-number {
    font-size: 3.2rem;
    font-weight: 300;
    margin-bottom: 0.8rem;
    color: var(--text-primary);
    letter-spacing: -0.02em;
}

.stat-label {
    font-size: 1.1rem;
    margin-bottom: 0;
    color: var(--text-primary);
    font-weight: 400;
    opacity: 0.8;
}

/* CTA Section - Minimalist */
.cta-section {
    background: var(--primary-white);
    position: relative;
}

.cta-title {
    font-size: 2.8rem;
    font-weight: 300;
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    letter-spacing: -0.01em;
}

.cta-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 3rem;
    max-width: 520px;
    margin-left: auto;
    margin-right: auto;
    font-weight: 300;
    line-height: 1.7;
}

.cta-buttons .btn {
    padding: 18px 40px;
    font-weight: 500;
    font-size: 1rem;
    border-radius: 12px;
    margin: 0.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: none;
    letter-spacing: 0.3px;
}

/* Step Cards - Ultra Clean */
.step-card {
    text-align: center;
    padding: 3.5rem 2.5rem;
    position: relative;
    background: var(--primary-white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-subtle);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    margin-top: 40px;
    border: 1px solid var(--border-light);
}

.step-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-medium);
}

.step-number {
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    color: var(--text-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    font-size: 1.5rem;
    box-shadow: var(--shadow-medium);
}

.step-icon {
    width: 90px;
    height: 90px;
    margin: 2.5rem auto 2rem;
    background: linear-gradient(135deg, var(--light-gold), var(--accent-gold));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.step-icon::before {
    content: '';
    position: absolute;
    inset: 2px;
    background: var(--primary-white);
    border-radius: 50%;
}

.step-icon i {
    font-size: 2.2rem;
    position: relative;
    z-index: 1;
    background: linear-gradient(135deg, var(--accent-gold), var(--warm-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.step-card h5 {
    font-size: 1.3rem;
    font-weight: 500;
    margin-bottom: 1.2rem;
    color: var(--text-primary);
    letter-spacing: 0.3px;
}

.step-card p {
    color: var(--text-secondary);
    font-weight: 300;
    line-height: 1.6;
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
