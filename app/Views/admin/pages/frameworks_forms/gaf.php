<?php
$content = $frameworks_content['gaf'] ?? [];
?>
<div class="p-30 bg-white">
    <form class="framework-content-form">
        <input type="hidden" name="framework_slug" value="gaf">
        <h4 class="mb-20 text-primary">CB-GAF Configuration</h4>
        
        <h5 class="mt-4 border-bottom pb-2">Hero Text & Navigation</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Navigation Button Label</label>
                    <input type="text" name="gaf_nav_label" class="form-control" value="<?= htmlspecialchars($content['gaf_nav_label'] ?? 'CB-GAF') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Section Tagline</label>
                    <input type="text" name="gaf_tagline" class="form-control" value="<?= htmlspecialchars($content['gaf_tagline'] ?? 'CB-GAF: Gap Analysis Framework') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Normal Text)</label>
                    <input type="text" name="gaf_heading_1" class="form-control" value="<?= htmlspecialchars($content['gaf_heading_1'] ?? 'Gap') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Span Text)</label>
                    <input type="text" name="gaf_heading_2" class="form-control" value="<?= htmlspecialchars($content['gaf_heading_2'] ?? 'Analysis Framework') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Quote</label>
                    <input type="text" name="gaf_quote" class="form-control" value="<?= htmlspecialchars($content['gaf_quote'] ?? 'Circuit Brilliance operates where the standards stop — and the engineering begins.') ?>">
                </div>
                <div class="form-group">
                    <label class="fw-bold">Description Paragraph</label>
                    <textarea name="gaf_desc" class="form-control" rows="3"><?= htmlspecialchars($content['gaf_desc'] ?? 'Maps the boundary between auditable standards and 18 years of engineering judgement. Identifies physical phenomena that standards often miss across all four domains.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Chart Values</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Chart Labels (Comma separated)</label>
                    <input type="text" name="gaf_chart_labels" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_labels'] ?? 'EV, BMS, Renewable, Power') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Type 1 Chart Label</label>
                    <input type="text" name="gaf_chart_type1_label" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_type1_label'] ?? 'Type 1') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Type 2 Chart Label</label>
                    <input type="text" name="gaf_chart_type2_label" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_type2_label'] ?? 'Type 2') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Type 3 Chart Label</label>
                    <input type="text" name="gaf_chart_type3_label" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_type3_label'] ?? 'Type 3') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Type 1 Gaps (Comma separated)</label>
                    <input type="text" name="gaf_chart_type1" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_type1'] ?? '12, 8, 10, 14') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Type 2 Gaps (Comma separated)</label>
                    <input type="text" name="gaf_chart_type2" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_type2'] ?? '14, 12, 9, 8') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Type 3 Gaps (Comma separated)</label>
                    <input type="text" name="gaf_chart_type3" class="form-control" value="<?= htmlspecialchars($content['gaf_chart_type3'] ?? '8, 10, 12, 6') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Gap Categories</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Gap 1 Title</label>
                    <input type="text" name="gaf_gap1_title" class="form-control mb-2" value="<?= htmlspecialchars($content['gaf_gap1_title'] ?? 'GAP TYPE 1 — Invisible Phenomena') ?>">
                    <textarea name="gaf_gap1_desc" class="form-control" rows="2"><?= htmlspecialchars($content['gaf_gap1_desc'] ?? 'Physical phenomena that cause real failures and are acknowledged by no standard.') ?></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Gap 2 Title</label>
                    <input type="text" name="gaf_gap2_title" class="form-control mb-2" value="<?= htmlspecialchars($content['gaf_gap2_title'] ?? 'GAP TYPE 2 — Judgement Gaps') ?>">
                    <textarea name="gaf_gap2_desc" class="form-control" rows="2"><?= htmlspecialchars($content['gaf_gap2_desc'] ?? 'Standard thresholds that cannot determine safety for a specific design\'s operating conditions.') ?></textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Gap 3 Title</label>
                    <input type="text" name="gaf_gap3_title" class="form-control mb-2" value="<?= htmlspecialchars($content['gaf_gap3_title'] ?? 'GAP TYPE 3 — Interaction Gaps') ?>">
                    <textarea name="gaf_gap3_desc" class="form-control" rows="2"><?= htmlspecialchars($content['gaf_gap3_desc'] ?? 'Failure modes from combinations of individually compliant elements.') ?></textarea>
                </div>
            </div>
        </div>

        <div class="text-end mt-20">
            <button type="button" class="btn btn-primary save-framework-btn">Save CB-GAF Content</button>
        </div>
    </form>
</div>
