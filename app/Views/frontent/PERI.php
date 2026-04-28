<?php include('common/header.php'); ?>



<main class="inner-page-light">
    <!-- ════════════════ INNER BANNER ════════════════ -->
    <section class="inner-banner">
        <div class="ib-content container">
            <h1 class="ib-title">Power Electronics Research Institute</h1>
            <p class="page-subtitle">Academic Wing of Circuit Brilliance</p>
        </div>
    </section>

    <!-- ════════════════ HERO / INTRO SECTION ════════════════ -->
    <?php if(!isset($peri_intro) || $peri_intro['status'] == 1): ?>
    <section class="hero-l">
        <div class="container text-center">
            <div style="max-width: 900px; margin: 0 auto;">
               
                <p class="l-sub animate__animated animate__fadeInUp animate__delay-1s mx-auto"
                    style="margin-bottom: 25px;">
                    <?= $peri_intro['web_content_2'] ?? 'PERI exists at the intersection of rigorous engineering practice and structured knowledge development. Where Circuit Brilliance applies domain expertise to client design engagements, PERI directs that same expertise in two directions — toward developing engineers who are genuinely ready for industry, and toward advancing power electronics knowledge through research, publication, and academic collaboration.' ?>
                </p>
                <!-- Status Badge -->
                <?php if(!empty($peri_intro['web_content_3'])): ?>
                <div class="animate__animated animate__fadeInUp animate__delay-2s d-flex justify-content-center"
                    style="margin-top: 35px;">
                    <span class="peri-status-badge">
                        <span class="peri-pulse-dot"></span>
                        <?= $peri_intro['web_content_3'] ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ════════════════ NAVIGATION ANCHORS SECTION ════════════════ -->
    <?php if(!empty($peri_anchors)): ?>
    <section class="anchor-nav-boxes sec-padding"
        style="background: var(--light-bg); position: relative; z-index: 10; margin-top: -40px; border-radius: 40px 40px 0 0;">
        <div class="container">
            <div class="cb-cards-grid">
                <?php foreach($peri_anchors as $index => $anchor): ?>
                <!-- Anchor <?= $index + 1 ?> -->
                <div data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                    <div class="intro-anchor-card">
                        <h4 style="color: var(--navy); font-weight: 800; font-size: 1.25rem; margin-bottom: 12px;"><?= $anchor['title'] ?></h4>
                        <p style="color: var(--text-mid); font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                            <?= $anchor['description'] ?></p>
                        <a href="<?= $anchor['anchor_link'] ?>"><?= $anchor['anchor_text'] ?></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ════════════════ STUDENTS & GRADUATES SECTION ════════════════ -->
    <?php if(!empty($peri_training) && $peri_training['status'] == 1): ?>
    <section class="sec-padding bg-white" id="training">
        <div class="container">
            <h2 class="sec-h center" data-aos="fade-up"> <?= str_replace(['For Students', '& Graduates'], ['For Students', '<span>& Graduates</span>'], $peri_training['web_content_1']) ?></h2>

            <div class="two-col-grid peri-overlap-grid" style="align-items: center; gap: 60px;">
                <div data-aos="fade-right">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <span style="width: 40px; height: 2px; background: var(--blue); display: inline-block;"></span>
                        <h3 style="color: var(--navy); font-size: 1.8rem; font-family: 'Outfit', sans-serif; font-weight: 800; margin: 0; letter-spacing: 1px;">
                            <?= $peri_training['web_content_2'] ?></h3>
                    </div>

                    <div style="position: relative; padding-left: 25px; border-left: 3px solid rgba(11,95,190,0.2);">
                        <p style="color: var(--text-mid); font-size: 1.15rem; line-height: 1.8; margin-bottom: 20px;">
                            <?= $peri_training['web_content_3'] ?>
                        </p>
                        <p style="color: var(--navy); font-size: 1.15rem; line-height: 1.8; font-weight: 600; margin-bottom: 20px; background: rgba(11,95,190,0.04); padding: 15px 20px; border-radius: 8px;">
                            <?= $peri_training['web_content_4'] ?>
                        </p>
                        <p style="color: var(--text-mid); font-size: 1.15rem; line-height: 1.8; font-style: italic; margin-bottom: 30px;">
                            <?= $peri_training['web_content_5'] ?>
                        </p>
                    </div>

                    <p class="sec-sub center" style="color: var(--blue);font-size: 1.2rem; font-weight: 700; margin-bottom: 50px;">
                        That student is a PERI graduate
                    </p>
                </div>

                <div data-aos="fade-left">
                    <div style="position: relative;">
                        <div style="border-radius: 24px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.08);">
                            <?php 
                                $img_path = !empty($peri_training['web_image_1']) ? 'images/content/'.$peri_training['web_image_1'] : 'assets/img/peri-interview.webp';
                            ?>
                            <img src="<?= base_url($img_path) ?>"
                                alt="Circuit Brilliance Specialist Design and Services — PERI Training Recruitment Scene"
                                style="width: 100%; display: block; transform: scale(1.05); transition: transform 0.5s ease;"
                                onmouseover="this.style.transform='scale(1)'"
                                onmouseout="this.style.transform='scale(1.05)'" loading="lazy" width="1024" height="1024">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="peri-stats-static wow fadeInUp" data-wow-delay="0.2s">
                <div class="peri-stats-static-grid">
                    <?php 
                    $stats = json_decode($peri_training['web_content_8'] ?? '[]', true);
                    if(empty($stats)) {
                        $stats = [
                            ['num' => '40', 'text' => 'Students interviewed, same generic result'],
                            ['num' => '1', 'text' => 'Student who stood apart with real design instinct'],
                            ['badge' => 'DAY 1', 'text' => 'Ready to contribute, what recruiters actually want']
                        ];
                    }
                    foreach($stats as $st): ?>
                    <div class="peri-static-card highlighted assurance-card">
                        <?php if(isset($st['num'])): ?>
                            <div class="peri-stat-num highlighted assurance-num" data-target="<?= $st['num'] ?>"><?= $st['num'] ?></div>
                        <?php else: ?>
                            <div class="peri-stat-badge"><?= $st['badge'] ?></div>
                        <?php endif; ?>
                        <div class="peri-stat-text highlighted"><?= $st['text'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Programme Intro -->
            <div class="peri-intro-block" data-aos="fade-up" style="text-align: center;">
                <h3 class="sec-h center" style="font-size: clamp(24px, 3vw, 36px); margin-bottom: 20px;"><?= $peri_training['web_content_6'] ?></h3>
                <p style="color: var(--text-mid); font-size: 1.15rem; max-width: 900px; margin: 0 auto; line-height: 1.8;">
                    <?= $peri_training['web_content_7'] ?>
                </p>

                <?php 
                $meta = json_decode($peri_training['web_content_9'] ?? '[]', true);
                if(empty($meta)) {
                    $meta = [
                        ['icon' => 'fa-clock', 'text' => 'Duration: 3 months'],
                        ['icon' => 'fa-laptop', 'text' => 'Online delivery'],
                        ['icon' => 'fa-calendar-alt', 'text' => 'Weekend + weekday sessions'],
                        ['icon' => 'fa-medal', 'text' => 'Outcome: Certificate + shareable digital badge + portfolio-ready project', 'full' => true]
                    ];
                }
                ?>
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; margin: 30px 0;">
                    <?php foreach(array_slice($meta, 0, 3) as $m): ?>
                    <div style="background: var(--light-bg); border: 1px solid var(--border-light); padding: 10px 20px; border-radius: 50px; font-weight: 700; color: var(--navy); font-size: 0.95rem;">
                        <i class="fa-solid <?= $m['icon'] ?> text-primary"></i> <span style="margin-left: 5px;">
                            <?php if(!empty($m['name'])): ?>
                                <span style="color: var(--blue);"><?= $m['name'] ?>:</span>
                            <?php endif; ?>
                            <?= $m['text'] ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if(isset($meta[3])): ?>
                <div style="display: inline-flex; align-items: center; background: rgba(40,167,69,0.05); border: 1px solid rgba(40,167,69,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 700; color: #1e7e34;">
                    <i class="fa-solid <?= $meta[3]['icon'] ?>" style="font-size: 1.2rem; margin-right: 10px;"></i> 
                    <?php if(!empty($meta[3]['name'])): ?>
                        <span style="opacity: 0.8;"><?= $meta[3]['name'] ?>:</span>
                    <?php endif; ?>
                    <?= $meta[3]['text'] ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Tables Section -->
            <div class="tech-table-grid two-cols" style="border-top: 5px solid var(--blue); margin-top: 50px;" data-aos="fade-up">
                <div class="t-grid-header">
                    <div class="t-h-col"><i class="fa-solid fa-book-open"></i> What Students Learn</div>
                    <div class="t-h-col"><i class="fa-solid fa-screwdriver-wrench"></i> Tools Used</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col">
                        <ul class="t-list">
                            <?php 
                            $learn = json_decode($peri_training['web_content_10'] ?? '[]', true);
                            if(!empty($learn)):
                                foreach($learn as $l): ?>
                                    <li><?= $l ?></li>
                                <?php endforeach; 
                            else: ?>
                                <li>No Data Available</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="t-b-col">
                        <ul class="t-list">
                            <?php 
                            $tools = json_decode($peri_training['web_content_11'] ?? '[]', true);
                            if(!empty($tools)):
                                foreach($tools as $t): ?>
                                    <li><strong style="color: var(--navy);"><?= $t['name'] ?></strong> — <?= $t['desc'] ?></li>
                                <?php endforeach;
                            else: ?>
                                <li>No Data Available</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div data-aos="zoom-in" style="text-align: center; margin-top: 10px;">
                <h4 style="color: var(--navy); font-weight: 800; font-size: clamp(20px, 2.5vw, 28px); margin-bottom: 50px; font-family: 'Outfit', sans-serif;">
                    <?= $peri_training['web_content_12'] ?: 'AI teaches you what to say. <span style="color: var(--blue);">PERI teaches you what to know</span>' ?>
                </h4>
            </div>

            <div class="tech-table-grid two-cols" style="border-top: 5px solid #A94442; margin-top: 20px;" data-aos="fade-up">
                <div class="t-grid-header">
                    <div class="t-h-col" style="color: #A94442;"><i class="fa-solid fa-robot"></i> What AI Can Do</div>
                    <div class="t-h-col" style="color: #28a745;"><i class="fa-solid fa-user-check"></i> What AI Cannot Do</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col" style="background: rgba(169, 68, 66, 0.02);">
                        <ul class="t-list">
                            <?php 
                            $ai_can = json_decode($peri_training['web_content_13'] ?? '[]', true);
                            if(!empty($ai_can)):
                                foreach($ai_can as $item): ?>
                                    <li><?= $item ?></li>
                                <?php endforeach;
                            else: ?>
                               <li>No Data Available</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="t-b-col" style="background: rgba(40, 167, 69, 0.02);">
                        <ul class="t-list">
                            <?php 
                            $ai_cannot = json_decode($peri_training['web_content_14'] ?? '[]', true);
                            if(!empty($ai_cannot)):
                                foreach($ai_cannot as $item): ?>
                                    <li><?= $item ?></li>
                                <?php endforeach;
                            else: ?>
                                <li>No Data Available</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <p style="text-align: center; margin-top: 25px; color: #6c757d; font-style: italic; font-size: 0.95rem;">
                <?= $peri_training['web_content_15'] ?: 'No Data Available' ?>
            </p>
        </div>
    </section>
    <?php endif; ?>

    <!-- ════════════════ PERI RESEARCH SECTION ════════════════ -->
    <?php if(!empty($peri_research)): ?>
    <section class="sec-padding" style="background: var(--light-bg); border-top: 1px solid var(--border-light);"
        id="research">
        <div class="container">
            <div class="two-col-grid" style="align-items: center;">
                <div data-aos="fade-right">
                    <div style="border-radius: 24px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.08);">
                        <img src="<?= base_url('images/content/' . ($peri_research['web_image_1'] ?: 'PERI_p1.webp')) ?>"
                            alt="Circuit Brilliance Specialist Design and Services — Engineering Research Lab"
                            style="width: 100%; display: block; transform: scale(1.05); transition: transform 0.5s ease;"
                            onmouseover="this.style.transform='scale(1)'"
                            onmouseout="this.style.transform='scale(1.05)'" loading="lazy" width="1200" height="800">
                    </div>
                </div>
                <div data-aos="fade-left">
                    <h2 class="sec-h" data-aos="fade-up" style="text-align: left; margin-bottom: 5px;"> 
                        <?= $peri_research['web_content_1'] ?: 'For Institutions , Universities <span>and Industry Partners</span>' ?>
                    </h2>
                    <p style="color: var(--text-mid); font-size: 1.15rem; line-height: 1.8;">
                        <?= $peri_research['web_content_2'] ?: 'PERI is the structured research and academic collaboration arm of Circuit Brilliance. It provides the environment through which Circuit Brilliance\'s proprietary analytical frameworks are academically validated, where technical whitepapers and research notes are developed and published, and where partnerships with university power electronics departments are established and grown.' ?>
                    </p>
                </div>
            </div>

            <!-- Research 4 Pillars -->
            <div class="two-col-grid mt-5" style="gap: 30px; align-items: stretch;">
                <?php 
                $pillars = json_decode($peri_research['web_content_3'] ?? '[]', true);
                if(empty($pillars)) {
                    $pillars = [
                        ['num' => '01', 'name' => 'Research & Framework Validation', 'text' => 'Academically validates Circuit Brilliance\'s six proprietary frameworks across real power electronics design scenarios.'],
                        ['num' => '02', 'name' => 'Technical Publications', 'text' => 'Publishes whitepapers and research notes grounded in 18 years of real engineering experience — written for practising engineers.'],
                        ['num' => '03', 'name' => 'University Collaboration', 'text' => 'Research partnerships with power electronics departments — joint research, knowledge exchange, and co-publication.'],
                        ['num' => '04', 'name' => 'Engineer Development', 'text' => 'Structured training programmes developing engineers from graduate fundamentals to advanced SiC/GaN, magnetics, and EMI.']
                    ];
                }
                foreach($pillars as $index => $p): ?>
                <div class="belief-item" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>"
                    style="background: #fff; border: 1px solid var(--border-light); padding: 40px 35px; border-radius: 20px; position: relative; overflow: hidden;">
                    <h4 style="color: var(--navy); font-weight: 800; font-size: 1.25rem; margin-bottom: 15px; position: relative; z-index: 2;">
                        <?= $p['num'] ?> <?= $p['name'] ?></h4>
                    <p style="color: var(--text-mid); margin: 0; line-height: 1.6; position: relative; z-index: 2; font-size: 0.95rem;">
                        <?= $p['text'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <div data-aos="zoom-in"
                style="text-align: center; margin-top: 50px; padding: 30px; border-radius: 12px; background: #fff; border: 1px solid rgba(11,95,190,0.15); box-shadow: 0 10px 30px rgba(11,95,190,0.04);">
                <p
                    style="color: var(--navy); font-weight: 600; font-size: 1.1rem; margin: 0; max-width: 900px; margin-left: auto; margin-right: auto;">
                    <i class="fa-solid fa-handshake" style="color: var(--blue); margin-right: 10px;"></i> 
                    <?= $peri_research['web_content_4'] ?: 'Interested in collaborating with PERI? We welcome conversations with university research groups, industry partners, and institutions at any stage of interest.' ?>
                </p>
            </div>
        </div>
    </section>

    <!-- ════════════════ THE PERI DIFFERENCE ════════════════ -->
    <section class="sec-padding bg-white" id="institutions">
        <div class="container" style="text-align: center;">

            <!-- Table 3: The PERI Difference (Modern Grid) -->
            <div class="tech-table-grid two-cols"
                style="border-top: 5px solid var(--blue); margin-top: 0px; text-align: left;" data-aos="fade-up">
                <div class="t-grid-header">
                    <div class="t-h-col"><i class="fa-solid fa-book"></i> <?= $peri_research['web_content_5'] ?: 'Conventional Engineering Education' ?></div>
                    <div class="t-h-col" style="color: var(--blue);"><i class="fa-solid fa-star"></i> <?= $peri_research['web_content_6'] ?: 'The PERI Approach' ?></div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col" style="background: rgba(10, 37, 64, 0.02);">
                        <ul class="t-list">
                            <?php 
                            $diff1 = json_decode($peri_research['web_content_7'] ?? '[]', true);
                            if(empty($diff1)) {
                                $diff1 = ["Chapter-by-chapter theory — without design context", "Concepts delivered before the design demands them", "Simulation only — no real design workflow", "No exposure to professional EDA tools", "Assessment by examination — not by doing", "Resume skills that are never actually practised"];
                            }
                            foreach($diff1 as $item): ?>
                                <li><?= $item ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="t-b-col" style="background: rgba(11, 95, 190, 0.03);">
                        <ul class="t-list">
                            <?php 
                            $diff2 = json_decode($peri_research['web_content_8'] ?? '[]', true);
                            if(empty($diff2)) {
                                $diff2 = ["Built around a real power electronics product development journey", "Every concept introduced when the design actually needs it", "Real design workflow — tools, trade-offs, and fabrication outputs", "Altium Designer, LTSpice, HyperLynx, Ansys Q3D — industry standard", "Assessment by project delivery and demonstration", "Every skill listed is a skill practised. Every project is real."];
                            }
                            foreach($diff2 as $item): ?>
                                <li><?= $item ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pull Quote Finale -->
            <div data-aos="zoom-in"
                style="margin-top: 60px; background: url('assets/img/hero.webp') center/cover no-repeat; border-radius: 24px; position: relative; overflow: hidden; padding: 60px 40px;">
                <div style="position: absolute; inset: 0; background: rgba(10,37,64,0.9); z-index: 1;"></div>
                <blockquote
                    style="font-family: 'Outfit', sans-serif; font-size: clamp(20px, 3vw, 32px); color: #fff; line-height: 1.5; font-weight: 300; max-width: 900px; margin: 0 auto; position: relative; z-index: 2;">
                    <i class="fa-solid fa-quote-left"
                        style="font-size: 2rem; color: var(--blue); opacity: 0.5; margin-bottom: 20px;"></i><br>
                    <?= $peri_research['web_content_9'] ?: '"A PERI student does not walk into a placement interview as a fresher. He walks in as an engineer who has not yet received his first payslip."' ?>
                </blockquote>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ════════════════ CONTACT CTA (ACTION CARDS) ════════════════ -->
    <section class="sec-padding" style="padding: 60px 0;
    background: linear-gradient(145deg, #1a5276 0%, #0c2b42 100%);
    position: relative;
    overflow: hidden;">
        <div class="container">
            
            <div
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; max-width: 1100px; margin: 0 auto;">
                <?php if(!empty($peri_ctas)): 
                    foreach($peri_ctas as $index => $cta): ?>
                <!-- Card <?= $index + 1 ?> -->
                <a href="<?= $cta['link'] ?>"
                    style="background: #fff; border: 1px solid var(--border-light); border-left: 4px solid <?= $cta['theme_color'] ?>; border-radius: 12px; padding: 25px; text-decoration: none; color: var(--navy); box-shadow: 0 4px 12px rgba(0,0,0,0.03); transition: all 0.3s ease; display: flex; flex-direction: column; align-items: flex-start;"
                    data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>" class="peri-cta-card">
                    <div
                        style="width: 45px; height: 45px; background: rgba(11,95,190,0.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: <?= $cta['theme_color'] ?>; margin-bottom: 15px; transition: all 0.3s ease;">
                        <i class="fa-solid <?= $cta['icon'] ?>"></i></div>
                    <h3
                        style="font-size: 1.05rem; font-weight: 700; color: var(--navy); margin-bottom: 8px; margin-top: 0;">
                        <?= $cta['title'] ?></h3>
                    <p style="font-size: 0.9rem; color: var(--text-mid); margin: 0 0 15px 0; flex-grow: 1;"><?= $cta['description'] ?></p>
                    <span
                        style="color: <?= $cta['theme_color'] ?>; font-weight: 600; font-size: 0.95rem; transition: all 0.3s ease;"><?= $cta['link_text'] ?></span>
                </a>
                <?php endforeach; 
                endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include('common/footer.php'); ?>