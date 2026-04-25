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
                                <form class="form form-smtp">
                                    <div class="box-body">
                                        <h4 class="box-title text-primary mb-0"><i class="ti-email me-15"></i> SMTP Settings</h4>
                                        <hr class="my-15">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SMTP HOST</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_host_mail" value="<?= $data['web_host_mail'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SMTP USER</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_user_mail" value="<?= $data['web_user_mail'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">TO MAIL</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_to_mail" value="<?= $data['web_to_mail'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SMTP PASS</label>
                                                    <div class="input-group mb-3">
                                                        <input type="password" name="web_pass" value="<?= $data['web_pass'] ?? '' ?>" class="form-control password-field">
                                                        <!-- <span class="input-group-text bg-transparent toggle-password" style="cursor: pointer;">
                                                            <i class="fas fa-eye text-fade password-toggle-icon"></i>
                                                        </span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SMTP PORT</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_port" value="<?= $data['web_port'] ?? '' ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">SMTP CRYPTO (read-only)</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" name="web_crypto" value="<?= $data['web_crypto'] ?? '' ?>" class="form-control" readonly>
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
        <script src="<?= CSS_PATH ?>/js/pages/smtp.js"></script>
</body>

</html>