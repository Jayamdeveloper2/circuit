<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
<style>
    .section-item {
        transition: all 0.3s ease;
        background: #fdfdfd;
    }
    .section-item:hover {
        background: #f8f9fa;
        border-color: #0052cc !important;
    }
    .drag-handle {
        cursor: move;
        color: #adb5bd;
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
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="me-auto">
                            <?php if (isset($breadcrumb)) : ?>
                                <?= $breadcrumb ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" id="add-stat" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add
                        </button>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="box shadow-none border-0 mb-0">
                                <form class="form form-content">
                                    <div class="box-body p-0">
                                        <div class="card shadow-none border mb-0">
                                            <div class="card-header d-flex justify-content-between align-items-center py-2 px-3 bg-light-soft">
                                                <h5 class="card-title mb-0 fs-14 fw-600 text-uppercase tracking-wider text-muted">Section Configuration</h5>
                                                <div class="cus-toggle">
                                                    <label class="cus-switch mb-0">
                                                        <input type="checkbox" name="missionStatus" id="missionStatus" value="1" <?= ($data['status'] == 1) ? 'checked' : '' ?>>
                                                        <span class="cus-slider round"></span>
                                                    </label>
                                                    <input type="hidden" name="missionStatusHidden" id="missionStatusHidden" value="<?= ($data['status'] == 1) ? '1' : '0' ?>">
                                                </div>
                                            </div>
                                            <div class="card-body p-4">
                                                <div id="stats-container">
                                                    <?php
                                                    $stats = json_decode($data['web_content_2'] ?? '[]', true);
                                                    if (!is_array($stats)) $stats = [];

                                                    foreach ($stats as $index => $stat): ?>
                                                        <div class="section-item mb-3 border p-3 rounded" draggable="true">
                                                            <div class="row g-3 align-items-center">
                                                                <div class="col-auto">
                                                                    <div class="drag-handle">
                                                                        <i class="fas fa-grip-vertical"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="form-label fs-12 text-muted text-uppercase fw-600">Value</label>
                                                                    <input type="text" name="stats[<?= $index ?>][count]" value="<?= $stat['count'] ?? '' ?>" class="form-control form-control-sm" placeholder="e.g. 30">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="form-label fs-12 text-muted text-uppercase fw-600">Suffix</label>
                                                                    <input type="text" name="stats[<?= $index ?>][suffix]" value="<?= $stat['suffix'] ?? '' ?>" class="form-control form-control-sm" placeholder="e.g. kW">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label fs-12 text-muted text-uppercase fw-600">Title</label>
                                                                    <input type="text" name="stats[<?= $index ?>][title]" value="<?= $stat['title'] ?? '' ?>" class="form-control form-control-sm" placeholder="Counter Title">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label fs-12 text-muted text-uppercase fw-600">Description</label>
                                                                    <input type="text" name="stats[<?= $index ?>][desc]" value="<?= $stat['desc'] ?? '' ?>" class="form-control form-control-sm" placeholder="Short description">
                                                                </div>
                                                                <div class="col-auto">
                                                                    <label class="form-label d-block">&nbsp;</label>
                                                                    <button type="button" class="btn btn-danger-light btn-sm remove-stat">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                                <?php if (empty($stats)): ?>
                                                    <div id="no-stats-msg" class="text-center py-5 border rounded bg-light-soft">
                                                        <i class="fas fa-list-ol fs-40 text-muted mb-3 d-block"></i>
                                                        <p class="text-muted mb-0">No counters added yet. Click "+ Add Counter" to begin.</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-footer bg-white text-end border-top py-3 px-4">
                                                <input type="hidden" name="web_content_id" value="<?= $data['web_content_id'] ?>">
                                                <input type="hidden" name="for" value="edit">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="fas fa-save me-1"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>
        <script src="<?= CSS_PATH ?>/js/pages/content.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let container = document.getElementById("stats-container");
                let addBtn = document.getElementById("add-stat");
                let noStatsMsg = document.getElementById("no-stats-msg");

                function updateIndices() {
                    const items = container.querySelectorAll(".section-item");
                    items.forEach((item, index) => {
                        item.querySelectorAll("input").forEach(input => {
                            const name = input.getAttribute("name");
                            if (name) {
                                input.setAttribute("name", name.replace(/stats\[\d+\]/, `stats[${index}]`));
                            }
                        });
                    });
                    if (noStatsMsg) {
                        noStatsMsg.style.display = items.length > 0 ? 'none' : 'block';
                    }
                }

                addBtn.addEventListener("click", function() {
                    let index = container.querySelectorAll(".section-item").length;
                    let html = `
                    <div class="section-item mb-3 border p-3 rounded" draggable="true">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <div class="drag-handle"><i class="fas fa-grip-vertical"></i></div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fs-12 text-muted text-uppercase fw-600">Value</label>
                                <input type="text" name="stats[${index}][count]" class="form-control form-control-sm" placeholder="e.g. 30">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fs-12 text-muted text-uppercase fw-600">Suffix</label>
                                <input type="text" name="stats[${index}][suffix]" class="form-control form-control-sm" placeholder="e.g. kW">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-12 text-muted text-uppercase fw-600">Title</label>
                                <input type="text" name="stats[${index}][title]" class="form-control form-control-sm" placeholder="Counter Title">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fs-12 text-muted text-uppercase fw-600">Description</label>
                                <input type="text" name="stats[${index}][desc]" class="form-control form-control-sm" placeholder="Short description">
                            </div>
                            <div class="col-auto">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger-light btn-sm remove-stat">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;
                    container.insertAdjacentHTML("beforeend", html);
                    updateIndices();
                });

                container.addEventListener("click", function(e) {
                    if (e.target.closest(".remove-stat")) {
                        e.target.closest(".section-item").remove();
                        updateIndices();
                    }
                });

                // Drag & drop sorting
                let dragged;
                container.addEventListener("dragstart", function(e) {
                    if (e.target.classList.contains("section-item")) {
                        dragged = e.target;
                        e.target.style.opacity = 0.5;
                    }
                });
                container.addEventListener("dragend", function(e) {
                    if (dragged) {
                        dragged.style.opacity = "";
                        updateIndices();
                    }
                });
                container.addEventListener("dragover", function(e) {
                    e.preventDefault();
                    let target = e.target.closest(".section-item");
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

                // Status Switch logic
                const missionStatus = document.getElementById('missionStatus');
                const missionStatusHidden = document.getElementById('missionStatusHidden');
                missionStatus.addEventListener('change', function() {
                    missionStatusHidden.value = this.checked ? '1' : '0';
                });
            });
        </script>
</body>
</html>