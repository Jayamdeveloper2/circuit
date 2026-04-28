<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

<style>
    .cus-switch { position: relative; display: inline-block; width: 50px; height: 24px; }
    .cus-switch input { opacity: 0; width: 0; height: 0; }
    .cus-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .cus-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    .cus-switch input:checked + .cus-slider { background-color: #2196F3; }
    .cus-switch input:checked + .cus-slider:before { transform: translateX(26px); }

    .dynamic-list-item { margin-bottom: 10px; display: flex; gap: 10px; align-items: center; }
    .hero-preview { max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; margin-top: 10px; }
    .box-header { display: flex; justify-content: space-between; align-items: center; }

    /* Modal Styling Fixes */
    #domainModal .modal-dialog,
    #domainModal .modal-content,
    #domainModal .modal-header,
    #domainModal .modal-body,
    #domainModal .modal-footer,
    #domainModal .row,
    #domainModal [class*="col-"],
    #domainModal .form-group {
        background-color: #ffffff !important;
    }
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
                            <h3 class="page-title"><?= $title ?? "Domain Services Management" ?></h3>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <!-- HERO SECTION MANAGEMENT -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="box shadow-none border">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Hero Section</h4>
                                    <div class="box-controls pull-right">
                                        <label class="cus-switch">
                                            <input type="checkbox" id="heroStatus" <?= ($hero['status'] ?? 1) == 1 ? 'checked' : '' ?>>
                                            <span class="cus-slider"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <form id="heroForm" enctype="multipart/form-data">
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
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary shadow-none">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DETAILED SECTIONS MANAGEMENT -->
                    <div class="row">
                        <div class="col-12">
                            <div class="box shadow-none border">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Domain Detail Sections</h4>
                                    <button class="btn btn-primary btn-sm add-btn shadow-none">
                                        <i class="fa fa-plus me-1"></i> Add New Section
                                    </button>
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="domainTable" class="text-fade table table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Anchor</th>
                                                    <th>Order</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Modal for Adding/Editing Sections -->
            <div class="modal modal-right fade" id="domainModal" tabindex="-1">
                <div class="modal-dialog modal-lg" style="width: 800px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Domain Section Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="domainForm" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Section Anchor (ID)</label>
                                            <input type="text" name="section_anchor" class="form-control" placeholder="e.g. ev" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Title Prefix</label>
                                            <input type="text" name="title_eb" class="form-control" placeholder="e.g. EV Power Electronics" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Main Heading (HTML allowed)</label>
                                    <input type="text" name="heading" class="form-control" placeholder="e.g. Automotive-Grade <span>Power Solutions</span>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <textarea name="description" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Theme Color</label>
                                            <input type="color" name="theme_color" class="form-control form-control-color w-100" value="#1A5276">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold">Display Order</label>
                                            <input type="number" name="display_order" class="form-control" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label fw-bold">Section Image</label>
                                    <input type="file" name="image" class="form-control mb-2" accept="image/*" onchange="previewSvc(this)">
                                    <img id="svcImgPreview" src="" class="hero-preview d-none" alt="Service Preview" style="height: 100px;">
                                </div>

                                <hr>
                                <div class="row">
                                    <!-- What We Design -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">What We Design</label>
                                        <div id="whatWeDesignList"></div>
                                        <button type="button" class="btn btn-xs btn-info mt-1" onclick="addListItem('whatWeDesignList', 'what_we_design[]')">+ Add Item</button>
                                    </div>
                                    <!-- Deliverables -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Deliverables</label>
                                        <div id="deliverablesList"></div>
                                        <button type="button" class="btn btn-xs btn-info mt-1" onclick="addListItem('deliverablesList', 'deliverables[]')">+ Add Item</button>
                                    </div>
                                    <!-- Technologies -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Technologies</label>
                                        <div id="technologiesList"></div>
                                        <button type="button" class="btn btn-xs btn-info mt-1" onclick="addListItem('technologiesList', 'technologies[]')">+ Add Item</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-end gap-2">
                                <input type="hidden" name="web_service_details_id" value="0">
                                <input type="hidden" name="for" value="edit">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary shadow-none">Save Section</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= base_url('assets/js/pages/domain_services.js') ?>"></script>
    </div>
</body>
</html>
