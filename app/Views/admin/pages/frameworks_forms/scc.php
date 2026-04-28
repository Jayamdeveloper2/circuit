<?php
$content = $frameworks_content['scc'] ?? [];
?>
<div class="p-30 bg-white">
    <form class="framework-content-form">
        <input type="hidden" name="framework_slug" value="scc">
        <h4 class="mb-20 text-primary">CB-SCC Configuration</h4>
        
        <h5 class="mt-4 border-bottom pb-2">Hero Text & Navigation</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Navigation Button Label</label>
                    <input type="text" name="scc_nav_label" class="form-control" value="<?= htmlspecialchars($content['scc_nav_label'] ?? 'CB-SCC') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Section Tagline</label>
                    <input type="text" name="scc_tagline" class="form-control" value="<?= htmlspecialchars($content['scc_tagline'] ?? 'CB-SCC: Standards Compliance Checklist') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Normal Text)</label>
                    <input type="text" name="scc_heading_1" class="form-control" value="<?= htmlspecialchars($content['scc_heading_1'] ?? 'Standards') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Span Text)</label>
                    <input type="text" name="scc_heading_2" class="form-control" value="<?= htmlspecialchars($content['scc_heading_2'] ?? 'Compliance Checklist') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Quote</label>
                    <input type="text" name="scc_quote" class="form-control" value="<?= htmlspecialchars($content['scc_quote'] ?? 'Find the compliance gap at the design stage — not at the certification stage.') ?>">
                </div>
                <div class="form-group">
                    <label class="fw-bold">Description Paragraph</label>
                    <textarea name="scc_desc" class="form-control" rows="3"><?= htmlspecialchars($content['scc_desc'] ?? 'A structured audit framework evaluating PCB design and documentation against applicable international standards covering PCB design, insulation coordination, reliability prediction, and product safety. Clause-level traceability. Cross-standard conflict identification.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Radar Chart Values</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Chart Labels (Comma separated)</label>
                    <input type="text" name="scc_chart_labels" class="form-control" value="<?= htmlspecialchars($content['scc_chart_labels'] ?? 'PCB Design, Insulation, Reliability, Safety, Conflict Check, Traceability') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Ad-Hoc Values (Comma separated)</label>
                    <input type="text" name="scc_chart_adhoc" class="form-control" value="<?= htmlspecialchars($content['scc_chart_adhoc'] ?? '40, 30, 20, 35, 10, 25') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">CB-SCC Values (Comma separated)</label>
                    <input type="text" name="scc_chart_cbscc" class="form-control" value="<?= htmlspecialchars($content['scc_chart_cbscc'] ?? '95, 95, 90, 92, 88, 97') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Counters</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Counter 1 Target</label>
                    <input type="number" name="scc_count1_target" class="form-control" value="<?= htmlspecialchars($content['scc_count1_target'] ?? '96') ?>">
                    <label class="fw-bold mt-2">Counter 1 Label</label>
                    <input type="text" name="scc_count1_label" class="form-control" value="<?= htmlspecialchars($content['scc_count1_label'] ?? 'Compliance Depth') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Counter 2 Target</label>
                    <input type="number" name="scc_count2_target" class="form-control" value="<?= htmlspecialchars($content['scc_count2_target'] ?? '100') ?>">
                    <label class="fw-bold mt-2">Counter 2 Label</label>
                    <input type="text" name="scc_count2_label" class="form-control" value="<?= htmlspecialchars($content['scc_count2_label'] ?? 'Traceability') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Deliverables</h5>
        <div class="form-group">
            <input type="text" name="scc_deliv_1" class="form-control mb-2" value="<?= htmlspecialchars($content['scc_deliv_1'] ?? 'Compliance status across applicable international standards') ?>">
            <input type="text" name="scc_deliv_2" class="form-control mb-2" value="<?= htmlspecialchars($content['scc_deliv_2'] ?? 'Clause-level findings traceable to specific standard and section') ?>">
            <input type="text" name="scc_deliv_3" class="form-control mb-2" value="<?= htmlspecialchars($content['scc_deliv_3'] ?? 'Cross-standard conflict identification') ?>">
        </div>

        <div class="text-end mt-20">
            <button type="button" class="btn btn-primary save-framework-btn">Save CB-SCC Content</button>
        </div>
    </form>
</div>
