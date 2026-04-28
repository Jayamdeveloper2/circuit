<?php
$content = $frameworks_content['thermal'] ?? [];
?>
<div class="p-30 bg-white">
    <form class="framework-content-form">
        <input type="hidden" name="framework_slug" value="thermal">
        <h4 class="mb-20 text-primary">CB-Thermal Configuration</h4>
        
        <h5 class="mt-4 border-bottom pb-2">Hero Text & Navigation</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Navigation Button Label</label>
                    <input type="text" name="thermal_nav_label" class="form-control" value="<?= htmlspecialchars($content['thermal_nav_label'] ?? 'CB-Thermal') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Section Tagline</label>
                    <input type="text" name="thermal_tagline" class="form-control" value="<?= htmlspecialchars($content['thermal_tagline'] ?? 'CB-Thermal: Thermal Analysis Framework') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Normal Text)</label>
                    <input type="text" name="thermal_heading_1" class="form-control" value="<?= htmlspecialchars($content['thermal_heading_1'] ?? 'Thermal') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Span Text)</label>
                    <input type="text" name="thermal_heading_2" class="form-control" value="<?= htmlspecialchars($content['thermal_heading_2'] ?? 'Analysis Framework') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Quote</label>
                    <input type="text" name="thermal_quote" class="form-control" value="<?= htmlspecialchars($content['thermal_quote'] ?? 'Every degree above junction limit is a reliability debt — CB-Thermal finds it before it compounds.') ?>">
                </div>
                <div class="form-group">
                    <label class="fw-bold">Description Paragraph</label>
                    <textarea name="thermal_desc" class="form-control" rows="3"><?= htmlspecialchars($content['thermal_desc'] ?? 'Complete junction-to-ambient thermal chain analysis. Maps every Rth node per heat-generating component. Identifies hotspot risks, validates thermal via arrays, estimates worst-case junction temperatures.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Bar Chart Values</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Chart Labels (Comma separated)</label>
                    <input type="text" name="thermal_chart_labels" class="form-control" value="<?= htmlspecialchars($content['thermal_chart_labels'] ?? 'Ambient, Heatsink, TIM, Case, Junction') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Temperatures (°C) (Comma separated)</label>
                    <input type="text" name="thermal_chart_data" class="form-control" value="<?= htmlspecialchars($content['thermal_chart_data'] ?? '45, 68, 79, 98, 142') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Counters</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Counter 1 Target</label>
                    <input type="number" name="thermal_count1_target" class="form-control" value="<?= htmlspecialchars($content['thermal_count1_target'] ?? '142') ?>">
                    <label class="fw-bold mt-2">Counter 1 Label</label>
                    <input type="text" name="thermal_count1_label" class="form-control" value="<?= htmlspecialchars($content['thermal_count1_label'] ?? 'Estimated Tj Max') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Counter 2 Target</label>
                    <input type="number" name="thermal_count2_target" class="form-control" value="<?= htmlspecialchars($content['thermal_count2_target'] ?? '5') ?>">
                    <label class="fw-bold mt-2">Counter 2 Label</label>
                    <input type="text" name="thermal_count2_label" class="form-control" value="<?= htmlspecialchars($content['thermal_count2_label'] ?? 'Thermal Nodes') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Deliverables</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Title 1</label>
                    <input type="text" name="thermal_deliv_t1" class="form-control mb-2" value="<?= htmlspecialchars($content['thermal_deliv_t1'] ?? 'Rth Chain Mapping') ?>">
                    <input type="text" name="thermal_deliv_d1" class="form-control" value="<?= htmlspecialchars($content['thermal_deliv_d1'] ?? 'Full junction-to-ambient Rth chain per heat-generating component') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Title 2</label>
                    <input type="text" name="thermal_deliv_t2" class="form-control mb-2" value="<?= htmlspecialchars($content['thermal_deliv_t2'] ?? 'Risk Assessment') ?>">
                    <input type="text" name="thermal_deliv_d2" class="form-control" value="<?= htmlspecialchars($content['thermal_deliv_d2'] ?? 'Hotspot risk assessment — placement, copper spreading, power density') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Title 3</label>
                    <input type="text" name="thermal_deliv_t3" class="form-control mb-2" value="<?= htmlspecialchars($content['thermal_deliv_t3'] ?? 'Simulation Data') ?>">
                    <input type="text" name="thermal_deliv_d3" class="form-control" value="<?= htmlspecialchars($content['thermal_deliv_d3'] ?? 'Worst-case junction temperature estimates at full load and maximum ambient') ?>">
                </div>
            </div>
        </div>

        <div class="text-end mt-20">
            <button type="button" class="btn btn-primary save-framework-btn">Save CB-Thermal Content</button>
        </div>
    </form>
</div>
