<?php include 'common/header.php'; ?>
<!-- <style>
    /* Section specific style fixes */
    .who-we-are-sec .two-col-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 80px;
        align-items: center;
    }
    
    @media (max-width: 991px) {
        .who-we-are-sec .two-col-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    .sec-h {
        position: relative;
        display: inline-block;
        margin-bottom: 30px;
    }

    .sec-h span {
        color: var(--blue);
        position: relative;
    }
</style> -->

<!-- ════════════════ UNIFIED INNER BANNER ════════════════ -->
<section class="inner-banner">
    <div class="ib-content container">
        <h1 class="ib-title">About <span>Circuit Brilliance</span></h1>
        <p class="page-subtitle">Power Electronics Design — Done Right, Every Time</p>
    </div>
</section>

<!-- ════════════════ LOGO AND CREDENTIAL BADGES ════════════════ -->
<section class="cred-badges-sec">
    <div class="container">
        <div class="cred-grid">
            <?php if (!empty($cred_badges)): ?>
                <?php foreach ($cred_badges as $index => $badge): ?>
                    <div class="cred-item" data-aos="zoom-in" data-aos-delay="<?= ($index + 1) * 100 ?>">
                        <div class="cred-icon"><i class="<?= $badge['web_icon'] ?>"></i></div>
                        <div class="cred-text">
                            <strong><?= $badge['web_title'] ?></strong>
                            <span><?= $badge['web_label'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback Static Content if DB is empty -->
                <div class="cred-item" data-aos="zoom-in" data-aos-delay="100">
                    <div class="cred-icon"><i class="fas fa-history"></i></div>
                    <div class="cred-text">
                        <strong>18+</strong>
                        <span>Years of Experience</span>
                    </div>
                </div>
                <!-- ... other fallback items ... -->
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ════════════════ WHO WE ARE ════════════════ -->
<section class="who-we-are-sec sec-padding">
    <div class="container">
        <div class="two-col-grid align-items-center">
            <div class="col-content" data-aos="fade-right">
                <h2 class="sec-h"><?= $about_content_data['web_content_1'] ?? 'About <span>Circuit Brilliance</span>' ?></h2>
                <div class="content-text">
                    <?= $about_content_data['web_content_2'] ?? '' ?>
                </div>
            </div>
            <div class="col-image" data-aos="fade-left">
                <div class="img-frame">
                    <img src="<?= $about_content_data['image'] ?? 'assets/img/about-who.png' ?>"
                        alt="<?= $about_content_data['web_content_1'] ?? 'Circuit Brilliance' ?>"
                        class="img-fluid rounded shadow img-comp-fixed" loading="lazy">
                    <div class="img-accent"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (isset($about_quote_data['status']) && $about_quote_data['status'] == 1) : ?>
<!-- ════════════════ PULL QUOTE ════════════════ -->
<section class="pull-quote-sec position-relative"
    style="background-image: url('<?= !empty($about_quote_data['web_image_1']) ? $about_quote_data['image'] : 'assets/img/approach-bg.png' ?>'); background-size: cover; background-position: center; background-attachment: fixed; padding: 100px 0;">
    <div class="container position-relative" style="z-index: 2;">
        <div class="quote-wrapper text-white text-center" data-aos="zoom-in"
            style="background: rgba(255,255,255,0.05); padding: 60px 40px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); max-width: 900px; margin: 0 auto; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
            <i class="fas fa-quote-left quote-icon mb-4" style="color: #00f0ff; font-size: 3rem; opacity: 0.9;"></i>
            <blockquote
                style="color: #ffffff; font-size: 1.8rem; font-weight: 300; line-height: 1.6; margin-bottom: 30px; font-style: italic;">
                <?= $about_quote_data['web_content_1'] ?? '' ?>
            </blockquote>
            <cite
                style="font-size: 1.2rem; font-weight: 500; color: #00f0ff; letter-spacing: 1px; display: block; text-transform: uppercase;">—
                <?= $about_quote_data['web_content_2'] ?? '' ?></cite>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (isset($how_we_work_data['status']) && $how_we_work_data['status'] == 1) : ?>
<!-- ════════════════ HOW WE WORK ════════════════ -->
<section class="how-we-work-sec sec-padding gray-bg">
    <div class="container">
        <div class="sec-header">
            <h2 class="sec-h"><?= $how_we_work_data['web_content_1'] ?? 'How We <span>Work</span>' ?></h2>
        </div>

        <div class="work-grid">
            <!-- Brief Engagement -->
            <div class="work-card" data-aos="fade-up" data-aos-delay="100">
                <div class="wc-icon"><i class="<?= $how_we_work_data['web_content_6'] ?? 'fas fa-file-invoice' ?>"></i></div>
                <h3><?= $how_we_work_data['web_content_2'] ?? 'What happens when you bring us a design brief' ?></h3>
                <div class="wc-text">
                    <?= $how_we_work_data['web_content_3'] ?? '' ?>
                </div>
            </div>
            <!-- From Scratch -->
            <div class="work-card" data-aos="fade-up" data-aos-delay="200">
                <div class="wc-icon"><i class="<?= $how_we_work_data['web_content_7'] ?? 'fas fa-microchip' ?>"></i></div>
                <h3><?= $how_we_work_data['web_content_4'] ?? 'What happens when you are building a product from scratch' ?></h3>
                <div class="wc-text">
                    <?= $how_we_work_data['web_content_5'] ?? '' ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>



<?php if (isset($about_vision_data['status']) && $about_vision_data['status'] == 1) : ?>
<!-- ════════════════ THE VISION & PERI ════════════════ -->
<section class="vision-sec sec-padding navy-bg text-white">
    <div class="container">
        <div class="vision-grid align-items-center">
            <div class="vision-image" data-aos="zoom-in">
                <img src="<?= $about_vision_data['image'] ?? 'assets/img/about-vision.png' ?>"
                    alt="<?= $about_vision_data['web_content_1'] ?? 'Circuit Brilliance Vision' ?>"
                    class="rounded shadow img-comp-fixed" loading="lazy">
            </div>
            <div class="vision-content" data-aos="fade-left">
                <h2 class="sec-h text-white"><?= $about_vision_data['web_content_1'] ?? 'More than projects. <span>A design hub</span>' ?></h2>
                <div class="vision-text" style="opacity: 0.85;">
                    <?= $about_vision_data['web_content_2'] ?? '' ?>
                </div>

                <div class="peri-card mt-4"
                    style="background: rgba(255,255,255,0.05); padding: 30px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                    <div class="peri-logo mb-3"
                        style="color: #00f0ff; font-weight: 800; font-size: 1.5rem; letter-spacing: 1px;">PERI</div>
                    <h4 class="text-white mb-3"><?= $about_vision_data['web_content_3'] ?? 'Power Electronics Research Institute' ?></h4>
                    <div class="peri-text" style="opacity: 0.8; font-size: 0.95rem;">
                        <?= $about_vision_data['web_content_4'] ?? '' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (isset($about_beliefs_data['status']) && $about_beliefs_data['status'] == 1) : ?>
<!-- ════════════════ WHAT WE BELIEVE ════════════════ -->
<section class="beliefs-sec sec-padding bg-white text-dark">
    <div class="container text-center">
        <h2 class="sec-h"><?= $about_beliefs_data['web_content_1'] ?? 'What We <span>Believe</span>' ?></h2>

        <div class="beliefs-grid mt-5">
            <?php 
            $beliefs = json_decode($about_beliefs_data['web_content_2'] ?? '[]', true);
            if(is_array($beliefs)):
                foreach($beliefs as $index => $item):
            ?>
            <div class="belief-item" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>"
                style="background: #f8f9fa; border: 1px solid #eaeaea; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.03);">
                <i class="<?= $item['icon'] ?? 'fa-solid fa-microchip' ?> mb-3" style="color: var(--navy); font-size: 2rem;"></i>
                <div class="belief-text" style="color: #4a5568; font-size: 1.05rem;">
                    <?= $item['text'] ?? '' ?>
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

<?php if (isset($about_mission_data['status']) && $about_mission_data['status'] == 1) : ?>
<!-- ════════════════ OUR APPROACH ════════════════ -->
<section class="approach-trace-sec sec-padding gray-bg">
    <div class="container">
        <div class="two-col-grid align-items-center" style="gap: 80px;">
            <div class="col-content" data-aos="fade-right">
                <h2 class="sec-h"><?= $about_mission_data['web_content_1'] ?? 'Our <span>Approach</span>' ?></h2>

                <div class="diagonal-list-wrapper mt-4">
                    <style>
                        .approach-rich-content { text-align: left !important; }
                        .approach-rich-content ul { list-style: none; padding: 0; margin-bottom: 25px; text-align: left !important; }
                        .approach-rich-content ul li { position: relative; padding-left: 35px; margin-bottom: 18px; font-size: 1.1rem; line-height: 1.5; color: #4a5568; text-align: left !important; }
                        .approach-rich-content ul li::before { content: "\f058"; font-family: "Font Awesome 6 Free"; font-weight: 900; position: absolute; left: 0; top: 2px; color: var(--navy); font-size: 1.3rem; }
                        .approach-rich-content ul li p { margin: 0; display: inline; text-align: left !important; }
                    </style>
                    <div class="approach-rich-content" data-aos="fade-up" data-aos-delay="200">
                        <?= $about_mission_data['web_content_2'] ?? '' ?>
                    </div>

                    <div class="approach-final-bold mt-4" data-aos="fade-up" data-aos-delay="500">
                        <i class="fas fa-check-double"></i> <?= $about_mission_data['web_content_3'] ?? '' ?>
                    </div>
                </div>
            </div>

            <div class="col-image" data-aos="fade-left">
                <div class="img-frame">
                    <img src="<?= $about_mission_data['image'] ?? 'assets/img/approach_new.png' ?>"
                        alt="<?= $about_mission_data['web_content_1'] ?? 'Circuit Brilliance Approach' ?>"
                        class="img-fluid rounded-lg shadow-xl img-comp-fixed" loading="lazy">
                    <div class="img-accent"></div>
                </div>
            </div>
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

            <a href="<?= base_url('contact') ?>" class="btn-cta">Start a Conversation →</a>

            <div class="cta-channels">
                <!-- LinkedIn -->
                <?php if (!empty($setting['linkedin_url'])): ?>
                <a href="<?= esc($setting['linkedin_url']) ?>" target="_blank" class="cta-chan">
                    <div class="cc-icon"><i class="fa-brands fa-linkedin-in"></i></div>
                    <div class="cc-text">
                        <span>LinkedIn</span>
                        <strong>Connect with us on LinkedIn</strong>
                    </div>
                </a>
                <?php endif; ?>

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

<?php include 'common/footer.php'; ?>