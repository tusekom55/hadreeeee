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

<!-- Hero Section - XM Style -->
<section class="hero-section">
    <div class="hero-background">
        <div class="hero-shapes"></div>
    </div>
    <div class="container">
        <div class="row align-items-center min-vh-80">
            <div class="col-lg-7">
                <div class="hero-content">
                    <div class="trust-badge mb-4">
                        <span class="badge-text">
                            <?php echo getCurrentLang() == 'tr' ? 
                                number_format($total_users) . '+ yatırımcı bize güveniyor' : 
                                number_format($total_users) . '+ investors trust us'; ?>
                        </span>
                    </div>
                    
                    <h1 class="hero-title">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'En çok ödül alan<br><span class="text-accent">kripto borsası</span><br>olmamız tesadüf değil' : 
                            'Being the most<br><span class="text-accent">awarded crypto exchange</span><br>is no coincidence'; ?>
                    </h1>
                    
                    <p class="hero-subtitle">
                        <?php echo getCurrentLang() == 'tr' ? 
                            'Yatırımcılara rahatça kâr edebilecekleri seçkin bir kripto yatırım ortamı sağlıyoruz.' : 
                            'We provide investors with an exclusive crypto investment environment where they can profit comfortably.'; ?>
                    </p>
                    
                    <div class="hero-buttons">
                        <?php if (!isLoggedIn()): ?>
                        <a href="register.php" class="btn btn-primary btn-lg">
                            <?php echo getCurrentLang() == 'tr' ? 'Hoş Geldin Bonusunu Al*' : 'Get Welcome Bonus*'; ?>
                        </a>
                        <small class="bonus-note">
                            <?php echo getCurrentLang() == 'tr' ? '*Sınırlı süreli teklif' : '*Limited time offer'; ?>
                        </small>
                        <?php else: ?>
                        <a href="markets.php" class="btn btn-primary btn-lg">
                            <?php echo getCurrentLang() == 'tr' ? 'Yatırıma Başla' : 'Start Trading'; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-visual">
                    <div class="trading-cards">
                        <?php if (!empty($top_markets)): ?>
                        <?php $count = 0; foreach ($top_markets as $market): if($count >= 5) break; ?>
                        <div class="trading-card" style="animation-delay: <?php echo $count * 0.2; ?>s">
                            <div class="card-icon">
                                <?php if ($market['logo_url']): ?>
                                <img src="<?php echo $market['logo_url']; ?>" alt="<?php echo $market['name']; ?>">
                                <?php else: ?>
                                <i class="fas fa-coins"></i>
                                <?php endif; ?>
                            </div>
                            <div class="card-info">
                                <div class="symbol"><?php echo str_replace('_TL', '', $market['symbol']); ?></div>
                                <div class="name"><?php echo $market['name']; ?></div>
                            </div>
                        </div>
                        <?php $count++; endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Access Section -->
<section class="quick-access py-4 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-3">
                <h6 class="text-muted mb-0">
                    <?php echo getCurrentLang() == 'tr' ? 
                        '50+ küresel kripto varlığa kolay erişim' : 
                        'Easy access to 50+ global crypto assets'; ?>
                </h6>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php if (!empty($top_markets)): ?>
            <?php $count = 0; foreach ($top_markets as $market): if($count >= 5) break; ?>
            <div class="col-lg-2 col-md-4 col-6 mb-3">
                <div class="quick-asset">
                    <div class="asset-icon">
                        <?php if ($market['logo_url']): ?>
                        <img src="<?php echo $market['logo_url']; ?>" alt="<?php echo $market['name']; ?>">
                        <?php else: ?>
                        <i class="fas fa-coins"></i>
                        <?php endif; ?>
                    </div>
                    <div class="asset-symbol"><?php echo str_replace('_TL', '', $market['symbol']); ?></div>
                    <div class="asset-name"><?php echo $market['name']; ?></div>
                </div>
            </div>
            <?php $count++; endforeach; ?>
            <?php endif; ?>
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
/* XM Style Professional Design */
:root {
    --primary-color: #1a73e8;
    --secondary-color: #34a853;
    --accent-color: #ff6b35;
    --dark-blue: #0d47a1;
    --light-blue: #e3f2fd;
    --text-primary: #1a1a1a;
    --text-secondary: #5f6368;
    --text-light: #9aa0a6;
    --bg-primary: #ffffff;
    --bg-secondary: #f8f9fa;
    --bg-accent: #fafbfc;
    --border-light: #e8eaed;
    --shadow-light: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    --shadow-medium: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    --shadow-heavy: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
    --border-radius: 8px;
    --success-color: #34a853;
    --danger-color: #ea4335;
    --warning-color: #fbbc04;
}

body {
    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    overflow-x: hidden;
    font-weight: 400;
    line-height: 1.6;
}

/* Hero Section - XM Style */
.hero-section {
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--light-blue) 100%);
    position: relative;
    padding: 120px 0 80px;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%231a73e8;stop-opacity:0.1" /><stop offset="100%" style="stop-color:%2334a853;stop-opacity:0.05" /></linearGradient></defs><path d="M0,300 Q250,200 500,300 T1000,300 L1000,0 L0,0 Z" fill="url(%23grad1)"/></svg>');
    background-size: cover;
}

.hero-shapes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 30%, rgba(26, 115, 232, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(52, 168, 83, 0.06) 0%, transparent 50%);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.trust-badge {
    display: inline-block;
    background: var(--bg-primary);
    border: 1px solid var(--border-light);
    border-radius: 25px;
    padding: 8px 20px;
    box-shadow: var(--shadow-light);
}

.badge-text {
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    color: var(--text-primary);
}

.hero-title .text-accent {
    color: var(--primary-color);
    font-weight: 700;
}

.hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2.5rem;
    color: var(--text-secondary);
    line-height: 1.6;
    max-width: 600px;
}

.hero-buttons .btn {
    padding: 16px 32px;
    font-weight: 600;
    font-size: 1rem;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    border: none;
    text-transform: none;
}

.hero-buttons .btn-primary {
    background: var(--primary-color);
    color: white;
    box-shadow: var(--shadow-medium);
}

.hero-buttons .btn-primary:hover {
    background: var(--dark-blue);
    transform: translateY(-2px);
    box-shadow: var(--shadow-heavy);
}

.bonus-note {
    display: block;
    margin-top: 8px;
    color: var(--text-light);
    font-size: 0.85rem;
}

/* Hero Visual - XM Style */
.hero-visual {
    position: relative;
    height: 400px;
}

.trading-cards {
    position: relative;
    height: 100%;
}

.trading-card {
    position: absolute;
    background: var(--bg-primary);
    border: 1px solid var(--border-light);
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow-medium);
    display: flex;
    align-items: center;
    min-width: 180px;
    animation: cardFloat 6s ease-in-out infinite;
}

.trading-card:nth-child(1) { top: 20px; right: 50px; }
.trading-card:nth-child(2) { top: 120px; right: 20px; }
.trading-card:nth-child(3) { top: 220px; right: 80px; }
.trading-card:nth-child(4) { top: 80px; right: 150px; }
.trading-card:nth-child(5) { top: 180px; right: 120px; }

.card-icon {
    width: 40px;
    height: 40px;
    margin-right: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card-icon img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
}

.card-icon i {
    font-size: 1.5rem;
    color: var(--primary-color);
}

.card-info .symbol {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-primary);
}

.card-info .name {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

@keyframes cardFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Quick Access Section */
.quick-access {
    background: var(--bg-secondary) !important;
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
}

.quick-asset {
    text-align: center;
    padding: 20px 10px;
    background: var(--bg-primary);
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-asset:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-light);
}

.asset-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.asset-icon img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.asset-icon i {
    font-size: 1.8rem;
    color: var(--primary-color);
}

.asset-symbol {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.asset-name {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.min-vh-80 {
    min-height: 80vh;
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
