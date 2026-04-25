// business.js for About Our Business section (matches aboutourbusiness.php view)

const table_columns = [
    {
        data: "serial_no",
        title: "S.No",
        is_default: true,
        dt: true,
        width: "30px",
    },
    {
        data: "web_title",
        className: "text-start",
        title: "Title",
        is_default: true,
        dt: true,
        width: "150px",
    },
    {
        data: "web_image",
        width: "200px",
        className: "text-center",
        title: "Image",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return row['web_image'] ? `<img width='50' src='${row['web_image']}' alt="">` : '';
        }
    },
    {
        data: "is_active",
        width: "50px",
        className: "text-center",
        title: "Status",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return `
                <div class="cus-toggle">
                    <label>Inactive</label>
                    <label class="cus-switch">
                        <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${row["web_business_id"]}" class="business_status">
                        <span class="cus-slider round"></span>
                    </label>
                    <label>Active</label>
                </div>`;
        },
    },
    {
        data: "display_order",
        title: "Display Order",
        is_default: true,
        dt: true,
        width: "130px",
    },
    {
        data: "web_business_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `
                <button data-pid="${row["web_business_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-business" type="button"><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
                <button data-pid="${row["web_business_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-business" type="button"><i class="fi fi-sr-trash"></i> Delete</button>
            `;
        }
    }
];

const dt_settings = {
    table: "#business_table",
    column: table_columns,
    url: "getAboutOurBusiness"
};

const dataTableInstance = common.dataTable(dt_settings);

// Add and Edit modal
$(document).on("click", ".edit-business", function () {
    let showOrHide = "show";
    $(".brand-form")[0].reset();
    $("#web_image").attr("src", "");
    $("#photo-msg").text("");
    const pid = Number($(this).data("pid")) || -1;
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".brand-form input[name=web_business_id]").val(pid);

    // Fetch the business data and last_count
    const result = common.ajax_fech("getAboutOurBusiness");

    let last_count = Number(result["last_count"]);
    if (isNaN(last_count) || last_count < 0) last_count = 0;

    // If editing, populate the form
    if (pid > 0) {
        const row = Array.isArray(result.data) ? result.data.find(r => r.web_business_id == pid) : null;
        if(row) {
            // Display order assignment
            $(".brand-form input[name=display_order]")
                .val(isNaN(Number(row.display_order)) ? "" : Number(row.display_order))
                .attr("data-last_count", last_count);
            $("#order_count").text(last_count);

            // Assign all fields from row
            $(".brand-form input[name=web_business_id]").val(row["web_business_id"]);
            $(".brand-form input[name=web_title]").val(row["web_title"]);
            $(".brand-form textarea[name=web_content]").val(row["web_content"]);
            $("#web_image").attr("src", row["web_image"] || "");
        } else {
            showOrHide = "hide";
            Swal2("error", "Something Error", "Try again later");
        }
    } else {
        // For add, assign new display order and clear content
        let next_order = last_count + 1;
        $(".brand-form input[name=display_order]")
            .val(next_order)
            .attr("data-last_count", last_count);
        $("#order_count").text(next_order);
        $(".brand-form textarea[name=web_content]").val("");
    }

    $("#brand-modal").modal(showOrHide);
});

// Form submit
$(".brand-form").on("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
        .ajax_save_file("saveAboutOurBusiness", formData)
        .then(function (response) {
            if (response.code == 200) {
                reloadDataTable(dataTableInstance);
                Swal2("success", "Success", "Successfully Saved").then(() => {
                    $("#brand-modal").modal("hide");
                });
            } else {
                Swal2("error", "Error", response.message);
            }
        })
        .catch(function () {
            reloadDataTable(dataTableInstance);
            Swal2("error", "Something Error", "Try again later");
        });
});

// Delete handler
$(document).on("click", ".del-business", function () {
    const pid = $(this).data("pid");
    const update_data = {
        web_business_id: pid,
        is_deleted: 1,
        for: "delete"
    };

    swal.fire({
        title: "Are you sure?",
        text: "You will not be able to recover this item!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#fec801",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            common
                .ajax_save("saveAboutOurBusiness", update_data)
                .then(function (response) {
                    if (response.code == 200) {
                        reloadDataTable(dataTableInstance, true);
                        Swal2("success", "Deleted!", "Successfully deleted");
                    } else {
                        Swal2("error", "Error", response.message);
                    }
                })
                .catch(function () {
                    reloadDataTable(dataTableInstance);
                    Swal2("error", "Something Error", "Try again later");
                });
        }
    });
});

// Status update
$(document).on("change", ".business_status", function () {
    const pid = $(this).data("pid");
    const update_data = {
        web_business_id: pid,
        for: "status",
        is_active: $(this).prop("checked") ? 1 : 0
    };

    common
        .ajax_save("saveAboutOurBusiness", update_data)
        .then(function (response) {
            reloadDataTable(dataTableInstance);
            if (response.code == 200) {
                Swal2("success", "Success", "Successfully Status Updated");
            } else {
                Swal2("error", "Failed", response.message || "Please Try Again");
            }
        })
        .catch(function () {
            reloadDataTable(dataTableInstance);
            Swal2("error", "Something Error", "Please Try Again");
        });
});

// Image preview & validation
$("input[name=web_image]").on("change", function (event) {
    const file = event.target.files[0];
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    const errorMsg = $("#photo-msg");
    if (file) {
        if (!allowedExtensions.test(file.name)) {
            errorMsg.text("Invalid file type! Only jpg, jpeg, and png are allowed.");
            $("#web_image").attr("src", "");
            return;
        }
        errorMsg.text("");
        const reader = new FileReader();
        reader.onload = function (e) {
            $("#web_image").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        $("#web_image").attr("src", "");
        errorMsg.text("");
    }
});

// Display order validation
$('.brand-form input[name=display_order]').on('input', function () {
    let val = $(this).val().replace(/\D/g, '');
    let last_count = Number($(this).data('last_count'));
    if (isNaN(last_count) || last_count < 1) last_count = 1;

    val = parseInt(val, 10);

    if (isNaN(val) || val < 1) {
        val = '';
    } else if (val > last_count) {
        val = last_count;
    }
    $(this).val(val);
});

