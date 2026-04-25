<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
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

    .cus-switch input:checked + .cus-slider {
        background-color: #2196F3;
    }

    .cus-switch input:checked + .cus-slider:before {
        transform: translateX(26px);
    }

    .cus-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <div class="wrapper">
            <div id="loader"></div>

            <?php include APPPATH . "/Views/admin/common/top.php"; ?>
            <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>
            <!-- Left side column. contains the logo and sidebar -->


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <div class="container-full">
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <h3 class="page-title"> <?= $breadcrumb ?? "" ?></h3>

                            </div>

                            <div>
                                <button data-pid="-1" class="btn btn-primary edit-podcast"> <i class="fi fi-br-plus"></i>
                                    Add <?= isset($title) ? $title : "" ?></button>
                            </div>

                        </div>
                    </div>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">

                            <div class="col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="cus-toggle mb-3">
                                        <label class="form-label mb-0">Page Status</label>
                                        <label class="cus-switch">
                                           <input type="checkbox" id="public_function_manageid" data-section="24" <?= (isset($podcastvideomaster['status']) && $podcastvideomaster['status']==1) ? 'checked' : '' ?>>

                                            <span class="cus-slider"></span>
                                        </label>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="podcast_table" class="text-fade table table-bordered display">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="podcast-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                                 aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-sm model_vs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><span class="modal-name">Add</span>
                                                <?= isset($title) ? $title : "" ?></h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form data-validate class="overflow-auto podcast-form">
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                Title
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="web_title" placeholder=""
                                                                       class="form-control" required=""
                                                                       data-validation-required-message="This field is required"
                                                                       aria-invalid="false">
                                                            </div>
                                                            <div class="help-block"></div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                Post Time
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="web_time" placeholder=""
                                                                       class="form-control" required=""
                                                                       data-validation-required-message="This field is required"
                                                                       aria-invalid="false">
                                                            </div>
                                                            <div class="help-block"></div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label">Content</label>
                                                            <div class="input-group mb-3">
                                                                <textarea class="form-control text-counter"
                                                                          name="web_desc" maxlength="5000"
                                                                          rows="3" required=""></textarea>
                                                            </div>
                                                            <div class="count-info"></div>
                                                        </div>
                                                    </div>


                                                </div>



                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label">
                                                                Youtube URL
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="web_url" placeholder=""
                                                                       class="form-control" required=""
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
                                                            <label class="form-label">
                                                                Display Order
                                                            </label>
                                                            <div class="input-group">
                                                                <input type="text" name="display_order" placeholder=""
                                                                       class="form-control" required=""
                                                                       data-validation-required-message="This field is required"
                                                                       aria-invalid="false">
                                                            </div>
                                                            <div class="help-block"></div>
                                                            <div class="count-info text-start fs-6">Last Order  <span id="order_count"></span></div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer modal-footer-uniform w-100">
                                                <input type="hidden" name="web_podcast_id" value="-1">
                                                <button type="button" class="btn btn-primary-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>


                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->



                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->



                </div>
            </div>

            <!-- /.content-wrapper -->
            <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
            <script src="<?= CSS_PATH ?>/js/pages/podcastlist.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                flatpickr("input[name=web_time]", {
                    enableTime: true, // enable time picker
                    dateFormat: "d/m/Y h:i K", // format: dd/mm/yyyy hh:mm AM/PM
                    time_24hr: false           // 12-hour clock
                });
            </script>
    </body>

</html>