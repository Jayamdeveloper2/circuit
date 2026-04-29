<?php include('common/header.php'); ?>

<!-- ════════════════ HERO ════════════════ -->
<section class="hero" id="home">
    <div class="hero-bg" role="img" aria-label="Power electronics PCB design Circuit Brilliance"></div>
    <div class="hero-ov"></div>

    <div class="hero-body">
        <div class="container">
            <div class="hero-main-h">
                <h1><span id="heroTyped"></span></h1>
            </div>

            <p class="hero-sub">
                Specialist power electronics design services for EV, renewable energy, and industrial power conversion —
                serving companies worldwide.
            </p>
            <div class="hero-btns">
                <a href="#services" class="btn-hp"><i class="fas fa-bolt"></i> Explore Our Services</a>
                <a href="contact.php" class="btn-hs"><i class="fas fa-comment-dots"></i> Contact Us</a>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L0 0C360 120 1080 120 1440 0L1440 120Z" fill="white" />
        </svg>
    </div>
</section>

<!-- ════════════════ CREDIBILITY COUNTERS ════════════════ -->
<?php if (($achievement_data['status'] ?? 0) == 1): ?>
    <section class="cnt-section" id="about">
        <div class="container">
            <div class="cnt-grid">
                <?php
                $stats = json_decode($achievement_data['web_content_2'] ?? '[]', true);
                if (is_array($stats)):
                    foreach ($stats as $index => $stat):
                ?>
                        <div class="cnt-card wow d<?= ($index % 4) ?>">
                            <div class="cnt-visual">
                                <span class="cnt-num" data-target="<?= htmlspecialchars($stat['count'] ?? '0') ?>">0</span><?php if (!empty($stat['suffix'])): ?><small><?= htmlspecialchars($stat['suffix']) ?></small><?php endif; ?>
                            </div>
                            <div class="cnt-info">
                                <h3 class="cnt-title"><?= htmlspecialchars($stat['title'] ?? '') ?></h3>
                                <p class="cnt-desc"><?= htmlspecialchars($stat['desc'] ?? '') ?></p>
                            </div>
                        </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- ════════════════ DYNAMIC TECH TABS SECTION ════════════════ -->
<section class="tech-tabs-sec" id="credentials">
    <div class="container">
        <h2 class="sec-h center wow"><?= $home_about_data['web_content_1'] ?? 'Credentials <span>& Tools</span>' ?></h2>

        <div class="tabs-grid">
            <!-- Left: Double Overlapping Images -->
            <div class="tabs-img-block wow fadeInLeft">
                <div class="img-wrap top">
                    <img src="<?= $home_about_data['image'] ?? 'assets/img/tabs-img1.jpg' ?>" alt="Engineering Laboratory">
                </div>
                <div class="img-wrap bottom">
                    <img src="<?= $home_about_data['image2'] ?? 'assets/img/tabs-img2.jpg' ?>" alt="PCB Schematic Design">
                </div>
            </div>

            <!-- Right: Tab Switcher Content -->
            <div class="tabs-content-block wow fadeInRight">
                <div class="tab-nav">
                    <button class="tab-btn active" data-tab="tab-tools">
                        <i class="fa-solid fa-microchip"></i> Expertise & Tools
                    </button>
                    <button class="tab-btn" data-tab="tab-credentials">
                        <i class="fa-solid fa-award"></i> Certifications
                    </button>
                </div>

                <div class="tab-panes">
                    <!-- Pane 1: Credentials -->
                    <div class="tab-pane" id="tab-credentials">
                        <div class="dynamic-badge-list">
                            <?= $home_about_data['web_content_5'] ?? '' ?>
                        </div>
                    </div>

                    <!-- Pane 2: Tools -->
                    <div class="tab-pane active" id="tab-tools">
                        <div class="dynamic-badge-list">
                            <?= $home_about_data['web_content_4'] ?? '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (isset($people_trust_data['status']) && $people_trust_data['status'] == 1) : ?>
<!-- ════════════════ WHAT WE DESIGN SECTION ════════════════ -->
<section class="design-sec" id="services">
    <div class="container">
        <div class="sec-header wow fadeIn">
            <h2 class="sec-h center wow"><?= $people_trust_data['web_content_1'] ?? 'What We <span>Design</span>' ?></h2>
            <p class="sec-sub"><?= $people_trust_data['web_content_2'] ?? '' ?></p>
        </div>

        <div class="design-grid">
            <?php if (!empty($people_trust_card_data)) : foreach ($people_trust_card_data as $index => $card) : ?>
                <!-- Card: <?= $card['web_title'] ?> -->
                <div class="design-card wow fadeInUp" data-wow-delay="<?= ($index * 0.1) ?>s">
                    <div class="d-icon">
                        <img src="<?= $card['web_image'] ?>" alt="<?= $card['web_title'] ?> Icon">
                    </div>
                    <div class="d-content">
                        <h3><?= $card['web_title'] ?></h3>
                        <p><?= $card['web_content'] ?></p>
                        <a href="domain-service.php#ev" class="d-link">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (isset($home_contact_data['status']) && $home_contact_data['status'] == 1) : ?>
<!-- ════════════════ SERVICE STRIP — CIRCUIT FLOW ════════════════ -->
<section class="svc-flow-sec" id="catalog">
    <div class="container">
        <div class="sec-header wow fadeIn">
            <h2 class="sec-h center wow"><?= $home_contact_data['web_content_1'] ?? 'Our <span>Design Services</span>' ?></h2>
            <p class="sec-sub"><?= $home_contact_data['web_content_2'] ?? '' ?></p>
        </div>

        <div class="svc-flow-container">
            <!-- Circuit Trace Line (Desktop) -->
            <div class="trace-line"></div>

            <div class="svc-flow-grid">
                <?php if (!empty($service_cate_card_data)) : foreach ($service_cate_card_data as $index => $item) : ?>
                    <!-- Item: <?= $item['web_title'] ?> -->
                    <div class="flow-item <?= ($index % 2 == 0) ? 'left' : 'right' ?> wow <?= ($index % 2 == 0) ? 'fadeInLeft' : 'fadeInRight' ?>" data-wow-delay="<?= ($index * 0.1) ?>s">
                        <div class="f-num"><?= sprintf('%02d', $index + 1) ?></div>
                        <div class="f-icon"><i class="<?= $item['web_icon'] ?>"></i></div>
                        <div class="f-content">
                            <h4><?= $item['web_title'] ?></h4>
                            <p><?= $item['web_content'] ?></p>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <?php if (!empty($home_contact_data['web_content_3'])) : ?>
            <!-- Bundle CTA Strip -->
            <div class="bundle-strip-inner wow fadeInUp">
                <h3>The Full Design Bundle</h3>
                <p><?= $home_contact_data['web_content_3'] ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>






<?php if (isset($mission_hub_data['status']) && $mission_hub_data['status'] == 1) : ?>
<!-- ════════════════ MISSION HUB — MINIMALIST DECLARATION ════════════════ -->
<section class="hub-mission-sec">
    <div class="container">
        <div class="mission-text wow fadeInUp">
            <p><?= $mission_hub_data['web_content_1'] ?? 'Circuit Brilliance is built to be more than a design service — it is a growing power electronics design hub, bringing together deep engineering expertise, structured processes, and real-world project exPerience to serve the global EV and renewable energy community.' ?></p>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (isset($whychoose_data['status']) && $whychoose_data['status'] == 1) : ?>
<!-- ════════════════ WHY CHOOSE — FEATURE GRID ════════════════ -->
<section class="why-choose-sec" id="why">
    <div class="container">
        <div class="sec-header wow fadeIn">
            <h2 class="sec-h center wow"><?= $whychoose_data['web_content_1'] ?? 'Why Engineers & Companies Choose <span>Circuit Brilliance</span>' ?></h2>
            <p class="sec-sub"><?= $whychoose_data['web_content_2'] ?? '' ?></p>
        </div>

        <div class="wc-grid">
            <?php if (!empty($whychoose_card_data)) : foreach ($whychoose_card_data as $index => $item) : ?>
                <!-- Card: <?= $item['web_title'] ?> -->
                <div class="wc-card wow fadeInUp" data-wow-delay="<?= ($index * 0.1) ?>s">
                    <i class="<?= $item['web_icon'] ?> wc-watermark"></i>
                    <div class="wc-num">
                        <?php if ($item['web_subtitle'] == '%') : ?>
                            <span class="wc-count" data-count="<?= $item['web_title'] ?>">0</span>
                        <?php else : ?>
                            <?= $item['web_title'] ?>
                        <?php endif; ?>
                        <span class="wc-unit"><?= $item['web_subtitle'] ?></span>
                    </div>
                    <h4><?= $item['web_heading'] ?></h4>
                    <p><?= $item['web_content'] ?></p>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════ New section counter  ════════════════ -->
<?php if (($framework_data['status'] ?? 0) == 1): ?>
<section class="assurance-section" id="assurance">
    <div class="container">
        <h2 class="sec-h center wow"><?= $framework_data['web_content_1'] ?? 'Engineering Assurance <span>Framework</span>' ?></h2>
        <p class="sec-sub"><a href="frameworks.php"
                style="color: inherit; text-decoration: none; border-bottom: 2px solid var(--blue);"><?= $framework_data['web_content_4'] ?? 'Verified before fabrication — every time. Click here to know more' ?> <i class="fas fa-arrow-right"
                    style="margin-left: 8px; font-size: 0.85em;"></i></a></p>

        <div class="assurance-grid">
            <?php
            $stats = json_decode($framework_data['web_content_2'] ?? '[]', true);
            if (is_array($stats)):
                foreach ($stats as $index => $stat):
            ?>
                <!-- Counter <?= $index + 1 ?> -->
                <div class="assurance-card wow <?= ($index > 0) ? 'd' . $index : '' ?>">
                    <div class="assurance-number">
                        <span class="assurance-num" data-target="<?= $stat['count'] ?? '0' ?>">0</span><span class="assurance-plus"><?= $stat['suffix'] ?? '+' ?></span>
                    </div>
                    <h3 class="assurance-label"><?= $stat['title'] ?? '' ?></h3>
                    <p class="assurance-desc"><?= $stat['desc'] ?? '' ?></p>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════ BLOG — SPLIT INFINITE CAROUSEL ════════════════ -->
<?php if (!empty($home_blog_content) && $home_blog_content['status'] == 1): ?>
<section class="blog-sec" id="blog">
    <div class="container">
        <div class="blog-split">

            <!-- LEFT: Content Panel -->
            <div class="blog-left wow fadeInLeft">
                <h2><?= $home_blog_content['web_content_1'] ?? 'From the Circuit<br><span>Brilliance Blog</span>' ?></h2>
                <div class="blog-sub">
                    <?= $home_blog_content['web_content_2'] ?? 'Design insights, engineering tips and power electronics thinking — straight from the workbench.' ?>
                </div>

                <ul class="blog-link-list">
                    <?php if(!empty($blogs)): ?>
                        <?php foreach(array_slice($blogs, 0, 3) as $blog): ?>
                        <li>
                            <a href="<?= base_url('blog/' . $blog['web_slug']) ?>" style="color: inherit; text-decoration: none;">
                                <i class="fa-solid fa-arrow-right"></i> <?= esc($blog['web_title']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- RIGHT: Interactive 2-view Carousel -->
            <div class="blog-right wow fadeInRight">
                <div class="blog-caro-header">
                    <h4 class="bch-title">Latest Articles</h4>
                    <div class="blog-nav">
                        <button id="blogPrev" aria-label="Previous"><i class="fa-solid fa-arrow-left"></i></button>
                        <button id="blogNext" aria-label="Next"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="blog-track-wrap" id="blogTrackWrap">
                    <div class="blog-track" id="blogTrack">
                    <?php if(!empty($blogs)): ?>
                        <?php foreach($blogs as $blog): ?>
                        <div class="blog-card">
                            <div class="bc-img">
                                <img src="<?= !empty($blog['web_image']) ? BLOG_IMG . $blog['web_image'] : base_url('assets/img/blog_placeholder.png') ?>" alt="<?= esc($blog['web_title']) ?>">
                            </div>
                            <div class="bc-body">
                                <span class="bc-cat ev"><?= esc($blog['web_tag']) ?></span>
                                <h4><?= esc($blog['web_title']) ?></h4>
                                <p><?= esc(mb_strimwidth(strip_tags($blog['web_content']), 0, 120, '...')) ?></p>
                                <div class="bc-foot">
                                    <span><i class="fa-regular fa-calendar"></i> <?= !empty($blog['web_time']) ? esc($blog['web_time']) : date('M j, Y', strtotime($blog['created_on'])) ?></span>
                                    <a href="<?= base_url('blog/' . $blog['web_slug']) ?>">Read More <i class="fa-solid fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="blog-card">
                            <div class="bc-body">
                                <p>No articles available at the moment.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ════════════════ New section for newsletterrrr ════════════════ -->
<section class="kgs-newsletter-sec">
    <div class="container">
        <div class="kgs-newsletter-box text-center">

            <h2 class="sec-h center wow mb-3">Subscribe to <span>Our Newsletter</span></h2>
            <!-- <p class="kgs-newsletter-sub">Subscribe for the latest updates, industry insights, and design resources — delivered to your inbox.</p> -->

            <!-- MAILCHIMP PLACEHOLDER START -->
            <div class="kgs-newsletter-placeholder">
                <p class="placeholder-note"><strong>Insights, ideas, and engineering know-how — straight to your
                        inbox.</strong></p>

                <!-- Temporary UI -->
                <form class="kgs-newsletter-form">
                    <input type="email" placeholder="Email address">
                    <button type="button">Subscribe</button>
                </form>
                <p class="form-footer">No spam. Unsubscribe anytime.</p>
            </div>
            <!-- MAILCHIMP PLACEHOLDER END -->

        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════ LET'S WORK TOGETHER (CTA) ════════════════ -->
<?php if (!empty($cta) && $cta['status'] == 1): ?>
<section class="cta-sec" id="contact-cta">
    <div class="container">
        <div class="cta-inner wow zoomIn">
            <h2 class="cta-h"><?= $cta['title'] ?></h2>
            <div class="cta-sub"><?= $cta['content'] ?></div>

            <a href="<?= base_url('contact') ?>" class="btn-cta">Contact Us</a>

            <div class="cta-channels">
                <!-- Form -->
                <a href="<?= base_url('contact') ?>" class="cta-chan">
                    <div class="cc-icon"><i class="fa-solid fa-file-signature"></i></div>
                    <div class="cc-text">
                        <span>Contact Form</span>
                        <strong>Fill in our project inquiry form</strong>
                    </div>
                </a>

                <!-- Email -->
                <?php if (!empty($setting['user_email'])): ?>
                <a href="mailto:<?= esc($setting['user_email']) ?>" class="cta-chan">
                    <div class="cc-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="cc-text">
                        <span>Email</span>
                        <strong><?= esc($setting['user_email']) ?></strong>
                    </div>
                </a>
                <?php endif; ?>

                <!-- WhatsApp -->
                <?php if (!empty($setting['user_phone_1'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $setting['user_phone_1']) ?>" target="_blank" rel="noopener noreferrer" class="cta-chan">
                    <div class="cc-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div class="cc-text">
                        <span>WhatsApp</span>
                        <strong>Message us on WhatsApp</strong>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include('common/footer.php'); ?>