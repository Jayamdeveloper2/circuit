<?php include('common/header.php'); ?>

<main class="inner-page">
    <!-- ════════════════ INNER BANNER ════════════════ -->
    <section class="inner-banner">
        <div class="ib-content container">
            <h1 class="ib-title" data-aos="fade-up">Insights & Engineering Blog</h1>
            <p class="page-subtitle" data-aos="fade-up" data-aos-delay="100">Deep dives into power electronics, PCB design, and technical frameworks.</p>
        </div>
    </section>

    <!-- ════════════════ BLOG LIST SECTION ════════════════ -->
    <section class="sec-padding bg-light-gray">
        <div class="container">
            <div class="blog-main-grid">
                <?php if (!empty($blogs)): ?>
                    <?php foreach ($blogs as $index => $blog): ?>
                        <div class="blog-card-v2" data-aos="fade-up" <?= $index % 2 != 0 ? 'data-aos-delay="100"' : '' ?>>
                            <div class="bc-img-w">
                                <img src="<?= BLOG_IMG . $blog['web_image'] ?>" alt="<?= esc($blog['web_title']) ?>" loading="lazy">
                                <?php if (!empty($blog['web_tag'])): ?>
                                    <span class="bc-tag"><?= esc($blog['web_tag']) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="bc-content">
                                <div class="bc-meta">
                                    <span><i class="fa-solid fa-calendar-days"></i> <?= !empty($blog['web_time']) ? esc($blog['web_time']) : date('F j, Y', strtotime($blog['created_on'])) ?></span>
                                </div>
                                <h3><?= esc($blog['web_title']) ?></h3>
                                <p><?= esc($blog['web_desc']) ?></p>
                                <a href="<?= base_url('blog/' . $blog['web_slug']) ?>" class="bc-link">Read Full Insight <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No blogs found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

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
</main>

<?php include('common/footer.php'); ?>