<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>
    <style>
    .cus-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .cus-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .cus-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    .cus-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    .cus-switch input:checked+.cus-slider {
        background-color: #2196F3;
    }
    .cus-switch input:checked+.cus-slider:before {
        transform: translateX(26px);
    }
    
    /* Complex JSON field styling */
    .json-field-container {
        border: 1px solid #eee;
        padding: 15px;
        border-radius: 8px;
        background: #fcfcfc;
        margin-bottom: 20px;
    }
    .json-item {
        background: #fff;
        border: 1px solid #e1e1e1;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 10px;
        position: relative;
    }
    .json-item .remove-item {
        position: absolute;
        right: -10px;
        top: -10px;
        width: 24px;
        height: 24px;
        padding: 0;
        border-radius: 50%;
        line-height: 22px;
        text-align: center;
    }
    .modal-right .modal-dialog {
        max-width: 600px;
        width: 100%;
    }
    
    /* Collapsible sections */
    .section-header {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        margin-top: 10px;
        transition: all 0.3s;
    }
    .section-header:hover {
        background: #edf2f7;
    }
    .toggle-icon {
        transition: transform 0.3s;
    }
    .section-collapsed .toggle-icon {
        transform: rotate(-90deg);
    }
    .section-content {
        transition: all 0.3s ease;
        overflow: hidden;
        padding: 5px 10px 15px 25px;
        border-left: 2px solid #edf2f7;
        margin-left: 10px;
    }
</style>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">
        <div class="wrapper">
            <div id="loader"></div>

            <?php include APPPATH . "/Views/admin/common/top.php"; ?>
            <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

            <div class="content-wrapper">
                <div class="container-full">
                <section class="content">
                        <div class="content-header mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-auto">
                                    <?php if (isset($breadcrumb)) : ?>
                                        <?= $breadcrumb ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="box shadow-none">
                                    <div class="box-body">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h4 class="mb-0">Flagship Showcase Details</h4>
                                            <div class="cus-toggle">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fw-bold ser-status-label">Visibility:</span>
                                                    <label class="cus-switch mb-0">
                                                        <input type="checkbox" class="status-showcase" data-id="<?= $data['web_portfolio_showcase_id'] ?>" <?= ($data['is_active'] == 1) ? 'checked' : '' ?>>
                                                        <span class="cus-slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <form data-validate class="showcase-form">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs customtab" role="tablist">
                                                <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab"><span class="hidden-sm-up"><i class="fa fa-home"></i></span> <span class="hidden-xs-down">General Info</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#eng-details" role="tab"><span class="hidden-sm-up"><i class="fa fa-cogs"></i></span> <span class="hidden-xs-down">Engineering Data</span></a> </li>
                                                <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#frameworks" role="tab"><span class="hidden-sm-up"><i class="fa fa-layers"></i></span> <span class="hidden-xs-down">Frameworks & Deliverables</span></a> </li>
                                            </ul>
                                            
                                            <!-- Tab panes -->
                                            <div class="tab-content mt-3">
                                                <div class="tab-pane active" id="general" role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Project Title</label>
                                                                <input type="text" name="web_title" class="form-control" required value="<?= $data['web_title'] ?>" placeholder="e.g. 11kW Integrated On-Board Charger">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Anchor ID <i class="fa fa-info-circle text-info" title="Used for navigation links like #ev"></i></label>
                                                                <input type="text" name="web_anchor_id" class="form-control" value="<?= $data['web_anchor_id'] ?>" placeholder="e.g. obc-11kw">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Status Badge Text</label>
                                                                <input type="text" name="web_status_text" class="form-control" value="<?= $data['web_status_text'] ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold">Tech Line (Tagline)</label>
                                                        <input type="text" name="web_tech_line" class="form-control" value="<?= $data['web_tech_line'] ?>" placeholder="e.g. Bi-Directional GaN-Based Efficiency">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label fw-bold">Key Hook Message (Description)</label>
                                                        <textarea name="web_hook" class="form-control" rows="3" placeholder="The persuasive summary for this project..."><?= $data['web_hook'] ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="eng-details" role="tabpanel">
                                                    <?php 
                                                        $sections = [
                                                            'execution_progress' => ['title' => 'Execution Progress', 'btn' => 'Add Stage'],
                                                            'key_specifications' => ['title' => 'Key Specifications', 'btn' => 'Add Spec'],
                                                            'design_highlights' => ['title' => 'Design Highlights', 'btn' => 'Add Highlight'],
                                                            'pcb_challenges' => ['title' => 'PCB & Engineering Challenges', 'btn' => 'Add Challenge']
                                                        ];
                                                        foreach($sections as $field => $info):
                                                    ?>
                                                    <div class="json-section section-collapsed" data-field="<?= $field ?>">
                                                        <div class="section-header d-flex justify-content-between align-items-center mb-2 p-2 rounded">
                                                            <label class="form-label mb-0 fw-bold" style="cursor: pointer;"><i class="fa fa-chevron-down me-2 toggle-icon"></i> <?= $info['title'] ?></label>
                                                            <button type="button" class="btn btn-xs btn-primary add-json-item"><i class="fa fa-plus"></i> <?= $info['btn'] ?></button>
                                                        </div>
                                                        <div class="section-content" style="display: none;">
                                                            <div class="json-items-container">
                                                                <?php if (!empty($data[$field])): foreach($data[$field] as $item): ?>
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function() {
                                                                            addJsonItem('<?= $field ?>', '<?= addslashes($item) ?>');
                                                                        });
                                                                    </script>
                                                                <?php endforeach; endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>

                                                <div class="tab-pane" id="frameworks" role="tabpanel">
                                                    <?php 
                                                        $sections = [
                                                            'frameworks_applied' => ['title' => 'Frameworks Applied', 'btn' => 'Add Framework'],
                                                            'design_deliverables' => ['title' => 'Design Deliverables', 'btn' => 'Add Deliverable']
                                                        ];
                                                        foreach($sections as $field => $info):
                                                    ?>
                                                    <div class="json-section section-collapsed" data-field="<?= $field ?>">
                                                        <div class="section-header d-flex justify-content-between align-items-center mb-2 p-2 rounded">
                                                            <label class="form-label mb-0 fw-bold" style="cursor: pointer;"><i class="fa fa-chevron-down me-2 toggle-icon"></i> <?= $info['title'] ?></label>
                                                            <button type="button" class="btn btn-xs btn-primary add-json-item"><i class="fa fa-plus"></i> <?= $info['btn'] ?></button>
                                                        </div>
                                                        <div class="section-content" style="display: none;">
                                                            <div class="json-items-container">
                                                                <?php if (!empty($data[$field])): foreach($data[$field] as $item): ?>
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function() {
                                                                            addJsonItem('<?= $field ?>', '<?= addslashes($item) ?>');
                                                                        });
                                                                    </script>
                                                                <?php endforeach; endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>

                                            <div class="box-footer p-0 mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                                                <p class="text-muted small mb-0"><i class="fa fa-info-circle me-1"></i> Changes will be reflected immediately on the Portfolio Flagship section.</p>
                                                <div>
                                                    <input type="hidden" name="web_portfolio_showcase_id" value="<?= $data['web_portfolio_showcase_id'] ?>">
                                                    <input type="hidden" name="display_order" value="<?= $data['display_order'] ?>">
                                                    <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save me-2"></i> Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
            <script src="<?= CSS_PATH ?>/js/pages/showcase.js"></script>
        </div>
    </body>
</html>
