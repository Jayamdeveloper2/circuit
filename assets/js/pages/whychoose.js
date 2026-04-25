var table_column = [
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
        width: "240px",
    },
    {
        data: "web_subtitle",
        className: "text-start",
        title: "Sub Title",
        is_default: true,
        dt: true,
        width: "140px",
    },
    {
        data: "web_heading",
        className: "text-start",
        title: "Heading",
        is_default: true,
        dt: true,
        width: "240px",
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
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${row["web_why_choose_id"]}" class="whychoose_status" >
              <span class="cus-slider round"></span>
            </label>
          </div>`;
        },
    },
    {
        data: "web_why_choose_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
                <button data-pid="${row["web_why_choose_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-whychoose" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
                <button data-pid="${row["web_why_choose_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-whychoose " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
            `;
        },
    },
];

var dt = {
    table: "#whychoose_table",
    column: table_column,
    url: "getWhyChooseUs",
};

var k = common.dataTable(dt);

// Add and Edit
$(document).on("click", ".edit-whychoose", function () {
    var vbk = "show";
    $(".whychoose-form")[0].reset();
    $(".whychoose-form textarea[name=web_content]").val("");
    $('#web_icon_logo').attr('class', '');
    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".whychoose-form input[name=web_why_choose_id]").val(pid);
    
    var result = common.ajax_fech("getWhyChooseUs", {web_why_choose_id: pid});
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".whychoose-form input[name=display_order]").data('last_count', last_count).val(last_count);

    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            var row = result["data"][0];
            $(".whychoose-form input[name=web_why_choose_id]").val(row["web_why_choose_id"]);
            $(".whychoose-form input[name=web_title]").val(row["web_title"]);
            $(".whychoose-form input[name=web_subtitle]").val(row["web_subtitle"]);
            $(".whychoose-form input[name=web_heading]").val(row["web_heading"]);
            $(".whychoose-form textarea[name=web_content]").val(row["web_content"]);
            $(".whychoose-form input[name=display_order]").val(row["display_order"]);
            $(".whychoose-form input[name=web_icon]").val(row["web_icon"]);
            $('#web_icon_logo').attr('class', row["web_icon"]);
        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try again later");
        }
    }
    $("#whychoose-modal").modal(vbk);
});

// Form Submit
$(".whychoose-form").on("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    formData.append("for", "edit");
    common.ajax_save_file("saveWhyChooseUs", formData)
        .then(function (response) {
            if (response.code == 200) {
                reloadDataTable(k);
                Swal2("success", "Success", "Successfully Saved").then(() => {
                    $("#whychoose-modal").modal("hide");
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
$(document).on("click", ".del-whychoose", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_why_choose_id: pid,
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
            common.ajax_save("saveWhyChooseUs", update_data)
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
$(document).on("change", ".whychoose_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_why_choose_id: pid,
        for: "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common.ajax_save("saveWhyChooseUs", update_data)
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

// Order validation
$('.whychoose-form input[name=display_order]').on('input', function () {
    let val = $(this).val().replace(/\D/g, '');
    let last_count = $(this).data('last_count');
    val = parseInt(val, 10);
    if (val > last_count) val = last_count;
    if (val < 1 || isNaN(val)) val = '';
    $(this).val(val);
});

// Icon Preview
$(".whychoose-form input[name=web_icon]").on("input", function () {
    $('#web_icon_logo').attr('class', $(this).val());
});
