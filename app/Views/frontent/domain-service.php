<?php include('common/header.php'); ?>

<main class="inner-page-light">
    <!-- INNER BANNER -->
    <section class="inner-banner">
        <div class="ib-content container">
            <div class="ib-title">Domain Services</div>
            <div class="">
                <p>End-to-End Power Electronics Design Services</p>
            </div>
        </div>
    </section>

    <!-- HERO SECTION -->
    <section class="hero-l">
        <div class="container text-center">
            <h1 class="l-h animate__animated animate__fadeInDown"><?= $hero['web_content_1'] ?? 'Specialist Expertise Across Four High-Growth Domains' ?></h1>
            <p class="l-sub animate__animated animate__fadeInUp animate__delay-1s mx-auto" style="max-width: 900px;">
                <?= $hero['web_content_2'] ?? '' ?>
            </p>
        </div>
    </section>

    <!-- STICKY ANCHOR NAV -->
    <div class="anchor-nav-w hide-mobile">
        <div class="container d-flex justify-content-center gap-3 flex-wrap">
            <?php foreach ($service_details as $sd): ?>
                <a href="#<?= $sd['section_anchor'] ?>" class="btn-hs px-4 py-3" style="font-size: 11px;"><?= $sd['title_eb'] ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach ($service_details as $index => $sd): ?>
    <!-- <?= strtoupper($sd['section_anchor']) ?> SECTION -->
    <section class="l-sec" id="<?= $sd['section_anchor'] ?>" <?= ($index % 2 != 0) ? 'style="background-color: #f8fafc;"' : '' ?>>
        <div class="container">
            <div class="l-grid-box">
                <div class="l-content">
                    <span class="l-sec-eb" style="color: <?= $sd['theme_color'] ?>;"><i class="fa-solid fa-link me-2"></i> <?= $sd['title_eb'] ?></span>
                    <h2 class="l-sec-h"><?= $sd['heading'] ?></h2>
                    <p class="l-p"><?= $sd['description'] ?></p>
                </div>
                <div class="img-creative-box">
                    <img src="<?= base_url('assets/img/' . $sd['image']) ?>" alt="Circuit Brilliance Specialist Design and Services — <?= $sd['title_eb'] ?>" class="img-comp-fixed" loading="lazy">
                </div>
            </div>

            <div class="tech-table-grid" style="border-top: 5px solid <?= $sd['theme_color'] ?>;">
                <div class="t-grid-header">
                    <div class="t-h-col"><i class="fa-solid fa-pencil-ruler"></i> What We Design</div>
                    <div class="t-h-col"><i class="fa-solid fa-file-invoice"></i> Deliverables</div>
                    <div class="t-h-col"><i class="fa-solid fa-microchip"></i> Technologies</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col" data-label="What We Design">
                        <ul class="t-list">
                            <?php foreach ($sd['what_we_design'] as $item): ?>
                                <li><?= $item ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="t-b-col" data-label="Deliverables">
                        <ul class="t-list">
                            <?php foreach ($sd['deliverables'] as $item): ?>
                                <li><?= $item ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="t-b-col" data-label="Technologies">
                        <ul class="t-list">
                            <?php foreach ($sd['technologies'] as $item): ?>
                                <li><?= $item ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endforeach; ?>

    <!-- FINAL CTA -->
    <section class="cta-sec">
        <div class="container">
            <div class="cta-inner wow zoomIn">
                <h2 class="cta-h">Have a Power Electronics <span>Design Project in Mind?</span></h2>
                <p class="cta-sub">Tell us about your project — domain, power level, challenge. We respond with a clear scoping proposal. No obligation. Just a direct conversation between engineers.</p>
                <div class="hero-btns mt-4">
                    <a href="contact.php" class="btn-hp">Start a Conversation <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="https://wa.me/918870174864" target="_blank" rel="noopener noreferrer" class="btn-hs px-4 py-3">Message on WhatsApp <i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include('common/footer.php'); ?>
