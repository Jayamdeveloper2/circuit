<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>
    <style>
    /* Custom Toggle Switch CSS */
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

    .cus-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">
        <div class="wrapper">
            <div id="loader"></div>

            <?php include APPPATH . "/Views/admin/common/top.php"; ?>
            <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container-full">
                <section class="content">
                        <!-- Breadcrumbs and Global Actions -->
                        <div class="content-header mb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="me-auto">
                                    <?php if (isset($breadcrumb)) : ?>
                                        <?= $breadcrumb ?>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button data-pid="-1" class="btn btn-primary edit-business"> 
                                        <i class="fi fi-br-plus me-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="box shadow-none">
                                    <div class="box-body">
                                        <!-- Integrated Settings Form -->
                                        <form class="form form-content mb-4">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="flex-grow-1">
                                                    <div class="form-group mb-3 col-md-4 px-0">
                                                        <label class="form-label fw-bold">Title</label>
                                                        <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control" placeholder="Enter title...">
                                                    </div>
                                                    <div class="form-group mb-0 col-md-10 px-0">
                                                        <label class="form-label fw-bold">Sub Title</label>
                                                        <div class="input-group">
                                                            <textarea class="form-control" name="web_content_2" placeholder="Enter sub title..."><?= $data['web_content_2'] ?></textarea>
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

                                        <!-- Items Table -->
                                        <div class="table-responsive">
                                            <table id="business_table" class="text-fade table table-bordered display">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div id="brand-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                                 aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-sm model_vs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><span class="modal-name">Add</span></h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form data-validate class="overflow-auto brand-form">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" name="web_title" class="form-control" required data-validation-required-message="This field is required">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Content</label>
                                                            <textarea name="web_content" class="form-control" required data-validation-required-message="This field is required" rows="2"></textarea>
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Image</label>
                                                            <div class="product-img text-start">
                                                                <input type="file" name="web_image" class="form-control" accept=".jpg,.jpeg,.png">
                                                                <div id="photo-msg" class="text-danger"></div>
                                                                <img id="web_image" src="" height="120" class="mt-2" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Display Order</label>
                                                            <input type="text" name="display_order" class="form-control" required data-validation-required-message="This field is required">
                                                            <div class="help-block"></div>
                                                            <div class="count-info text-start fs-6">Last Order <span id="order_count"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer modal-footer-uniform w-100">
                                                <input type="hidden" name="web_business_id" value="-1">
                                                <button type="button" class="btn btn-primary-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.content -->

                </div>
            </div>
            <!-- /.content-wrapper -->
            <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
            <script src="<?= CSS_PATH ?>/js/pages/business.js"></script>
            <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
            <script>
            const missionStatus = document.getElementById('missionStatus');
            const missionStatusHidden = document.getElementById('missionStatusHidden');
            const statusText = document.getElementById('statusText');

            function updateStatusText() {
                if (missionStatus.checked) {
                    missionStatusHidden.value = '1';
                    if (statusText) statusText.textContent = 'Enabled (1)';
                } else {
                    missionStatusHidden.value = '0';
                    if (statusText) statusText.textContent = 'Disabled (0)';
                }
            }

            missionStatus.addEventListener('change', updateStatusText);
            updateStatusText();
        </script>
        </div>
    </body>
</html>