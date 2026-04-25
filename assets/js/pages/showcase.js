// Helper to add JSON item row with structured fields
function addJsonItem(section, value = '') {
    const container = $(`.json-section[data-field="${section}"] .json-items-container`);
    if(!container.length) return;

    let html = '';
    
    // Parse value if it contains structured segments (for edit mode)
    // Format: "IconClass || Title : Value"
    let iconPart = '';
    let restPart = value;
    
    if (value.includes('||')) {
        let parts = value.split('||');
        iconPart = parts[0].trim();
        restPart = parts[1].trim();
    }

    let sepRegex = /[:—]/;
    let parts = restPart.split(sepRegex);
    let val1 = parts[0] ? parts[0].trim() : '';
    let val2 = parts[1] ? parts[1].trim() : '';

    if (section === 'execution_progress') {
        html = `
            <div class="json-item mb-2 p-2 border rounded bg-light shadow-sm">
                <div class="row gx-2 align-items-center">
                    <div class="col-7">
                        <input type="text" name="${section}_title[]" class="form-control form-control-sm" value="${val1}" placeholder="Stage Title (e.g. Schematic)">
                    </div>
                    <div class="col-4">
                        <select name="${section}_val[]" class="form-select form-select-sm">
                            <option value="Complete" ${val2 == 'Complete' ? 'selected' : ''}>Complete</option>
                            <option value="In Progress" ${val2 == 'In Progress' ? 'selected' : ''}>In Progress</option>
                            <option value="Upcoming" ${val2 == 'Upcoming' || !val2 ? 'selected' : ''}>Upcoming</option>
                        </select>
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item p-1"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>`;
    } else if (section === 'design_highlights') {
        html = `
            <div class="json-item mb-2 p-2 border rounded bg-light shadow-sm">
                <div class="row gx-2 align-items-center">
                    <div class="col-4">
                        <input type="text" name="${section}_title[]" class="form-control form-control-sm fw-bold" value="${val1}" placeholder="Bold label">
                    </div>
                    <div class="col-7">
                        <textarea name="${section}_val[]" class="form-control form-control-sm" rows="1" placeholder="Highlight detail...">${val2}</textarea>
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item p-1"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>`;
    } else if (section === 'design_deliverables') {
        // ONLY Deliverables get the custom Icon field
        html = `
            <div class="json-item mb-2 p-2 border rounded bg-light shadow-sm">
                <div class="row gx-2 align-items-center">
                    <div class="col-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text icon-preview"><i class="${iconPart || 'fas fa-cog'}"></i></span>
                            <input type="text" name="${section}_icon[]" class="form-control showcase-icon-input" value="${iconPart}" placeholder="Icon class (fas fa-file)">
                        </div>
                    </div>
                    <div class="col-4">
                        <input type="text" name="${section}_title[]" class="form-control form-control-sm" value="${val1}" placeholder="Label">
                    </div>
                    <div class="col-4">
                        <input type="text" name="${section}_val[]" class="form-control form-control-sm" value="${val2}" placeholder="Value/Detail">
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item p-1"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>`;
    } else {
        // All other sections get the standard 2-column layout
        let placeholder1 = "Label";
        let placeholder2 = "Value/Detail";
        if(section == 'pcb_challenges') { placeholder1 = "Challenge Area"; placeholder2 = "Detail"; }
        if(section == 'frameworks_applied') { placeholder1 = "Framework Badge"; placeholder2 = "Detail"; }

        html = `
            <div class="json-item mb-2 p-2 border rounded bg-light shadow-sm">
                <div class="row gx-2 align-items-center">
                    <div class="col-5">
                        <input type="text" name="${section}_title[]" class="form-control form-control-sm" value="${val1}" placeholder="${placeholder1}">
                    </div>
                    <div class="col-6">
                        <input type="text" name="${section}_val[]" class="form-control form-control-sm" value="${val2}" placeholder="${placeholder2}">
                    </div>
                    <div class="col-1 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item p-1"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>`;
    }
    
    container.append(html);
}

$(function () {
    "use strict";

    // Add item button click
    $(document).on('click', '.add-json-item', function() {
        const section = $(this).closest('.json-section').data('field');
        addJsonItem(section);
    });

    // Remove item button click
    $(document).on('click', '.remove-item', function() {
        $(this).closest('.json-item').remove();
    });

    // Toggle collapsible JSON sections
    $(document).on('click', '.section-header label', function() {
        const section = $(this).closest('.json-section');
        const content = section.find('.section-content');
        
        section.toggleClass('section-collapsed');
        content.slideToggle(300);
    });

    // Ensure section expands when adding a new item
    $(document).on('click', '.add-json-item', function() {
        const section = $(this).closest('.json-section');
        const content = section.find('.section-content');
        
        if (section.hasClass('section-collapsed')) {
            section.removeClass('section-collapsed');
            content.slideDown(300);
        }
    });

    // Save
    $('.showcase-form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('for', 'edit');

        $.ajax({
            url: "api/savePortfolioShowcase",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    Swal2("success", "Success", "Showcase project saved successfully");
                } else {
                    Swal2("error", "Error", res.message);
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Status toggle
    $(document).on('change', '.status-showcase', function () {
        let id = $(this).data('id');
        let status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: 'api/savePortfolioShowcase',
            type: 'POST',
            data: { web_portfolio_showcase_id: id, is_active: status, for: 'status' },
            headers: { "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content") },
            success: function (res) {
                if (res.status == 'success') {
                    Swal2("success", "Success", "Visibility updated successfully");
                } else {
                    Swal2("error", "Error", "Failed to update status");
                }
                if(res.csrf_hash) $('meta[name="csrf-token-hash"]').attr("content", res.csrf_hash);
            }
        });
    });

    // Live Icon Preview
    $(document).on('input', '.showcase-icon-input', function() {
        const val = $(this).val() || 'fas fa-cog';
        $(this).siblings('.icon-preview').find('i').attr('class', val);
    });

});

