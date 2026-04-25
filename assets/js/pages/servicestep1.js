console.log(web_service_id);
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
        data: "display_order",
        title: "Display Order",
        is_default: true,
        dt: true,
        width: "70px",
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
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-pid="${
                row["web_service_step_1_id"]
              }" class="servicestep1_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "web_service_step_1_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
          <button data-pid="${row["web_service_step_1_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-servicestep1" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
          <button data-pid="${row["web_service_step_1_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-servicestep1 " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
      `;
        },
    },
];

var dt = {
    table: "#servicestep1_table",
    column: table_column,
    url: "getServiceStep1",
    data_src: {web_service_id: web_service_id}
};

var k = common.dataTable(dt);


// Add and Edit
$(document).on("click", ".edit-servicestep1", function () {
    var vbk = "show";
    $(".servicestep1-form")[0].reset();

    // Reset all preview images and error messages for images
    $("#web_image").attr("src", "");
    $("#web_image_2").attr("src", "");
    $("#web_image_3").attr("src", "");
    $(".product-img #photo-msg").text("");

    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".servicestep1-form input[name=web_service_step_1_id]").val(pid);
    $(".servicestep1-form input[name=web_service_id]").val(web_service_id);
    var result = common.ajax_fech("getServiceStep1", {web_service_step_1_id: pid, web_service_id: web_service_id});
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".servicestep1-form input[name=display_order]").data('last_count', last_count).val(last_count);

    // Also clear the original hidden textarea
    $('textarea[name=web_content], textarea[name=web_cate_content_1], textarea[name=web_cate_content_2], textarea[name=web_cate_content_3]').val('').trigger('change');
    $('#show_content').addClass('d-none');
    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            var d = result["data"][0];
            $(".servicestep1-form input[name=web_service_step_1_id]").val(d["web_service_step_1_id"]);
            $(".servicestep1-form input[name=web_title]").val(d["web_title"]);
            $(".servicestep1-form input[name=footer_text]").val(d["footer_text"]);
            $(`.servicestep1-form input[name="is_menu"][value="${d["is_menu"]}"]`).prop("checked", true);
            $(".servicestep1-form input[name=display_order]").val(d["display_order"]);
            // always yes i dont want this one
            $(`.servicestep1-form input[name="is_next_level"][value="${result["data"][0]["is_next_level"]}"]`
            ).prop("checked", true);

    if (result["data"][0]["is_next_level"] == 1) {
        $('#show_content').removeClass('d-none');
    }
            $(".servicestep1-form textarea[name=web_content]").val(d["web_content"]).trigger('change');
            $(".servicestep1-form input[name=web_cate_title_1]").val(d["web_cate_title_1"]);
            $(".servicestep1-form textarea[name=web_cate_content_1]").val(d["web_cate_content_1"]).trigger('change');
            $(".servicestep1-form input[name=web_cate_title_2]").val(d["web_cate_title_2"]);
            $(".servicestep1-form textarea[name=web_cate_content_2]").val(d["web_cate_content_2"]).trigger('change');
            $(".servicestep1-form input[name=web_cate_title_3]").val(d["web_cate_title_3"]);
            $(".servicestep1-form textarea[name=web_cate_content_3]").val(d["web_cate_content_3"]).trigger('change');

            // Set all 3 image previews if available
            $("#web_image").attr("src", d["web_image"] || "");
            $("#web_image_2").attr("src", d["web_image_2"] || "");
            $("#web_image_3").attr("src", d["web_image_3"] || "");
        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try Some again time");
        }
    }

    $("#servicestep1-modal").modal(vbk);
});

// Show/hide content when is_next_level changes
$(`.servicestep1-form input[name="is_next_level"]`).on('change', function () {

    if ($(this).val() == 1) {
        $('#show_content').removeClass('d-none');
    } else {
        $('#show_content').addClass('d-none');
    }
});

// Form Submit
$(".servicestep1-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
        .ajax_save_file("saveServiceStep1", formData)
        .then(function (response) {
            if (response.code == 200) {
                reloadDataTable(k);
                Swal2("success", "Success", "Successfully User Saved").then(() => {
                    $("#servicestep1-modal").modal("hide");
                });
            } else {
                Swal2("error", "Something Error", response.message);
            }
        })
        .catch(function (error) {
            reloadDataTable(k);
            Swal2("error", "Something Error", "Try Some again time");
        });
});

// Delete
$(document).on("click", ".del-servicestep1", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_service_step_1_id: pid,
        is_deleted: 1,
        for : "delete",
    };
    swal
        .fire({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#fec801",
            confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
            if (result.isConfirmed) {
                common
                    .ajax_save("saveServiceStep1", update_data)
                    .then(function (response) {
                        if (response.code == 200) {
                            reloadDataTable(k, true);
                            Swal2("success", "Deleted!", "Successfully deleted");
                        } else {
                            Swal2("error", "Something Error", response.message);
                        }
                    })
                    .catch(function (error) {
                        reloadDataTable(k);
                        console.error("Error:", error);
                        Swal2("error", "Something Error", "Try Some again time");
                    });
            }
        });
});

// Status update
$(document).on("change", ".servicestep1_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_service_step_1_id: pid,
        for : "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common.ajax_save("saveServiceStep1", update_data)
        .then(function (response) {
            reloadDataTable(k);
            if (response.code == 200) {
                Swal2("success", "Success", "Successfully Status Updated");
            } else {
                Swal2("error", "Failed", "Please Try Again");
            }
        })
        .catch(function (error) {
            reloadDataTable(k);
            Swal2("error", "Something Error", "Please Try Again");
        });
});

// Image 1 Preview
$("input[name=web_image]").on("change", function (event) {
    handleImagePreview(event, "#web_image", $(this).closest(".product-img").find("#photo-msg"));
});
// Image 2 Preview
$("input[name=web_image_2]").on("change", function (event) {
    handleImagePreview(event, "#web_image_2", $(this).closest(".product-img").find("#photo-msg"));
});
// Image 3 Preview
$("input[name=web_image_3]").on("change", function (event) {
    handleImagePreview(event, "#web_image_3", $(this).closest(".product-img").find("#photo-msg"));
});
// Centralized image validation/preview
function handleImagePreview(event, imgSelector, errorMsg) {
    const file = event.target.files[0];
    const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if (file) {
        if (!allowedExtensions.test(file.name)) {
            errorMsg.text("Invalid file type! Only jpg, jpeg, and png are allowed.");
            $(imgSelector).attr("src", "");
            return;
        }
        errorMsg.text("");
        const reader = new FileReader();
        reader.onload = function (e) {
            $(imgSelector).attr("src", e.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        $(imgSelector).attr("src", "");
        errorMsg.text("");
    }
}

$('.servicestep1-form input[name=display_order]').on('input', function () {
    let val = $(this).val().replace(/\D/g, ''); // remove non-digits
    let last_count = $(this).data('last_count');
    // Convert to number
    val = parseInt(val, 10);

    // Validate range
    if (val > last_count)
        val = last_count;
    if (val < 1 || isNaN(val))
        val = '';

    $(this).val(val);
});

$(function (e) {
    // $('textarea[name=web_content]').richText();
    $('textarea[name=web_cate_content_1]').richText();
    // $('textarea[name=web_cate_content_2]').richText();
    // $('textarea[name=web_cate_content_3]').richText();
});
