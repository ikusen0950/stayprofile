<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password - Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Reset your password for Islanders App - Streamlining Island Life with Seamless Digital Solutions" />
    <meta name="keywords" content="islanders, password reset, forgot password, island, digital solutions" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="theme-color" content="#1f2129">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Forgot Password - Islanders App" />
    <meta property="og:description" content="Reset your password and regain access to your account" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:site_name" content="Islanders" />
    <link rel="canonical" href="<?= current_url() ?>" />
    <link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
    
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700&display=swap" />

    <link rel="preload" href="/assets/css/style.bundle.css" as="style">
    <link rel="preload" href="/assets/plugins/global/plugins.bundle.css" as="style">
    <link rel="preload" href="/assets/media/hotel/hotel_image_1.jpg" as="image">

    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/custom-theme.css" rel="stylesheet" type="text/css" />

    <script>
    if (window.top != window.self) {
        window.top.location.replace(window.self.location.href);
    }
    </script>
    <style>
    body { 
        font-family: Inter, sans-serif; 
        margin: 0; 
        background: #fff;
    }
    .d-flex { display: flex !important; }
    .flex-column { flex-direction: column !important; }
    .flex-lg-row { flex-direction: row !important; }
    .flex-center { justify-content: center !important; align-items: center !important; }
    .text-center { text-align: center !important; }
    .w-100 { width: 100% !important; }
    .h-100 { height: 100% !important; }
    .position-relative { position: relative !important; }
    .position-absolute { position: absolute !important; }
    
    .carousel-container {
        position: relative;
        overflow: hidden;
        min-height: 100vh;
    }

    .carousel-item img {
        width: 100%;
        object-fit: cover;
        height: 100vh;
        transition: opacity 0.6s ease-in-out;
    }

    .carousel-control-prev,
    .carousel-control-next {
        z-index: 15 !important;
        width: 15% !important;
        opacity: 0.8 !important;
        border-radius: 0.5rem;
        margin: 0 10px;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1 !important;
    }

    .carousel-indicators {
        z-index: 15 !important;
        bottom: 20px !important;
    }

    .carousel-indicators button {
        z-index: 15 !important;
        width: 12px !important;
        height: 12px !important;
        border-radius: 50% !important;
        margin: 0 5px !important;
        border: 2px solid white !important;
    }

    .carousel-indicators button.active {
        background-color: white !important;
        transform: scale(1.2);
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: white;
        text-align: center;
        z-index: 10;
        pointer-events: none;
    }

    .overlay a,
    .overlay button {
        pointer-events: auto;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.775rem 1rem;
        font-size: 1.1rem;
        font-weight: 500;
        line-height: 1.5;
        color: #181C32;
        background: #F5F8FA;
        border: 1px solid #E1E3EA;
        border-radius: 0.475rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .btn {
        display: inline-block;
        font-weight: 600;
        line-height: 1.5;
        text-align: center;
        text-decoration: none;
        vertical-align: middle;
        cursor: pointer;
        border: 1px solid transparent;
        padding: 0.775rem 1.5rem;
        font-size: 1.1rem;
        border-radius: 0.475rem;
        transition: all 0.15s ease-in-out;
    }

    .btn-dark {
        color: #FFFFFF;
        background-color: #181C32;
        border-color: #181C32;
    }

    .btn-light {
        color: #181C32;
        background-color: #F5F8FA;
        border-color: #E1E3EA;
    }

    @media (max-width: 768px) {
        .flex-lg-row {
            flex-direction: column !important;
        }
        
        .carousel-container {
            min-height: 40vh !important;
            height: 40vh !important;
        }
        
        .carousel-item img {
            height: 40vh !important;
            object-fit: cover;
        }
        
        .w-lg-600px {
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .flex-lg-row-fluid {
            padding: 1rem !important;
            min-height: 60vh;
        }
        
        .w-lg-500px {
            padding: 1rem !important;
            width: 100% !important;
            max-width: 100% !important;
        }
        
        .form-control {
            font-size: 16px !important;
            padding: 1rem;
            min-height: 50px;
        }
        
        .btn-lg {
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            min-height: 50px;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 20% !important;
        }
        
        .carousel-indicators {
            bottom: 10px !important;
        }
        
        .overlay h4 {
            font-size: 1rem !important;
            margin: 0.5rem !important;
        }
        
        .overlay .h-40px {
            height: 50px !important;
            width: auto !important;
            max-width: 200px !important;
        }
        
        .social-icons {
            margin-top: 1rem !important;
            gap: 0.5rem;
        }
        
        .social-icons a {
            padding: 0.25rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        
        .social-icons a:hover {
            background: rgba(255,255,255,0.1);
            transform: scale(1.1);
        }
        
        .d-flex.flex-column.flex-lg-row.flex-column-fluid {
            height: 100vh;
            overflow-y: auto;
        }
        
        .keyboard-show {
            position: fixed !important;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .keyboard-show .carousel-container {
            height: 30vh !important;
            min-height: 30vh !important;
        }
        
        .keyboard-show .carousel-item img {
            height: 30vh !important;
        }
        
        .keyboard-show .flex-lg-row-fluid {
            height: 70vh !important;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .input-focused {
            transform: scale(1.02);
            transition: transform 0.2s ease;
            border-color: #1f2129 !important;
            box-shadow: 0 0 0 0.2rem rgba(32, 212, 137, 0.25) !important;
        }
        
        .carousel-container,
        .flex-lg-row-fluid {
            transition: height 0.3s ease;
        }
        
        .py-10 {
            padding-top: max(1rem, env(safe-area-inset-top)) !important;
            padding-bottom: max(1rem, env(safe-area-inset-bottom)) !important;
        }
        
        .p-5 {
            padding: 1rem !important;
        }
    }

    @media (max-width: 480px) {
        .carousel-indicators {
            display: none !important;
        }
        
        .social-icons {
            justify-content: center !important;
            gap: 1rem;
        }
        
        .social-icons a {
            margin: 0 !important;
        }
        
        .social-icons i {
            font-size: 1.5rem !important;
        }
        
        .overlay .h-40px {
            height: 60px !important;
            max-width: 250px !important;
        }
    }

    .carousel-item {
        will-change: transform;
    }
    
    img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: optimize-contrast;
    }
    </style>
</head>

<body id="kt_body" class="app-blank">
    <script>
    var defaultThemeMode = "light";
    var themeMode;

    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
    </script>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-lg-row-auto w-lg-600px pt-lg-0">
                <div class="carousel-container">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/assets/media/hotel/hotel_image_1.jpg" class="d-block" alt="Slide 1" loading="eager">
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/media/hotel/hotel_image_2.jpg" class="d-block" alt="Slide 2" loading="lazy">
                            </div>
                            <div class="carousel-item">
                                <img src="/assets/media/hotel/hotel_image_3.jpg" class="d-block" alt="Slide 3" loading="lazy">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <div class="overlay">
                        <div class="d-flex flex-row-fluid flex-center flex-column-auto flex-column text-center">
                            <a href="/" class="mb-2">
                                <img alt="Logo" src="/assets/media/logos/default.svg" class="h-40px h-lg-50px" />
                            </a>
                            <br />
                            <h4 class="fw-light fs-2 text-white lh-lg m-2">
                                Streamlining Island Life with Seamless Digital Solutions
                            </h4>

                            <div class="d-flex justify-content-between align-items-center mt-2 social-icons">
                                <a href="/" class="me-2"><i class="ki-duotone ki-facebook text-white fs-2x"><span
                                            class="path1"></span> <span class="path2"></span></i></a>
                                <a href="/" class="me-2"><i class="ki-duotone ki-instagram text-white fs-2x"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                                <a href="/" class="me-2"><i class="ki-duotone ki-twitter text-white fs-2x"><span
                                            class="path1"></span><span class="path2"></span></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-lg-row-fluid py-10">
                <div class="d-flex flex-center flex-column flex-column-fluid">
                    <div class="w-lg-500px p-10 p-lg-15 mx-auto">
                        <form class="form w-100" novalidate="novalidate" action="<?= url_to('forgot') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="text-center mb-10">
                                <h1 class="text-gray-900 mb-3"><?= lang('Auth.forgotPassword') ?></h1>
                                <div class="text-gray-500 fw-semibold fs-4">
                                    Enter your email to reset your password
                                </div>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="form-label fs-6 fw-bold text-gray-900"><?= lang('Auth.emailAddress') ?></label>
                                <input class="form-control form-control-lg form-control-solid <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                    type="email" name="email" placeholder="<?= lang('Auth.emailAddress') ?>" value="<?= old('email') ?>" />
                                <div class="invalid-feedback"><?= session('errors.email') ?></div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="submit" class="btn btn-lg btn-dark me-4">
                                    <span class="indicator-label"><?= lang('Auth.sendInstructions') ?></span>
                                    <span class="indicator-progress d-none">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <a href="<?= url_to('login') ?>" class="btn btn-lg btn-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
                    <div class="d-flex align-items-center text-gray-900 order-2 order-md-1 ms-2">
                        <span class="text-muted fw-semibold me-1"><?= date('Y') ?>&copy;</span>
                        <span class="me-1">Crafted with ❤️ by</span>
                        <i class="ki-duotone ki-square-brackets fs-3 text-danger me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <a href="/" target="_blank" class="text-danger text-hover-danger">Short Script</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    var hostUrl = "/assets/";
    
    window.KTComponentsOriginal = null;
    
    const originalAddEventListener = window.addEventListener;
    window.addEventListener = function(type, listener, options) {
        if (type === 'load' && listener.toString().includes('KTApp.hidePageLoading')) {
            const safeListener = function() {
                if (typeof KTApp !== 'undefined' && KTApp.hidePageLoading) {
                    try {
                        KTApp.hidePageLoading();
                    } catch(e) {
                        console.log('KTApp.hidePageLoading skipped:', e.message);
                    }
                }
            };
            return originalAddEventListener.call(this, type, safeListener, options);
        }
        return originalAddEventListener.call(this, type, listener, options);
    };
    </script>

    <script src="/assets/plugins/global/plugins.bundle.js" defer></script>
    <script src="/assets/js/auth.js" defer></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const forgotForm = document.querySelector('form[action*="forgot"]');
        const body = document.body;
        
        if (forgotForm) {
            forgotForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const indicatorLabel = submitBtn.querySelector('.indicator-label');
                    const indicatorProgress = submitBtn.querySelector('.indicator-progress');
                    
                    if (indicatorLabel && indicatorProgress) {
                        indicatorLabel.classList.add('d-none');
                        indicatorProgress.classList.remove('d-none');
                    }
                    submitBtn.disabled = true;
                    
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        if (indicatorLabel && indicatorProgress) {
                            indicatorLabel.classList.remove('d-none');
                            indicatorProgress.classList.add('d-none');
                        }
                    }, 10000);
                }
            });
        }
        
        if (window.innerWidth <= 768) {
            let initialViewportHeight = window.innerHeight;
            let isKeyboardOpen = false;
            
            const inputs = document.querySelectorAll('input[type="email"]');
            
            function handleViewportChange() {
                const currentHeight = window.innerHeight;
                const heightDifference = initialViewportHeight - currentHeight;
                
                if (heightDifference > 150) {
                    if (!isKeyboardOpen) {
                        isKeyboardOpen = true;
                        body.classList.add('keyboard-show');
                        
                        const activeInput = document.activeElement;
                        if (activeInput && activeInput.tagName === 'INPUT') {
                            setTimeout(() => {
                                activeInput.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }, 300);
                        }
                    }
                } else {
                    if (isKeyboardOpen) {
                        isKeyboardOpen = false;
                        body.classList.remove('keyboard-show');
                    }
                }
            }
            
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.classList.add('input-focused');
                    
                    setTimeout(() => {
                        handleViewportChange();
                        
                        if (isKeyboardOpen) {
                            const rect = this.getBoundingClientRect();
                            const viewportHeight = window.innerHeight;
                            
                            if (rect.bottom > viewportHeight * 0.7) {
                                this.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        }
                    }, 300);
                });
                
                input.addEventListener('blur', function() {
                    this.classList.remove('input-focused');
                    
                    setTimeout(() => {
                        handleViewportChange();
                    }, 100);
                });
            });
            
            window.addEventListener('resize', handleViewportChange);
            
            window.addEventListener('orientationchange', function() {
                setTimeout(() => {
                    initialViewportHeight = window.innerHeight;
                    handleViewportChange();
                }, 500);
            });
            
            if (window.visualViewport) {
                window.visualViewport.addEventListener('resize', handleViewportChange);
            }
        }
    });
    </script>
</body>
</html>
