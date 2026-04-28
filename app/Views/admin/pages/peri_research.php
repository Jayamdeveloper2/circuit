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
                            <h3 class="page-title"><?= $title ?? "Institutions & Research Section" ?></h3>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <form class="peri-research-form">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="nav-tabs-custom shadow-none border">
                                    <ul class="nav nav-tabs">
                                        <li><a href="#tab_main" class="active" data-bs-toggle="tab"><i class="fa fa-info-circle me-2"></i>Institutions Intro</a></li>
                                        <li><a href="#tab_pillars" data-bs-toggle="tab"><i class="fa fa-th-large me-2"></i>Research Pillars</a></li>
                                        <li><a href="#tab_collaboration" data-bs-toggle="tab"><i class="fa fa-handshake me-2"></i>Collaboration</a></li>
                                        <li><a href="#tab_difference" data-bs-toggle="tab"><i class="fa fa-exchange me-2"></i>PERI Difference</a></li>
                                        <li><a href="#tab_quote" data-bs-toggle="tab"><i class="fa fa-quote-right me-2"></i>Pull Quote</a></li>
                                    </ul>
                                    <div class="tab-content p-4">
                                        <!-- Tab 1: Institutions Intro -->
                                        <div class="tab-pane active" id="tab_main">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold">Section Heading</label>
                                                        <input type="text" name="web_content_1" class="form-control" value="<?= esc($data['web_content_1'] ?? '', 'attr') ?>">
                                                        <small class="text-muted">Use &lt;span&gt;...&lt;/span&gt; for highlighted text.</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Intro Content</label>
                                                        <textarea name="web_content_2" class="form-control" rows="6"><?= esc($data['web_content_2'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Section Image</label>
                                                        <input type="file" name="web_image_1" class="form-control mb-2 image-input">
                                                        <div class="image-preview border rounded p-1 bg-light text-center" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                                            <?php if(!empty($data['web_image_1'])): ?>
                                                                <img src="<?= base_url('images/content/' . $data['web_image_1']) ?>" class="img-fluid mh-100">
                                                            <?php else: ?>
                                                                <span class="text-muted">No Image</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab 2: Research Pillars -->
                                        <div class="tab-pane" id="tab_pillars">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="fw-bold mb-0">Research & Collaboration Pillars</h5>
                                                <button type="button" class="btn btn-sm btn-primary add-pillar-row"><i class="fa fa-plus me-1"></i>Add Pillar</button>
                                            </div>
                                            <div id="pillar-repeater">
                                                <?php 
                                                $pillars = json_decode($data['web_content_3'] ?? '[]', true);
                                                foreach($pillars as $p): ?>
                                                <div class="pillar-row border rounded p-3 mb-3 position-relative bg-light-soft">
                                                    <button type="button" class="btn btn-xs btn-danger position-absolute end-0 top-0 mt-2 me-2 remove-row"><i class="fa fa-times"></i></button>
                                                    <div class="row g-3">
                                                        <div class="col-md-2">
                                                            <label class="form-label small fw-bold">Number/Prefix</label>
                                                            <input type="text" class="form-control form-control-sm row-num" value="<?= esc($p['num'] ?? '', 'attr') ?>" placeholder="01">
                                                        </div>
                                                        <div class="col-md-10">
                                                            <label class="form-label small fw-bold">Pillar Name</label>
                                                            <input type="text" class="form-control form-control-sm row-name" value="<?= esc($p['name'] ?? '', 'attr') ?>" placeholder="Pillar Title">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label small fw-bold">Description</label>
                                                            <textarea class="form-control form-control-sm row-text" rows="2" placeholder="Describe this pillar..."><?= esc($p['text'] ?? '') ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- Tab: Collaboration -->
                                        <div class="tab-pane" id="tab_collaboration">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Collaboration Prompt (Handshake Section)</label>
                                                <textarea name="web_content_4" class="form-control" rows="4"><?= esc($data['web_content_4'] ?? '') ?></textarea>
                                                <p class="text-muted small mt-2">
                                                    <i class="fa fa-info-circle me-1"></i> This text appears within the highlighted box with the handshake icon, typically used to invite university or industry partners.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Tab 3: PERI Difference -->
                                        <div class="tab-pane" id="tab_difference">
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Column 1 Heading (Conventional)</label>
                                                    <input type="text" name="web_content_5" class="form-control" value="<?= esc($data['web_content_5'] ?? '', 'attr') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Column 2 Heading (PERI Approach)</label>
                                                    <input type="text" name="web_content_6" class="form-control" value="<?= esc($data['web_content_6'] ?? '', 'attr') ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-bold mb-0 text-muted">Conventional List</h6>
                                                        <button type="button" class="btn btn-xs btn-outline-secondary add-diff1-row"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div id="diff1-repeater">
                                                        <?php 
                                                        $diff1 = json_decode($data['web_content_7'] ?? '[]', true);
                                                        foreach($diff1 as $item): ?>
                                                        <div class="diff1-row mb-2 position-relative">
                                                            <input type="text" class="form-control form-control-sm pe-4 row-diff1" value="<?= esc($item, 'attr') ?>">
                                                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-bold mb-0 text-primary">PERI List</h6>
                                                        <button type="button" class="btn btn-xs btn-outline-primary add-diff2-row"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    <div id="diff2-repeater">
                                                        <?php 
                                                        $diff2 = json_decode($data['web_content_8'] ?? '[]', true);
                                                        foreach($diff2 as $item): ?>
                                                        <div class="diff2-row mb-2 position-relative">
                                                            <input type="text" class="form-control form-control-sm pe-4 row-diff2" value="<?= esc($item, 'attr') ?>">
                                                            <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab 4: Pull Quote -->
                                        <div class="tab-pane" id="tab_quote">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Pull Quote Finale</label>
                                                <textarea name="web_content_9" class="form-control" rows="4"><?= esc($data['web_content_9'] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm"><i class="fa fa-save me-2"></i>Save All Changes</button>
                            </div>
                        </div>
                        <input type="hidden" name="web_content_id" value="20">
                    </form>
                </section>
            </div>
        </div>

        <?php include APPPATH . "/Views/admin/common/footer.php"; ?>

        <style>
            .bg-light-soft { background-color: #f8f9fa; border: 1px solid #dee2e6 !important; }
            .cursor-pointer { cursor: pointer; }
            .btn-xs { padding: 0.125rem 0.25rem; font-size: 0.75rem; }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof jQuery !== 'undefined') {
                    (function($) {
                        $(document).ready(function() {
                            
                            // Add Pillar
                            $('.add-pillar-row').click(function() {
                                $('#pillar-repeater').append(`
                                    <div class="pillar-row border rounded p-3 mb-3 position-relative bg-light-soft">
                                        <button type="button" class="btn btn-xs btn-danger position-absolute end-0 top-0 mt-2 me-2 remove-row"><i class="fa fa-times"></i></button>
                                        <div class="row g-3">
                                            <div class="col-md-2">
                                                <label class="form-label small fw-bold">Number/Prefix</label>
                                                <input type="text" class="form-control form-control-sm row-num" placeholder="01">
                                            </div>
                                            <div class="col-md-10">
                                                <label class="form-label small fw-bold">Pillar Name</label>
                                                <input type="text" class="form-control form-control-sm row-name" placeholder="Pillar Title">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small fw-bold">Description</label>
                                                <textarea class="form-control form-control-sm row-text" rows="2" placeholder="Describe this pillar..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });

                            // Add Diff Rows
                            $('.add-diff1-row').click(function() {
                                $('#diff1-repeater').append(`
                                    <div class="diff1-row mb-2 position-relative">
                                        <input type="text" class="form-control form-control-sm pe-4 row-diff1">
                                        <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                    </div>
                                `);
                            });

                            $('.add-diff2-row').click(function() {
                                $('#diff2-repeater').append(`
                                    <div class="diff2-row mb-2 position-relative">
                                        <input type="text" class="form-control form-control-sm pe-4 row-diff2">
                                        <i class="fa fa-times text-danger position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer remove-small-row" style="font-size:12px"></i>
                                    </div>
                                `);
                            });

                            // Remove Logic
                            $(document).on('click', '.remove-row, .remove-small-row', function() {
                                $(this).closest('.pillar-row, .diff1-row, .diff2-row').remove();
                            });

                            // Ajax Save
                            $('.peri-research-form').submit(function(e) {
                                e.preventDefault();
                                
                                // Collect Pillars
                                let pillars = [];
                                $('.pillar-row').each(function() {
                                    let name = $(this).find('.row-name').val();
                                    if(name) {
                                        pillars.push({
                                            num: $(this).find('.row-num').val(),
                                            name: name,
                                            text: $(this).find('.row-text').val()
                                        });
                                    }
                                });

                                // Collect Diffs
                                let diff1 = [];
                                $('.row-diff1').each(function() { if($(this).val()) diff1.push($(this).val()); });
                                let diff2 = [];
                                $('.row-diff2').each(function() { if($(this).val()) diff2.push($(this).val()); });

                                let formData = new FormData(this);
                                formData.append('for', 'save_research');
                                formData.append('web_content_3', JSON.stringify(pillars));
                                formData.append('web_content_7', JSON.stringify(diff1));
                                formData.append('web_content_8', JSON.stringify(diff2));

                                common.ajax_save_file("saveContent", formData)
                                    .then(res => {
                                        if (res && res.status === 'success') {
                                            Swal.fire('Saved!', 'Research content has been updated.', 'success').then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error', res.message || 'Failed to save', 'error');
                                        }
                                    }).catch(err => {
                                        Swal.fire('Error', 'Server error occurred', 'error');
                                    });
                            });
                        });
                    })(jQuery);
                }
            });
        </script>
    </div>
</body>
</html>
