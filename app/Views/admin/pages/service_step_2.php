<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>
    <link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css"/>
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
                                <h3 class="page-title"> <?= isset($title) ? $title : "" ?> <i style="font-size: 14px" class="fa fa-angle-up fa-rotate-90"></i> <?=$service_name?> <i style="font-size: 14px" class="fa fa-angle-up fa-rotate-90"></i> <?=$step_1?> </h3>

                            </div>

                            <div>
                                 <a  class="btn btn-danger" href="<?=base_url(ADMIN_NAME . '/service-manage/'.$web_service_step_1_id)?>" ><i class="fas fa-arrow-left"></i> Back</a>
                                
                                <button data-pid="-1" class="btn btn-primary edit-servicestep2"> <i class="fi fi-br-plus"></i>
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
                                            <table id="servicestep2_table" class="text-fade table table-bordered display">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="servicestep2-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                                 aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-sm model_vs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><span class="modal-name">Add</span>

                                                </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form data-validate class="overflow-auto servicestep2-form">
                                            <div class="modal-body">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Title
                                                                </label>
                                                                <div class="input-group">
                                                                    <input type="text" name="web_title" placeholder=""
                                                                           class="form-control" 
                                                                           data-validation-required-message="This field is required"
                                                                           aria-invalid="false">
                                                                </div>
                                                                <div class="help-block"></div>
                                                            </div>

                                                        </div>
                                                        
                                                        
                                                        <!-- <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Show Footer</label>
                                                                <div class="controls row">
                                                                    <fieldset class="col-md-4">
                                                                        <input name="is_menu" type="radio" id="is_menu_yes" value="1"  aria-invalid="true" class="is-valid">
                                                                        <label for="is_menu_yes">Yes</label>
                                                                    </fieldset>
                                                                    <fieldset class="col-md-4">
                                                                        <input name="is_menu" type="radio" id="is_menu_no" value="0" checked  aria-invalid="false" class="is-valid">
                                                                        <label for="is_menu_no">NO</label>
                                                                    </fieldset>                                                                    
                                                                </div>
                                                                <div class="invalid-feedback" style="display: none;">Please select a Menu.</div>
                                                            </div>
                                                        </div> -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">
                                                                        Display Order
                                                                    </label>
                                                                    <div class="input-group">
                                                                        <input type="text" name="display_order" placeholder=""
                                                                               class="form-control" 
                                                                               data-validation-required-message="This field is required"
                                                                               aria-invalid="false">
                                                                    </div>
                                                                    <div class="help-block"></div>
                                                                    <div class="count-info text-start fs-6">Last Order  <span id="order_count"></span></div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Is Category<span class="text-danger">*</span></label>
                                                                <div class="controls row">
                                                                    <fieldset class="col-md-4">
                                                                        <input name="is_next_level" type="radio" id="is_next_level_yes" value="1"  aria-invalid="true" class="is-valid">
                                                                        <label for="is_next_level_yes">Yes</label>
                                                                    </fieldset>
                                                                    <fieldset class="col-md-4">
                                                                        <input name="is_next_level" type="radio" id="is_next_level_no" value="0"  aria-invalid="false" class="is-valid">
                                                                        <label for="is_next_level_no">NO</label>
                                                                    </fieldset>                                                                    
                                                                </div>
                                                                <div class="invalid-feedback" style="display: none;">Please select a Category.</div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="row d-none" id="show_content">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Content</label>
                                                                <div class="input-group mb-3">
                                                                    <textarea class="form-control text-counter"
                                                                              name="web_content"  
                                                                              rows="3" ></textarea>
                                                                </div>
                                                                <div class="count-info"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h4 class="form-label text-primary">Poins to ponder</h4>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Category Title 1
                                                                </label>
                                                                <div class="input-group">
                                                                    <input type="text" name="web_cate_title_1" placeholder=""
                                                                           class="form-control" 
                                                                           data-validation-required-message="This field is required"
                                                                           aria-invalid="false">
                                                                </div>
                                                                <div class="help-block"></div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Category Content 1</label>
                                                                <div class="input-group mb-3">
                                                                    <textarea class="form-control text-counter"
                                                                              name="web_cate_content_1"  
                                                                              rows="3" ></textarea>
                                                                </div>
                                                                <div class="count-info"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Category Title 2
                                                                </label>
                                                                <div class="input-group">
                                                                    <input type="text" name="web_cate_title_2" placeholder=""
                                                                           class="form-control" 
                                                                           data-validation-required-message="This field is required"
                                                                           aria-invalid="false">
                                                                </div>
                                                                <div class="help-block"></div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Category Content 2</label>
                                                                <div class="input-group mb-3">
                                                                    <textarea class="form-control text-counter"
                                                                              name="web_cate_content_2"  
                                                                              rows="3" ></textarea>
                                                                </div>
                                                                <div class="count-info"></div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">
                                                                    Category Title 3
                                                                </label>
                                                                <div class="input-group">
                                                                    <input type="text" name="web_cate_title_3" placeholder=""
                                                                           class="form-control" 
                                                                           data-validation-required-message="This field is required"
                                                                           aria-invalid="false">
                                                                </div>
                                                                <div class="help-block"></div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Category Content 3</label>
                                                                <div class="input-group mb-3">
                                                                    <textarea class="form-control text-counter"
                                                                              name="web_cate_content_3"  
                                                                              rows="3" ></textarea>
                                                                </div>
                                                                <div class="count-info"></div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Image </label>
                                                                <div class="product-img text-start">
                                                                    <div class="input-group  ">
                                                                        <input type="file" name="web_image"
                                                                               class="form-control" accept=".jpg,.jpeg,.png">
                                                                    </div>
                                                                    <div id="photo-msg" class=" text-danger"></div>
                                                                    <img id="web_image" src="" height="120" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                                <div class="modal-footer modal-footer-uniform w-100">
                                                    <input type="hidden" name="web_service_step_1_id" value="<?= $web_service_step_1_id ?>">
                                                    <input type="hidden" name="web_service_step_2_id" value="-1">
                                                    <input type="hidden" name="web_service_id" value="<?= $web_service_id ?>">
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
            <script>
                const web_service_id = <?= $web_service_id ?>;
                const web_service_step_1_id = <?= $web_service_step_1_id ?>;
            </script>
            <script src="<?= CSS_PATH ?>/js/pages/servicestep2.js"></script>
    </body>

</html>