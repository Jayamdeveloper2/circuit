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
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="row">

                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <form class="form form-setting">
                                    <div class="box-body">
                                        <h4 class="box-title text-primary mb-0"><i class="ti-user me-15"></i> Contact Details</h4>
                                        <hr class="my-15">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Main Title</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Sub Title</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_content_2" value="<?= $data['web_content_2'] ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="input-group mb-3">
                                                        <textarea type="text" class="form-control" rows="3" name="web_content_3"><?= $data['web_content_3'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-at"></i></span>
                                                        <input type="text" name="user_email" value="<?= $data['user_email'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Phone 1</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                                        <input type="text" name="user_phone_1" value="<?= $data['user_phone_1'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Phone 2</label>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                                            <input type="text" name="user_phone_2" value="<?= $data['user_phone_2'] ?? '' ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                </div> -->
                                        </div>

                                        <h4 class="box-title text-primary mb-0"><i class="ti-user me-15"></i> Social Media</h4>
                                        <hr class="my-15">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Facebook</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                                        <input type="text" name="facebook_url" value="<?= $data['facebook_url'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Youtube</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-youtube"></i></span>
                                                        <input type="text" name="youtube_url" value="<?= $data['youtube_url'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Instagram</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                                        <input type="text" name="instagram_url" value="<?= $data['instagram_url'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Whatsapp</label>
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                                        <input type="text" name="whatsapp_url" value="<?= $data['whatsapp_url'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <h4 class="box-title text-primary mb-0"><i class="ti-user me-15"></i> Address</h4>
                                        <hr class="my-15">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Address Line 1</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="address_1" value="<?= $data['address_1'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Address Line 2</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="address_2" value="<?= $data['address_2'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Address Line 3</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="address_3" value="<?= $data['address_3'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Business Hours</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="pincode" value="<?= $data['pincode'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 class="box-title text-primary mb-0"><i class="ti-user me-15"></i> Footer Content</h4>
                                                <hr class="my-15">
                                                <div class="form-group">
                                                    <label class="form-label">Content</label>
                                                    <div class="input-group mb-3">
                                                        <textarea type="text" class="form-control" rows="5" name="about_content"><?= $data['about_content'] ?? '' ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="box-title text-primary mb-0"><i class="ti-user me-15"></i> Contact Us</h4>
                                                <hr class="my-15">
                                                <div class="form-group">
                                                    <label class="form-label">Map URL</label>
                                                    <div class="input-group mb-3">
                                                        <textarea class="form-control" rows="3" name="map_url"><?= $data['map_url'] ?? '' ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-save-alt"></i> Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
        </div>
        <!-- /.content-wrapper -->
        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/js/pages/setting.js"></script>
</body>

</html>