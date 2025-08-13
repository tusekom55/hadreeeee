<?php
require_once 'includes/functions.php';

$page_title = 'GlobalBorsa - Türkiye\'nin En Güvenilir Kripto Borsası';

// Get some sample market data for display
$markets = getMarketData('crypto_tl', 6);
?>

<!DOCTYPE html>
<html lang="<?php echo getCurrentLang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="Türkiye'nin en güvenilir kripto borsası. 7/24 Türkçe destek, güvenli altyapı, düşük komisyonlar.">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link href="assets/css/landing-new.css" rel="stylesheet">
    
    <style>
        /* Critical CSS - Embedded to ensure loading */
        body {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Hero Slider */
        .hero-slider {
            position: relative;
            height: 100vh;
            overflow: hidden;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            margin-top: -76px; /* Offset header */
            padding-top: 76px;
        }
        
        .slider-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .slide.active {
            opacity: 1;
        }
        
        .slide-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            z-index: 1;
        }
        
        .slide-bg-2 {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .slide-bg-3 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .slide-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 2;
        }
        
        .slide-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
            padding: 2rem 0;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 2rem;
        }
        
        .hero-title .highlight {
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .hero-description {
            font-size: 1.3rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }
        
        .btn-cta {
            display: inline-block;
            background: linear-gradient(135deg, #ffd700 0%, #ffed4a 100%);
            color: #333;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
        }
        
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.4);
            color: #333;
            text-decoration: none;
        }
        
        .hero-disclaimer {
            margin-top: 1rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        /* Slider Progress Bar */
        .slider-progress {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            overflow: hidden;
            z-index: 20;
        }
        
        .slider-progress::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: #ffd700;
            border-radius: 2px;
            animation: progress 5s linear infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        
        /* Coin Ticker */
        .coin-ticker {
            background: #f8f9fa;
            padding: 3rem 0;
            overflow: hidden;
        }
        
        .ticker-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .ticker-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .ticker-container {
            overflow: hidden;
            position: relative;
        }
        
        .ticker-track {
            display: flex;
            animation: ticker 30s linear infinite;
            gap: 2rem;
        }
        
        .coin-item {
            flex-shrink: 0;
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            min-width: 200px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .coin-item:hover {
            transform: translateY(-5px);
        }
        
        .coin-flag {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .coin-symbol {
            font-weight: 700;
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .coin-name {
            font-size: 0.9rem;
            color: #666;
        }
        
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Service Cards */
        .services {
            padding: 6rem 0;
            background: white;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .service-card {
            text-align: center;
            padding: 2rem;
            border-radius: 20px;
            background: #f8f9fa;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .service-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Market Indicators */
        .market-indicators {
            background: #1a202c;
            color: white;
            padding: 6rem 0;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
        }
        
        .indicators-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .indicator-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }
        
        .indicator-item:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .pair {
            display: block;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .price {
            display: block;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #ffd700;
        }
        
        .change {
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        
        .change.positive {
            background: rgba(72, 187, 120, 0.2);
            color: #48bb78;
        }
        
        .change.negative {
            background: rgba(245, 101, 101, 0.2);
            color: #f56565;
        }
        
        /* Promo Cards */
        .promo-cards {
            background: #f8f9fa;
            padding: 6rem 0;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto 4rem;
        }
        
        .highlight {
            color: #667eea;
        }
        
        .promo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .promo-card {
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 2rem;
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-height: 200px;
        }
        
        .promo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .dark-card {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            color: white;
        }
        
        .blue-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .green-card {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }
        
        .light-card {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            color: #333;
            border: 1px solid #e2e8f0;
        }
        
        .promo-content {
            flex: 1;
        }
        
        .promo-header {
            margin-bottom: 1rem;
        }
        
        .promo-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .app-ratings {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        
        .rating i {
            font-size: 1.2rem;
        }
        
        .rating span {
            color: #ffd700;
        }
        
        .promo-card p {
            margin-bottom: 1.5rem;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .bonus-amount {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 10px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .promo-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: inherit;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .promo-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: inherit;
            text-decoration: none;
            transform: translateX(5px);
        }
        
        .light-card .promo-btn {
            background: #667eea;
            color: white;
        }
        
        .light-card .promo-btn:hover {
            background: #5a67d8;
            color: white;
        }
        
        .promo-visual {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .phone-mockup {
            width: 80px;
            height: 120px;
            background: #333;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .phone-screen {
            width: 60px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
        }
        
        .app-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .bonus-visual, .trophy-visual, .copy-visual {
            text-align: center;
        }
        
        .gift-box, .trophy, .user-avatar {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        
        .bonus-text, .prize-text {
            font-weight: 700;
            font-size: 1.2rem;
        }
        
        .copy-arrows {
            font-size: 2rem;
            margin-top: 0.5rem;
        }
        
        /* Education Section */
        .education {
            background: white;
            padding: 6rem 0;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-description {
            font-size: 1.2rem;
            color: #666;
            margin-top: 1rem;
        }
        
        .education-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .education-card {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .education-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .card-image {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }
        
        .education-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .education-card p {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .card-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .card-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        /* Contact CTA */
        .contact-cta {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 6rem 0;
        }
        
        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .contact-info h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .contact-info p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .contact-features {
            margin-bottom: 2rem;
        }
        
        .feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .feature i {
            color: #ffd700;
            font-size: 1.2rem;
        }
        
        .contact-form {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            backdrop-filter: blur(10px);
        }
        
        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ffd700;
            box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.3);
        }
        
        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #ffd700 0%, #ffed4a 100%);
            color: #333;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.3);
        }
        
        /* Live Support */
        .live-support {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        .support-btn {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        .support-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(72, 187, 120, 0.4);
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-description {
                font-size: 1.1rem;
            }
            
            .btn-cta {
                padding: 0.875rem 2rem;
                font-size: 1rem;
            }
            
            .ticker-header h2 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .promo-card {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .contact-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Skip the header include for cleaner implementation -->
    <!-- Hero Slider starts immediately -->

    <!-- Hero Slider -->
    <section class="hero-slider" id="hero">
        <div class="slider-container">
            <!-- Slide 1 -->
            <div class="slide active">
                <div class="slide-background"></div>
                <div class="slide-content">
                    <div class="container">
                        <p class="hero-subtitle"><?php echo getCurrentLang() == 'tr' ? 'Binlerce yatırımcı bize güveniyor' : 'Thousands of investors trust us'; ?></p>
                        <h1 class="hero-title">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Türkiye\'nin en güvenilir <span class="highlight">kripto borsası</span> olmamız tesadüf değil' : 
                                'Being Turkey\'s most trusted <span class="highlight">crypto exchange</span> is no coincidence'; ?>
                        </h1>
                        <p class="hero-description">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Yatırımcılara rahatça kâr edebilecekleri seçkin bir yatırım ortamı sağlıyoruz.' : 
                                'We provide an exclusive investment environment where investors can easily profit.'; ?>
                        </p>
                        <a href="register.php" class="btn-cta">
                            <?php echo getCurrentLang() == 'tr' ? '1.000 TL\'ye varan %100 bonus alın' : 'Get up to 1,000 TL 100% bonus'; ?>
                        </a>
                        <p class="hero-disclaimer">
                            *<?php echo getCurrentLang() == 'tr' ? 'Sınırlı süreli teklif' : 'Limited time offer'; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <div class="slide-background slide-bg-2"></div>
                <div class="slide-content">
                    <div class="container">
                        <p class="hero-subtitle"><?php echo getCurrentLang() == 'tr' ? 'Kripto pazarında lider pozisyon' : 'Leading position in crypto market'; ?></p>
                        <h1 class="hero-title">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Bitcoin ve Altcoin Ticaretinde <span class="highlight">Lider Platform</span>' : 
                                'Leading Platform in <span class="highlight">Bitcoin & Altcoin Trading</span>'; ?>
                        </h1>
                        <p class="hero-description">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Türkiye\'de 100.000\'den fazla yatırımcının tercih ettiği güvenilir platform. Düşük komisyonlar ve hızlı işlem garantisi.' : 
                                'Trusted platform preferred by over 100,000 investors in Turkey. Low commissions and fast transaction guarantee.'; ?>
                        </p>
                        <a href="register.php" class="btn-cta">
                            <?php echo getCurrentLang() == 'tr' ? 'Canlı Hesap Aç' : 'Open Live Account'; ?>
                        </a>
                        <p class="hero-disclaimer">
                            *<?php echo getCurrentLang() == 'tr' ? 'Risk uyarısı geçerlidir' : 'Risk warning applies'; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <div class="slide-background slide-bg-3"></div>
                <div class="slide-content">
                    <div class="container">
                        <p class="hero-subtitle"><?php echo getCurrentLang() == 'tr' ? 'Profesyonel analist desteği' : 'Professional analyst support'; ?></p>
                        <h1 class="hero-title">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Uzman Analist Desteği ile <span class="highlight">Kazanmaya Başlayın</span>' : 
                                'Start Winning with <span class="highlight">Expert Analyst Support</span>'; ?>
                        </h1>
                        <p class="hero-description">
                            <?php echo getCurrentLang() == 'tr' ? 
                                'Günlük kripto analizleri, webinarlar ve eğitim materyalleri ile yatırım bilginizi artırın. Başarılı trader\'ların sırlarını öğrenin.' : 
                                'Increase your investment knowledge with daily crypto analysis, webinars and training materials. Learn the secrets of successful traders.'; ?>
                        </p>
                        <a href="#" class="btn-cta">
                            <?php echo getCurrentLang() == 'tr' ? 'Ücretsiz Eğitime Başla' : 'Start Free Training'; ?>
                        </a>
                        <p class="hero-disclaimer">
                            *<?php echo getCurrentLang() == 'tr' ? 'Eğitim materyalleri ücretsizdir' : 'Training materials are free'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Auto-play Progress Bar -->
        <div class="slider-progress" id="sliderProgress"></div>
    </section>

    <!-- Coin List Ticker -->
    <section class="coin-ticker" id="coin-ticker">
        <div class="ticker-header">
            <h2><?php echo getCurrentLang() == 'tr' ? '100\'den fazla kripto paraya kolay erişim' : 'Easy access to over 100 cryptocurrencies'; ?></h2>
        </div>
        <div class="ticker-container">
            <div class="ticker-track">
                <!-- First set of coins -->
                <div class="coin-item">
                    <div class="coin-flag">₿</div>
                    <div class="coin-info">
                        <div class="coin-symbol">BTC/TL</div>
                        <div class="coin-name">Bitcoin</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">Ξ</div>
                    <div class="coin-info">
                        <div class="coin-symbol">ETH/TL</div>
                        <div class="coin-name">Ethereum</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🔶</div>
                    <div class="coin-info">
                        <div class="coin-symbol">BNB/TL</div>
                        <div class="coin-name">Binance Coin</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">⚡</div>
                    <div class="coin-info">
                        <div class="coin-symbol">SOL/TL</div>
                        <div class="coin-name">Solana</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🔵</div>
                    <div class="coin-info">
                        <div class="coin-symbol">ADA/TL</div>
                        <div class="coin-name">Cardano</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🟣</div>
                    <div class="coin-info">
                        <div class="coin-symbol">DOT/TL</div>
                        <div class="coin-name">Polkadot</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🔗</div>
                    <div class="coin-info">
                        <div class="coin-symbol">LINK/TL</div>
                        <div class="coin-name">Chainlink</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🌙</div>
                    <div class="coin-info">
                        <div class="coin-symbol">LUNA/TL</div>
                        <div class="coin-name">Terra Luna</div>
                    </div>
                </div>
                
                <!-- Duplicate set for seamless loop -->
                <div class="coin-item">
                    <div class="coin-flag">₿</div>
                    <div class="coin-info">
                        <div class="coin-symbol">BTC/TL</div>
                        <div class="coin-name">Bitcoin</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">Ξ</div>
                    <div class="coin-info">
                        <div class="coin-symbol">ETH/TL</div>
                        <div class="coin-name">Ethereum</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🔶</div>
                    <div class="coin-info">
                        <div class="coin-symbol">BNB/TL</div>
                        <div class="coin-name">Binance Coin</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">⚡</div>
                    <div class="coin-info">
                        <div class="coin-symbol">SOL/TL</div>
                        <div class="coin-name">Solana</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🔵</div>
                    <div class="coin-info">
                        <div class="coin-symbol">ADA/TL</div>
                        <div class="coin-name">Cardano</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🟣</div>
                    <div class="coin-info">
                        <div class="coin-symbol">DOT/TL</div>
                        <div class="coin-name">Polkadot</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🔗</div>
                    <div class="coin-info">
                        <div class="coin-symbol">LINK/TL</div>
                        <div class="coin-name">Chainlink</div>
                    </div>
                </div>
                
                <div class="coin-item">
                    <div class="coin-flag">🌙</div>
                    <div class="coin-info">
                        <div class="coin-symbol">LUNA/TL</div>
                        <div class="coin-name">Terra Luna</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Cards -->
    <section class="services" id="services">
        <div class="container">
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3><?php echo getCurrentLang() == 'tr' ? 'Güvenli ve Şifreli' : 'Secure and Encrypted'; ?></h3>
                    <p><?php echo getCurrentLang() == 'tr' ? 'SSL şifreleme ve çoklu güvenlik katmanları ile paranız her zaman güvende.' : 'Your money is always safe with SSL encryption and multiple security layers.'; ?></p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3><?php echo getCurrentLang() == 'tr' ? 'Gelişmiş Ticaret Araçları' : 'Advanced Trading Tools'; ?></h3>
                    <p><?php echo getCurrentLang() == 'tr' ? 'Profesyonel grafik araçları ve teknik analiz göstergeleri ile ticaret yapın.' : 'Trade with professional charting tools and technical analysis indicators.'; ?></p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3><?php echo getCurrentLang() == 'tr' ? '7/24 Türkçe Destek' : '24/7 Turkish Support'; ?></h3>
                    <p><?php echo getCurrentLang() == 'tr' ? 'Uzman ekibimiz 7 gün 24 saat Türkçe destek hizmeti sunmaktadır.' : 'Our expert team provides 24/7 Turkish support service.'; ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Market Indicators -->
    <section class="market-indicators" id="indicators">
        <div class="container">
            <h2 class="section-title"><?php echo getCurrentLang() == 'tr' ? 'Canlı Piyasa Göstergeleri' : 'Live Market Indicators'; ?></h2>
            <div class="indicators-grid">
                <?php foreach (array_slice($markets, 0, 6) as $market): ?>
                <div class="indicator-item">
                    <span class="pair"><?php echo $market['symbol']; ?></span>
                    <span class="price"><?php echo formatPrice($market['price']); ?> TL</span>
                    <span class="change <?php echo $market['change_24h'] >= 0 ? 'positive' : 'negative'; ?>">
                        <?php echo ($market['change_24h'] >= 0 ? '+' : '') . number_format($market['change_24h'], 2); ?>%
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Promo Cards Section -->
    <section class="promo-cards" id="promo-cards">
        <div class="container">
            <h2 class="section-title animate-on-scroll">
                <?php echo getCurrentLang() == 'tr' ? 'Yatırımcılarımızın' : 'Take a look at our investors\''; ?>
                <span class="highlight"><?php echo getCurrentLang() == 'tr' ? 'favorilerine' : 'favorites'; ?></span> 
                <?php echo getCurrentLang() == 'tr' ? 'göz atın' : ''; ?>
            </h2>
            <p class="section-subtitle animate-on-scroll">
                <?php echo getCurrentLang() == 'tr' ? 
                    'Yatırımda herkesin ilk tercihi olmamızı sağlayan bazı vazgeçilmez ürünlerimiz hakkında bilgi edinin.' : 
                    'Learn about some of our indispensable products that make us everyone\'s first choice in investment.'; ?>
            </p>
            
            <div class="promo-grid">
                <!-- App Card -->
                <div class="promo-card dark-card">
                    <div class="promo-content">
                        <div class="promo-header">
                            <h3><?php echo getCurrentLang() == 'tr' ? 'GlobalBorsa uygulaması' : 'GlobalBorsa app'; ?></h3>
                            <div class="app-ratings">
                                <div class="rating">
                                    <i class="fab fa-apple"></i>
                                    <span>★★★★★</span>
                                </div>
                                <div class="rating">
                                    <i class="fab fa-google-play"></i>
                                    <span>★★★★★</span>
                                </div>
                            </div>
                        </div>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Yüksek puanlı, ödüllü GlobalBorsa uygulamasıyla hizmetlerine eksiksiz erişin.' : 'Get complete access to services with the highly-rated, award-winning GlobalBorsa app.'; ?></p>
                        <a href="#" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Uygulamayı Edinin' : 'Get the App'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="phone-mockup">
                            <div class="phone-screen">
                                <div class="app-icon">📱</div>
                                <div class="app-name">GlobalBorsa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bonus Card -->
                <div class="promo-card blue-card">
                    <div class="promo-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? '%100 bonus' : '100% bonus'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Daha fazla yatırım, daha az risk ve daha çok getiri için fonlarınızı kullanın.' : 'Use your funds for more investment, less risk and more returns.'; ?></p>
                        <div class="bonus-amount">
                            <?php echo getCurrentLang() == 'tr' ? '1.000 TL\'ye varan %100 bonus alın' : 'Get up to 1,000 TL 100% bonus'; ?>
                        </div>
                        <a href="register.php" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Bonusunuzu alın' : 'Get your bonus'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="bonus-visual">
                            <div class="gift-box">🎁</div>
                            <div class="bonus-text">%100</div>
                        </div>
                    </div>
                </div>

                <!-- Competition Card -->
                <div class="promo-card green-card">
                    <div class="promo-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'GlobalBorsa yarışmaları' : 'GlobalBorsa competitions'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Yatırımlarınızla zirveye ilerleyin ve toplam 50.000 TL çekilebilir nakit ödülden payınızı alın.' : 'Advance to the top with your investments and get your share of 50,000 TL total withdrawable cash prizes.'; ?></p>
                        <a href="#" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Hemen katılın' : 'Join now'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="trophy-visual">
                            <div class="trophy">🏆</div>
                            <div class="prize-text">50.000 TL</div>
                        </div>
                    </div>
                </div>

                <!-- Copy Trade Card -->
                <div class="promo-card light-card">
                    <div class="promo-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'GlobalBorsa copy trade' : 'GlobalBorsa copy trade'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Kazançlı yatırım stratejilerini kopyalayan 1.000\'den fazla yatırımcıya katılın ya da işlemlerinizi paylaşıp komisyon kazanın.' : 'Join over 1,000 investors copying profitable investment strategies or share your trades and earn commissions.'; ?></p>
                        <a href="#" class="promo-btn">
                            <?php echo getCurrentLang() == 'tr' ? 'Copy trade\'e başlayın' : 'Start copy trading'; ?> 
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="promo-visual">
                        <div class="copy-visual">
                            <div class="user-avatar">👤</div>
                            <div class="copy-arrows">📈</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section class="education" id="egitim">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?php echo getCurrentLang() == 'tr' ? 'Eğitim ve Analiz Merkezi' : 'Education and Analysis Center'; ?></h2>
                <p class="section-description"><?php echo getCurrentLang() == 'tr' ? 'Başarılı yatırımcı olmak için gereken tüm bilgileri uzman ekibimizden öğrenin.' : 'Learn everything you need to become a successful investor from our expert team.'; ?></p>
            </div>

            <div class="education-grid">
                <div class="education-card">
                    <div class="card-image">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="card-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'Canlı Webinarlar' : 'Live Webinars'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Uzman analistlerden canlı kripto piyasa analizleri ve ticaret stratejileri öğrenin.' : 'Learn live crypto market analysis and trading strategies from expert analysts.'; ?></p>
                        <button class="card-btn"><?php echo getCurrentLang() == 'tr' ? 'Katıl' : 'Join'; ?></button>
                    </div>
                </div>

                <div class="education-card">
                    <div class="card-image">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="card-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'Kripto Sözlüğü' : 'Crypto Dictionary'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Kripto para ticaretinde kullanılan tüm terimleri detaylı açıklamalarıyla öğrenin.' : 'Learn all terms used in cryptocurrency trading with detailed explanations.'; ?></p>
                        <button class="card-btn"><?php echo getCurrentLang() == 'tr' ? 'Keşfet' : 'Explore'; ?></button>
                    </div>
                </div>

                <div class="education-card">
                    <div class="card-image">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="card-content">
                        <h3><?php echo getCurrentLang() == 'tr' ? 'Temel Teknik Analiz' : 'Basic Technical Analysis'; ?></h3>
                        <p><?php echo getCurrentLang() == 'tr' ? 'Grafik okuma, indikatörler ve ticaret sinyalleri hakkında temel bilgileri edinin.' : 'Get basic information about chart reading, indicators and trading signals.'; ?></p>
                        <button class="card-btn"><?php echo getCurrentLang() == 'tr' ? 'Başla' : 'Start'; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact/CTA Section -->
    <section class="contact-cta" id="iletisim">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2><?php echo getCurrentLang() == 'tr' ? 'Sizi Arayalım' : 'Let Us Call You'; ?></h2>
                    <p><?php echo getCurrentLang() == 'tr' ? 'Yatırım danışmanlarımız size en uygun hesap türünü ve yatırım stratejisini belirlemek için iletişime geçsin.' : 'Let our investment advisors contact you to determine the most suitable account type and investment strategy for you.'; ?></p>
                    <div class="contact-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo getCurrentLang() == 'tr' ? 'Ücretsiz danışmanlık' : 'Free consultation'; ?></span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo getCurrentLang() == 'tr' ? 'Kişiselleştirilmiş strateji' : 'Personalized strategy'; ?></span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo getCurrentLang() == 'tr' ? 'Risk yönetimi' : 'Risk management'; ?></span>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <form id="callbackForm">
                        <div class="form-group">
                            <input type="text" id="name" name="name" placeholder="<?php echo getCurrentLang() == 'tr' ? 'Adınız Soyadınız' : 'Your Name Surname'; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" id="phone" name="phone" placeholder="<?php echo getCurrentLang() == 'tr' ? 'Telefon Numaranız' : 'Your Phone Number'; ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="<?php echo getCurrentLang() == 'tr' ? 'E-posta Adresiniz' : 'Your Email Address'; ?>" required>
                        </div>
                        <div class="form-group">
                            <select id="experience" name="experience" required>
                                <option value=""><?php echo getCurrentLang() == 'tr' ? 'Yatırım Deneyiminiz' : 'Your Investment Experience'; ?></option>
                                <option value="beginner"><?php echo getCurrentLang() == 'tr' ? 'Yeni başlıyorum' : 'Just starting'; ?></option>
                                <option value="intermediate"><?php echo getCurrentLang() == 'tr' ? 'Orta seviye' : 'Intermediate'; ?></option>
                                <option value="advanced"><?php echo getCurrentLang() == 'tr' ? 'İleri seviye' : 'Advanced'; ?></option>
                            </select>
                        </div>
                        <button type="submit" class="submit-btn"><?php echo getCurrentLang() == 'tr' ? 'Beni Arayın' : 'Call Me'; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Include existing footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Live Support Button -->
    <div class="live-support" id="liveSupport">
        <button class="support-btn">
            <i class="fas fa-comments"></i>
            <span><?php echo getCurrentLang() == 'tr' ? 'Canlı Destek' : 'Live Support'; ?></span>
        </button>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="assets/js/landing-new.js"></script>
</body>
</html>
