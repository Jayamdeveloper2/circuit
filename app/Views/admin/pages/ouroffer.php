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

                    <!-- ====== INCLUDE FIRST SECTION FROM careercontent.php WITH BREADCRUMBS====== -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                        <div>
                            <button data-pid="-1" class="btn btn-primary edit-industry">
                                <i class="fi fi-br-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box">
                                    <div class="box-body">
                                        <form class="form form-content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="cus-toggle mb-3">
                                                        <label class="form-label fw-bold mb-0"></label>
                                                        <div class="d-flex align-items-center">
                                                            <label class="cus-switch mb-0">
                                                                <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                    <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                                <span class="cus-slider round"></span>
                                                            </label>
                                                            <input type="hidden" name="missionStatusHidden" id="missionStatusHidden"value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Title</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control">


                                                                <input type="hidden" name="web_content_id" value="<?= $data["web_content_id"] ?>">
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-save"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="table-responsive mt-30">
                                            <table id="industry_table" class="text-fade table table-bordered display">
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div id="brand-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-sm model_vs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">
                                    <span class="modal-name">Add</span>
                                </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form data-validate class="overflow-auto brand-form">
                                <div class="modal-body">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="form-label">Title</label>
                                                    <div class="input-group">
                                                        <input type="text" name="web_title" placeholder=""
                                                            class="form-control" required
                                                            data-validation-required-message="This field is required"
                                                            aria-invalid="false">
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="input-group">
                                                        <textarea name="web_content" placeholder="" class="form-control" required data-validation-required-message="This field is required" aria-invalid="false" rows="2"></textarea>
                                                    </div>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="form-label">Image </label>
                                                    <div class="product-img text-start">
                                                        <div class="input-group">
                                                            <input type="file" name="web_image"
                                                                class="form-control" accept=".jpg,.jpeg,.png">
                                                        </div>
                                                        <div id="photo-msg" class="text-danger"></div>
                                                        <img id="web_image" src="" height="120" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="form-label">Display Order</label>
                                                    <div class="input-group">
                                                        <input type="text" name="display_order" placeholder=""
                                                            class="form-control" required
                                                            data-validation-required-message="This field is required"
                                                            aria-invalid="false">
                                                    </div>
                                                    <div class="help-block"></div>
                                                    <div class="count-info text-start fs-6">
                                                        Last Order <span id="order_count"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer modal-footer-uniform w-100">
                                        <input type="hidden" name="web_industry_id" value="-1">
                                        <button type="button" class="btn btn-primary-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                    <!-- /.content -->

                </div>
            </div>
            <!-- /.content-wrapper -->
            <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
            <script src="<?= CSS_PATH ?>/js/pages/industry.js"></script>
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