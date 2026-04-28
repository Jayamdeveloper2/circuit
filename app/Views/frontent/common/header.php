<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Circuit Brilliance | Power Electronics PCB Design — EV &amp; Renewable Energy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Specialist power electronics PCB design services — EV, renewable energy, BMS, and power conversion. IPC CID+ certified with 18+ years of expertise. Global engineering consultancy.">
    <link rel="canonical" href="<?= current_url() ?>">

    <!-- Open Graph for Social Media -->
    <?php if (isset($meta)): ?>
    <meta property="og:title" content="<?= isset($meta['meta_title']) ? esc($meta['meta_title']) : 'Circuit Brilliance | Power Electronics PCB Design' ?>">
    <meta property="og:description" content="<?= isset($meta['meta_desc']) ? esc($meta['meta_desc']) : 'Specialist power electronics PCB design services — EV, renewable energy, BMS, and power conversion.' ?>">
    <meta property="og:image" content="<?= isset($meta['meta_image']) ? esc($meta['meta_image']) : base_url('frontent_assets/img/logo/logo.png') ?>">
    <meta property="og:url" content="<?= isset($meta['meta_url']) ? esc($meta['meta_url']) : current_url() ?>">
    <meta property="og:type" content="article">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?= FRONT_CSS_PATH ?>/css/style.css">
    <link rel="icon" type="image/png" href="<?= FRONT_CSS_PATH ?>/img/fav.png">
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
</head>

<body>

    <!-- PRELOADER -->
    <div id="preloader">
        <div class="chip-loader-w">
            <svg viewBox="0 0 800 500" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="chipGradient" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#2d2d2d"></stop>
                        <stop offset="100%" stop-color="#0f0f0f"></stop>
                    </linearGradient>
                    <linearGradient id="textGradient" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="#eeeeee"></stop>
                        <stop offset="100%" stop-color="#888888"></stop>
                    </linearGradient>
                    <linearGradient id="pinGradient" x1="1" y1="0" x2="0" y2="0">
                        <stop offset="0%" stop-color="#bbbbbb"></stop>
                        <stop offset="50%" stop-color="#888888"></stop>
                        <stop offset="100%" stop-color="#555555"></stop>
                    </linearGradient>
                </defs>
                <g id="traces">
                    <path d="M100 100 H200 V210 H326" class="trace-bg"></path>
                    <path d="M100 100 H200 V210 H326" class="trace-flow purple"></path>
                    <path d="M80 180 H180 V230 H326" class="trace-bg"></path>
                    <path d="M80 180 H180 V230 H326" class="trace-flow blue"></path>
                    <path d="M60 260 H150 V250 H326" class="trace-bg"></path>
                    <path d="M60 260 H150 V250 H326" class="trace-flow yellow"></path>
                    <path d="M100 350 H200 V270 H326" class="trace-bg"></path>
                    <path d="M100 350 H200 V270 H326" class="trace-flow green"></path>
                    <path d="M700 90 H560 V210 H474" class="trace-bg"></path>
                    <path d="M700 90 H560 V210 H474" class="trace-flow blue"></path>
                    <path d="M740 160 H580 V230 H474" class="trace-bg"></path>
                    <path d="M740 160 H580 V230 H474" class="trace-flow green"></path>
                    <path d="M720 250 H590 V250 H474" class="trace-bg"></path>
                    <path d="M720 250 H590 V250 H474" class="trace-flow red"></path>
                    <path d="M680 340 H570 V270 H474" class="trace-bg"></path>
                    <path d="M680 340 H570 V270 H474" class="trace-flow yellow"></path>
                </g>
                <rect x="330" y="190" width="140" height="100" rx="20" ry="20" fill="url(#chipGradient)" stroke="#222"
                    stroke-width="3"></rect>
                <g>
                    <rect x="322" y="205" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                    <rect x="322" y="225" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                    <rect x="322" y="245" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                    <rect x="322" y="265" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                </g>
                <g>
                    <rect x="470" y="205" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                    <rect x="470" y="225" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                    <rect x="470" y="245" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                    <rect x="470" y="265" width="8" height="10" fill="url(#pinGradient)" rx="2"></rect>
                </g>
                <circle cx="100" cy="100" r="5" fill="#333"></circle>
                <circle cx="80" cy="180" r="5" fill="#333"></circle>
                <circle cx="60" cy="260" r="5" fill="#333"></circle>
                <circle cx="100" cy="350" r="5" fill="#333"></circle>
                <circle cx="700" cy="90" r="5" fill="#333"></circle>
                <circle cx="740" cy="160" r="5" fill="#333"></circle>
                <circle cx="720" cy="250" r="5" fill="#333"></circle>
                <circle cx="680" cy="340" r="5" fill="#333"></circle>
            </svg>
        </div>
    </div>

    <!-- ════════════════ TOP BAR ════════════════ -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-inner">
                <div class="topbar-left">
                    Power Electronics Design — <a href="#services">Schematic to Production-Ready PCB</a>
                </div>
                <div class="topbar-right">
                    <a href="tel:+918870174864" class="topbar-item">
                        <i class="fas fa-phone"></i>
                        <strong>+91 88701 74864</strong>
                    </a>
                    <a href="mailto:contact@circuitbrilliance.com" class="topbar-item">
                        <i class="fas fa-envelope"></i>
                        <span>contact@circuitbrilliance.com</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="topbar-sep"></div>
    </div>

    <!-- ════════════════ HEADER ════════════════ -->
    <header class="hdr" id="hdr" role="banner">
        <div class="container">
            <div class="hdr-inner">
                <!-- Logo -->
                <div class="hdr-logo">
                    <a href="<?= base_url() ?>" aria-label="Circuit Brilliance Home">
                        <img src="<?= FRONT_CSS_PATH ?>/img/logo/logo.png" alt="Circuit Brilliance Logo">
                    </a>
                </div>
                <!-- Desktop Nav -->
                <?php $current_uri = uri_string(); ?>
                <nav class="hdr-nav" role="navigation" aria-label="Main navigation">
                    <ul class="nav-ul">
                        <li class="<?php echo ($current_uri == '' || $current_uri == 'index.php' || $current_uri == 'home') ? 'active' : ''; ?>"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="has-dropdown <?php echo (strpos($current_uri, 'domain-service') !== false || strpos($current_uri, 'frameworks') !== false) ? 'active' : ''; ?>">
                            <a href="#">Services <i class="fas fa-chevron-down" style="font-size:10px; margin-left:3px;"></i></a>
                            <ul class="dropdown-menu">
                                <li class="<?php echo (strpos($current_uri, 'domain-service') !== false) ? 'active' : ''; ?>"><a href="<?= base_url('domain-service') ?>">Domain Services</a></li>
                                <li class="<?php echo (strpos($current_uri, 'frameworks') !== false) ? 'active' : ''; ?>"><a href="<?= base_url('frameworks') ?>">Proprietary Frameworks</a></li>
                            </ul>
                        </li>
                        <li class="<?php echo (strpos($current_uri, 'peri') !== false) ? 'active' : ''; ?>"><a href="<?= base_url('peri') ?>">PERI</a></li>
                        <li class="<?php echo (strpos($current_uri, 'portfolio') !== false) ? 'active' : ''; ?>"><a href="<?= base_url('portfolio') ?>">Portfolio</a></li>
                        <li class="<?php echo (strpos($current_uri, 'blog') !== false) ? 'active' : ''; ?>"><a href="<?= base_url('blog') ?>">Blog</a></li>
                        <li class="<?php echo (strpos($current_uri, 'about') !== false) ? 'active' : ''; ?>"><a href="<?= base_url('about') ?>">About</a></li>
                    </ul>
                </nav>
                <!-- Actions -->
                <div class="hdr-actions">
                    <a href="<?= base_url('contact') ?>" class="btn-cta-hdr">Contact Us</a>
                    <a href="https://www.linkedin.com/company/circuit-brilliance" target="_blank" rel="noopener noreferrer" class="hdr-icon" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://wa.me/918870174864" target="_blank" rel="noopener noreferrer" class="hdr-icon wa"
                        aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <button class="burger" id="burger" aria-label="Open navigation menu" aria-expanded="false">
                        <span class="bl"></span><span class="bl"></span><span class="bl"></span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Nav -->
    <div class="mnav" id="mnav" role="dialog" aria-modal="true" aria-label="Navigation menu">
        <div class="mnav-panel">
            <div class="mnav-hdr">
                <span class="mnav-brand"><img src="<?= FRONT_CSS_PATH ?>/img/logo/logo.png"
                        style="height:45px; width:auto; background:white; padding:5px; border-radius:8px;"></span>
                <span class="mnav-x" id="mnav-x" role="button" tabindex="0" aria-label="Close menu">&times;</span>
            </div>
            <div class="mnav-links">
                <a href="<?= base_url() ?>" class="<?php echo ($current_uri == '' || $current_uri == 'index.php' || $current_uri == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="#" style="font-weight: 700; color: var(--navy);">Services</a>
                <a href="<?= base_url('domain-service') ?>" class="<?php echo (strpos($current_uri, 'domain-service') !== false) ? 'active' : ''; ?>" style="padding-left: 40px; font-size: 14px; border-bottom: none; padding-top: 5px; padding-bottom: 5px; color: var(--text-mid); text-decoration: none;">- Domain Services</a>
                <a href="<?= base_url('frameworks') ?>" class="<?php echo (strpos($current_uri, 'frameworks') !== false) ? 'active' : ''; ?>" style="padding-left: 40px; font-size: 14px; padding-top: 5px; padding-bottom: 12px; color: var(--text-mid); text-decoration: none;">- Proprietary Frameworks</a>
                <a href="<?= base_url('peri') ?>" class="<?php echo (strpos($current_uri, 'peri') !== false) ? 'active' : ''; ?>" style="font-weight: 700;">PERI</a>
                <a href="<?= base_url('portfolio') ?>" class="<?php echo (strpos($current_uri, 'portfolio') !== false) ? 'active' : ''; ?>">Portfolio</a>
                <a href="<?= base_url('blog') ?>" class="<?php echo (strpos($current_uri, 'blog') !== false) ? 'active' : ''; ?>">Blog</a>
                <a href="<?= base_url('about') ?>" class="<?php echo (strpos($current_uri, 'about') !== false) ? 'active' : ''; ?>">About</a>
            </div>
            <div class="mnav-foot">
                <a href="<?= base_url('contact') ?>" class="mnav-btn">Contact Us</a>
                <div class="mnav-socials">
                    <a href="https://www.linkedin.com/company/circuit-brilliance" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i
                            class="fab fa-linkedin-in"></i></a>
                    <a href="https://wa.me/918870174864" target="_blank" rel="noopener noreferrer" class="wa"
                        aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>