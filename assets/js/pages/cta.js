var table_column = [
    {
        data: "serial_no",
        title: "S.No",
        is_default: true,
        dt: true,
        width: "30px",
    },
    {
        data: "tag",
        className: "text-start fw-bold",
        title: "Page",
        is_default: true,
        dt: true,
        width: "150px",
    },
    {
        data: "title",
        title: "Title",
        is_default: true,
        dt: true,
        width: "200px",
    },
    {
        data: "status",
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
              <input type="checkbox" ${data == 1 ? "checked" : ""} data-tag="${row["raw_tag"]}" class="cta_status" >
              <span class="cus-slider round"></span>
            </label>
            <label>Active</label>
          </div>`;
        },
    },
    {
        data: "raw_tag",
        width: "150px",
        className: "text-center my-btn position-relative",
        title: "Action",
        render: function (data, type, row) {
            return `      
      <button data-tag="${row["raw_tag"]}" class="waves-effect waves-light btn btn-primary-light btn-sm edit-cta" type="button" ><i class="fi fi-sr-attribution-pencil"></i> Edit</button>
      `;
        },
    },
];

var dt = {
    table: "#cta_table",
    column: table_column,
    url: "getCallToActions",
};

var k = common.dataTable(dt);

// Add and Edit
$(document).on("click", ".edit-cta", function () {
    var vbk = "show";
    $(".cta-form")[0].reset();
    var tag = $(this).data("tag");
    $(".modal-name").text("Edit");
    $(".cta-form input[name=tag]").val(tag);
    
    var result = common.ajax_fech("getCallToAction", {tag: tag});

    if (result["code"] == 200 && result["data"].length != 0) {
        var data = result["data"][0];
        $(".cta-form input[name=tag]").val(data["tag"]);
        $("#displayTag").val(data["tag"].replace('-', ' ').toUpperCase());
        $(".cta-form input[name=title]").val(data["title"]);
        $(".cta-form textarea[name=content]").val(data["content"]);
        $(".cta-form select[name=status]").val(data["status"]);
    } else {
        vbk = "hide";
        Swal2("error", "Something Error", "Try Some again time");
    }
    
    $("#cta-modal").modal(vbk);
});

// From Submit
$(".cta-form").on("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    common
        .ajax_save_file("saveCallToAction", formData)
        .then(function (response) {
            if (response.status === 'success' || response.code == 200) {
                reloadDataTable(k);
                Swal2("success", "Success", "Successfully Saved").then(() => {
                    $("#cta-modal").modal("hide");
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

//status update
$(document).on("change", ".cta_status", function () {
    var tag = $(this).data("tag");
    var status = $(this).prop("checked") ? 1 : 0;
    
    // Fetch full data first to ensure we don't overwrite with empty content
    var result = common.ajax_fech("getCallToAction", {tag: tag});
    var data = (result["code"] == 200 && result["data"].length != 0) ? result["data"][0] : null;
    
    if (!data) return;

    var update_data = {
        tag: tag,
        status: status,
        title: data['title'],
        content: data['content']
    };

    common
        .ajax_save("saveCallToAction", update_data)
        .then(function (response) {
            reloadDataTable(k);
            if (response.status === 'success' || response.code == 200) {
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
