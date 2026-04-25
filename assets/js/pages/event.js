var table_column = [
    {
        data: "serial_no",
        title: "S.No",
        width: "30px",
    },
    {
        data: "event_title",
        title: "Title",
        width: "200px",
    },
    // ===== COVER IMAGE =====
    {
        data: "event_cover_url",
        title: "Main Image",
        width: "120px",
        render: function (data) {
            if (!data) return '<span class="text-muted">No Image</span>';
            return `<img src="${data}" height="50" style="border-radius:5px;object-fit:cover;">`;
        },
    },

    // ===== MANAGE BUTTONS =====
    {
        data: "web_event_id",
        title: "Manage",
        width: "350px",
        render: function (data, type, row) {
            return `
            <a href="${row['image_url']}" class="btn btn-primary-light btn-sm">
                <i class="fi fi-sr-add-image"></i> What We Offer
            </a>
            <a href="${row['video_url']}" class="btn btn-primary-light btn-sm">
                <i class="fi fi-sr-apps"></i> Industry Applications
            </a>`;
        },
    },

    {
        data: "display_order",
        title: "Order",
        width: "70px",
    },

    // ===== STATUS =====
    {
        data: "is_active",
        title: "Status",
        width: "80px",
        render: function (data, type, row) {
            return `
            <div class="cus-toggle">
                <label>Inactive</label>
                <label class="cus-switch">
                    <input type="checkbox"
                        ${data == 1 ? "checked" : ""}
                        data-pid="${row['web_event_id']}"
                        class="event_status">
                    <span class="cus-slider round"></span>
                </label>
                <label>Active</label>
            </div>`;
        },
    },

    // ===== ACTION =====
    {
        data: "web_event_id",
        title: "Action",
        width: "200px",
        render: function (data, type, row) {
            return `
            <button data-pid="${data}"
                class="btn btn-primary-light btn-sm edit-event">
                <i class="fi fi-sr-attribution-pencil"></i> Edit
            </button>

            <button data-pid="${data}"
                class="btn btn-danger-light btn-sm del-event">
                <i class="fi fi-sr-trash"></i> Delete
            </button>`;
        },
    },
];

var dt = {
    table: "#event_table",
    column: table_column,
    url: "getEvent",
};

var k = common.dataTable(dt);



// ================= EDIT =================

$(document).on("click", ".edit-event", function () {

    let pid = $(this).data("pid");

    $(".event-form")[0].reset();
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");

    // IMPORTANT FIELD NAME
    $(".event-form input[name=web_event_id]").val(pid);

    let result = common.ajax_fech("getEvent", {
        web_event_id: pid   // CORRECT KEY
    });

    let last_count = pid > 0
        ? result.last_count
        : result.last_count + 1;

    $("#order_count").text(last_count);

    $(".event-form input[name=display_order]")
        .data("last_count", last_count)
        .val(last_count);

    // Clear CKEditor and Image Preview
    $(".event-form textarea[name=event_content]").val('');
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['event_content']) {
        try {
            CKEDITOR.instances['event_content'].setData('');
        } catch (err) {}
    }
    $("#event_image_preview").attr("src", "");
    $("#event_current_image").attr("src", "");
    $("#event_current_image_wrap").hide();
    $("#event_new_image_wrap").hide();

    if (pid > 0 && result.code == 200) {

        let d = result.data[0];

        $(".event-form input[name=event_title]")
            .val(d.event_title);

        $(".event-form input[name=display_order]")
            .val(d.display_order);

        // Show existing image preview
        if (d.event_cover_url) {
            $("#event_current_image").attr("src", d.event_cover_url);
            $("#event_current_image_wrap").show();
        }

        // Populate Textarea and CKEditor
        $(".event-form textarea[name=event_content]").val(d.event_content || '');
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['event_content']) {
            try {
                CKEDITOR.instances['event_content'].setData(d.event_content || '');
            } catch (err) {
                console.log("CKEditor not fully ready: ", err);
                CKEDITOR.instances['event_content'].on('instanceReady', function() {
                    this.setData(d.event_content || '');
                });
            }
        }
    }

    $("#event-modal").modal("show");
});



// ================= SAVE =================

$(".event-form").on("submit", function (e) {

    e.preventDefault();

    // Ensure CKEditor sets textarea value before creating FormData
    if (typeof CKEDITOR !== 'undefined') {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }

    let formData = new FormData(this);
    formData.append("for", "edit");

    common.ajax_save_file("saveEvent", formData)
        .then((res) => {

            if (res.code == 200) {

                reloadDataTable(k);
                Swal2("success", "Success", "Service saved successfully").then(() => {

                    $("#event-modal").modal("hide");
                });

            } else {
                Swal2("error", "Error", res.message);
            }
        });
});



// ================= DELETE =================

$(document).on("click", ".del-event", function () {

    let pid = $(this).data("pid");

    swal.fire({
        title: "Delete Product?",
        icon: "warning",
        showCancelButton: true,

    }).then((r) => {

        if (r.isConfirmed) {

            common.ajax_save("saveEvent", {
                web_event_id: pid,   // FIXED
                is_deleted: 1,
                for: "delete",
            }).then(() => {

                reloadDataTable(k, true);
                Swal2("success", "Deleted!", "Service successfully deleted");

            });
        }
    });
});



// ================= STATUS =================

$(document).on("change", ".event_status", function () {

    common.ajax_save("saveEvent", {

        web_event_id: $(this).data("pid"),  // FIXED

        is_active: $(this).prop("checked") ? 1 : 0,

        for: "status",

    }).then(() => {

        reloadDataTable(k);
        Swal2("success", "Updated", "Product status changed successfully");

    });
});
