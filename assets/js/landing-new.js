// GlobalBorsa Landing Page JavaScript - Based on landing-ornek.html

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initHeroSlider();
    initScrollAnimations();
    initContactForm();
    initLiveSupport();
    initSmoothScrolling();
    initResponsiveFeatures();
});

// Hero Slider functionality
function initHeroSlider() {
    const slides = document.querySelectorAll('.slide');
    const progressBar = document.getElementById('sliderProgress');
    let currentSlide = 0;
    const slideInterval = 5000; // 5 seconds per slide
    
    if (slides.length === 0) return;
    
    // Auto-advance slides
    setInterval(() => {
        // Remove active class from current slide
        slides[currentSlide].classList.remove('active');
        
        // Move to next slide
        currentSlide = (currentSlide + 1) % slides.length;
        
        // Add active class to new slide
        slides[currentSlide].classList.add('active');
        
        // Reset progress bar animation
        if (progressBar) {
            progressBar.style.animation = 'none';
            progressBar.offsetHeight; // Trigger reflow
            progressBar.style.animation = 'progress 5s linear infinite';
        }
    }, slideInterval);
    
    // Initialize progress bar
    if (progressBar) {
        progressBar.style.animation = 'progress 5s linear infinite';
    }
}

// Scroll-triggered animations
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Parallax effect for hero section
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroSlider = document.querySelector('.hero-slider');
        
        if (heroSlider) {
            const parallax = scrolled * 0.5;
            heroSlider.style.transform = `translateY(${parallax}px)`;
        }
    });
}

// Contact form handling
function initContactForm() {
    const form = document.getElementById('callbackForm');
    
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Validate form
        if (!validateForm(data)) {
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('.submit-btn');
        const originalText = submitBtn.textContent;
        submitBtn.textContent = getCurrentLang() === 'tr' ? 'Gönderiliyor...' : 'Sending...';
        submitBtn.disabled = true;
        
        // Simulate form submission (replace with actual API call)
        setTimeout(() => {
            showNotification(
                getCurrentLang() === 'tr' ? 'Başarılı!' : 'Success!',
                getCurrentLang() === 'tr' ? 
                    'Talebiniz alındı. En kısa sürede size dönüş yapacağız.' : 
                    'Your request has been received. We will get back to you soon.',
                'success'
            );
            
            form.reset();
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
}

// Form validation
function validateForm(data) {
    const errors = [];
    
    if (!data.name || data.name.trim().length < 2) {
        errors.push(getCurrentLang() === 'tr' ? 'Geçerli bir isim giriniz' : 'Please enter a valid name');
    }
    
    if (!data.phone || data.phone.trim().length < 10) {
        errors.push(getCurrentLang() === 'tr' ? 'Geçerli bir telefon numarası giriniz' : 'Please enter a valid phone number');
    }
    
    if (!data.email || !isValidEmail(data.email)) {
        errors.push(getCurrentLang() === 'tr' ? 'Geçerli bir e-posta adresi giriniz' : 'Please enter a valid email address');
    }
    
    if (!data.experience) {
        errors.push(getCurrentLang() === 'tr' ? 'Yatırım deneyiminizi seçiniz' : 'Please select your investment experience');
    }
    
    if (errors.length > 0) {
        showNotification(
            getCurrentLang() === 'tr' ? 'Hata!' : 'Error!',
            errors.join('\n'),
            'error'
        );
        return false;
    }
    
    return true;
}

// Email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Live support functionality
function initLiveSupport() {
    const supportBtn = document.querySelector('.support-btn');
    
    if (!supportBtn) return;
    
    supportBtn.addEventListener('click', function() {
        // Show support options or open chat
        showNotification(
            getCurrentLang() === 'tr' ? 'Canlı Destek' : 'Live Support',
            getCurrentLang() === 'tr' ? 
                'Destek ekibimiz size yardımcı olmak için hazır!' : 
                'Our support team is ready to help you!',
            'info'
        );
        
        // In a real implementation, this would open a chat widget
        // or redirect to a support page
    });
}

// Smooth scrolling for navigation links
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = document.querySelector('.navbar')?.offsetHeight || 80;
                const targetPosition = target.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Responsive features
function initResponsiveFeatures() {
    // Mobile menu toggle (if needed)
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
    
    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (hamburger && navMenu) {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        // Reset mobile menu on desktop
        if (window.innerWidth > 768) {
            if (hamburger && navMenu) {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            }
        }
    });
}

// Notification system
function showNotification(title, message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-title">${title}</div>
            <div class="notification-message">${message}</div>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add notification styles
    const notificationStyles = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            z-index: 10000;
            min-width: 300px;
            max-width: 400px;
            animation: slideInRight 0.3s ease-out;
        }
        
        .notification-success {
            border-left: 4px solid #48bb78;
        }
        
        .notification-error {
            border-left: 4px solid #f56565;
        }
        
        .notification-info {
            border-left: 4px solid #667eea;
        }
        
        .notification-content {
            padding: 1rem;
            position: relative;
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .notification-message {
            color: #666;
            line-height: 1.4;
            white-space: pre-line;
        }
        
        .notification-close {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #999;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .notification-close:hover {
            color: #333;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    
    // Add styles if not already added
    if (!document.querySelector('#notification-styles')) {
        const styleElement = document.createElement('style');
        styleElement.id = 'notification-styles';
        styleElement.textContent = notificationStyles;
        document.head.appendChild(styleElement);
    }
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Handle close button
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', function() {
        notification.style.animation = 'slideInRight 0.3s ease-out reverse';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideInRight 0.3s ease-out reverse';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Utility function to get current language
function getCurrentLang() {
    return document.documentElement.lang || 'tr';
}

// Enhanced hover effects for cards
document.addEventListener('DOMContentLoaded', function() {
    // Add enhanced hover effects to promo cards
    const promoCards = document.querySelectorAll('.promo-card');
    promoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add hover effects to service cards
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.service-icon');
            if (icon) {
                icon.style.transform = 'scale(1.1) rotate(5deg)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.service-icon');
            if (icon) {
                icon.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    });
});

// Coin ticker pause on hover
document.addEventListener('DOMContentLoaded', function() {
    const tickerTrack = document.querySelector('.ticker-track');
    
    if (tickerTrack) {
        tickerTrack.addEventListener('mouseenter', function() {
            this.style.animationPlayState = 'paused';
        });
        
        tickerTrack.addEventListener('mouseleave', function() {
            this.style.animationPlayState = 'running';
        });
    }
});

// Loading screen
function showLoadingScreen() {
    const loadingHTML = `
        <div id="loading-screen" style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            transition: opacity 0.5s ease;
        ">
            <div style="text-align: center; color: white;">
                <div style="
                    width: 50px;
                    height: 50px;
                    border: 3px solid rgba(255, 255, 255, 0.3);
                    border-top: 3px solid #ffd700;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 1rem;
                "></div>
                <div style="font-size: 1.2rem; font-weight: 600;">
                    <i class="fas fa-chart-line" style="margin-right: 0.5rem;"></i>
                    GlobalBorsa
                </div>
            </div>
        </div>
        <style>
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    `;
    
    document.body.insertAdjacentHTML('beforeend', loadingHTML);
    
    // Remove loading screen after page load
    window.addEventListener('load', function() {
        setTimeout(() => {
            const loadingScreen = document.getElementById('loading-screen');
            if (loadingScreen) {
                loadingScreen.style.opacity = '0';
                setTimeout(() => loadingScreen.remove(), 500);
            }
        }, 1000);
    });
}

// Initialize loading screen
showLoadingScreen();

// Performance monitoring
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 GlobalBorsa Landing Page loaded successfully');
    console.log('📊 Performance metrics:');
    console.log('- Hero Slider:', document.querySelectorAll('.slide').length, 'slides');
    console.log('- Promo Cards:', document.querySelectorAll('.promo-card').length, 'cards');
    console.log('- Service Cards:', document.querySelectorAll('.service-card').length, 'services');
    console.log('- Screen size:', window.innerWidth + 'x' + window.innerHeight);
});

// Error handling
window.addEventListener('error', function(e) {
    console.warn('Landing page error:', e.error);
    // Gracefully handle errors without breaking the user experience
});

// Export functions for external use
window.GlobalBorsaLanding = {
    showNotification,
    getCurrentLang,
    initHeroSlider,
    initScrollAnimations
};
