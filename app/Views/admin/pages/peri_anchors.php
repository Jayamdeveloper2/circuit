<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

<style>
    .cus-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .cus-switch input { opacity: 0; width: 0; height: 0; }
    .cus-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }
    .cus-slider:before {
        position: absolute;
        content: "";
        height: 18px; width: 18px; left: 3px; bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    .cus-switch input:checked + .cus-slider { background-color: #2196F3; }
    .cus-switch input:checked + .cus-slider:before { transform: translateX(26px); }

    /* Modal Styling Fixes */
    #anchorModal .modal-dialog,
    #anchorModal .modal-content,
    #anchorModal .modal-header,
    #anchorModal .modal-body,
    #anchorModal .modal-footer,
    #anchorModal .row,
    #anchorModal [class*="col-"],
    #anchorModal .form-group {
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
                            <h3 class="page-title"><?= $breadcrumb ?? "PERI Anchor Cards" ?></h3>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary add-btn shadow-none">
                                <i class="fa fa-plus me-1"></i> Add Anchor Card
                            </button>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box shadow-none border">
                                <div class="box-body p-0">
                                    <div class="table-responsive">
                                        <table id="anchorTable" class="text-fade table table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Title</th>
                                                    <th>Subtitle</th>
                                                    <th>Link/Anchor</th>
                                                    <th>Order</th>
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

            <!-- Modal -->
            <div class="modal modal-right fade" id="anchorModal" tabindex="-1">
                <div class="modal-dialog modal-lg" style="width: 600px;">
                    <div class="modal-content d-flex flex-column" style="height: 100vh;">
                        <div class="modal-header">
                            <h5 class="modal-title">Anchor Card Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="anchor-form d-flex flex-column flex-grow-1 overflow-hidden">
                            <div class="modal-body flex-grow-1 overflow-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Card Title</label>
                                            <input type="text" name="title" class="form-control" required placeholder="e.g. For Students & Graduates">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Description</label>
                                            <textarea name="description" class="form-control" rows="3" required placeholder="Enter short description..."></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Anchor Link (ID)</label>
                                                    <input type="text" name="anchor_link" class="form-control" placeholder="e.g. #training">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Link Text</label>
                                                    <input type="text" name="anchor_text" class="form-control" placeholder="e.g. Explore PERI Training ↓">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Display Order</label>
                                                    <input type="number" name="display_order" class="form-control" value="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Status</label>
                                                    <select name="is_active" class="form-select">
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:1px solid #eee;">
                                <input type="hidden" name="web_peri_anchor_id" value="0">
                                <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary shadow-none">Save Card</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/js/pages/peri_anchors.js"></script>
    </div>
</body>
</html>
