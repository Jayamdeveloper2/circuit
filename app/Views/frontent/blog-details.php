<?php include('common/header.php'); ?>

<main class="inner-page">
    <!-- ════════════════ INNER BANNER ════════════════ -->
    <section class="inner-banner blog-inner-banner">
        <div class="ib-content container">
            <nav class="blog-breadcrumb-banner" data-aos="fade-up">
                <a href="<?= base_url('blog') ?>">Blog</a> <i class="fa-solid fa-chevron-right"></i> <span><?= esc($blog['web_tag']) ?></span>
            </nav>
            <h1 class="ib-title" data-aos="fade-up"><?= esc($blog['web_title']) ?></h1>
            <div class="bd-meta" data-aos="fade-up" data-aos-delay="100">
                <span class="bd-meta-item"><i class="fa-solid fa-calendar-days"></i> <?= !empty($blog['web_time']) ? esc($blog['web_time']) : date('F j, Y', strtotime($blog['created_on'])) ?></span>
            </div>
        </div>
    </section>

    <!-- ════════════════ BLOG CONTENT SECTION ════════════════ -->
    <section class="sec-padding bg-white">
        <div class="container bd-container">
            <div class="blog-article">
                
                <!-- Content Type: Image (Move to Top) -->
                <?php if (!empty($blog['web_image'])): ?>
                <figure class="bd-figure" data-aos="fade-up" style="margin-top: 0; margin-bottom: 50px;">
                    <img src="<?= BLOG_IMG . $blog['web_image'] ?>" alt="<?= esc($blog['web_title']) ?>" class="bd-img" loading="lazy">
                </figure>
                <?php endif; ?>

                <div class="bd-chunk" data-aos="fade-up">
                    <?= $blog['web_content'] ?>
                </div>

                <style>
                    /* Ensure CKEditor media embeds and iframes are responsive */
                    .bd-chunk figure.media {
                        margin: 2rem 0;
                        text-align: center;
                    }
                    .bd-chunk figure.media iframe,
                    .bd-chunk iframe {
                        width: 100%;
                        aspect-ratio: 16/9;
                        border-radius: 12px;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                    }
                </style>

                <script>
                    // Auto-convert <oembed> tags to <iframe> in case CKEditor saved them as semantic tags
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelectorAll('oembed[url]').forEach(element => {
                            const url = element.getAttribute('url');
                            let iframeUrl = '';
                            
                            if (url.includes('youtube.com/watch?v=')) {
                                iframeUrl = url.replace('watch?v=', 'embed/');
                                const ampersandIndex = iframeUrl.indexOf('&');
                                if (ampersandIndex !== -1) {
                                    iframeUrl = iframeUrl.substring(0, ampersandIndex);
                                }
                            } else if (url.includes('youtu.be/')) {
                                iframeUrl = url.replace('youtu.be/', 'youtube.com/embed/');
                            } else if (url.includes('youtube.com/embed/')) {
                                iframeUrl = url;
                            } else if (url.includes('vimeo.com/')) {
                                iframeUrl = url.replace('vimeo.com/', 'player.vimeo.com/video/');
                            }
                            
                            if (iframeUrl) {
                                const iframe = document.createElement('iframe');
                                iframe.setAttribute('src', iframeUrl);
                                iframe.setAttribute('frameborder', '0');
                                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                                iframe.setAttribute('allowfullscreen', 'true');
                                element.replaceWith(iframe);
                            }
                        });
                    });
                </script>

                <!-- ════════════════ SOCIAL SHARING ════════════════ -->
                <div class="blog-share-w" data-aos="fade-up">
                    <span style="font-weight: 600; margin-right: 15px;">Share this insight:</span>
                    <div class="share-links" style="display: flex; gap: 12px; align-items: center;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener noreferrer" style="background-color: #1877F2; color: white; width: 42px; height: 42px; border-radius: 50%; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(24, 119, 242, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(current_url()) ?>&title=<?= urlencode($blog['web_title']) ?>&summary=<?= urlencode($blog['web_desc'] ?? '') ?>" target="_blank" rel="noopener noreferrer" style="background-color: #0A66C2; color: white; width: 42px; height: 42px; border-radius: 50%; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(10, 102, 194, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blog Sidebar -->
            <aside class="blog-sidebar" data-aos="fade-left">
                <div class="bs-widget">
                    <h5>Recent Insights</h5>
                    <ul class="bs-recent-list">
                        <?php if(!empty($recent_blogs)): ?>
                            <?php foreach($recent_blogs as $recent): ?>
                            <li>
                                <a href="<?= base_url('blog/' . $recent['web_slug']) ?>">
                                    <span class="bs-date"><?= !empty($recent['web_time']) ? esc($recent['web_time']) : date('F j, Y', strtotime($recent['created_on'])) ?></span>
                                    <h6><?= esc(mb_strimwidth($recent['web_title'], 0, 55, '...')) ?></h6>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><span class="text-muted" style="font-size:0.9rem;">No recent insights.</span></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <?php if (!empty($cta_sidebar) && $cta_sidebar['status'] == 1): ?>
                <div class="bs-widget bs-cta">
                    <h5><?= $cta_sidebar['title'] ?></h5>
                    <div class="bs-cta-divider"></div>
                    <p><?= $cta_sidebar['content'] ?></p>
                    <a href="<?= base_url('contact') ?>" class="btn-bs-cta">Talk to an Expert</a>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </section>
    <!-- ════════════════ LET'S WORK TOGETHER (CTA) ════════════════ -->
    <?php if (!empty($cta_bottom) && $cta_bottom['status'] == 1): ?>
    <section class="cta-sec" id="contact-cta">
        <div class="container">
            <div class="cta-inner wow zoomIn">
                <h2 class="cta-h"><?= $cta_bottom['title'] ?></h2>
                <div class="cta-sub"><?= $cta_bottom['content'] ?></div>

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
