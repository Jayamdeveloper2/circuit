<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css" />



<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

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
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>

                        </div>

                        <div>
                            <button data-pid="-1" class="btn btn-primary edit-approach"> <i class="fi fi-br-plus"></i>
                                Add
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
                                    <div class="table-responsive">
                                        <table id="approach_table" class="text-fade table table-bordered display">

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="approach-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-sm model_vs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><span class="modal-name">Add</span>
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form data-validate class="overflow-auto approach-form">
                                        <div class="modal-body">
                                            <div>
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


                                                </div>

                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label">Content</label>
                                                            <div class="input-group mb-3">
                                                                <textarea class="form-control text-counter"
                                                                    name="web_content"
                                                                    rows="10"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label">Image</label>
                                                            <div class="input-group mb-3">
                                                                <input type="file" class="form-control" name="web_image_2" accept=".jpg,.jpeg,.png">
                                                            </div>
                                                            <div id="photo-msg_2" class="text-danger"></div>
                                                            <img id="web_image_2_preview" src="" height="120" alt="">
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
                                                            <div class="count-info text-start fs-6">Last Order <span id="order_count"></span></div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer modal-footer-uniform w-100">
                                                <input type="hidden" name="web_approach_id" value="-1">
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
        <script src="<?= CSS_PATH ?>/plugins/wysiwyag/jquery.richtext.js"></script>
        <script src="<?= CSS_PATH ?>/js/pages/accomplishmentside.js?v=<?= time() . rand() ?>"></script>
        <!--<script>-->
        <!--$('textarea[name=web_content]').richText();</script>-->
</body>

</html>