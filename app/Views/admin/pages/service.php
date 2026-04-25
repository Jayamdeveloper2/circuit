<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>

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
                                <h3 class="page-title"> 
                                <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                                </h3>
                            </div>

                            <div>
                                <button data-pid="-1" class="btn btn-primary edit-note"> <i class="fi fi-sr-attribution-pencil"></i>
                                    Edit </button>
                                <button data-pid="-1" class="btn btn-primary edit-service"> <i class="fi fi-br-plus"></i>
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
                                            <table id="service_table" class="text-fade table table-bordered display">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="service-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                                 aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-sm model_vs">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><span class="modal-name">Add</span>

                                                </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form data-validate class="overflow-auto service-form">
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
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label class="form-label w-100">
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
                                                <input type="hidden" name="web_service_id" value="-1">
                                                <button type="button" class="btn btn-primary-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <div id="note-modal" class="modal modal-right fade" tabindex="-1" role="dialog"
                                     aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-sm model_vs">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><span class="modal-name">Edit</span></h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <form data-validate class="overflow-auto note-form">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label class="form-label">Description</label>
                                                                <div class="input-group">
                                                                   <textarea name="description2" rows='5' class="form-control" required id="notedescription"></textarea>
                                                                                        <input type="hidden" name="web_service_note_id" value="-1">
                                                        
                                                                                        </div>
                                                                                        <div class="help-block"></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer modal-footer-uniform w-100">
                                                                          
                                                                            <button type="button" class="btn btn-primary-light"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
</div>

                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->
                </div>
            </div>

            <!-- /.content-wrapper -->
           <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
            <script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
            <script src="<?= CSS_PATH ?>/js/pages/service.js"></script>
            <script>
$(document).ready(function() {

    function loadNoteData() {
        console.log('Loading service note data...');

        let result = common.ajax_fech("getServiceNote", {});

        if (result && result.code === 200) {
            if (result.data) {
               let note = result.data.data || {}; // unwrap the nested data
     console.log("Description:", note.description);

                $('#notedescription').val(note.description || '');
                $('#web_service_note_id').val(note.web_service_note_id || -1);
              
               
            } else {
                console.log("No note found, setting to Add mode");
                $('#notedescription').val('');
                $('#web_service_note_id').val(-1);
                $('.modal-name').text('Add');
            }
        } else {
            console.error("Error fetching service note", result);
            Swal2("error", "Error", "Error loading note data");
        }
    }

    // Form Submit
    $(".note-form").on("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);
        formData.append("for", "edit"); // Always edit

        common.ajax_save_file("saveServiceNote", formData)
            .then(function(response) {
                if (response.code == 200) {
                    loadNoteData(); // Reload notes
                    Swal2("success", "Success", "Note saved successfully").then(() => {
                        $("#note-modal").modal("hide");
                        $(".note-form")[0].reset();
                    });
                } else {
                    Swal2("error", "Error", response.message);
                }
            })
            .catch(function(err) {
                console.error("Save error:", err);
                Swal2("error", "Error", "Please try again later");
            });
    });

    // Edit button click
    $('.edit-note').on('click', function() {
        $('#note-modal').modal('show');
        loadNoteData(); // Fetch and populate first row data
    });
});
</script>

    </body>
</html>