<?php
$content = $frameworks_content['fmea'] ?? [];
?>
<div class="p-30 bg-white">
    <form class="framework-content-form">
        <input type="hidden" name="framework_slug" value="fmea">
        <h4 class="mb-20 text-primary">CB-FMEA Configuration</h4>
        
        <h5 class="mt-4 border-bottom pb-2">Hero Text & Navigation</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Navigation Button Label</label>
                    <input type="text" name="fmea_nav_label" class="form-control" value="<?= htmlspecialchars($content['fmea_nav_label'] ?? 'CB-FMEA') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Section Tagline</label>
                    <input type="text" name="fmea_tagline" class="form-control" value="<?= htmlspecialchars($content['fmea_tagline'] ?? 'CB-FMEA: Failure Mode & Effects Analysis') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Normal Text)</label>
                    <input type="text" name="fmea_heading_1" class="form-control" value="<?= htmlspecialchars($content['fmea_heading_1'] ?? 'Failure Mode &') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Span Text)</label>
                    <input type="text" name="fmea_heading_2" class="form-control" value="<?= htmlspecialchars($content['fmea_heading_2'] ?? 'Effects Analysis') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Quote</label>
                    <input type="text" name="fmea_quote" class="form-control" value="<?= htmlspecialchars($content['fmea_quote'] ?? 'Generic FMEA finds generic failures. CB-FMEA finds the ones that take down your board.') ?>">
                </div>
                <div class="form-group">
                    <label class="fw-bold">Description Paragraph</label>
                    <textarea name="fmea_desc" class="form-control" rows="3"><?= htmlspecialchars($content['fmea_desc'] ?? 'Two-tier, power-electronics-specific FMEA framework. Tier 1 maps failure propagation paths across the full system. Tier 2 scores failure mode severity at component level.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Doughnut Chart Values</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Chart Labels (Comma separated)</label>
                    <input type="text" name="fmea_chart_labels" class="form-control" value="<?= htmlspecialchars($content['fmea_chart_labels'] ?? 'Critical, High, Medium, Mitigated') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Risk Distribution (Comma separated)</label>
                    <input type="text" name="fmea_chart_data" class="form-control" value="<?= htmlspecialchars($content['fmea_chart_data'] ?? '8, 14, 21, 11') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Tiers</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Tier 1 Title</label>
                    <input type="text" name="fmea_tier1_title" class="form-control mb-2" value="<?= htmlspecialchars($content['fmea_tier1_title'] ?? 'TIER 1 — System-Level Failure Mapping') ?>">
                    <label class="fw-bold">Tier 1 Description</label>
                    <textarea name="fmea_tier1_desc" class="form-control" rows="2"><?= htmlspecialchars($content['fmea_tier1_desc'] ?? 'Maps failure propagation paths across topology, gate driver chain, isolation barriers, and protection logic.') ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Tier 2 Title</label>
                    <input type="text" name="fmea_tier2_title" class="form-control mb-2" value="<?= htmlspecialchars($content['fmea_tier2_title'] ?? 'TIER 2 — Component-Level Analysis') ?>">
                    <label class="fw-bold">Tier 2 Description</label>
                    <textarea name="fmea_tier2_desc" class="form-control" rows="2"><?= htmlspecialchars($content['fmea_tier2_desc'] ?? 'SOD scores and RPN rankings calibrated to switching frequency, voltage class, and thermal profile.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Deliverables</h5>
        <div class="form-group">
            <input type="text" name="fmea_deliv_1" class="form-control mb-2" value="<?= htmlspecialchars($content['fmea_deliv_1'] ?? 'System-level failure propagation map (Tier 1)') ?>">
            <input type="text" name="fmea_deliv_2" class="form-control mb-2" value="<?= htmlspecialchars($content['fmea_deliv_2'] ?? 'Component-level risk register (Tier 2) — SOD scores and RPN rankings') ?>">
            <input type="text" name="fmea_deliv_3" class="form-control mb-2" value="<?= htmlspecialchars($content['fmea_deliv_3'] ?? 'Structured report for design reviews and audits') ?>">
        </div>

        <div class="text-end mt-20">
            <button type="button" class="btn btn-primary save-framework-btn">Save CB-FMEA Content</button>
        </div>
    </form>
</div>
