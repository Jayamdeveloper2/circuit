var table_column = [
    {
        data: "serial_no",
        title: "S.No",
        is_default: true,
        dt: true,
        width: "30px",
    },
    {
        data: "web_icon",
        width: "100px",
        className: "text-center",
        title: "Icon",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return `<i class='${row['web_icon']}' style="font-size: 20px; padding: 10px;"></i>`;
        },
    },
    {
        data: "web_title",
        className: "text-start",
        title: "Title (Bold)",
        is_default: true,
        dt: true,
    },
    {
        data: "web_label",
        className: "text-start",
        title: "Label (Span)",
        is_default: true,
        dt: true,
    },
    {
        data: "display_order",
        title: "Order",
        is_default: true,
        dt: true,
        width: "80px",
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
            <label class="cus-switch">
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${row["web_cred_badge_id"]}" class="badge_status" >
              <span class="cus-slider round"></span>
            </label>
          </div>`;
        },
    },
    {
        data: "web_cred_badge_id",
        width: "180px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
                <button data-pid="${row["web_cred_badge_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-badge" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
                <button data-pid="${row["web_cred_badge_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-badge " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
            `;
        },
    },
];

var dt = {
    table: "#badge_table",
    column: table_column,
    url: "getCredBadges",
};

var k = common.dataTable(dt);

// Add and Edit
$(document).on("click", ".edit-badge", function () {
    var vbk = "show";
    $(".badge-form")[0].reset();
    $('#web_icon_preview').attr('class', '');
    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".badge-form input[name=web_cred_badge_id]").val(pid);
    
    var result = common.ajax_fech("getCredBadges", {web_cred_badge_id: pid});
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".badge-form input[name=display_order]").data('last_count', last_count).val(last_count);

    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            var row = result["data"][0];
            $(".badge-form input[name=web_cred_badge_id]").val(row["web_cred_badge_id"]);
            $(".badge-form input[name=web_icon]").val(row["web_icon"]);
            $(".badge-form input[name=web_title]").val(row["web_title"]);
            $(".badge-form input[name=web_label]").val(row["web_label"]);
            $(".badge-form input[name=display_order]").val(row["display_order"]);
            $('#web_icon_preview').attr('class', row["web_icon"]);
        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try again later");
        }
    }
    $("#badge-modal").modal(vbk);
});

// Form Submit
$(".badge-form").on("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    formData.append("for", "edit");
    common.ajax_save_file("saveCredBadge", formData)
        .then(function (response) {
            if (response.code == 200) {
                reloadDataTable(k);
                Swal2("success", "Success", "Successfully Saved").then(() => {
                    $("#badge-modal").modal("hide");
                });
            } else {
                Swal2("error", "Error", response.message);
            }
        })
        .catch(function (error) {
            reloadDataTable(k);
            Swal2("error", "Error", "Something went wrong");
        });
});

// Delete
$(document).on("click", ".del-badge", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_cred_badge_id: pid,
        is_deleted: 1,
        for: "delete",
    };

    swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#fec801",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            common.ajax_save("saveCredBadge", update_data)
                .then(function (response) {
                    if (response.code == 200) {
                        reloadDataTable(k, true);
                        Swal2("success", "Deleted!", "Item has been deleted.");
                    } else {
                        Swal2("error", "Error", response.message);
                    }
                })
                .catch(function (error) {
                    reloadDataTable(k);
                    Swal2("error", "Error", "Something went wrong");
                });
        }
    });
});

// Status update
$(document).on("change", ".badge_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_cred_badge_id: pid,
        for: "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common.ajax_save("saveCredBadge", update_data)
        .then(function (response) {
            reloadDataTable(k);
            if (response.code == 200) {
                Swal2("success", "Success", "Status updated successfully");
            } else {
                Swal2("error", "Failed", "Please try again");
            }
        })
        .catch(function (error) {
            reloadDataTable(k);
            Swal2("error", "Error", "Please try again");
        });
});

// Icon Preview
$(".badge-form input[name=web_icon]").on("input", function () {
    $('#web_icon_preview').attr('class', $(this).val());
});
