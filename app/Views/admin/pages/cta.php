<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
        <div id="loader"></div>
        <?php include APPPATH . "/Views/admin/common/top.php"; ?>
        <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                <div class="content-header p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h5 class="page-title text-muted fw-normal" style="font-size: 16px;">
                                General <span class="mx-2"><i class="fa fa-chevron-right" style="font-size: 10px;"></i></span> 
                                <span class="text-dark fw-normal">Call to Action</span>
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box border-0 shadow-sm">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="cta_table" class="text-fade table table-bordered display">
                                            <!-- DataTables will populate this -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Edit Modal (Right-side drawer) -->
        <div id="cta-modal" class="modal modal-right fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-sm model_vs">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="modal-name">Edit</span> Call to Action</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="cta-form overflow-auto">
                        <div class="modal-body">
                            <input type="hidden" name="tag">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Page Tag</label>
                                        <input type="text" class="form-control" id="displayTag" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">CTA Title</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="title" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">CTA Content / Description</label>
                                        <div class="input-group">
                                            <textarea name="content" rows="6" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer modal-footer-uniform w-100">
                            <button type="button" class="btn btn-primary-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= base_url('assets/js/pages/cta.js') ?>"></script>
    </div>
</body>
</html>
