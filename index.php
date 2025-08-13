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


<?php include 'includes/footer.php'; ?>
