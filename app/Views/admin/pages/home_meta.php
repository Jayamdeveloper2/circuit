<!DOCTYPE html>
<html lang="en">
    <?php include APPPATH . "/Views/admin/common/header.php"; ?>

    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">

        <div class="wrapper">
            <div id="loader"></div>

            <?php include APPPATH . "/Views/admin/common/top.php"; ?>
            <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <div class="container-full">
                    <!-- Content Header -->
                    <div class="content-header">
                        <div class="d-flex align-items-center">
                            <div class="me-auto">
                                <h3 class="page-title"> <?= isset($title) ? $title : "Home Page Meta SEO" ?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="col-12">
                                <div class="box">
                                    <div class="box-body">
                                        <form class="home-meta-form" data-validate>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form-label">Meta Title</label>
                                                        <div class="input-group">
                                                            <input type="text" name="meta_title" value="<?= $data['meta_title'] ?? '' ?>" class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form-label">Meta Description</label>
                                                        <div class="input-group">
                                                            <textarea name="meta_desc" class="form-control" rows="4"><?= $data['meta_desc'] ?? '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="form-label">Meta Keywords</label>
                                                        <div class="input-group">
                                                            <textarea name="meta_key" class="form-control" rows="4"><?= $data['meta_key'] ?? '' ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-8 text-end">
                                                    <input type="hidden" name="for" value="edit_home_meta">
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
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
            <script>
                $(".home-meta-form").on("submit", function (event) {
                    event.preventDefault();
                    
                    const formData = new FormData(this);
                    
                    common.ajax_save_file("saveHomeMeta", formData)
                        .then(function (response) {
                            if (response.code == 200) {
                                Swal2("success", "Success", "Successfully Saved Meta Tags");
                            } else {
                                Swal2("error", "Error", response.message || "Something went wrong.");
                            }
                        })
                        .catch(function (error) {
                            Swal2("error", "Error", "Please try again later.");
                        });
                });
            </script>
    </body>

</html>
