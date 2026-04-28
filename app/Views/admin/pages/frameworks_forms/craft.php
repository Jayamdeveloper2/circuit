<?php
$content = $frameworks_content['craft'] ?? [];
?>
<div class="p-30 bg-white">
    <form class="framework-content-form">
        <input type="hidden" name="framework_slug" value="craft">
        <h4 class="mb-20 text-primary">CB-CRAFT Configuration</h4>
        
        <h5 class="mt-4 border-bottom pb-2">Hero Text & Navigation</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Navigation Button Label</label>
                    <input type="text" name="craft_nav_label" class="form-control" value="<?= htmlspecialchars($content['craft_nav_label'] ?? 'CB-CRAFT') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Section Tagline</label>
                    <input type="text" name="craft_tagline" class="form-control" value="<?= htmlspecialchars($content['craft_tagline'] ?? 'CB-CRAFT: Design Execution Framework') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Normal Text)</label>
                    <input type="text" name="craft_heading_1" class="form-control" value="<?= htmlspecialchars($content['craft_heading_1'] ?? 'Comprehensive Review and') ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="fw-bold">Heading (Span Text)</label>
                    <input type="text" name="craft_heading_2" class="form-control" value="<?= htmlspecialchars($content['craft_heading_2'] ?? 'Assured Fabrication Technology') ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="fw-bold">Quote</label>
                    <input type="text" name="craft_quote" class="form-control" value="<?= htmlspecialchars($content['craft_quote'] ?? 'CB-CRAFT reflects the design as implemented. It does not pass or fail. It observes, records, and verifies.') ?>">
                </div>
                <div class="form-group">
                    <label class="fw-bold">Description Paragraph</label>
                    <textarea name="craft_desc" class="form-control" rows="3"><?= htmlspecialchars($content['craft_desc'] ?? 'CB-CRAFT is Circuit Brilliance\'s PCB Design Execution Framework — the stage where every upstream framework output (SCC, LBF, Thermal, GAF, FMEA) converges into a verified, manufacturable PCB deliverable.') ?></textarea>
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Ecosystem Position Text</h5>
        <div class="form-group">
            <textarea name="craft_ecosystem" class="form-control" rows="3"><?= htmlspecialchars($content['craft_ecosystem'] ?? 'CB-CRAFT does not determine requirements — it verifies their implementation. CB-SCC determines compliance requirements — CB-CRAFT checks the PCB delivers them. CB-LBF determines current values — CB-CRAFT sizes the copper to carry them. CB-Thermal determines thermal zones — CB-CRAFT verifies placement honours them.') ?></textarea>
        </div>

        <h5 class="mt-4 border-bottom pb-2">9-Stage Execution Details</h5>
        <p class="text-muted small">For each stage, provide the Title and a short Description.</p>
        
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 01 Title</label>
                <input type="text" name="craft_stage1_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage1_title'] ?? 'Layout Intelligence Extraction') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 01 Description</label>
                <input type="text" name="craft_stage1_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage1_desc'] ?? 'Reading the schematic for layout-critical information.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 02 Title</label>
                <input type="text" name="craft_stage2_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage2_title'] ?? 'Layout-Specific Client Inputs') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 02 Description</label>
                <input type="text" name="craft_stage2_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage2_desc'] ?? 'Mechanical constraints, surface finish, layer budget.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 03 Title</label>
                <input type="text" name="craft_stage3_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage3_title'] ?? 'Layer Stack & Design Rules') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 03 Description</label>
                <input type="text" name="craft_stage3_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage3_desc'] ?? 'Isolation, copper weight, and design rule implementation.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 04 Title</label>
                <input type="text" name="craft_stage4_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage4_title'] ?? 'Component Placement') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 04 Description</label>
                <input type="text" name="craft_stage4_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage4_desc'] ?? 'Switching loops, gate drive proximity, thermal zone compliance.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 05 Title</label>
                <input type="text" name="craft_stage5_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage5_title'] ?? 'Routing') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 05 Description</label>
                <input type="text" name="craft_stage5_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage5_desc'] ?? 'Power trace sizing, Kelvin sense routing, ground zone discipline.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 06 Title</label>
                <input type="text" name="craft_stage6_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage6_title'] ?? 'DFM + DFA') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 06 Description</label>
                <input type="text" name="craft_stage6_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage6_desc'] ?? 'Design for Manufacturability and Assembly verification.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 07 Title</label>
                <input type="text" name="craft_stage7_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage7_title'] ?? 'DFT — Design for Testability') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 07 Description</label>
                <input type="text" name="craft_stage7_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage7_desc'] ?? 'Test points, programming access, serviceability.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 08 Title</label>
                <input type="text" name="craft_stage8_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage8_title'] ?? 'DFS — Design for Safety') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 08 Description</label>
                <input type="text" name="craft_stage8_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage8_desc'] ?? 'Creepage, clearance, isolation, safety marking.') ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <label class="fw-bold">Stage 09 Title</label>
                <input type="text" name="craft_stage9_title" class="form-control" value="<?= htmlspecialchars($content['craft_stage9_title'] ?? 'Release for Prototyping') ?>">
            </div>
            <div class="col-md-8">
                <label class="fw-bold">Stage 09 Description</label>
                <input type="text" name="craft_stage9_desc" class="form-control" value="<?= htmlspecialchars($content['craft_stage9_desc'] ?? 'Final package generation, ODB++, and manufacturing release.') ?>">
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">Domains</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Domain 1 Title</label>
                    <input type="text" name="craft_domain1_title" class="form-control" value="<?= htmlspecialchars($content['craft_domain1_title'] ?? 'EV Powertrain') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Domain 1 Focus</label>
                    <input type="text" name="craft_domain1_focus" class="form-control" value="<?= htmlspecialchars($content['craft_domain1_focus'] ?? 'HV isolation, SiC/GaN switching loops, HVIL, automotive DFx') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Domain 2 Title</label>
                    <input type="text" name="craft_domain2_title" class="form-control" value="<?= htmlspecialchars($content['craft_domain2_title'] ?? 'Battery Management') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Domain 2 Focus</label>
                    <input type="text" name="craft_domain2_focus" class="form-control" value="<?= htmlspecialchars($content['craft_domain2_focus'] ?? 'AFE sense matching, stack voltage isolation, Kelvin routing') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Domain 3 Title</label>
                    <input type="text" name="craft_domain3_title" class="form-control" value="<?= htmlspecialchars($content['craft_domain3_title'] ?? 'Renewable Energy') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Domain 3 Focus</label>
                    <input type="text" name="craft_domain3_focus" class="form-control" value="<?= htmlspecialchars($content['craft_domain3_focus'] ?? 'Common-mode loops, GFDI, outdoor creepage, LCL filter') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Domain 4 Title</label>
                    <input type="text" name="craft_domain4_title" class="form-control" value="<?= htmlspecialchars($content['craft_domain4_title'] ?? 'Power Converters & SMPS') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Domain 4 Focus</label>
                    <input type="text" name="craft_domain4_focus" class="form-control" value="<?= htmlspecialchars($content['craft_domain4_focus'] ?? 'Primary switching loop, Y-cap placement, isolation slot') ?>">
                </div>
            </div>
        </div>

        <h5 class="mt-4 border-bottom pb-2">What the Client Receives</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 1 Title</label>
                    <input type="text" name="craft_deliv1_title" class="form-control" value="<?= htmlspecialchars($content['craft_deliv1_title'] ?? 'CB-CRAFT Review Record') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 1 Desc</label>
                    <input type="text" name="craft_deliv1_desc" class="form-control" value="<?= htmlspecialchars($content['craft_deliv1_desc'] ?? 'every checkpoint reviewed across all nine stages, observations recorded') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 2 Title</label>
                    <input type="text" name="craft_deliv2_title" class="form-control" value="<?= htmlspecialchars($content['craft_deliv2_title'] ?? 'Framework Summary Report') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 2 Desc</label>
                    <input type="text" name="craft_deliv2_desc" class="form-control" value="<?= htmlspecialchars($content['craft_deliv2_desc'] ?? 'one-page confirmation the design underwent CB-CRAFT review') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 3 Title</label>
                    <input type="text" name="craft_deliv3_title" class="form-control" value="<?= htmlspecialchars($content['craft_deliv3_title'] ?? 'Design Rationale Note') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 3 Desc</label>
                    <input type="text" name="craft_deliv3_desc" class="form-control" value="<?= htmlspecialchars($content['craft_deliv3_desc'] ?? 'switching loop area, isolation strategy, copper weight rationale') ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 4 Title</label>
                    <input type="text" name="craft_deliv4_title" class="form-control" value="<?= htmlspecialchars($content['craft_deliv4_title'] ?? 'Gerber Package') ?>">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="fw-bold">Deliverable 4 Desc</label>
                    <input type="text" name="craft_deliv4_desc" class="form-control" value="<?= htmlspecialchars($content['craft_deliv4_desc'] ?? 'fabrication-ready files verified under CB-CRAFT before release') ?>">
                </div>
            </div>
        </div>

        <div class="text-end mt-20">
            <button type="button" class="btn btn-primary save-framework-btn">Save CB-CRAFT Content</button>
        </div>
    </form>
</div>
