<?php include('common/header.php'); ?>
<?php
$scc = $frameworks_content['scc'] ?? [];
$thermal = $frameworks_content['thermal'] ?? [];
$lbf = $frameworks_content['lbf'] ?? [];
$gaf = $frameworks_content['gaf'] ?? [];
$fmea = $frameworks_content['fmea'] ?? [];
$craft = $frameworks_content['craft'] ?? [];
?>

<style>
    /* 
     CHART DESIGN OVERRIDES & THEMING (From Reference HTML) 
     Using 'Barlow Condensed' and 'Outfit' for that industrial-premium feel.
  */
    @font-face {
        font-family: 'Barlow Condensed';
        src: url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700&display=swap');
    }

    .chart-block {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        margin: 30px auto;
        max-width: 600px;
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .chart-block.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .chart-label {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 3px;
        /* text-transform: uppercase; */
        color: #64748b;
        margin-bottom: 20px;
        font-weight: 700;
    }

    canvas {
        display: block;
        width: 100% !important;
        height: auto !important;
    }

    /* Animated Counters */
    .counter-row {
        display: flex;
        gap: 32px;
        justify-content: center;
        margin-top: 32px;
        flex-wrap: wrap;
    }

    .counter-num {
        font-family: 'Outfit', sans-serif;
        font-size: 38px;
        line-height: 1;
        font-weight: 800;
        color: var(--navy);
    }

    .counter-sub {
        font-family: 'Barlow Condensed', sans-serif;
        font-size: 11px;
        letter-spacing: 2px;
        /* text-transform: uppercase; */
        color: #64748b;
        margin-top: 6px;
        font-weight: 600;
    }

    /* CB-SCC Green */
    .c-scc {
        color: #008d61 !important;
    }

    /* CB-Thermal Pink */
    .c-thermal {
        color: #FF4DB8 !important;
    }

    /* CB-LBF Orange */
    .c-lbf {
        color: #FF6B35 !important;
    }

    /* CB-GAF Violet */
    .c-gaf {
        color: #A855F7 !important;
    }

    /* CB-FMEA Blue */
    .c-fmea {
        color: #0077B6 !important;
    }


    /* CRAFT Stages */
    .stage-card {
        background: #fff;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        height: 100%;
        transition: transform 0.3s ease;
    }

    .stage-card:hover {
        transform: translateY(-5px);
    }

    .stage-num {
        width: 32px;
        height: 32px;
        background: #1B5E82;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 800;
        font-size: 13px;
        margin-bottom: 15px;
    }
</style>

<main class="inner-page-light">
    <!-- INNER BANNER -->
    <section class="inner-banner">
        <div class="ib-content container">
            <div class="ib-title">Proprietary Engineering Frameworks</div>
            <div class="">
                <p>Scientific Design Methodology</p>
            </div>
        </div>
    </section>

    <!-- HERO SECTION -->
    <section class="hero-l" style="background-image: url('assets/img/tech-bg.webp');">
        <div class="container text-center">
            <h1 class="l-h animate__animated animate__fadeInDown">Six Proprietary Analytical Pillars</h1>
            <p class="l-sub animate__animated animate__fadeInUp animate__delay-1s mx-auto" style="max-width: 900px;">
                Our design process is built on six independent analytical pillars — ensuring that every engineering
                decision is validated against international standards, physical phenomena, and failure mode libraries.
            </p>
        </div>
    </section>

    <!-- STICKY ANCHOR NAV -->
    <div class="anchor-nav-hp hide-mobile">
        <div class="container d-flex justify-content-center gap-3 flex-wrap">
            <a href="#scc" class="btn-hs px-4 py-3"><?= htmlspecialchars($scc['scc_nav_label'] ?? 'CB-SCC') ?></a>
            <a href="#thermal" class="btn-hs px-4 py-3"><?= htmlspecialchars($thermal['thermal_nav_label'] ?? 'CB-Thermal') ?></a>
            <a href="#lbf" class="btn-hs px-4 py-3"><?= htmlspecialchars($lbf['lbf_nav_label'] ?? 'CB-LBF') ?></a>
            <a href="#gaf" class="btn-hs px-4 py-3"><?= htmlspecialchars($gaf['gaf_nav_label'] ?? 'CB-GAF') ?></a>
            <a href="#fmea" class="btn-hs px-4 py-3"><?= htmlspecialchars($fmea['fmea_nav_label'] ?? 'CB-FMEA') ?></a>
            <a href="#craft" class="btn-hs px-4 py-3"><?= htmlspecialchars($craft['craft_nav_label'] ?? 'CB-CRAFT') ?></a>
        </div>
    </div>

    <!-- CB-SCC SECTION -->
    <section class="l-sec" id="scc">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="l-sec-eb" style="color: #008d61;"><i class="fa-solid fa-link me-2"></i> <?= htmlspecialchars($scc['scc_tagline'] ?? 'CB-SCC: Standards Compliance Checklist') ?></span>
                    <h2 class="l-sec-h"><?= htmlspecialchars($scc['scc_heading_1'] ?? 'Standards') ?> <span><?= htmlspecialchars($scc['scc_heading_2'] ?? 'Compliance Checklist') ?></span></h2>
                    <p class="d-block mb-3" style="font-style: italic; color: #555;">"<?= htmlspecialchars($scc['scc_quote'] ?? 'Find the compliance gap at the design stage — not at the certification stage.') ?>"</p>
                    <p class="l-p"><?= htmlspecialchars($scc['scc_desc'] ?? 'A structured audit framework evaluating PCB design and documentation against applicable international standards covering PCB design, insulation coordination, reliability prediction, and product safety. Clause-level traceability. Cross-standard conflict identification.') ?></p>
                </div>
                <div class="col-lg-6">
                    <div class="chart-block" id="scc-chart-block">
                        <div class="chart-label">CB-SCC | Compliance Coverage Evaluation</div>
                        <canvas id="sccChart"></canvas>
                        <div class="counter-row">
                            <div class="counter-item text-center">
                                <div class="counter-num c-scc" data-target="<?= htmlspecialchars($scc['scc_count1_target'] ?? '96') ?>" data-suffix="%">0%</div>
                                <div class="counter-sub"><?= htmlspecialchars($scc['scc_count1_label'] ?? 'Compliance Depth') ?></div>
                            </div>
                            <div class="counter-item text-center">
                                <div class="counter-num h4 fw-bold" data-target="<?= htmlspecialchars($scc['scc_count2_target'] ?? '100') ?>" data-suffix="%" style="color: #64748b;">0%</div>
                                <div class="counter-sub"><?= htmlspecialchars($scc['scc_count2_label'] ?? 'Traceability') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tech-table-grid" style="border-top: 5px solid #008d61;">
                <div class="t-grid-header">
                    <div class="t-h-col" style="grid-column: span 3; justify-content: center;">What the Client Receives</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col"><ul class="t-list"><li><?= htmlspecialchars($scc['scc_deliv_1'] ?? 'Compliance status across applicable international standards') ?></li></ul></div>
                    <div class="t-b-col"><ul class="t-list"><li><?= htmlspecialchars($scc['scc_deliv_2'] ?? 'Clause-level findings traceable to specific standard and section') ?></li></ul></div>
                    <div class="t-b-col"><ul class="t-list"><li><?= htmlspecialchars($scc['scc_deliv_3'] ?? 'Cross-standard conflict identification') ?></li></ul></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CB-THERMAL SECTION -->
    <section class="l-sec" id="thermal" style="background-color: #f8fafc;">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="l-sec-eb" style="color: #FF4DB8;"><i class="fa-solid fa-link me-2"></i> <?= htmlspecialchars($thermal['thermal_tagline'] ?? 'CB-Thermal: Thermal Analysis Framework') ?></span>
                    <h2 class="l-sec-h"><?= htmlspecialchars($thermal['thermal_heading_1'] ?? 'Thermal') ?> <span><?= htmlspecialchars($thermal['thermal_heading_2'] ?? 'Analysis Framework') ?></span></h2>
                    <p class="d-block mb-3" style="font-style: italic; color: #555;">"<?= htmlspecialchars($thermal['thermal_quote'] ?? 'Every degree above junction limit is a reliability debt — CB-Thermal finds it before it compounds.') ?>"</p>
                    <p class="l-p"><?= htmlspecialchars($thermal['thermal_desc'] ?? 'Complete junction-to-ambient thermal chain analysis. Maps every Rth node per heat-generating component. Identifies hotspot risks, validates thermal via arrays, estimates worst-case junction temperatures.') ?></p>
                </div>
                <div class="col-lg-6">
                    <div class="chart-block" id="thermal-chart-block">
                        <div class="chart-label">CB-Thermal | Junction-to-Ambient Chain °C</div>
                        <canvas id="thermalChart"></canvas>
                        <div class="counter-row">
                            <div class="counter-item text-center">
                                <div class="counter-num c-thermal" data-target="<?= htmlspecialchars($thermal['thermal_count1_target'] ?? '142') ?>" data-suffix="°C">0°C</div>
                                <div class="counter-sub"><?= htmlspecialchars($thermal['thermal_count1_label'] ?? 'Estimated Tj Max') ?></div>
                            </div>
                            <div class="counter-item text-center">
                                <div class="counter-num h4 fw-bold" data-target="<?= htmlspecialchars($thermal['thermal_count2_target'] ?? '5') ?>" data-suffix="" style="color: #64748b;">0</div>
                                <div class="counter-sub"><?= htmlspecialchars($thermal['thermal_count2_label'] ?? 'Thermal Nodes') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tech-table-grid" style="border-top: 5px solid #FF4DB8;">
                <div class="t-grid-header">
                    <div class="t-h-col" style="grid-column: span 3; justify-content: center;">What the Client Receives</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col"><div class="l-eb" style="font-size: 11px;"><?= htmlspecialchars($thermal['thermal_deliv_t1'] ?? 'Rth Chain Mapping') ?></div><ul class="t-list"><li><?= htmlspecialchars($thermal['thermal_deliv_d1'] ?? 'Full junction-to-ambient Rth chain per heat-generating component') ?></li></ul></div>
                    <div class="t-b-col"><div class="l-eb" style="font-size: 11px;"><?= htmlspecialchars($thermal['thermal_deliv_t2'] ?? 'Risk Assessment') ?></div><ul class="t-list"><li><?= htmlspecialchars($thermal['thermal_deliv_d2'] ?? 'Hotspot risk assessment — placement, copper spreading, power density') ?></li></ul></div>
                    <div class="t-b-col"><div class="l-eb" style="font-size: 11px;"><?= htmlspecialchars($thermal['thermal_deliv_t3'] ?? 'Simulation Data') ?></div><ul class="t-list"><li><?= htmlspecialchars($thermal['thermal_deliv_d3'] ?? 'Worst-case junction temperature estimates at full load and maximum ambient') ?></li></ul></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CB-LBF SECTION -->
    <section class="l-sec" id="lbf">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="l-sec-eb" style="color: #FF6B35;"><i class="fa-solid fa-link me-2"></i> <?= htmlspecialchars($lbf['lbf_tagline'] ?? 'CB-LBF: Loss Budget Framework') ?></span>
                    <h2 class="l-sec-h"><?= htmlspecialchars($lbf['lbf_heading_1'] ?? 'Loss') ?> <span><?= htmlspecialchars($lbf['lbf_heading_2'] ?? 'Budget Framework') ?></span></h2>
                    <p class="d-block mb-3" style="font-style: italic; color: #555;">"<?= htmlspecialchars($lbf['lbf_quote'] ?? 'Fight for the Fractions — efficiency is won or lost in the decimals.') ?>"</p>
                    <p class="l-p"><?= htmlspecialchars($lbf['lbf_desc'] ?? 'Full-spectrum loss analysis framework. Every watt of loss has an address — CB-LBF locates each one across conduction, switching, magnetics, gate drive, and PCB parasitics. Scanner Principle: no verdicts, pure visibility.') ?></p>
                </div>
                <div class="col-lg-6">
                    <div class="chart-block" id="lbf-chart-block">
                        <div class="chart-label">CB-LBF | Loss Mechanism Breakdown %</div>
                        <canvas id="lbfChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="tech-table-grid" style="border-top: 5px solid #FF6B35;">
                <div class="t-grid-header">
                    <div class="t-h-col" style="grid-column: span 3; justify-content: center;">What the Client Receives</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col"><ul class="t-list"><li><?= htmlspecialchars($lbf['lbf_deliv_1'] ?? 'Full-spectrum loss scan — every mechanism identified and quantified') ?></li></ul></div>
                    <div class="t-b-col"><ul class="t-list"><li><?= htmlspecialchars($lbf['lbf_deliv_2'] ?? 'Itemised loss register per mechanism and per operating point') ?></li></ul></div>
                    <div class="t-b-col"><ul class="t-list"><li><?= htmlspecialchars($lbf['lbf_deliv_3'] ?? 'Scanner Principle report — verdict-free, engineered for the team to act on') ?></li></ul></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CB-GAF SECTION -->
    <section class="l-sec" id="gaf" style="background-color: #f8fafc;">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="l-sec-eb" style="color: #A855F7;"><i class="fa-solid fa-link me-2"></i> <?= htmlspecialchars($gaf['gaf_tagline'] ?? 'CB-GAF: Gap Analysis Framework') ?></span>
                    <h2 class="l-sec-h"><?= htmlspecialchars($gaf['gaf_heading_1'] ?? 'Gap') ?> <span><?= htmlspecialchars($gaf['gaf_heading_2'] ?? 'Analysis Framework') ?></span></h2>
                    <p class="d-block mb-3" style="font-style: italic; color: #555;">"<?= htmlspecialchars($gaf['gaf_quote'] ?? 'Circuit Brilliance operates where the standards stop — and the engineering begins.') ?>"</p>
                    <p class="l-p"><?= htmlspecialchars($gaf['gaf_desc'] ?? 'Maps the boundary between auditable standards and 18 years of engineering judgement. Identifies physical phenomena that standards often miss across all four domains.') ?></p>
                </div>
                <div class="col-lg-6">
                    <div class="chart-block" id="gaf-chart-block">
                        <div class="chart-label">CB-GAF | Gap Type Intensity per Domain</div>
                        <canvas id="gafChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="tech-table-grid" style="border-top: 5px solid #A855F7;">
                <div class="t-grid-header">
                    <div class="t-h-col">Gap Type</div>
                    <div class="t-h-col" style="grid-column: span 2;">Description</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col" data-label="Gap Type"><strong><?= htmlspecialchars($gaf['gaf_gap1_title'] ?? 'GAP TYPE 1 — Invisible Phenomena') ?></strong></div>
                    <div class="t-b-col" data-label="Description" style="grid-column: span 2;"><?= htmlspecialchars($gaf['gaf_gap1_desc'] ?? 'Physical phenomena that cause real failures and are acknowledged by no standard.') ?></div>
                </div>
                <div class="t-grid-body" style="border-top: 1px solid #eee;">
                    <div class="t-b-col" data-label="Gap Type"><strong><?= htmlspecialchars($gaf['gaf_gap2_title'] ?? 'GAP TYPE 2 — Judgement Gaps') ?></strong></div>
                    <div class="t-b-col" data-label="Description" style="grid-column: span 2;"><?= htmlspecialchars($gaf['gaf_gap2_desc'] ?? 'Standard thresholds that cannot determine safety for a specific design\'s operating conditions.') ?></div>
                </div>
                <div class="t-grid-body" style="border-top: 1px solid #eee;">
                    <div class="t-b-col" data-label="Gap Type"><strong><?= htmlspecialchars($gaf['gaf_gap3_title'] ?? 'GAP TYPE 3 — Interaction Gaps') ?></strong></div>
                    <div class="t-b-col" data-label="Description" style="grid-column: span 2;"><?= htmlspecialchars($gaf['gaf_gap3_desc'] ?? 'Failure modes from combinations of individually compliant elements.') ?></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CB-FMEA SECTION -->
    <section class="l-sec" id="fmea">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <span class="l-sec-eb" style="color: #0077B6;"><i class="fa-solid fa-link me-2"></i> <?= htmlspecialchars($fmea['fmea_tagline'] ?? 'CB-FMEA: Failure Mode & Effects Analysis') ?></span>
                    <h2 class="l-sec-h"><?= htmlspecialchars($fmea['fmea_heading_1'] ?? 'Failure Mode &') ?> <span><?= htmlspecialchars($fmea['fmea_heading_2'] ?? 'Effects Analysis') ?></span></h2>
                    <p class="d-block mb-3" style="font-style: italic; color: #555;">"<?= htmlspecialchars($fmea['fmea_quote'] ?? 'Generic FMEA finds generic failures. CB-FMEA finds the ones that take down your board.') ?>"</p>
                    <p class="l-p"><?= htmlspecialchars($fmea['fmea_desc'] ?? 'Two-tier, power-electronics-specific FMEA framework. Tier 1 maps failure propagation paths across the full system. Tier 2 scores failure mode severity at component level.') ?></p>
                </div>
                <div class="col-lg-6">
                    <div class="chart-block" id="fmea-chart-block">
                        <div class="chart-label">CB-FMEA | Risk Distribution RPN</div>
                        <canvas id="fmeaChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="tech-table-grid" style="border-top: 5px solid #0077B6;">
                <div class="t-grid-body">
                    <div class="t-b-col" data-label="Analysis Tier"><strong><?= htmlspecialchars($fmea['fmea_tier1_title'] ?? 'TIER 1 — System-Level Failure Mapping') ?></strong></div>
                    <div class="t-b-col" data-label="Technical Scope" style="grid-column: span 2;"><?= htmlspecialchars($fmea['fmea_tier1_desc'] ?? 'Maps failure propagation paths across topology, gate driver chain, isolation barriers, and protection logic.') ?></div>
                </div>
                <div class="t-grid-body" style="border-top: 1px solid #eee;">
                    <div class="t-b-col" data-label="Analysis Tier"><strong><?= htmlspecialchars($fmea['fmea_tier2_title'] ?? 'TIER 2 — Component-Level Analysis') ?></strong></div>
                    <div class="t-b-col" data-label="Technical Scope" style="grid-column: span 2;"><?= htmlspecialchars($fmea['fmea_tier2_desc'] ?? 'SOD scores and RPN rankings calibrated to switching frequency, voltage class, and thermal profile.') ?></div>
                </div>
            </div>

            <div class="tech-table-grid mt-4" style="border-top: 5px solid #0077B6;">
                <div class="t-grid-header"><div class="t-h-col" style="grid-column: span 3; justify-content: center;">What the Client Receives</div></div>
                <div class="t-grid-body">
                    <div class="t-b-col" data-label="Deliverable 1"><ul class="t-list"><li><?= htmlspecialchars($fmea['fmea_deliv_1'] ?? 'System-level failure propagation map (Tier 1)') ?></li></ul></div>
                    <div class="t-b-col" data-label="Deliverable 2"><ul class="t-list"><li><?= htmlspecialchars($fmea['fmea_deliv_2'] ?? 'Component-level risk register (Tier 2) — SOD scores and RPN rankings') ?></li></ul></div>
                    <div class="t-b-col" data-label="Deliverable 3"><ul class="t-list"><li><?= htmlspecialchars($fmea['fmea_deliv_3'] ?? 'Structured report for design reviews and audits') ?></li></ul></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CB-CRAFT SECTION -->
    <section class="l-sec" id="craft" style="background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-7">
                    <span class="l-sec-eb" style="color: #1B5E82;"><i class="fa-solid fa-link me-2"></i> <?= htmlspecialchars($craft['craft_tagline'] ?? 'CB-CRAFT: Design Execution Framework') ?></span>
                    <h2 class="l-sec-h"><?= htmlspecialchars($craft['craft_heading_1'] ?? 'Comprehensive Review and') ?> <span><?= htmlspecialchars($craft['craft_heading_2'] ?? 'Assured Fabrication Technology') ?></span></h2>
                    <p class="d-block mb-3" style="font-style: italic; color: #555;">"<?= htmlspecialchars($craft['craft_quote'] ?? 'CB-CRAFT reflects the design as implemented. It does not pass or fail. It observes, records, and verifies.') ?>"</p>
                    <p class="l-p"><?= htmlspecialchars($craft['craft_desc'] ?? 'CB-CRAFT is Circuit Brilliance\'s PCB Design Execution Framework — the stage where every upstream framework output (SCC, LBF, Thermal, GAF, FMEA) converges into a verified, manufacturable PCB deliverable.') ?></p>
                </div>
            </div>

            <!-- NINE STAGE GRID - ROW WISE -->
            <div class="mb-5">
                <h3 class="l-eb text-center mb-5" style="color: #1B5E82; font-size: 14px; letter-spacing: 5px;">Nine-Stage Execution Flow</h3>
                
                <div class="tech-table-grid" style="border-top: 5px solid #1B5E82;">
                    <div class="t-grid-header">
                        <div class="t-h-col" style="justify-content: center;">Phase 1: Analysis</div>
                        <div class="t-h-col" style="justify-content: center;">Phase 2: Design</div>
                        <div class="t-h-col" style="justify-content: center;">Phase 3: Verification</div>
                    </div>
                    <div class="t-grid-body">
                        <!-- Row 1 -->
                        <div class="t-b-col" data-label="Phase 1: Analysis" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">01</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage1_title'] ?? 'Layout Intelligence Extraction') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage1_desc'] ?? 'Reading the schematic for layout-critical information.') ?></p>
                        </div>
                        <div class="t-b-col" data-label="Phase 2: Design" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">02</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage2_title'] ?? 'Layout-Specific Client Inputs') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage2_desc'] ?? 'Mechanical constraints, surface finish, layer budget.') ?></p>
                        </div>
                        <div class="t-b-col" data-label="Phase 3: Verification" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">03</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage3_title'] ?? 'Layer Stack & Design Rules') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage3_desc'] ?? 'Isolation, copper weight, and design rule implementation.') ?></p>
                        </div>
                    </div>
                    <div class="t-grid-body" style="border-top: 1px solid #eee;">
                        <!-- Row 2 -->
                        <div class="t-b-col" data-label="Phase 1: Analysis" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">04</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage4_title'] ?? 'Component Placement') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage4_desc'] ?? 'Switching loops, gate drive proximity, thermal zone compliance.') ?></p>
                        </div>
                        <div class="t-b-col" data-label="Phase 2: Design" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">05</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage5_title'] ?? 'Routing') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage5_desc'] ?? 'Power trace sizing, Kelvin sense routing, ground zone discipline.') ?></p>
                        </div>
                        <div class="t-b-col" data-label="Phase 3: Verification" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">06</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage6_title'] ?? 'DFM + DFA') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage6_desc'] ?? 'Design for Manufacturability and Assembly verification.') ?></p>
                        </div>
                    </div>
                    <div class="t-grid-body" style="border-top: 1px solid #eee;">
                        <!-- Row 3 -->
                        <div class="t-b-col" data-label="Phase 1: Analysis" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">07</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage7_title'] ?? 'DFT — Design for Testability') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage7_desc'] ?? 'Test points, programming access, serviceability.') ?></p>
                        </div>
                        <div class="t-b-col" data-label="Phase 2: Design" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">08</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage8_title'] ?? 'DFS — Design for Safety') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage8_desc'] ?? 'Creepage, clearance, isolation, safety marking.') ?></p>
                        </div>
                        <div class="t-b-col" data-label="Phase 3: Verification" style="padding: 20px;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-light text-dark p-2" style="font-size: 10px;">09</span>
                                <strong style="font-size: 13px;"><?= htmlspecialchars($craft['craft_stage9_title'] ?? 'Release for Prototyping') ?></strong>
                            </div>
                            <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_stage9_desc'] ?? 'Final package generation, ODB++, and manufacturing release.') ?></p>
                        </div>
                    </div>
                </div>
            </div>

<div class="col-lg-5" style="margin:1.5rem">
                    <div class="p-4 bg-white rounded-4 border shadow-sm text-center" style="margin:0 0 45px 0;">
                        <div class="l-eb text-center mb-2" style="color: #1B5E82; font-size: 14px; letter-spacing: 5px;">Framework Ecosystem Position</div>
                        <p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_ecosystem'] ?? 'CB-CRAFT does not determine requirements — it verifies their implementation. CB-SCC determines compliance requirements — CB-CRAFT checks the PCB delivers them. CB-LBF determines current values — CB-CRAFT sizes the copper to carry them. CB-Thermal determines thermal zones — CB-CRAFT verifies placement honours them.') ?></p> </div>
                </div>
            <div class="tech-table-grid" style="border-top: 5px solid #1B5E82;">
                
                <div class="t-grid-header">
                    <div class="t-h-col">Domain</div>
                    <div class="t-h-col" style="grid-column: span 2;">Specific Execution Focus</div>
                </div>
                <div class="t-grid-body">
                    <div class="t-b-col" data-label="Domain"><strong><?= htmlspecialchars($craft['craft_domain1_title'] ?? 'EV Powertrain') ?></strong></div><div class="t-b-col" data-label="Focus Focus" style="grid-column: span 2;"><?= htmlspecialchars($craft['craft_domain1_focus'] ?? 'HV isolation, SiC/GaN switching loops, HVIL, automotive DFx') ?></div>
                </div>
                <div class="t-grid-body" style="border-top: 1px solid #eee;">
                    <div class="t-b-col" data-label="Domain"><strong><?= htmlspecialchars($craft['craft_domain2_title'] ?? 'Battery Management') ?></strong></div><div class="t-b-col" data-label="Focus Focus" style="grid-column: span 2;"><?= htmlspecialchars($craft['craft_domain2_focus'] ?? 'AFE sense matching, stack voltage isolation, Kelvin routing') ?></div>
                </div>
                <div class="t-grid-body" style="border-top: 1px solid #eee;">
                    <div class="t-b-col" data-label="Domain"><strong><?= htmlspecialchars($craft['craft_domain3_title'] ?? 'Renewable Energy') ?></strong></div><div class="t-b-col" data-label="Focus Focus" style="grid-column: span 2;"><?= htmlspecialchars($craft['craft_domain3_focus'] ?? 'Common-mode loops, GFDI, outdoor creepage, LCL filter') ?></div>
                </div>
                <div class="t-grid-body" style="border-top: 1px solid #eee;">
                    <div class="t-b-col" data-label="Domain"><strong><?= htmlspecialchars($craft['craft_domain4_title'] ?? 'Power Converters & SMPS') ?></strong></div><div class="t-b-col" data-label="Focus Focus" style="grid-column: span 2;"><?= htmlspecialchars($craft['craft_domain4_focus'] ?? 'Primary switching loop, Y-cap placement, isolation slot') ?></div>
                </div>
            </div>

            <div class="tech-table-grid mt-4" style="border-top: 5px solid #1B5E82;">
                <div class="t-grid-header"><div class="t-h-col" style="grid-column: span 4; justify-content: center;">What the Client Receives</div></div>
                <div class="t-grid-body" style="grid-template-columns: repeat(4, 1fr);">
                    <div class="t-b-col" style="padding: 25px;"><strong style="color: var(--navy);"><?= htmlspecialchars($craft['craft_deliv1_title'] ?? 'CB-CRAFT Review Record') ?></strong><p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_deliv1_desc'] ?? 'every checkpoint reviewed across all nine stages, observations recorded') ?></p></div>
                    <div class="t-b-col" style="padding: 25px;"><strong style="color: var(--navy);"><?= htmlspecialchars($craft['craft_deliv2_title'] ?? 'Framework Summary Report') ?></strong><p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_deliv2_desc'] ?? 'one-page confirmation the design underwent CB-CRAFT review') ?></p></div>
                    <div class="t-b-col" style="padding: 25px;"><strong style="color: var(--navy);"><?= htmlspecialchars($craft['craft_deliv3_title'] ?? 'Design Rationale Note') ?></strong><p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_deliv3_desc'] ?? 'switching loop area, isolation strategy, copper weight rationale') ?></p></div>
                    <div class="t-b-col" style="padding: 25px;"><strong style="color: var(--navy);"><?= htmlspecialchars($craft['craft_deliv4_title'] ?? 'Gerber Package') ?></strong><p class="small text-muted mb-0"><?= htmlspecialchars($craft['craft_deliv4_desc'] ?? 'fabrication-ready files verified under CB-CRAFT before release') ?></p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT CTA -->
    <section class="cta-sec">
        <div class="container">
            <div class="cta-inner wow zoomIn">
                <h2 class="cta-h">Apply a Proprietary <span>Analytical Framework.</span></h2>
                <p class="cta-sub">Our analytical approach eliminates hardware guesswork and reduces revision cycles through rigorous physical validation at the design stage.</p>
                <div class="hero-btns mt-4">
                    <a href="contact.php#cbContactForm" class="btn-hp">Book a Scoping Call <i class="fa-solid fa-arrow-right"></i></a>
                    <a href="domain-service.php" class="btn-hs">Domain Expertise</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// ── Palette (From Reference)
const C = {
  accent:  '#00c2ff',
  warn:    '#ff6b35',
  green:   '#008d61',
  pink:    '#ff4db8',
  muted:   '#64748b',
  border:  '#e2e8f0',
  dark:    '#0f172a'
};

Chart.defaults.color = C.muted;
Chart.defaults.font.family = "'Outfit', sans-serif";

function animateCounter(el, target, suffix='', duration=1600) {
  let start = null;
  function step(ts) {
    if (!start) start = ts;
    const progress = Math.min((ts - start) / duration, 1);
    const ease = 1 - Math.pow(1 - progress, 3);
    el.textContent = Math.round(ease * target) + suffix;
    if (progress < 1) requestAnimationFrame(step);
  }
  requestAnimationFrame(step);
}

const chartData = {};
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      const id = entry.target.id;
      if (chartData[id] && !chartData[id].drawn) {
        chartData[id].draw();
        chartData[id].drawn = true;
      }
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.chart-block').forEach(el => observer.observe(el));

// 1. SCC - Radar
chartData['scc-chart-block'] = {
  drawn: false,
  draw() {
    new Chart(document.getElementById('sccChart'), {
      type: 'radar',
      data: {
        labels: '<?= htmlspecialchars($scc['scc_chart_labels'] ?? 'PCB Design, Insulation, Reliability, Safety, Conflict Check, Traceability') ?>'.split(',').map(s => s.trim()),
        datasets: [
          { label: 'Ad-Hoc', data: [<?= $scc['scc_chart_adhoc'] ?? '40, 30, 20, 35, 10, 25' ?>], backgroundColor: 'rgba(100,116,139,0.1)', borderColor: '#cbd5e1', borderWidth: 1 },
          { label: 'CB-SCC', data: [<?= $scc['scc_chart_cbscc'] ?? '95, 95, 90, 92, 88, 97' ?>], backgroundColor: 'rgba(0,255,176,0.1)', borderColor: C.green, borderWidth: 2 }
        ]
      },
      options: { aspectRatio: 1.3, maintainAspectRatio: true, scales: { r: { min: 0, max: 100, ticks: { display: false } } }, plugins: { legend: { position: 'bottom' } } }
    });
    document.querySelectorAll('#scc-chart-block .counter-num').forEach(el => animateCounter(el, parseInt(el.dataset.target), el.dataset.suffix));
  }
};

// 2. Thermal - Bar
chartData['thermal-chart-block'] = {
  drawn: false,
  draw() {
    new Chart(document.getElementById('thermalChart'), {
      type: 'bar',
      data: {
        labels: '<?= htmlspecialchars($thermal['thermal_chart_labels'] ?? 'Ambient, Heatsink, TIM, Case, Junction') ?>'.split(',').map(s => s.trim()),
        datasets: [{ label: 'Temp (°C)', data: [<?= $thermal['thermal_chart_data'] ?? '45, 68, 79, 98, 142' ?>], backgroundColor: C.pink, borderRadius: 10 }]
      },
      options: { aspectRatio: 1.5, maintainAspectRatio: true, plugins: { legend: { display: false } } }
    });
    document.querySelectorAll('#thermal-chart-block .counter-num').forEach(el => animateCounter(el, parseInt(el.dataset.target), el.dataset.suffix));
  }
};

// 3. LBF - Horizontal
chartData['lbf-chart-block'] = {
  drawn: false,
  draw() {
    new Chart(document.getElementById('lbfChart'), {
      type: 'bar',
      data: {
        labels: '<?= htmlspecialchars($lbf['lbf_chart_labels'] ?? 'Conduction, Switching, Core, Winding, Gate, Dead-Time, Parasitic') ?>'.split(',').map(s => s.trim()),
        datasets: [{ label: 'Loss Contribution (%)', data: [<?= $lbf['lbf_chart_data'] ?? '28.4, 22.1, 17.6, 13.8, 8.2, 6.1, 3.8' ?>], backgroundColor: C.warn, borderRadius: 8 }]
      },
      options: { aspectRatio: 1.8, maintainAspectRatio: true, indexAxis: 'y', plugins: { legend: { display: false } } }
    });
  }
};

// 4. GAF - Grouped
chartData['gaf-chart-block'] = {
  drawn: false,
  draw() {
    new Chart(document.getElementById('gafChart'), {
      type: 'bar',
      data: {
        labels: '<?= htmlspecialchars($gaf['gaf_chart_labels'] ?? 'EV, BMS, Renewable, Power') ?>'.split(',').map(s => s.trim()),
        datasets: [
          { label: '<?= htmlspecialchars($gaf['gaf_chart_type1_label'] ?? 'Type 1') ?>', data: [<?= $gaf['gaf_chart_type1'] ?? '12, 8, 10, 14' ?>], backgroundColor: C.gaf },
          { label: '<?= htmlspecialchars($gaf['gaf_chart_type2_label'] ?? 'Type 2') ?>', data: [<?= $gaf['gaf_chart_type2'] ?? '14, 12, 9, 8' ?>], backgroundColor: C.accent },
          { label: '<?= htmlspecialchars($gaf['gaf_chart_type3_label'] ?? 'Type 3') ?>', data: [<?= $gaf['gaf_chart_type3'] ?? '8, 10, 12, 6' ?>], backgroundColor: C.green }
        ]
      },
      options: { aspectRatio: 1.5, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } } }
    });
  }
};

// 5. FMEA - Donut
chartData['fmea-chart-block'] = {
  drawn: false,
  draw() {
    new Chart(document.getElementById('fmeaChart'), {
      type: 'doughnut',
      data: {
        labels: '<?= htmlspecialchars($fmea['fmea_chart_labels'] ?? 'Critical, High, Medium, Mitigated') ?>'.split(',').map(s => s.trim()),
        datasets: [{ data: [<?= $fmea['fmea_chart_data'] ?? '8, 14, 21, 11' ?>], backgroundColor: ['#ef4444', C.warn, C.accent, C.green], borderWidth: 0 }]
      },
      options: { aspectRatio: 1.5, maintainAspectRatio: true, cutout: '75%', plugins: { legend: { position: 'bottom' } } }
    });
  }
};
</script>

<?php include('common/footer.php'); ?>
