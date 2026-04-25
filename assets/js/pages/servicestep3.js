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
                    row["web_service_step_3_id"]
                    }" class="servicestep3_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "web_service_step_3_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
          <button data-pid="${row["web_service_step_3_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-servicestep3" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
          <button data-pid="${row["web_service_step_3_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-servicestep3 " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
      `;
        },
    },
];

var dt = {
    table: "#servicestep3_table",
    column: table_column,
    url: "getServiceStep3",
    data_src: {web_service_step_2_id: web_service_step_2_id}
};

var k = common.dataTable(dt);


// Add and Edit
$(document).on("click", ".edit-servicestep3", function () {
    var vbk = "show";
    $(".servicestep3-form")[0].reset();
    $("#web_image").attr("src", "");
    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".servicestep3-form input[name=web_service_step_3_id]").val(pid);
    $(".servicestep3-form input[name=web_service_id]").val(web_service_id);
    $(".servicestep3-form input[name=web_service_step_1_id]").val(web_service_step_1_id);
    $(".servicestep3-form input[name=web_service_step_2_id]").val(web_service_step_2_id);
    var result = common.ajax_fech("getServiceStep3", {web_service_step_1_id: web_service_step_1_id, web_service_step_2_id: web_service_step_2_id, web_service_step_3_id: pid, web_service_id: web_service_id});
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".servicestep3-form input[name=display_order]").data('last_count', last_count).val(last_count);
 
// Also clear the original hidden textarea
    $('textarea[name=web_content], textarea[name=web_cate_content_1], textarea[name=web_cate_content_2], textarea[name=web_cate_content_3]').val('').trigger('change');
    $('#show_content').addClass('d-none');
    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            $(".servicestep3-form input[name=web_service_step_3_id]").val(
                    result["data"][0]["web_service_step_3_id"]
                    );
            $(".servicestep3-form input[name=web_title]").val(
                    result["data"][0]["web_title"]
                    );
            
             $(".servicestep3-form input[name=footer_text]").val(
                    result["data"][0]["footer_text"]
                    );
            
              $(`.servicestep3-form input[name="is_menu"][value="${result["data"][0]["is_menu"]}"]`
                    ).prop("checked", true);

            $(".servicestep3-form input[name=display_order]").val(
                    result["data"][0]["display_order"]
                    );

            $(`.servicestep3-form input[name="is_next_level"][value="${result["data"][0]["is_next_level"]}"]`
                    ).prop("checked", true);

             

            $(".servicestep3-form textarea[name=web_content]").val(
                    result["data"][0]["web_content"]
                    ).trigger('change');

            $(".servicestep3-form input[name=web_cate_title_1]").val(
                    result["data"][0]["web_cate_title_1"]
                    );

            $(".servicestep3-form textarea[name=web_cate_content_1]").val(
                    result["data"][0]["web_cate_content_1"]
                    ).trigger('change');
            $(".servicestep3-form input[name=web_cate_title_2]").val(
                    result["data"][0]["web_cate_title_2"]
                    );

            $(".servicestep3-form textarea[name=web_cate_content_2]").val(
                    result["data"][0]["web_cate_content_2"]
                    ).trigger('change');
            $(".servicestep3-form input[name=web_cate_title_3]").val(
                    result["data"][0]["web_cate_title_3"]
                    );

            $(".servicestep3-form textarea[name=web_cate_content_3]").val(
                    result["data"][0]["web_cate_content_3"]
                    ).trigger('change');


            $("#web_image").attr("src", result["data"][0]["web_image"]);
        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try Some again time");
        }
    }

    $("#servicestep3-modal").modal(vbk);
});
 

// From Submit
$(".servicestep3-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
            .ajax_save_file("saveServiceStep3", formData)
            .then(function (response) {
                if (response.code == 200) {
                    reloadDataTable(k);
                    Swal2("success", "Success", "Successfully User Saved").then(() => {
                        $("#servicestep3-modal").modal("hide");
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
$(document).on("click", ".del-servicestep3", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_service_step_3_id: pid,
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
                            .ajax_save("saveServiceStep3", update_data)
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

//status update
$(document).on("change", ".servicestep3_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_service_step_3_id: pid,
        for : "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common.ajax_save("saveServiceStep3", update_data)
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

// Image
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
        // Clear error message and show preview
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

$('.servicestep3-form input[name=display_order]').on('input', function () {
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
    $('textarea[name=web_content]').richText();
    $('textarea[name=web_cate_content_1]').richText();
    $('textarea[name=web_cate_content_2]').richText();
    $('textarea[name=web_cate_content_3]').richText();

});

 