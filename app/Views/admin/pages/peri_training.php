<!DOCTYPE html>
<html lang="en">
<?php include APPPATH . "/Views/admin/common/header.php"; ?>

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
                            <h3 class="page-title"><?= $title ?? "Students & Graduates Section" ?></h3>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <form class="peri-training-form">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="nav-tabs-custom shadow-none border">
                                    <ul class="nav nav-tabs">
                                        <li><a href="#tab_main" class="active" data-bs-toggle="tab"><i class="fa fa-info-circle me-2"></i>Main Content & Story</a></li>
                                        <li><a href="#tab_stats" data-bs-toggle="tab"><i class="fa fa-chart-bar me-2"></i>Engagement Stats</a></li>
                                        <li><a href="#tab_info" data-bs-toggle="tab"><i class="fa fa-file-text me-2"></i>Programme Info</a></li>
                                        <li><a href="#tab_meta" data-bs-toggle="tab"><i class="fa fa-certificate me-2"></i>Programme Badges</a></li>
                                        <li><a href="#tab_curriculum" data-bs-toggle="tab"><i class="fa fa-book me-2"></i>Curriculum & Tools</a></li>
                                        <li><a href="#tab_ai_comparison" data-bs-toggle="tab"><i class="fa fa-robot me-2"></i>AI vs PERI</a></li>
                                    </ul>
                                    <div class="tab-content p-4">
                                        <!-- Tab 1: Main Content -->
                                        <div class="tab-pane active" id="tab_main">
                                            <div class="row align-items-center mb-4">
                                                <div class="col">
                                                    <h4 class="box-title mb-0">Core Section Details</h4>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-bold me-2 status-label <?= ($data['status'] == 1) ? 'text-primary' : 'text-muted' ?>"><?= ($data['status'] == 1) ? 'Active' : 'Inactive' ?></span>
                                                        <label class="switch">
                                                            <input type="checkbox" name="status" value="1" <?= ($data['status'] == 1) ? 'checked' : '' ?> id="statusToggle">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <style>
                                                        .switch { position: relative; display: inline-block; width: 50px; height: 26px; }
                                                        .switch input { opacity: 0; width: 0; height: 0; }
                                                        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; }
                                                        .slider:before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: white; transition: .4s; }
                                                        input:checked + .slider { background-color: #2196F3; }
                                                        input:checked + .slider:before { transform: translateX(24px); }
                                                        .slider.round { border-radius: 34px; }
                                                        .slider.round:before { border-radius: 50%; }
                                                        .status-label { font-size: 0.9rem; transition: all 0.3s; }
                                                        .bg-light-soft { background-color: #f8f9fa; }
                                                    </style>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Section Main Heading</label>
                                                <input type="text" name="web_content_1" class="form-control" value="<?= esc($data['web_content_1'] ?? '', 'attr') ?>" placeholder="e.g. For Students & Graduates">
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold d-block">Section Image (e.g. Interview Scene)</label>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="border rounded overflow-hidden" style="width: 120px; height: 120px; background: #eee; display: flex; align-items: center; justify-content: center;">
                                                        <img id="preview_web_image_1" src="<?= !empty($data['web_image_1']) ? base_url('images/content/'.esc($data['web_image_1'], 'attr')) : base_url('assets/img/peri-interview.webp') ?>" style="max-width: 100%; max-height: 100%; object-fit: cover;" onerror="this.src='<?= base_url('assets/img/peri-interview.webp') ?>'">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <input class="form-control" type="file" name="web_image_1" onchange="document.getElementById('preview_web_image_1').src = window.URL.createObjectURL(this.files[0])">
                                                        <p class="text-muted small mt-1 mb-0"><i class="fa fa-info-circle me-1"></i></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-4">
                                            <h5 class="fw-bold text-primary mb-3"><i class="fa fa-quote-left me-2"></i>The Story Section</h5>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Story Title</label>
                                                <input type="text" name="web_content_2" class="form-control" value="<?= esc($data['web_content_2'] ?? '', 'attr') ?>" placeholder="e.g. The Recruiter Moment">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Opening Paragraph</label>
                                                <textarea name="web_content_3" class="form-control" rows="3" placeholder="A technical recruiter sits..."><?= esc($data['web_content_3'] ?? '') ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Highlighted Response (Bold Block)</label>
                                                <textarea name="web_content_4" class="form-control" rows="3" placeholder="Asked about gate drive design..."><?= esc($data['web_content_4'] ?? '') ?></textarea>
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label fw-bold">Closing Hook/Question</label>
                                                <input type="text" name="web_content_5" class="form-control" value="<?= esc($data['web_content_5'] ?? '', 'attr') ?>" placeholder="looks up. 'Where did you learn this?'">
                                            </div>
                                        </div>

                                        <!-- Tab 2: Engagement Stats -->
                                        <div class="tab-pane" id="tab_stats">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h4 class="box-title mb-0">Engagement Statistics</h4>
                                                <button type="button" class="btn btn-sm btn-info-light add-stat-row"><i class="fa fa-plus me-1"></i> Add Statistic</button>
                                            </div>
                                            <div id="stats-repeater">
                                                <?php 
                                                $stats = json_decode($data['web_content_8'] ?? '[]', true);
                                                foreach($stats as $s): 
                                                    $val = $s['badge'] ?? $s['num'] ?? '';
                                                    $isBadge = isset($s['badge']) ? '1' : '0';
                                                ?>
                                                <div class="stat-row border rounded p-3 mb-3 position-relative bg-light-soft">
                                                    <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 mt-1 me-1 remove-row"><i class="fa fa-times"></i></button>
                                                    <div class="row g-2">
                                                        <div class="col-4">
                                                            <label class="form-label small fw-bold">Number/Badge</label>
                                                            <input type="text" class="form-control form-control-sm row-num" value="<?= esc($val, 'attr') ?>" placeholder="e.g. 100">
                                                            <input type="hidden" class="row-is-badge" value="<?= $isBadge ?>">
                                                        </div>
                                                        <div class="col-8">
                                                            <label class="form-label small fw-bold">Label Text</label>
                                                            <textarea class="form-control form-control-sm row-text" rows="2" placeholder="Description..."><?= esc($s['text']) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- Tab 3: Programme Info -->
                                        <div class="tab-pane" id="tab_info">
                                            <h4 class="box-title mb-3">Core Programme Details</h4>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Programme/Course Title</label>
                                                <input type="text" name="web_content_6" class="form-control" value="<?= esc($data['web_content_6'] ?? '', 'attr') ?>" placeholder="e.g. Certificate Programme in Power Electronics...">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Programme Introduction/Details</label>
                                                <textarea name="web_content_7" class="form-control" rows="8" placeholder="A 3-month structured programme..."><?= esc($data['web_content_7'] ?? '') ?></textarea>
                                            </div>
                                        </div>

                                        <!-- Tab 4: Programme Badges -->
                                        <div class="tab-pane" id="tab_meta">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h4 class="box-title mb-0">Programme Meta Badges</h4>
                                                <button type="button" class="btn btn-sm btn-success-light add-meta-row"><i class="fa fa-plus me-1"></i> Add Badge</button>
                                            </div>
                                            <div id="meta-repeater">
                                                <?php 
                                                $meta = json_decode($data['web_content_9'] ?? '[]', true);
                                                foreach($meta as $m): ?>
                                                <div class="meta-row border rounded p-3 mb-3 position-relative bg-light-soft">
                                                    <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 mt-1 me-1 remove-row"><i class="fa fa-times"></i></button>
                                                    <div class="row g-2">
                                                        <div class="col-3">
                                                            <label class="form-label small fw-bold">Icon Class</label>
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid <?= esc($m['icon'], 'attr') ?> text-primary"></i></span>
                                                                <input type="text" class="form-control form-control-sm row-icon border-start-0 ps-0" value="<?= esc($m['icon'], 'attr') ?>" placeholder="fa-clock" oninput="$(this).siblings('.input-group-text').find('i').attr('class', 'fa-solid ' + this.value + ' text-primary')">
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label small fw-bold">Label/Name</label>
                                                            <input type="text" class="form-control form-control-sm row-name" value="<?= esc($m['name'] ?? '', 'attr') ?>" placeholder="e.g. Duration">
                                                        </div>
                                                        <div class="col-5">
                                                            <label class="form-label small fw-bold">Details/Text</label>
                                                            <input type="text" class="form-control form-control-sm row-text" value="<?= esc($m['text'], 'attr') ?>" placeholder="3 months">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- Tab 5: Curriculum & Tools -->
                                        <div class="tab-pane" id="tab_curriculum">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-book-open me-2 text-primary"></i>What Students Learn</h5>
                                                        <button type="button" class="btn btn-xs btn-primary-light add-learn-row"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div id="learn-repeater">
                                                        <?php 
                                                        $learn = json_decode($data['web_content_10'] ?? '[]', true);
                                                        foreach($learn as $l): ?>
                                                        <div class="learn-row mb-2 position-relative">
                                                            <input type="text" class="form-control form-control-sm pe-4 row-learn" value="<?= esc($l, 'attr') ?>" placeholder="Outcome...">
                                                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-screwdriver-wrench me-2 text-primary"></i>Tools Used</h5>
                                                        <button type="button" class="btn btn-xs btn-success-light add-tool-row"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div id="tool-repeater">
                                                        <?php 
                                                        $tools = json_decode($data['web_content_11'] ?? '[]', true);
                                                        foreach($tools as $t): ?>
                                                        <div class="tool-row border rounded p-2 mb-2 position-relative bg-light-soft">
                                                            <i class="fa fa-times text-danger position-absolute end-0 top-0 mt-1 me-1 cursor-pointer remove-small-row" style="font-size:10px"></i>
                                                            <div class="row g-2">
                                                                <div class="col-4">
                                                                    <input type="text" class="form-control form-control-sm tool-name" value="<?= esc($t['name'] ?? '', 'attr') ?>" placeholder="Tool">
                                                                </div>
                                                                <div class="col-8">
                                                                    <input type="text" class="form-control form-control-sm tool-desc" value="<?= esc($t['desc'] ?? '', 'attr') ?>" placeholder="Description">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab 6: AI vs PERI Comparison -->
                                        <div class="tab-pane" id="tab_ai_comparison">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Comparison Section Heading</label>
                                                <input type="text" name="web_content_12" class="form-control" value="<?= esc($data['web_content_12'] ?? '', 'attr') ?>" placeholder="AI teaches you what to say. PERI teaches you what to know">
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="fw-bold mb-0 text-danger"><i class="fa-solid fa-robot me-2"></i>What AI Can Do</h5>
                                                        <button type="button" class="btn btn-xs btn-danger-light add-ai-can-row"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div id="ai-can-repeater">
                                                        <?php 
                                                        $ai_can = json_decode($data['web_content_13'] ?? '[]', true);
                                                        foreach($ai_can as $item): ?>
                                                        <div class="ai-can-row mb-2 position-relative">
                                                            <input type="text" class="form-control form-control-sm pe-4 row-ai-can" value="<?= esc($item, 'attr') ?>" placeholder="AI Capability...">
                                                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="fw-bold mb-0 text-success"><i class="fa-solid fa-user-check me-2"></i>What AI Cannot Do</h5>
                                                        <button type="button" class="btn btn-xs btn-success-light add-ai-cannot-row"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div id="ai-cannot-repeater">
                                                        <?php 
                                                        $ai_cannot = json_decode($data['web_content_14'] ?? '[]', true);
                                                        foreach($ai_cannot as $item): ?>
                                                        <div class="ai-cannot-row mb-2 position-relative">
                                                            <input type="text" class="form-control form-control-sm pe-4 row-ai-cannot" value="<?= esc($item, 'attr') ?>" placeholder="Human Advantage...">
                                                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Footer Note (Fees/Enrolment)</label>
                                                <textarea name="web_content_15" class="form-control" rows="2" placeholder="Course fees and enrolment details available on request."><?= esc($data['web_content_15'] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-end mt-4">
                                    <input type="hidden" name="web_content_id" value="19">
                                    <button type="submit" class="btn btn-primary shadow-none px-4">
                                        <i class="fa fa-save me-1"></i> Save All Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>

        <script>
            $(document).ready(function() {
                // Toggle Label Update
                $('#statusToggle').change(function() {
                    let label = $('.status-label');
                    if(this.checked) {
                        label.text('Active').removeClass('text-muted').addClass('text-primary');
                    } else {
                        label.text('Inactive').removeClass('text-primary').addClass('text-muted');
                    }
                });

                // Add Stat Row
                $('.add-stat-row').click(function() {
                    $('#stats-repeater').append(`
                        <div class="stat-row border rounded p-3 mb-3 position-relative">
                            <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 mt-1 me-1 remove-row"><i class="fa fa-times"></i></button>
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small fw-bold">Number/Badge</label>
                                    <input type="text" class="form-control form-control-sm row-num" placeholder="e.g. 100">
                                    <input type="hidden" class="row-is-badge" value="0">
                                </div>
                                <div class="col-8">
                                    <label class="form-label small fw-bold">Label Text</label>
                                    <textarea class="form-control form-control-sm row-text" rows="2" placeholder="Description..."></textarea>
                                </div>
                            </div>
                        </div>
                    `);
                });

                // Add Meta Row
                $('.add-meta-row').click(function() {
                    $('#meta-repeater').append(`
                        <div class="meta-row border rounded p-3 mb-3 position-relative bg-light-soft">
                            <button type="button" class="btn btn-sm text-danger position-absolute top-0 end-0 mt-1 me-1 remove-row"><i class="fa fa-times"></i></button>
                            <div class="row g-2">
                                <div class="col-3">
                                    <label class="form-label small fw-bold">Icon Class</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-star text-primary"></i></span>
                                        <input type="text" class="form-control form-control-sm row-icon border-start-0 ps-0" placeholder="fa-star" oninput="$(this).siblings('.input-group-text').find('i').attr('class', 'fa-solid ' + this.value + ' text-primary')">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label small fw-bold">Label/Name</label>
                                    <input type="text" class="form-control form-control-sm row-name" placeholder="Name">
                                </div>
                                <div class="col-5">
                                    <label class="form-label small fw-bold">Details/Text</label>
                                    <input type="text" class="form-control form-control-sm row-text" placeholder="Details">
                                </div>
                            </div>
                        </div>
                    `);
                });

                // Add Learn Outcome
                $('.add-learn-row').click(function() {
                    $('#learn-repeater').append(`
                        <div class="learn-row mb-2 position-relative">
                            <input type="text" class="form-control form-control-sm pe-4 row-learn" placeholder="Learning Outcome...">
                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                        </div>
                    `);
                });

                // Add Tool
                $('.add-tool-row').click(function() {
                    $('#tool-repeater').append(`
                        <div class="tool-row border rounded p-2 mb-2 position-relative bg-light-soft">
                            <i class="fa fa-times text-danger position-absolute end-0 top-0 mt-1 me-1 cursor-pointer remove-small-row" style="font-size:10px"></i>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="text" class="form-control form-control-sm tool-name" placeholder="Tool Name">
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm tool-desc" placeholder="Tool Description">
                                </div>
                            </div>
                        </div>
                    `);
                });

                // Add AI Can Row
                $('.add-ai-can-row').click(function() {
                    $('#ai-can-repeater').append(`
                        <div class="ai-can-row mb-2 position-relative">
                            <input type="text" class="form-control form-control-sm pe-4 row-ai-can" placeholder="AI Capability...">
                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                        </div>
                    `);
                });

                // Add AI Cannot Row
                $('.add-ai-cannot-row').click(function() {
                    $('#ai-cannot-repeater').append(`
                        <div class="ai-cannot-row mb-2 position-relative">
                            <input type="text" class="form-control form-control-sm pe-4 row-ai-cannot" placeholder="Human Advantage...">
                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                        </div>
                    `);
                });

                // Unified Remove Logic
                $(document).on('click', '.remove-row, .remove-small-row', function() {
                    let row = $(this).closest('.stat-row, .meta-row, .learn-row, .tool-row, .ai-can-row, .ai-cannot-row');
                    if($(this).hasClass('remove-small-row')) {
                        row.remove(); // Direct remove for small rows
                    } else {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove();
                            }
                        });
                    }
                });

                // Toggle logic for badge vs num based on text content (simple heuristic)
                $(document).on('input', '.row-num', function() {
                    let val = $(this).val();
                    let isBadge = isNaN(val) ? '1' : '0';
                    $(this).siblings('.row-is-badge').val(isBadge);
                });

                $('.peri-training-form').on('submit', function(e) {
                    e.preventDefault();
                    
                    // Collect Stats
                    let stats = [];
                    $('#stats-repeater .stat-row').each(function() {
                        let rowNum = $(this).find('.row-num').val();
                        let rowText = $(this).find('.row-text').val();
                        let isBadge = $(this).find('.row-is-badge').val() == '1';
                        if(rowNum && rowText) {
                            let obj = { text: rowText };
                            if(isBadge) obj.badge = rowNum;
                            else obj.num = rowNum;
                            stats.push(obj);
                        }
                    });

                    // Collect Meta
                    let meta = [];
                    $('#meta-repeater .meta-row').each(function() {
                        let rowIcon = $(this).find('.row-icon').val();
                        let rowName = $(this).find('.row-name').val();
                        let rowText = $(this).find('.row-text').val();
                        if(rowIcon && rowText) meta.push({ icon: rowIcon, name: rowName, text: rowText });
                    });

                    // Collect Curriculum
                    let learn = [];
                    $('#learn-repeater .row-learn').each(function() {
                        let val = $(this).val();
                        if(val) learn.push(val);
                    });

                    // Collect Tools
                    let tools = [];
                    $('#tool-repeater .tool-row').each(function() {
                        let name = $(this).find('.tool-name').val();
                        let desc = $(this).find('.tool-desc').val();
                        if(name) tools.push({ name: name, desc: desc });
                    });

                    // Collect AI Comparison
                    let ai_can = [];
                    $('#ai-can-repeater .row-ai-can').each(function() {
                        let val = $(this).val();
                        if(val) ai_can.push(val);
                    });
                    
                    let ai_cannot = [];
                    $('#ai-cannot-repeater .row-ai-cannot').each(function() {
                        let val = $(this).val();
                        if(val) ai_cannot.push(val);
                    });

                    let formData = new FormData(this);
                    formData.append('for', 'save_training');
                    formData.append('web_content_8', JSON.stringify(stats));
                    formData.append('web_content_9', JSON.stringify(meta));
                    formData.append('web_content_10', JSON.stringify(learn));
                    formData.append('web_content_11', JSON.stringify(tools));
                    formData.append('web_content_13', JSON.stringify(ai_can));
                    formData.append('web_content_14', JSON.stringify(ai_cannot));

                    common.ajax_save_file("saveContent", formData)
                        .then(res => {
                            if (res.code == 200 || res.status == 'success') {
                                Swal2("success", "Saved!", "Section content updated successfully");
                                setTimeout(() => { location.reload(); }, 1200);
                            } else {
                                Swal2("error", "Error", res.message || "Failed to save content");
                            }
                        })
                        .catch(xhr => {
                            let msg = "A server error occurred while saving.";
                            try {
                                let res = xhr.responseJSON;
                                if(res && res.message) msg = res.message;
                            } catch(e) {}
                            Swal2("error", "Server Error", msg);
                        });
                });
            });
        </script>
    </div>
</body>
</html>
