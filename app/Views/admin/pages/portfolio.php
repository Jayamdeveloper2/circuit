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
    #portfolio-modal .modal-dialog,
    #portfolio-modal .modal-content,
    #portfolio-modal .modal-header,
    #portfolio-modal .modal-body,
    #portfolio-modal .modal-footer,
    #portfolio-modal .row,
    #portfolio-modal [class*="col-"],
    #portfolio-modal .form-group {
        background-color: #ffffff !important;
    }

    #portfolio-modal .modal-content {
        height: 100vh;
    }

    #portfolio-modal .modal-footer {
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
                            <div class="d-flex align-items-center">
                                <button data-id="-1" class="btn btn-primary edit-portfolio">
                                    <i class="fi fi-br-plus me-1"></i> Add Domain Tile
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="box shadow-none">
                                <div class="box-body">
                                    <!-- Portfolio Intro Form -->
                                    <form class="form form-content mb-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <div class="form-group mb-3 col-md-4 px-0">
                                                    <label class="form-label fw-bold">Section Title</label>
                                                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control" placeholder="Enter title...">
                                                </div>
                                                <div class="form-group mb-0 col-md-10 px-0">
                                                    <label class="form-label fw-bold">Intro Paragraph</label>
                                                    <div class="input-group">
                                                        <textarea class="form-control" name="web_content_2" rows="4" placeholder="Enter intro text..."><?= $data['web_content_2'] ?></textarea>
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
                                                                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden" value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="web_content_id" value="<?= $data['web_content_id'] ?>">
                                    </form>

                                    <hr>
                                    <h4 class="mb-3">Domain Image Tiles</h4>

                                    <!-- Domain Tiles Table -->
                                    <div class="table-responsive">
                                        <table id="portfolio_table" class="text-fade table table-bordered display">
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div><!-- end .row -->

                    <!-- Modal -->
                    <div id="portfolio-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

                        <div class="modal-dialog modal-sm model_vs">
                            <div class="modal-content d-flex flex-column">

                                <!-- HEADER -->
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        <span class="modal-name">Add</span> Domain
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- FORM START -->
                                <form data-validate class="portfolio-form d-flex flex-column flex-grow-1 overflow-hidden">

                                    <!-- BODY -->
                                    <div class="modal-body flex-grow-1 overflow-auto">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Title</label>
                                                    <input type="text" name="web_title" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Subtitle</label>
                                                    <textarea name="web_content" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Footer Description</label>
                                                    <textarea name="web_footer_desc" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Theme Class</label>
                                                    <select name="web_theme" class="form-control form-select">
                                                        <option value="bms">BMS Theme (Blue/Teal)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Anchor ID</label>
                                                    <input type="text" name="web_anchor" class="form-control" placeholder="e.g. bms">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Anchor URL</label>
                                                    <input type="text" name="web_url" class="form-control" placeholder="#anchor-name">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Image</label>
                                                    <input type="file" name="web_image" class="form-control">
                                                    <img id="web_image_prev" class="mt-2 d-none" height="120">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Display Order</label>
                                                    <input type="number" name="display_order" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Status</label>
                                                    <div class="d-flex align-items-center gap-3 mt-2">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="portfolioStatus" value="1" checked>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <span>Active</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- end modal-body -->

                                    <!-- FOOTER -->
                                    <div class="modal-footer">
                                        <input type="hidden" name="web_portfolio_domain_id" value="-1">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Design</button>
                                    </div>

                                </form><!-- end form -->

                            </div><!-- end modal-content -->
                        </div><!-- end modal-dialog -->
                    </div><!-- end modal -->
                </section>
            </div>
        </div>
        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/js/pages/portfolio.js"></script>
        <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
        <script>
            const missionStatus = document.getElementById('missionStatus');
            const missionStatusHidden = document.getElementById('missionStatusHidden');

            missionStatus.addEventListener('change', function() {
                missionStatusHidden.value = this.checked ? '1' : '0';
            });
        </script>
    </div>
</body>

</html>