<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>
    <link rel="stylesheet" href="<?= CSS_PATH ?>/css/pages/sponsor.css">
     <link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <style>
        ./* Custom Toggle Switch CSS */
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
                                <button data-pid="-1" class="btn btn-primary edit-sponser"> <i class="fi fi-br-plus"></i>
                                    Add <?= isset($title) ? $title : "" ?></button>
                            </div>

                        </div>
                    </div>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">

                            <div class="col-4">
                                <div class="box">
                                    <div class="box-body">
                                        <form class="form sponser-content-form">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="cus-toggle mb-3">
                                                    <label class="form-label fw-bold mb-0">Status</label>
                                                    <div class="d-flex align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden"value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                        <!-- Optional text next to switch -->
                                                        <!-- <span class="ms-2" id="statusText"><?= ($data['status'] == 1) ? 'Enabled (1)' : 'Disabled (0)' ?></span> -->
                                                    </div>
                                                </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Title</label>
                                                            <div class="input-group mb-3">                                                           
                                                                <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>"  class="form-control"  >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Content</label>
                                                            <div class="input-group mb-3">                                                           
                                                                <textarea type="text" name="web_content_2"    class="form-control"  ><?= $data['web_content_2'] ?></textarea
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Upload File</label>
                                                            <div class="input-group mb-3">
                                                                <input type="file" name="web_file_1" class="form-control">
                                                            </div>
                                                        </div>
                                                        <?php if (!empty($data['web_file_1'])): ?>
                                                            <div class="mt-2">
                                                                <a href="<?= base_url('files/content/' . $data['web_file_1']) ?>" download="<?= $data['web_file_1'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                    Download Existing File
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                </div>
                                            </div> 
                                            <!-- /.box-body -->
                                            <div class="box-footer text-end">
                                                <input type="hidden" name="web_content_id" value="<?= $data['web_content_id'] ?>"  >
                                                <button type="submit" class="btn btn-primary" >
                                                    <i class="ti-save-alt"></i> Save
                                                </button>
                                            </div>  
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-8">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="sponser_table" class="text-fade table table-bordered display">

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="sponser-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                             aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                            <div class="modal-dialog modal-sm model_vs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><span class="modal-name">Add</span>
                                            <?= isset($title) ? $title : "" ?></h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form data-validate class="overflow-auto sponser-form">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label class="form-label">Image </label>
                                                        <div class="product-img text-start">
                                                            <div class="input-group  ">
                                                                <input type="file" name="web_image"
                                                                       class="form-control" accept=".jpg,.jpeg,.png,.avif">
                                                            </div>
                                                            <div id="photo-msg" class=" text-danger"></div>
                                                            <img id="web_image" src="" height="120" alt="">
                                                        </div>
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
                                            <input type="hidden" name="web_sponser_id" value="-1">
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
        <script src="<?= CSS_PATH ?>/js/pages/sponsor.js"></script>
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
    </body>

</html>