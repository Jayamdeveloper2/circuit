<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>
<link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
<style>
    .cus-switch { position: relative; display: inline-block; width: 50px; height: 24px; }
    .cus-switch input { opacity: 0; width: 0; height: 0; }
    .cus-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
    .cus-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
    .cus-switch input:checked+.cus-slider { background-color: #2196F3; }
    .cus-switch input:checked+.cus-slider:before { transform: translateX(26px); }
    .cus-toggle { display: flex; align-items: center; justify-content: space-between; }
    
    .section-item { transition: all 0.3s ease; background: #fff; border: 1px solid #dee2e6; }
    .section-item:hover { border-color: #007bff !important; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }
    .drag-handle { cursor: move; color: #adb5bd; padding: 10px; }
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
                            <h3 class="page-title"><?= $breadcrumb ?? "" ?></h3>
                        </div>
                        <button type="button" id="add-belief" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Belief
                        </button>
                    </div>
                </div>

                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-12">
                            <div class="box">
                                <form class="form form-content">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="card bg-light-soft border-0">
                                                    <div class="card-body">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-8">
                                                                <div class="form-group mb-0">
                                                                    <label class="form-label fw-600">Section Title</label>
                                                                    <input type="text" name="web_content_1" value="<?= $data['web_content_1'] ?? '' ?>" class="form-control" placeholder="What We <span>Believe</span>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="cus-toggle mt-4">
                                                                    <label class="form-label fw-bold mb-0">Enable Section</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="cus-switch mb-0">
                                                                            <input type="checkbox" name="missionStatus" id="missionStatus" value="1" <?= (isset($data['status']) && $data['status'] == 1) ? 'checked' : '' ?>>
                                                                            <span class="cus-slider round"></span>
                                                                        </label>
                                                                        <input type="hidden" name="missionStatusHidden" id="missionStatusHidden" value="<?= (isset($data['status']) && $data['status'] == 1) ? '1' : '0' ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div id="beliefs-container">
                                                    <?php
                                                    $beliefs = json_decode($data['web_content_2'] ?? '[]', true);
                                                    if (!is_array($beliefs)) $beliefs = [];
                                                    foreach ($beliefs as $index => $belief): ?>
                                                        <div class="section-item mb-3 p-3 rounded" draggable="true">
                                                            <div class="row g-3 align-items-center">
                                                                <div class="col-auto">
                                                                    <div class="drag-handle"><i class="fas fa-grip-vertical"></i></div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label fs-12 text-muted text-uppercase fw-600">Icon (FontAwesome)</label>
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text bg-white"><i class="<?= $belief['icon'] ?? 'fa-solid fa-microchip' ?> belief-icon-preview"></i></span>
                                                                        <input type="text" name="stats[<?= $index ?>][icon]" value="<?= $belief['icon'] ?? 'fa-solid fa-microchip' ?>" class="form-control belief-icon-input" placeholder="fa-solid fa-microchip">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <label class="form-label fs-12 text-muted text-uppercase fw-600">Belief Text</label>
                                                                    <textarea name="stats[<?= $index ?>][text]" rows="2" class="form-control"><?= $belief['text'] ?? '' ?></textarea>
                                                                </div>
                                                                <div class="col-auto">
                                                                    <button type="button" class="btn btn-danger-light btn-sm remove-belief mt-4">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                                <?php if (empty($beliefs)): ?>
                                                    <div id="no-beliefs-msg" class="text-center py-5 border rounded bg-light-soft">
                                                        <i class="fas fa-heart fs-40 text-muted mb-3 d-block"></i>
                                                        <p class="text-muted mb-0">No beliefs added yet. Click "+ Add Belief" to begin.</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer text-end">
                                        <input type="hidden" name="web_content_id" value="14">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="ti-save-alt me-1"></i> Save Updates
                                        </button>
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
            $(document).ready(function() {
                let container = document.getElementById("beliefs-container");
                let addBtn = document.getElementById("add-belief");
                let noBeliefsMsg = document.getElementById("no-beliefs-msg");

                function updateIndices() {
                    const items = container.querySelectorAll(".section-item");
                    items.forEach((item, index) => {
                        item.querySelectorAll("input, textarea").forEach(field => {
                            const name = field.getAttribute("name");
                            if (name) {
                                field.setAttribute("name", name.replace(/stats\[\d+\]/, `stats[${index}]`));
                            }
                        });
                    });
                    if (noBeliefsMsg) {
                        noBeliefsMsg.style.display = items.length > 0 ? 'none' : 'block';
                    }
                }

                $(document).on('input', '.belief-icon-input', function() {
                    const preview = $(this).closest('.input-group').find('.belief-icon-preview');
                    preview.attr('class', $(this).val() + ' belief-icon-preview');
                });

                addBtn.addEventListener("click", function() {
                    let index = container.querySelectorAll(".section-item").length;
                    let html = `
                    <div class="section-item mb-3 p-3 rounded" draggable="true">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <div class="drag-handle"><i class="fas fa-grip-vertical"></i></div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-12 text-muted text-uppercase fw-600">Icon (FontAwesome)</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-microchip belief-icon-preview"></i></span>
                                    <input type="text" name="stats[${index}][icon]" class="form-control belief-icon-input" placeholder="fa-solid fa-microchip" value="fa-solid fa-microchip">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fs-12 text-muted text-uppercase fw-600">Belief Text</label>
                                <textarea name="stats[${index}][text]" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger-light btn-sm remove-belief mt-4">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;
                    container.insertAdjacentHTML("beforeend", html);
                    updateIndices();
                });

                container.addEventListener("click", function(e) {
                    if (e.target.closest(".remove-belief")) {
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

                const missionStatus = document.getElementById('missionStatus');
                const missionStatusHidden = document.getElementById('missionStatusHidden');
                missionStatus.addEventListener('change', function() {
                    missionStatusHidden.value = this.checked ? '1' : '0';
                });
            });
        </script>
    </div>
</body>
</html>
