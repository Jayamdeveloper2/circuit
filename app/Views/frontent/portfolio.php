<?php include 'common/header.php'; ?>

<!-- ════════════════ UNIFIED INNER BANNER ════════════════ -->
<section class="inner-banner">
    <div class="ib-content container">
        <h1 class="ib-title">Our <span>Portfolio</span></h1>
        <p class="page-subtitle">Power Electronics Design — Done Right, Every Time</p>
    </div>
</section>

<!-- ════════════════ INTRO & DOMAINS ════════════════ -->
<?php if (isset($portfolio_intro) && $portfolio_intro['status'] == 1) : ?>
    <section class="sec-padding" style="background: #fff;">
        <div class="container">
            <!-- Intro Text -->
            <div class="port-intro" data-aos="fade-up">
                <p>
                    <?= $portfolio_intro['web_content_2'] ?>
                </p>
            </div>

            <!-- Domain Image Tiles -->
            <div class="port-domain-grid pt-5">
                <?php if (!empty($portfolio_domains)) : ?>
                    <?php foreach ($portfolio_domains as $index => $domain) : ?>
                        <a href="<?= $domain['web_url'] ?>" class="domain-tile-card" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                            <img src="<?= $domain['image'] ?>" alt="<?= $domain['web_title'] ?>" class="tile-img">
                            <div class="tile-overlay">
                                <h4><?= $domain['web_title'] ?></h4>
                                <p class="font-sm"><?= $domain['web_content'] ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- ════════════════ FLAGSHIP SHOWCASES (DYNAMIC) ════════════════ -->
<?php if (!empty($showcase_projects)) : ?>
    <?php foreach ($showcase_projects as $sc) : ?>
    <section class="sec-padding pt-0 pb-0" id="<?= $sc['web_anchor_id'] ?>" style="background:#f8fafc;">
        <div class="container" style="padding-top: 80px;">
            <!-- Title Block -->
            <div class="port-flagship-head" data-aos="fade-up">
                <div class="port-tags" style="justify-content: center;">
                    <div class="port-status"><span class="port-dot"></span><?= $sc['web_status_text'] ?></div>
                </div>
                <h2 class="sec-h" style="text-align:center; margin-top:20px;"><?= $sc['web_title'] ?></h2>
                <p class="port-tech-line"><?= str_replace('|', '&nbsp;|&nbsp;', $sc['web_tech_line']) ?></p>
                <p class="port-hook">
                    <?= $sc['web_hook'] ?>
                </p>
            </div>

            <!-- Progress Tracker -->
            <?php if (!empty($sc['execution_progress'])) : ?>
            <div class="port-tracker-container" data-aos="fade-up">
                <h4 class="port-sect-title">Execution Progress</h4>
                <div class="port-tracker">
                    <div class="pt-line">
                        <?php 
                        $total = count($sc['execution_progress']);
                        $complete = 0;
                        foreach($sc['execution_progress'] as $p) {
                            if (stripos($p, 'Complete') !== false) $complete++;
                        }
                        $width = ($total > 1) ? ($complete / ($total - 1)) * 100 : 0;
                        if ($width > 100) $width = 100;
                        ?>
                        <div class="pt-line-active" style="width: <?= $width ?>%;"></div>
                    </div>

                    <?php foreach ($sc['execution_progress'] as $idx => $progress) : 
                        $parts = explode(':', $progress);
                        $label = $parts[0] ?? $progress;
                        $sub = $parts[1] ?? '';
                        $class = 'pt-upcoming';
                        $icon = ($idx + 1);
                        
                        if (stripos($sub, 'Complete') !== false) {
                            $class = 'pt-complete';
                            $icon = '<i class="fa-solid fa-check"></i>';
                        } elseif (stripos($sub, 'In Progress') !== false) {
                            $class = 'pt-active';
                            $icon = '<i class="fa-solid fa-spinner fa-spin"></i>';
                        }
                    ?>
                    <div class="pt-stage <?= $class ?>">
                        <div class="pt-node"><?= $icon ?></div>
                        <div class="pt-label"><?= ($idx + 1) . '. ' . trim($label) ?></div>
                        <div class="pt-sub"><?= trim($sub) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="two-col-grid" style="gap:50px; margin-top:60px; align-items: start;">
                <!-- Key Specifications -->
                <?php if (!empty($sc['key_specifications'])) : ?>
                <div data-aos="fade-right">
                    <h3 class="port-sect-title">Key Specifications</h3>
                    <div class="port-spec-card">
                        <?php foreach ($sc['key_specifications'] as $spec) : 
                            $parts = explode(':', $spec);
                            $label = $parts[0] ?? '';
                            $val = $parts[1] ?? '';
                            $isAccent = (stripos($label, 'Efficiency') !== false) ? 'ps-accent' : '';
                        ?>
                        <div class="port-spec-row">
                            <div class="ps-label"><?= trim($label) ?></div>
                            <div class="ps-val <?= $isAccent ?>"><?= trim($val) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Design Highlights -->
                <?php if (!empty($sc['design_highlights'])) : ?>
                <div data-aos="fade-left">
                    <h3 class="port-sect-title">Design Highlights</h3>
                    <div class="port-hl-list">
                        <?php foreach ($sc['design_highlights'] as $hl) : ?>
                        <div class="port-hl-item">
                            <i class="fas fa-check-circle"></i>
                            <?php 
                                $parts = explode('—', $hl);
                                $bold = $parts[0] ?? '';
                                $rest = $parts[1] ?? '';
                            ?>
                            <p><strong><?= trim($bold) ?></strong> <?= !empty($rest) ? '— ' . trim($rest) : '' ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- PCB Design Challenges -->
            <?php if (!empty($sc['pcb_challenges'])) : ?>
            <h3 class="port-sect-title" style="text-align:center; margin-top:80px;" data-aos="fade-up">PCB Design Challenges Mastered</h3>
            <div class="tech-table-grid" data-aos="fade-up">
                <div class="t-grid-header" style="grid-template-columns: 1fr 2fr;">
                    <div class="t-h-col"><i class="fa-solid fa-layer-group"></i> Challenge Area</div>
                    <div class="t-h-col"><i class="fa-solid fa-microchip"></i> Engineering Detail</div>
                </div>
                <?php foreach ($sc['pcb_challenges'] as $idx => $chal) : 
                    $parts = explode(':', $chal);
                    $area = $parts[0] ?? '';
                    $detail = $parts[1] ?? '';
                    $isLast = ($idx == count($sc['pcb_challenges']) - 1);
                ?>
                <div class="t-grid-body" style="grid-template-columns: 1fr 2fr; <?= $isLast ? 'border-bottom: none;' : 'border-bottom: 1px solid var(--border-light);' ?>">
                    <div class="t-b-col" style="font-weight:700; color:var(--navy); border-right: 1px solid var(--border-light);"><?= trim($area) ?></div>
                    <div class="t-b-col" style="color:var(--text-mid);"><?= trim($detail) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Frameworks Applied Section -->
            <?php if (!empty($sc['frameworks_applied'])) : ?>
            <h3 class="port-sect-title" style="text-align:center; margin-top:80px;" data-aos="fade-up">Circuit Brilliance <span>Frameworks Applied</span></h3>
            
            <div class="framework-badge-strip" data-aos="fade-up">
                <?php foreach ($sc['frameworks_applied'] as $fa) : 
                    $parts = explode(':', $fa);
                    $badge = $parts[0] ?? '';
                ?>
                <span class="bad-f"><?= trim($badge) ?></span>
                <?php endforeach; ?>
            </div>

            <div class="framework-app-grid mb-5" data-aos="fade-up">
                <?php foreach ($sc['frameworks_applied'] as $fa) : 
                    $parts = explode(':', $fa);
                    $title = $parts[0] ?? '';
                    $desc = $parts[1] ?? '';
                ?>
                <div class="framework-app-card">
                    <div class="fa-card-title"><?= trim($title) ?> <span>Verified</span></div>
                    <p class="fa-card-desc"><?= trim($desc) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Design Deliverables -->
            <?php if (!empty($sc['design_deliverables'])) : ?>
            <div class="port-hl-list bg-white" style="padding: 40px; border-radius: 20px; border: 1px solid var(--border-light); margin-top: 60px;" data-aos="fade-up">
                <h3 class="port-sect-title" style="margin-top: 0;">Full Design Deliverables</h3>
                <?php foreach ($sc['design_deliverables'] as $del) : 
                    // Parse: Icon || Title : Value
                    $iconPart = '';
                    $restPart = $del;
                    if (strpos($del, '||') !== false) {
                        $parts = explode('||', $del);
                        $iconPart = trim($parts[0]);
                        $restPart = trim($parts[1]);
                    }

                    $parts = explode(':', $restPart);
                    $item = $parts[0] ?? '';
                    $desc = $parts[1] ?? '';
                    
                    // Fallback icons if no custom icon provided
                    $icon = $iconPart ?: 'fas fa-file-contract';
                    if (!$iconPart) {
                        if (stripos($item, 'Schematic') !== false) $icon = 'fas fa-file-contract';
                        if (stripos($item, 'Simulation') !== false) $icon = 'fas fa-chart-line';
                        if (stripos($item, 'PCB') !== false) $icon = 'fas fa-microchip';
                        if (stripos($item, 'Documentation') !== false) $icon = 'fas fa-book';
                    }
                ?>
                <div class="port-hl-item">
                    <i class="<?= $icon ?>" style="color: var(--blue);"></i>
                    <p><strong><?= trim($item) ?></strong> <?= !empty($desc) ? ': ' . trim($desc) : '' ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endforeach; ?>
<?php endif; ?>

<!-- ════════════════ PLANNED SHOWCASE DESIGNS (DYNAMIC) ════════════════ -->
<?php if (!empty($planned_showcases) && (!isset($planned_intro) || $planned_intro['status'] == 1)) : ?>
<section class="sec-padding" style="background:#f8fafc;padding-top:0!important;" id="planned">
    <div class="container">
        <div class="text-center" style="margin-bottom:60px;" data-aos="fade-up">
            <h2 class="sec-h"><?= $planned_intro['web_content_1'] ?? 'Planned <span>Showcase Designs</span>' ?></h2>
            <p class="sec-sub"><?= $planned_intro['web_content_2'] ?? 'Demonstrating full domain breadth — these designs are currently in preparation to showcase our complete engineering capability across the power electronics landscape.' ?></p>
        </div>

        <div class="planned-showcase-stack">
            <?php foreach ($planned_showcases as $ps) : ?>
            <div class="planned-card <?= $ps['theme_class'] ?>" data-aos="fade-up" id="<?= $ps['anchor_id'] ?>">
                <div class="pc-content">
                    <div class="pc-tag"><?= $ps['web_tag'] ?></div>
                    <h3 class="pc-title"><?= $ps['web_title'] ?></h3>
                    <p class="pc-tech"><?= $ps['web_tech_line'] ?></p>
                    <div class="pc-list">
                        <?= $ps['web_features'] ?>
                    </div>
                    <?php if (!empty($ps['web_footer'])) : ?>
                    <p class="pc-footer"><?= $ps['web_footer'] ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ════════════════ RECOGNISE YOUR DESIGN CHALLENGE HERE? (CTA) ════════════════ -->
<?php if (!empty($cta) && $cta['status'] == 1): ?>
<section class="cta-sec" id="contact-cta">
    <div class="container">
        <div class="cta-inner wow zoomIn">
            <h2 class="cta-h"><?= $cta['title'] ?></h2>
            <div class="cta-sub"><?= $cta['content'] ?></div>

            <a href="<?= base_url('contact') ?>" class="btn-cta">Start a Conversation →</a>

            <div class="cta-channels">
                <a href="<?= base_url('contact') ?>" class="cta-chan">
                    <div class="cc-icon"><i class="fa-solid fa-file-signature"></i></div>
                    <div class="cc-text">
                        <span>Contact Form</span>
                        <strong>Fill in our project inquiry form</strong>
                    </div>
                </a>
                
                <?php if (!empty($setting['user_email'])): ?>
                <a href="mailto:<?= esc($setting['user_email']) ?>" class="cta-chan">
                    <div class="cc-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="cc-text">
                        <span>Email</span>
                        <strong><?= esc($setting['user_email']) ?></strong>
                    </div>
                </a>
                <?php endif; ?>

                <a href="<?= base_url('frameworks') ?>" class="cta-chan">
                    <div class="cc-icon"><i class="fa-solid fa-microchip"></i></div>
                    <div class="cc-text">
                        <span>Explore Frameworks</span>
                        <strong>See our design frameworks</strong>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'common/footer.php'; ?>