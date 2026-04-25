<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<link href="<?= CSS_PATH ?>/plugins/wysiwyag/richtext.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
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
        <div id="loader"></div>

        <?php include APPPATH . "/Views/admin/common/top.php"; ?>
        <?php include APPPATH . "/Views/admin/common/side_nav.php"; ?>
        <!-- Left side column. contains the logo and sidebar -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container-full">
                <!-- Page Header -->
                <div class="content-header">
                    <div class="d-flex align-items-center">
                        <div class="me-auto">
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <form class="form form-content">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="cus-toggle mb-3">
                                                    <label class="form-label fw-bold mb-0">Status</label>
                                                    <div class="d-flex align-items-center">
                                                        <label class="cus-switch mb-0">
                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1"
                                                                <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                            <span class="cus-slider round"></span>
                                                        </label>
                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden" value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                        <!-- Optional text next to switch -->
                                                        <!-- <span class="ms-2" id="statusText"><?= ($data['status'] == 1) ? 'Enabled (1)' : 'Disabled (0)' ?></span> -->
                                                    </div>
                                                </div>



                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label class="form-label">Title</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Sections (Icon, Title & Content)</label><small class="form-text text-muted d-block mt-1">
                                                👉 Drag & drop rows to rearrange order.
                                            </small>
                                            <div id="sections-container">
                                                <?php
                                                $stats = json_decode($data['web_content_2'] ?? '[]', true);
                                                if (!is_array($stats)) {
                                                    $stats = [];
                                                }
                                                foreach ($stats as $index => $section): ?>
                                                    <div class="row section-item mb-3 border p-2 rounded " draggable="true" style="    border: 1px solid #3c6a98 !important;">

                                                        <!-- Icon -->
                                                        <div class="col-md-3">
                                                            <label class="form-label">Icon (FA class)</label>
                                                            <input type="text" name="stats[<?= $index ?>][icon]"
                                                                value="<?= htmlspecialchars($section['icon'] ?? '') ?>"
                                                                class="form-control" placeholder="fas fa-star">
                                                            <span class="text-muted "><i class="<?= htmlspecialchars($section['icon'] ?? 'fas fa-star') ?>"></i></span>
                                                        </div>

                                                        <!-- Title -->
                                                        <div class="col-md-3">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" name="stats[<?= $index ?>][title]"
                                                                value="<?= htmlspecialchars($section['title'] ?? '') ?>"
                                                                class="form-control" placeholder="Enter Title">
                                                        </div>

                                                        <!-- Content -->
                                                        <div class="col-md-4" style="width: 48.333333%;">
                                                            <label class="form-label">Content</label>
                                                            <textarea name="stats[<?= $index ?>][content]"
                                                                rows="3" class="form-control"
                                                                placeholder="Enter Content"><?= htmlspecialchars($section['content'] ?? '') ?></textarea>
                                                        </div>

                                                        <!-- Remove -->
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button type="button" class="btn btn-danger remove-section">X</button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                            <button type="button" id="add-section" class="btn btn-primary mt-2">+ Add Section</button>

                                        </div>



                                    </div>




                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-end">
                                <input type="hidden" name="web_content_id" value="<?= $data['web_content_id'] ?>">
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
    <script src="<?= CSS_PATH ?>/plugins/wysiwyag/jquery.richtext.js"></script>

    <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>
    <?php if ($richText ?? false) { ?>
        <script>
            $('textarea[name=web_content_2]').richText();
        </script>
    <?php } ?>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let container = document.getElementById("sections-container");
        let addBtn = document.getElementById("add-section");

        addBtn.addEventListener("click", function() {
            let index = container.querySelectorAll(".section-item").length;
            let html = `
        <div class="row section-item mb-3 border p-2 rounded">
            <div class="col-md-3">
                <label class="form-label">Icon (FA class)</label>
                <input type="text" name="stats[${index}][icon]" class="form-control icon-input" placeholder="fas fa-star">
                <small class="text-muted">Preview: <i class="fas fa-star"></i></small>
            </div>
            <div class="col-md-3">
                <label class="form-label">Title</label>
                <input type="text" name="stats[${index}][title]" class="form-control" placeholder="Enter Title">
            </div>
            <div class="col-md-4">
                <label class="form-label">Content</label>
                <textarea name="stats[${index}][content]" rows="3" class="form-control" placeholder="Enter Content"></textarea>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-section">X</button>
            </div>
        </div>`;
            container.insertAdjacentHTML("beforeend", html);
        });

        container.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-section")) {
                e.target.closest(".section-item").remove();
            }
        });
        let dragged;
        container.addEventListener("dragstart", function(e) {
            if (e.target.classList.contains("section-item")) { // FIXED
                dragged = e.target;
                e.target.style.opacity = 0.5;
            }
        });
        container.addEventListener("dragend", function(e) {
            if (dragged) dragged.style.opacity = "";
        });
        container.addEventListener("dragover", function(e) {
            e.preventDefault();
            let target = e.target.closest(".section-item"); // FIXED
            if (target && target !== dragged) {
                let bounding = target.getBoundingClientRect();
                let offset = bounding.y + bounding.height / 2;
                if (e.clientY - offset > 0) {
                    target.after(dragged);
                } else {
                    target.before(dragged);
                }
            }
        });

        // Live icon preview update
        container.addEventListener("input", function(e) {
            if (e.target.classList.contains("icon-input")) {
                let icon = e.target.value.trim();
                let preview = e.target.closest(".col-md-3").querySelector("small i");
                preview.className = icon || "fas fa-star";
            }
        });

        // Enable drag & drop sorting if jQuery UI available
        if (typeof $ !== "undefined" && typeof $.fn.sortable !== "undefined") {
            $("#sections-container").sortable({
                handle: ".section-item",
                placeholder: "sortable-placeholder"
            });
        }
    });
    const missionStatus = document.getElementById('missionStatus');
    const missionStatusHidden = document.getElementById('missionStatusHidden');
    const statusText = document.getElementById('statusText');

    function updateStatusText() {
        if (missionStatus.checked) {
            missionStatusHidden.value = '1';
            if (statusText) statusText.textContent = 'Enabled (1)';
        } else {
            missionStatusHidden.value = '0';
            if (statusText) statusText.textContent = 'Disabled (0)';
        }
    }

    missionStatus.addEventListener('change', updateStatusText);
    updateStatusText();
</script>


</html>