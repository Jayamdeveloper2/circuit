<?php
$content = $frameworks_content['lbf'] ?? [];
?>
<div class="p-30 bg-white">
    <form class="framework-content-form">
        <input type="hidden" name="framework_slug" value="lbf">
        <h4 class="mb-20 text-primary">CB-LBF Configuration</h4>
        
        <h5 class="mt-4 border-bottom pb-2">Hero Text & Navigation</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Navigation Button Label</label>
                    <input type="text" name="lbf_nav_label" class="form-control" value="<?= htmlspecialchars($content['lbf_nav_label'] ?? 'CB-LBF') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Section Tagline</label>
                    <input type="text" name="lbf_tagline" class="form-control" value="<?= htmlspecialchars($content['lbf_tagline'] ?? 'CB-LBF: Loss Budget Framework') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Normal Text)</label>
                    <input type="text" name="lbf_heading_1" class="form-control" value="<?= htmlspecialchars($content['lbf_heading_1'] ?? 'Loss') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Span Text)</label>
                    <input type="text" name="lbf_heading_2" class="form-control" value="<?= htmlspecialchars($content['lbf_heading_2'] ?? 'Budget Framework') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Quote</label>
                    <input type="text" name="lbf_quote" class="form-control" value="<?= htmlspecialchars($content['lbf_quote'] ?? 'Fight for the Fractions — efficiency is won or lost in the decimals.') ?>">
                </div>
                <div class="form-group">
                    <label class="fw-bold">Description Paragraph</label>
                    <textarea name="lbf_desc" class="form-control" rows="3"><?= htmlspecialchars($content['lbf_desc'] ?? 'Full-spectrum loss analysis framework. Every watt of loss has an address — CB-LBF locates each one across conduction, switching, magnetics, gate drive, and PCB parasitics. Scanner Principle: no verdicts, pure visibility.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Chart Values</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Chart Labels (Comma separated)</label>
                    <input type="text" name="lbf_chart_labels" class="form-control" value="<?= htmlspecialchars($content['lbf_chart_labels'] ?? 'Conduction, Switching, Core, Winding, Gate, Dead-Time, Parasitic') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Loss Contribution % (Comma separated)</label>
                    <input type="text" name="lbf_chart_data" class="form-control" value="<?= htmlspecialchars($content['lbf_chart_data'] ?? '28.4, 22.1, 17.6, 13.8, 8.2, 6.1, 3.8') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Deliverables</h5>
        <div class="form-group">
            <input type="text" name="lbf_deliv_1" class="form-control mb-2" value="<?= htmlspecialchars($content['lbf_deliv_1'] ?? 'Full-spectrum loss scan — every mechanism identified and quantified') ?>">
            <input type="text" name="lbf_deliv_2" class="form-control mb-2" value="<?= htmlspecialchars($content['lbf_deliv_2'] ?? 'Itemised loss register per mechanism and per operating point') ?>">
            <input type="text" name="lbf_deliv_3" class="form-control mb-2" value="<?= htmlspecialchars($content['lbf_deliv_3'] ?? 'Scanner Principle report — verdict-free, engineered for the team to act on') ?>">
        </div>

        <div class="text-end mt-20">
            <button type="button" class="btn btn-primary save-framework-btn">Save CB-LBF Content</button>
        </div>
    </form>
</div>
