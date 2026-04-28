<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

<script>
    const BASE_URL = "<?= base_url() ?>/";
    const ADMIN_URL = "<?= base_url(ADMIN_NAME) ?>/";
</script>

<style>
    .hero-preview { max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; margin-top: 10px; }
    .nav-tabs-custom > .nav-tabs > li.active > a { border-top-color: #3375d6; }
    .framework-tab-content { padding: 20px; background: #fff; border: 1px solid #eee; border-top: none; min-height: 500px; }
    .nav-tabs .nav-link { font-weight: 500; color: #555; }
    .nav-tabs .nav-link.active { color: #0d6efd; font-weight: 700; border-bottom: 3px solid #0d6efd; }
</style>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">
        <div id="loader"></div>
        <?php include APPPATH . "/Views/admin/common/top.php"; ?>
        <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

        <div class="content-wrapper">
            <div class="container-full">
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title">Engineering Frameworks Management</h3>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box shadow-none border">
                                <div class="box-body p-0">
                                    <!-- MAIN TABS -->
                                    <ul class="nav nav-tabs nav-bordered" id="mainFrameworkTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="hero-tab" data-bs-toggle="tab" href="#hero-content" role="tab">
                                                <i class="fa fa-home me-2"></i> Hero
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="scc-tab" data-bs-toggle="tab" href="#scc-content" role="tab">
                                                <i class="fa fa-layer-group me-2"></i> CB-SCC
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="thermal-tab" data-bs-toggle="tab" href="#thermal-content" role="tab">
                                                <i class="fa fa-temperature-high me-2"></i> CB-Thermal
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="lbf-tab" data-bs-toggle="tab" href="#lbf-content" role="tab">
                                                <i class="fa fa-bolt me-2"></i> CB-LBF
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="gaf-tab" data-bs-toggle="tab" href="#gaf-content" role="tab">
                                                <i class="fa fa-random me-2"></i> CB-GAF
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="fmea-tab" data-bs-toggle="tab" href="#fmea-content" role="tab">
                                                <i class="fa fa-exclamation-triangle me-2"></i> CB-FMEA
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="craft-tab" data-bs-toggle="tab" href="#craft-content" role="tab">
                                                <i class="fa fa-cogs me-2"></i> CB-CRAFT
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="mainFrameworkTabContent">
                                        <!-- HERO TAB CONTENT -->
                                        <div class="tab-pane active" id="hero-content" role="tabpanel">
                                            <div class="p-30 bg-white">
                                                <form id="heroForm">
                                                    <h4 class="mb-20 text-primary">Main Hero Section</h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Title</label>
                                                                <input type="text" name="title" class="form-control" value="<?= $hero['web_content_1'] ?? '' ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Description</label>
                                                                <textarea name="description" class="form-control" rows="4" required><?= $hero['web_content_2'] ?? '' ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-end mt-20">
                                                        <button type="submit" class="btn btn-primary shadow-none px-4">Save Hero Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- CB-SCC TAB CONTENT -->
                                        <div class="tab-pane" id="scc-content" role="tabpanel">
                                            <?php include APPPATH . "/Views/admin/pages/frameworks_forms/scc.php"; ?>
                                        </div>

                                        <!-- CB-THERMAL TAB CONTENT -->
                                        <div class="tab-pane" id="thermal-content" role="tabpanel">
                                            <?php include APPPATH . "/Views/admin/pages/frameworks_forms/thermal.php"; ?>
                                        </div>

                                        <!-- CB-LBF TAB CONTENT -->
                                        <div class="tab-pane" id="lbf-content" role="tabpanel">
                                            <?php include APPPATH . "/Views/admin/pages/frameworks_forms/lbf.php"; ?>
                                        </div>

                                        <!-- CB-GAF TAB CONTENT -->
                                        <div class="tab-pane" id="gaf-content" role="tabpanel">
                                            <?php include APPPATH . "/Views/admin/pages/frameworks_forms/gaf.php"; ?>
                                        </div>

                                        <!-- CB-FMEA TAB CONTENT -->
                                        <div class="tab-pane" id="fmea-content" role="tabpanel">
                                            <?php include APPPATH . "/Views/admin/pages/frameworks_forms/fmea.php"; ?>
                                        </div>

                                        <!-- CB-CRAFT TAB CONTENT -->
                                        <div class="tab-pane" id="craft-content" role="tabpanel">
                                            <?php include APPPATH . "/Views/admin/pages/frameworks_forms/craft.php"; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= base_url('assets/js/pages/frameworks_manage.js') ?>"></script>
    </div>
</body>
</html>
