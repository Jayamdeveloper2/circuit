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

    /* Force white background throughout the modal — overrides admin theme grey */
    #plannedModal .modal-dialog,
    #plannedModal .modal-content,
    #plannedModal .modal-header,
    #plannedModal .modal-body,
    #plannedModal .modal-footer,
    #plannedModal .row,
    #plannedModal [class*="col-"],
    #plannedModal .form-group {
        background-color: #ffffff !important;
    }

    #plannedModal .modal-content {
        height: 100vh;
    }

    #plannedModal .modal-footer {
        border-top: 1px solid #eee;
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
                            <button type="button" class="btn btn-primary add-planned-btn"><i class="fa fa-plus-circle me-2"></i> Add Planned Design</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-body">
                                    <!-- Planned Showcase Intro Form -->
                                    <form class="form form-content mb-4 border-bottom pb-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <div class="form-group mb-3 col-md-4 px-0">
                                                    <label class="form-label fw-bold">Section Title</label>
                                                    <input type="text" name="web_content_1" value="<?= $intro['web_content_1'] ?>" class="form-control" placeholder="Enter title...">
                                                </div>
                                                <div class="form-group mb-0 col-md-10 px-0">
                                                    <label class="form-label fw-bold">Intro Paragraph</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="web_content_2" rows="3" placeholder="Enter intro text..."><?= $intro['web_content_2'] ?></textarea>
                                                        <button class="btn btn-primary" type="submit" style="width: 45px;">
                                                            <i class="fa fa-save"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-2">
                                                <div class="cus-toggle">
                                                    <div class="d-flex align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                <?= ($intro['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden" value="<?= ($intro['status'] == 1) ? '1' : '0' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="web_content_id" value="<?= $intro['web_content_id'] ?>">
                                    </form>

                                    <div class="table-responsive">
                                        <table id="plannedTable" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Tag (Domain)</th>
                                                    <th>Title</th>
                                                    <th>Theme</th>
                                                    <th>Order</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal modal-right fade" id="plannedModal" tabindex="-1">
            <div class="modal-dialog modal-lg" style="width: 600px;">
                <div class="modal-content d-flex flex-column">
                    <div class="modal-header">
                        <h5 class="modal-title">Planned Design Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="planned-form d-flex flex-column flex-grow-1 overflow-hidden">
                        <div class="modal-body flex-grow-1 overflow-auto">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Domain Tag</label>
                                        <input type="text" name="web_tag" class="form-control" required placeholder="e.g. Battery Management Systems">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Project Title</label>
                                <input type="text" name="web_title" class="form-control" required placeholder="e.g. 20kW High Voltage BMS">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tech Line (Comma separated tech)</label>
                                <input type="text" name="web_tech_line" class="form-control" required placeholder="Mixed Signal | 350V Bus | 20kW">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Key Features (Use bullet points)</label>
                                <textarea name="web_features" id="web_features_editor" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Footer Description</label>
                                <textarea name="web_footer" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Theme Class</label>
                                        <select name="theme_class" class="form-select">
                                            <option value="bms-theme">BMS Theme (Blue/Teal)</option>
                                            <option value="renewable-theme">Renewable Theme (Green)</option>
                                            <option value="power-theme">Power Theme (Navy)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Anchor ID</label>
                                        <input type="text" name="anchor_id" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" name="display_order" class="form-control" value="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label d-block">Status</label>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="is_active" id="activeY" value="1" checked>
                                            <label class="btn btn-outline-success btn-sm" for="activeY">Active</label>
                                            <input type="radio" class="btn-check" name="is_active" id="activeN" value="0">
                                            <label class="btn btn-outline-danger btn-sm" for="activeN">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="web_planned_showcase_id" value="0">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary shadow-none">Save Design</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
    <script src="<?= CSS_PATH ?>/js/pages/planned_showcase.js"></script>
    <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
    <script>
        const missionStatus = document.getElementById('missionStatus');
        const missionStatusHidden = document.getElementById('missionStatusHidden');

        missionStatus.addEventListener('change', function() {
            missionStatusHidden.value = this.checked ? '1' : '0';
        });
    </script>
</body>

</html>