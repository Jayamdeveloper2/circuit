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
        data: "web_icon",
        width: "200px",
        className: "text-center",
        title: "Logo",
        is_default: false,
        dt: true,
        render: function (data, type, row) {
            return `
             <i class='${row['web_icon']}'  style=" font-size: 20px; padding: 10px; "  alt=""></i>
         `;
        },
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
                    row["web_involved_id"]
                    }" class="involvedlist_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "web_involved_id",
        width: "200px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
      <button data-pid="${row["web_involved_id"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-involvedlist" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
          <button data-pid="${row["web_involved_id"]}" class="waves-effect waves-light btn btn-danger-light btn-sm del-involvedlist " type="button" ><i class="fi fi-sr-trash"></i> Delete</button>
      `;
        },
    },
];

var dt = {
    table: "#involvedlist_table",
    column: table_column,
    url: "getInvolvedList",
};

var k = common.dataTable(dt);


// Add and Edit
$(document).on("click", ".edit-involvedlist", function () {
    var vbk = "show";
    $(".involvedlist-form")[0].reset();
    $("#web_image").attr("src", "");
    var pid = $(this).data("pid");
    $(".modal-name").text(pid > 0 ? "Edit" : "Add");
    $(".involvedlist-form input[name=web_involved_id]").val(pid);
    var result = common.ajax_fech("getInvolvedList", {web_involved_id: pid});
    let last_count = (pid > 0) ? Number(result["last_count"]) : (Number(result["last_count"]) + 1);
    $("#order_count").text(last_count);
    $(".involvedlist-form input[name=display_order]").data('last_count', last_count).val(last_count);

    if (pid > 0) {
        if (result["code"] == 200 && result["data"].length != 0) {
            $(".involvedlist-form input[name=web_involved_id]").val(
                    result["data"][0]["web_involved_id"]
                    );
            $(".involvedlist-form input[name=web_title]").val(
                    result["data"][0]["web_title"]
                    );
            
             $(".involvedlist-form textarea[name=web_content]").val(
                    result["data"][0]["web_title"]
                    );

            $(".involvedlist-form input[name=display_order]").val(
                    result["data"][0]["display_order"]
                    );

          
            $(".involvedlist-form input[name=web_icon]").val(
                    result["data"][0]["web_icon"]
                    );
            $('#web_icon_logo').attr('class', result["data"][0]["web_icon"]);
          
        } else {
            vbk = "hide";
            Swal2("error", "Something Error", "Try Some again time");
        }
    }
    $("#involvedlist-modal").modal(vbk);
});

// From Submit
$(".involvedlist-form").on("submit", function (event) {
    event.preventDefault(); // Prevent default form submission
    // Submit the form via AJAX if validation passes
    const formData = new FormData(this);
    formData.append("for", "edit");
    common
            .ajax_save_file("saveInvolvedList", formData)
            .then(function (response) {
                if (response.code == 200) {
                    reloadDataTable(k);
                    Swal2("success", "Success", "Successfully User Saved").then(() => {
                        $("#involvedlist-modal").modal("hide");
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
$(document).on("click", ".del-involvedlist", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_involved_id: pid,
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
                            .ajax_save("saveInvolvedList", update_data)
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
$(document).on("change", ".involvedlist_status", function () {
    var pid = $(this).data("pid");
    var update_data = {
        web_involved_id: pid,
        for : "status",
        is_active: $(this).prop("checked") ? 1 : 0,
    };

    common
            .ajax_save("saveInvolvedList", update_data)
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


$('.involvedlist-form input[name=display_order]').on('input', function () {
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

// Image
$("input[name=web_icon]").on("change", function (event) {
    $('#web_icon_logo').attr('class', $(this).val());
});
