<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">

        <?php include APPPATH . "/Views/admin/common/top.php"; ?>
        <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

        <div class="content-wrapper">
            <div class="container-full">

                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                        <div>
                            <button data-pid="-1" class="btn btn-primary edit-event">
                                <i class="fi fi-br-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>

                <section class="content">

                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="event_table" class="text-fade table table-bordered display"></table>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL -->
                    <div id="event-modal" class="modal modal-right fade" tabindex="-1">
                        <div class="modal-dialog modal-sm model_vs">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        <span class="modal-name">Add</span>
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form class="event-form" enctype="multipart/form-data">

                                    <div class="modal-body overflow-auto">

                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="event_title" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="event_content" id="event_content" class="form-control" rows="4"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Cover Image</label>
                                            <input type="file" name="event_image" id="event_image_input" class="form-control" accept=".jpg,.jpeg,.png">
                                            <div id="event-photo-msg" class="text-danger mt-1"></div>

                                            <!-- Current saved image (from DB) -->
                                            <div id="event_current_image_wrap" style="display:none; margin-top:8px;">
                                                <small class="text-muted d-block mb-1">Current Image:</small>
                                                <img id="event_current_image" src="" height="90"
                                                    style="border-radius:6px; border:1px solid #ddd; object-fit:cover;">
                                            </div>

                                            <!-- New file upload preview -->
                                            <div id="event_new_image_wrap" style="display:none; margin-top:8px;">
                                                <small class="text-muted d-block mb-1">New Image Preview:</small>
                                                <img id="event_image_preview" src="" height="90"
                                                    style="border-radius:6px; border:1px solid #ddd; object-fit:cover;">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Display Order</label>
                                            <input type="text" name="display_order" class="form-control" required>
                                            <div class="count-info">
                                                Last Order <span id="order_count"></span>
                                            </div>
                                        </div>

                                        <input type="hidden" name="web_event_id" value="-1">

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary-light" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>

        <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
        <script>
            const base_url = "<?= base_url('/') ?>";

            $(function() {
                CKEDITOR.replace('event_content');
            });

            // Image preview (new upload)
            $("#event_image_input").on("change", function(event) {
                const file = event.target.files[0];
                const allowed = /(\.jpg|\.jpeg|\.png)$/i;
                const msg = $("#event-photo-msg");
                if (file) {
                    if (!allowed.test(file.name)) {
                        msg.text("Invalid file type! Only jpg, jpeg, png allowed.");
                        $("#event_new_image_wrap").hide();
                        return;
                    }
                    msg.text("");
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $("#event_image_preview").attr("src", e.target.result);
                        $("#event_new_image_wrap").show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $("#event_new_image_wrap").hide();
                    msg.text("");
                }
            });
        </script>

        <script src="<?= CSS_PATH ?>/js/pages/event.js?v=<?= time() ?>"></script>

    </div>
</body>

</html>