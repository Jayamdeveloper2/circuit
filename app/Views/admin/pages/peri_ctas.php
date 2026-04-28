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
    #ctaModal .modal-dialog,
    #ctaModal .modal-content,
    #ctaModal .modal-header,
    #ctaModal .modal-body,
    #ctaModal .modal-footer,
    #ctaModal .row,
    #ctaModal [class*="col-"],
    #ctaModal .form-group {
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
                            <h3 class="page-title"><?= $title ?? "PERI Action Cards" ?></h3>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary add-btn shadow-none">
                                <i class="fa fa-plus me-1"></i> Add Action Card
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
                                        <table id="ctaTable" class="text-fade table table-bordered display">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Icon</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
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
            <div class="modal modal-right fade" id="ctaModal" tabindex="-1">
                <div class="modal-dialog modal-lg" style="width: 600px;">
                    <div class="modal-content d-flex flex-column" style="height: 100vh;">
                        <div class="modal-header">
                            <h5 class="modal-title">Action Card Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="cta-form d-flex flex-column flex-grow-1 overflow-hidden">
                            <div class="modal-body flex-grow-1 overflow-auto">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Card Title</label>
                                            <input type="text" name="title" class="form-control" required placeholder="e.g. I am a student or graduate">
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="form-label fw-bold">Description</label>
                                            <textarea name="description" class="form-control" rows="3" required placeholder="Enter short description..."></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Icon (FontAwesome class)</label>
                                                    <input type="text" name="icon" class="form-control" placeholder="e.g. fa-user-graduate" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Theme Color</label>
                                                    <select class="form-select theme-color-select mb-2">
                                                        <option value="var(--blue)">Blue (Standard)</option>
                                                        <option value="#28a745">Green (Success)</option>
                                                        <option value="#d39e00">Orange (Warning)</option>
                                                        <option value="other">Other / Custom Color...</option>
                                                    </select>
                                                    <input type="text" name="theme_color" class="form-control d-none" placeholder="Enter Hex code (e.g. #FF5733)" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Button Link</label>
                                                    <select class="form-select link-select mb-2">
                                                        <option value="contact.php?subject=PERI Training Inquiry">Contact (Training)</option>
                                                        <option value="contact.php?subject=Institutional Collaboration Inquiry">Contact (Institutional)</option>
                                                        <option value="contact.php?subject=Industry Research Conversation">Contact (Industry)</option>
                                                        <option value="contact.php">General Contact</option>
                                                        <option value="other">Other / Custom URL...</option>
                                                    </select>
                                                    <input type="text" name="link" class="form-control d-none" placeholder="e.g. contact.php?subject=..." required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label class="form-label fw-bold">Button Text</label>
                                                    <input type="text" name="link_text" class="form-control" placeholder="e.g. Enquire About the Programme →" required>
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
                                <input type="hidden" name="web_peri_cta_id" value="0">
                                <button type="button" class="btn btn-danger-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary shadow-none">Save Card</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= base_url('assets/js/pages/peri_ctas.js') ?>"></script>
    </div>
</body>
</html>
