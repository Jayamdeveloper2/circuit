<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Custom Toggle Switch CSS */
    .cus-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .cus-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .cus-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .cus-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .cus-switch input:checked+.cus-slider {
        background-color: #2196F3;
    }

    .cus-switch input:checked+.cus-slider:before {
        transform: translateX(26px);
    }

    .cus-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div class="wrapper">

        <?php include APPPATH . "/Views/admin/common/top.php"; ?>
        <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>

        <div class="content-wrapper">
            <div class="container-full">

                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"><?= $breadcrumb ?></h3>
                        </div>
                        <div class="me-2">
                            <a href="<?= base_url(ADMIN_NAME . '/product-manage') ?>" class="btn btn-secondary">
                                <i class="fi fi-br-arrow-left"></i> Back
                            </a>
                        </div>
                        <div>
                            <button class="btn btn-primary add-video">
                                <i class="fi fi-br-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>

                <section class="content">

                    <div class="box">
                        <div class="box-body">
                            <form class="form form-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cus-toggle mb-3">
                                            <label class="form-label fw-bold mb-0"></label>
                                            <div class="d-flex align-items-center">
                                                <label class="cus-switch mb-0">
                                                    <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                        <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                    <span class="cus-slider round"></span>
                                                </label>
                                                <input type="hidden" name="missionStatusHidden" id="missionStatusHidden"
                                                    value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label">Title</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control">
                                                    <input type="hidden" name="web_content_id" value="<?= $data["web_content_id"] ?>">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table id="event_video_table" class="table table-bordered display"></table>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL -->
                    <div id="video-modal" class="modal fade">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4>Add</h4>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form class="video-form">
                                    <div class="modal-body">

                                        <input type="hidden" id="web_event_id" name="web_event_id" value="<?= $event_id ?>">

                                        <div class="form-group mb-3">
                                            <label>Icon Title</label>
                                            <input type="text" id="video_title" name="video_title" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label>Icon Class (e.g. fas fa-home)</label>
                                            <input type="text" id="video_url" name="video_url" class="form-control" placeholder="fas fa-home" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Display Order</label>
                                            <input type="text" id="display_order" name="display_order" class="form-control" required>
                                            <div class="count-info">
                                                Last Order <span id="order_count"></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Save</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>

        <script>
            const base_url = "<?= base_url() ?>";
        </script>
        <script src="<?= CSS_PATH ?>/js/pages/event_videos.js?v=<?= time() ?>"></script>
        <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
        <script>
            const missionStatus = document.getElementById('missionStatus');
            const missionStatusHidden = document.getElementById('missionStatusHidden');

            function updateStatusText() {
                if (missionStatus.checked) {
                    missionStatusHidden.value = '1';
                } else {
                    missionStatusHidden.value = '0';
                }
            }

            missionStatus.addEventListener('change', updateStatusText);
            updateStatusText();
        </script>

    </div>
</body>

</html>