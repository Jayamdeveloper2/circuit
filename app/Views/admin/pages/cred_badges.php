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
                                <button data-pid="-1" class="btn btn-primary edit-badge">
                                    <i class="fi fi-br-plus me-1"></i> Add Badge
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="box shadow-none">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="badge_table" class="text-fade table table-bordered display">
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div id="badge-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-sm model_vs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><span class="modal-name">Add</span> Badge</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form data-validate class="overflow-auto badge-form">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Icon (FontAwesome Class) <span class="text-danger">*</span></label>
                                                        <input type="text" name="web_icon" class="form-control" required="" data-validation-required-message="This field is required" placeholder="e.g. fas fa-history">
                                                        <i class='' id='web_icon_preview' style=" font-size: 20px; padding: 10px; "></i>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Title (Bold Text) <span class="text-danger">*</span></label>
                                                        <input type="text" name="web_title" class="form-control" required="" data-validation-required-message="This field is required" placeholder="e.g. 18+">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Label (Span Text)</label>
                                                        <input type="text" name="web_label" class="form-control" placeholder="e.g. Years of Experience">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Display Order</label>
                                                        <input type="number" name="display_order" class="form-control" required="" data-validation-required-message="This field is required">
                                                        <div class="help-block"></div>
                                                        <div class="count-info text-start fs-6">Last Order <span id="order_count"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer modal-footer-uniform w-100">
                                            <input type="hidden" name="web_cred_badge_id" value="-1">
                                            <button type="button" class="btn btn-primary-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
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
        <script src="<?= CSS_PATH ?>/js/pages/cred_badges.js"></script>
</body>

</html>
