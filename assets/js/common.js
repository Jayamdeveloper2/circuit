//console.log = console.warn = console.error = function() {};

const main_url = "http://localhost/circuit/";
const base_url = main_url + "circuit-manage/api/";
console.log(base_url);
var common = {};
common.editors = {};

common.initEditor = function (selector) {
    if (typeof ClassicEditor === 'undefined') {
        console.error("CKEditor script not loaded.");
        return;
    }
    const element = document.querySelector(selector);
    if (!element) {
        console.warn("Element not found for CKEditor: " + selector);
        return;
    }
    ClassicEditor.create(element, {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
    })
    .then(editor => {
        common.editors[selector] = editor;
    })
    .catch(error => {
        console.error("CKEditor initialization failed:", error);
    });
};

// set csrf token
var csrfName = $('meta[name="csrf-token-name"]').attr("content");
var csrfHash = $('meta[name="csrf-token-hash"]').attr("content");

// Set up jQuery to include the CSRF token in the headers
// $.ajaxSetup({

// });

// $(document).ajaxStart(function() { Pace.restart(); });

const ll = {
  copy: {
    extend: "copyHtml5",
    text: '<i class="fas fa-copy"></i> Copy',
    className: "waves-effect waves-light btn-sm btn btn-primary-light mb-2",
  },
  excel: {
    extend: "excelHtml5",
    text: '<i class="fas fa-file-excel"></i> Excel',
    className: "waves-effect waves-light btn btn-sm  btn-success-light mb-2",
  },
  pdf: {
    extend: "pdfHtml5",
    text: '<i class="fas fa-file-pdf"></i> PDF',
    className: "waves-effect waves-light btn btn-sm btn-danger-light mb-2",
    orientation: "portrait",
    pageSize: "A4",
  },
  print: {
    extend: "print",
    text: '<i class="fas fa-print"></i> Print',
    className: "waves-effect waves-light btn btn-sm btn-warning-light mb-2",
  },
};

var dt_check_data = [];

common.dataTable = function (dt_data) {
  const {
    table,
    column,
    url,
    meth = "POST",
    data_src = [],
    order = [],
    multiSort = false,
    processing = true,
    serverSide = false,
    button_array = [],
    filter = [],
  } = dt_data;

  var o = $(table).DataTable({
    // destroy: true,
    ajax: {
      url: base_url + url,
      dataSrc: "data",
      method: meth,
      data: function (d) {
        return $.extend({}, d, data_src, filter);
        // Example of debugging the request parameters
      },
      dataSrc: function (response) {
        dt_check_data = response.pk_ids;
        return response.data;
      },
      error: function (xhr, status, error) {
        alert("Error: " + error);
      },
    },
    columnDefs: [
      {
        targets: [0], // All columns
        orderable: false,
      },
    ],

    language: {
      emptyTable: `<div style="text-align: center;">   
                           <div class="table-no-data">
                                    <img src="${main_url}assets/images/no-data.png" width="120">
                                    <label>No Data Found</label>
                               </div> </div>`,
      zeroRecords: `<div style="text-align: center;">   
                           <div class="table-no-data">
                                    <img src="${main_url}assets/images/no-data.png" width="120">
                                    <label>No Data Found</label>
                               </div> </div>`,
      info: "Showing _START_ to _END_ of _TOTAL_ entries", // Total only
      infoFiltered: "", // Remove the filtered text
      infoEmpty: "", // For empty data
      sLengthMenu: "Entries _MENU_ per page",
    },
    createdRow: function (row, data, dataIndex) {
      if (data["is_resubmit"] == 1 && data["is_accept"] == 1) {
        $(row).css("background-color", "#f8d7da73");
      }
    },
    buttons: button_array,
    columns: column,
    order: order,
    multiSort: multiSort,
    processing: processing,
    serverSide: serverSide,
    dom: '<"d-flex justify-content-between cu-table" <"table-custom-content"B> f> r t <"dt-footer" l i p>',
    paging: true, // Enables pagination
    searching: true, // Enables search
    ordering: true,
    scrollY: "420px", // Set vertical scrolling for data
    scrollX: true, // Enable horizontal scrolling
    scrollCollapse: true, // Allow the table to shrink if data is less
    autoWidth: true,
    responsive: true,
    layout: {
      topStart: {
        buttons: [
          {
            extend: "colvis",
            columns: ":not(.noVis)",
            popoverTitle: "Column visibility selector",
          },
        ],
      },
    },
  });
  return o;
};

// Data Table

common.ajax_fech = function (
  url_path,
  data = "",
  type = "POST",
  data_type = "json"
) {
  let result = "";
  $.ajax({
    type: type,
    url: base_url + url_path,
    data: data,
    async: false,
    cache: false,
    dataType: data_type,
    success: function (data) {
      if (data && data.message === 'Session Expired') {
        window.location.href = main_url + 'circuit-manage';
        return;
      }
      result = data;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      result = { error: 1, message: errorThrown };
    },
  });
  return result;
};

common.ajax_save = function (
  url_path,
  data,
  type = "POST",
  data_type = "json",
  recall = true
) {
  return new Promise(function (resolve, reject) {
    // Return a Promise for async handling
    $.ajax({
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"), // Add CSRF token to the header
      },
      url: base_url + url_path,
      type: type,
      data: data,
      dataType: data_type,
      cache: false,
      success: function (response) {
        if (response && response.message === 'Session Expired') {
          window.location.href = main_url + 'circuit-manage';
          return;
        }
        $('meta[name="csrf-token-hash"]').attr("content", response.csrf_hash);
        resolve(response); // Resolve the Promise with the successful response
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        if (XMLHttpRequest.status == 403) {
          // If CSRF token error occurs, refresh the token and retry
          if (recall) {
            refreshCsrfToken()
              .then(function () {
                // Retry the original request after refreshing the token
                common
                  .ajax_save(url_path, data, type, data_type, false)
                  .then(function (retryResponse) {
                    resolve(retryResponse); // Resolve with retry response
                  })
                  .catch(function (retryError) {
                    reject(retryError); // Reject if retry fails
                  });
              })
              .catch(function () {
                reject("Failed to refresh CSRF token"); // Reject if token refresh fails
              });
          }
        } else {
          reject(XMLHttpRequest); // Reject if there's any other error
        }
      },
    });
  });
};

common.ajax_save_file = function (
  url_path,
  data,
  type = "POST",
  data_type = "json",
  recall = true
) {
  return new Promise(function (resolve, reject) {
    // Return a Promise for async handling
    $.ajax({
      headers: {
        "X-CSRF-Token": $('meta[name="csrf-token-hash"]').attr("content"), // Add CSRF token to the header
      },
      url: base_url + url_path,
      type: type,
      data: data,
      dataType: data_type,
      cache: false,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response && response.message === 'Session Expired') {
          window.location.href = main_url + 'circuit-manage';
          return;
        }
        $('meta[name="csrf-token-hash"]').attr("content", response.csrf_hash);
        resolve(response); // Resolve the Promise with the successful response
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        if (XMLHttpRequest.status == 403) {
          // If CSRF token error occurs, refresh the token and retry
          if (recall) {
            refreshCsrfToken()
              .then(function () {
                // Retry the original request after refreshing the token
                common
                  .ajax_save_file(url_path, data, type, data_type, false)
                  .then(function (retryResponse) {
                    resolve(retryResponse); // Resolve with retry response
                  })
                  .catch(function (retryError) {
                    reject(retryError); // Reject if retry fails
                  });
              })
              .catch(function () {
                reject("Failed to refresh CSRF token"); // Reject if token refresh fails
              });
          }
        } else {
          reject(XMLHttpRequest); // Reject if there's any other error
        }
      },
    });
  });
};

function refreshCsrfToken() {
  return new Promise(function (resolve, reject) {
    $.post(base_url + "refreshCsrf", function (csrf_data) {
      if (csrf_data.csrf_hash) {
        $('meta[name="csrf-token-hash"]').attr("content", csrf_data.csrf_hash); // Update the CSRF token in the meta tag
        resolve(); // Resolve the Promise after the token is refreshed
      } else {
        reject("Failed to get a new CSRF token"); // Reject if there's an issue fetching the new token
      }
    }).fail(function () {
      reject("Failed to refresh CSRF token"); // Reject if the POST request fails
    });
  });
}

common.ajax_call1 = function (data) {
  let result = "";
  $.ajax({
    type: "POST",
    url: "ajax.php",
    data: data,
    async: false,
    cache: false,
    dataType: "json",
    success: function (data) {
      result = data;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      result = { error: 1, message: errorThrown };
    },
  });

  return result;
};

common.ajax_survey = function (formadata) {
  var resResult = "";
  $.ajax({
    type: "POST",
    cache: false,
    async: false,
    contentType: false,
    processData: false,
    url: "ajax.php",
    data: formadata,
    dataType: "json",
    success: function (data) {
      resResult = data;
    },
    error: function (XMLHttpRequest, textStatus, errorThrown) {
      resResult = { error: 1, message: errorThrown };
    },
  });

  return resResult;
};

// Select HTML
let selectHtml = function (id, placeholder, data) {
  const $select = $(id);
  $select.empty();
  const placeholderdata = $("<option>", {
    value: "",
    text: placeholder,
    disabled: true,
    selected: true,
  });
  $select.append(placeholderdata);

  data.forEach((item) => {
    $select.append(new Option(item.text, item.id));
  });
};

// select2 common
let select2Html = function (
  id,
  placeholder,
  data,
  dropdownParent,
  data_attr = false
) {
  $(id)
    .html("<option></option>")
    .select2({
      tags: false,
      placeholder: placeholder,
      data: data,
      allowClear: true,
      width: "100%",
      dropdownParent: $(dropdownParent),
      escapeMarkup: function (markup) {
        return markup;
      },
    });
  if (data_attr) {
    data.forEach(function (item) {
      let optionElement = $(`${id} option[value="${item.id}"]`);
      optionElement.attr(`data-${data_attr}`, item[data_attr]);
    });
  }
};

let MSelect = function (id, placeholder, data, dropdownParent) {
  $(id)
    .html("")
    .select2({
      width: "100%",
      placeholder: placeholder,
      allowClear: true,
      data: data,
      dropdownParent: $(dropdownParent),
      escapeMarkup: function (markup) {
        return markup;
      },
    });
};

function select2AjaxCall(_for, _id, obj) {
  let res = common.ajax_call({ for: _for, ...obj });
  if (res.error == 0) {
    select2Html(_id, "Select", res.data);
    return true;
  } else {
    select2Html(_id, "Select", []);
    return false;
  }
}

function Mselect2AjaxCall(_id, placeholder, _for, obj = {}, dropdownParent) {
  return new Promise((resolve, reject) => {
    let res = common.ajax_fech(_for, obj);
    if (res.code == 200) {
      MSelect(_id, placeholder, res.data, dropdownParent);
    } else {
      MSelect(_id, placeholder, [], dropdownParent);
    }
    resolve(true);
  });
}

function select2Ajax(_for, _id, obj = {}, dropdownParent, data_attr = false) {
  return new Promise((resolve, reject) => {
    let res = common.ajax_fech(_for, obj);
    if (res.code == 200) {
      select2Html(_id, "Select", res.data, dropdownParent, data_attr);
    } else {
      select2Html(_id, "Select", [], dropdownParent, data_attr);
    }
    resolve(true);
  });
}

// convert formdata into json object
const toJsonData = (formID) => {
  let obj = {};
  let formData = new FormData($(formID)[0]);
  for (let [key, value] of formData) {
    obj[key] = value == "" ? null : value;
  }
  return JSON.stringify(obj);
};

const Swal2 = function (type = "success", title = "", text = "") {
  return swal.fire({
    title: title,
    text: text,
    icon: type,
  });
};

// Jquery Dependency

$("input[data-type='currency']").on({
  keyup: function () {
    formatCurrency($(this));
  },
  blur: function () {
    formatCurrency($(this), "blur");
  },
});

function formatNumber(n) {
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(input, blur) {
  var input_val = input.val();
  if (input_val === "") {
    return;
  }

  // Original length
  var original_len = input_val.length;

  // Initial caret position
  var caret_pos = input.prop("selectionStart");

  // Remove any commas or non-numeric characters except the decimal
  input_val = input_val.replace(/,/g, "");

  // Check for decimal
  if (input_val.indexOf(".") >= 0) {
    // Get position of the first decimal
    var decimal_pos = input_val.indexOf(".");

    // Split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos + 1);

    // Validate right side to ensure only numbers
    right_side = right_side.replace(/[^0-9]/g, "");

    // On blur, ensure 2 numbers after decimal
    if (blur === "blur") {
      right_side = (right_side + "00").substring(0, 2);
    }

    // Join number by `.`
    input_val = left_side + "." + right_side;
  } else {
    // No decimal entered, validate input as numeric
    input_val = input_val.replace(/[^0-9]/g, "");

    // Final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }

  // Send updated string to input
  input.val(input_val);

  // Put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}

// Money Contvert
function convertToIndianFormat(amount) {
  if (amount >= 10000000) {
    // If the amount is more than or equal to 1 crore
    return (amount / 10000000).toFixed(2) + " Crore";
  } else if (amount >= 100000) {
    // If the amount is more than or equal to 1 lakh
    return (amount / 100000).toFixed(2) + " Lakh";
  } else {
    // If the amount is less than 1 lakh
    return moneyFormat(amount).toString();
  }
}

// Bootrap tooltip
function initializeTooltips() {
  // Initialize all tooltips
  const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  tooltips.forEach((tooltip) => {
    new bootstrap.Tooltip(tooltip);
  });
}
initializeTooltips();
// money comma add
function moneyFormat(number) {
  const indianCurrencyFormat = new Intl.NumberFormat("en-IN");
  return indianCurrencyFormat.format(number);
}

let pageName = window.location.pathname.split("/").pop();
// Load Accept Reject Status
$(document).on("click", ".loadlist-accept", function () {
  var update_data = {
    trip_detail_id: $(this).data("pid"),
    is_accept: $(this).data("accept"),
  };
  common
    .ajax_save("saveTripDataStatus", update_data)
    .then(function (response) {
      if (pageName == "dashboard") {
        getTipperDetails();
      } else {
        t.ajax.reload(null, false);
      }

      if (response.code == 200) {
        Swal2("success", "Success", "Successfully Status Updated");
      } else {
        Swal2("error", "Failed", "Please Try Again");
      }
    })
    .catch(function (error) {
      if (pageName == "dashboard") {
        getTipperDetails();
      } else {
        t.ajax.reload(null, false);
      }
      Swal2("error", "Something Error", "Please Try Again");
    });
});

// change password

// Save Material Data
$(".user_change_password_form").on("submit", function (event) {
  event.preventDefault(); // Prevent default form submission
  // Submit the form via AJAX if validation passes
  common
    .ajax_save("changeUserPassword", $(this).serializeArray())
    .then(function (response) {
      if (response.code == 200) {
        Swal2("success", "Success", response.message).then(() => {
          $("#user-change-password").modal("hide");
          window.location.reload();
        });
      } else {
        Swal2("error", "Failed", response.message);
      }
    })
    .catch(function (error) {
      Swal2("error", "Something Error", "Try Some again time");
    });
});

// Save Email Data
$(".user_change_email_form").on("submit", function (event) {
  event.preventDefault(); // Prevent default form submission
  // Submit the form via AJAX if validation passes
  common
    .ajax_save("changeUserEmail", $(this).serializeArray())
    .then(function (response) {
      if (response.code == 200) {
        Swal2("success", "Success", response.message).then(() => {
          $("#user-change-email").modal("hide");
          location.reload();
        });
      } else {
        Swal2("error", "Failed", response.message);
      }
    })
    .catch(function (error) {
      Swal2("error", "Something Error", "Try Some again time");
    });
});


$(".modal.modal-right").on("hidden.bs.modal", function () {
  const $form = $(this).find("form");
  resetForm($form);
});

var excelLoader = function (loader_action) {
  var loader_html = ``;
  var load_action = $(".excel-loader");
  load_action.css("display", "none");
  if (loader_action == "show") {
    load_action.css("display", "flex");
    loader_html = `
    <div class="loader-content text-center">
        <h2 class="text-white">Processing your Excel</h2>
        <img loading="lazy" src="${main_url}/assets/images/preloaders/excel-loading.gif">
        <h3 class="text-white">Please wait<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></h3>
    </div>`;
  }
  load_action.html(loader_html);
};

const colors = {
  A: "rgba(114, 172, 193, 0.37)",
  B: "rgba(255, 182, 193, 0.5)",
  C: "rgba(144, 238, 144, 0.4)",
  D: "rgba(255, 250, 205, 0.6)",
  E: "rgba(173, 216, 230, 0.5)",
  F: "rgba(221, 160, 221, 0.3)",
  G: "rgba(240, 128, 128, 0.4)",
  H: "rgba(255, 228, 196, 0.5)",
  I: "rgba(152, 251, 152, 0.4)",
  J: "rgba(135, 206, 250, 0.6)",
  K: "rgba(176, 224, 230, 0.3)",
  L: "rgba(250, 240, 230, 0.4)",
  M: "rgba(255, 222, 173, 0.6)",
  N: "rgba(240, 248, 255, 0.4)",
  O: "rgba(245, 245, 220, 0.5)",
  P: "rgba(224, 255, 255, 0.5)",
  Q: "rgba(255, 239, 213, 0.6)",
  R: "rgba(255, 228, 225, 0.4)",
  S: "rgba(245, 245, 220, 0.3)",
  T: "rgba(230, 230, 250, 0.5)",
  U: "rgba(175, 238, 238, 0.5)",
  V: "rgba(255, 228, 181, 0.6)",
  W: "rgba(245, 245, 245, 0.3)",
  X: "rgba(240, 230, 140, 0.5)",
  Y: "rgba(240, 128, 128, 0.4)",
  Z: "rgba(255, 255, 224, 0.6)",
};

function darkenColor(rgba) {
  const rgbaValues = rgba.match(/rgba\((\d+),\s*(\d+),\s*(\d+)/);
  if (!rgbaValues) return "rgba(0, 0, 0, 0.8)"; // Default to black if parsing fails

  const [_, r, g, b] = rgbaValues.map(Number);
  const factor = 0.6; // Darken factor
  const darkR = Math.max(0, r * factor);
  const darkG = Math.max(0, g * factor);
  const darkB = Math.max(0, b * factor);

  return `rgba(${Math.round(darkR)}, ${Math.round(darkG)}, ${Math.round(
    darkB
  )}, 1)`;
}

// Text count
$(document).ready(function () {
  resetTestCounter();
});
function resetTestCounter() {
  $(".text-counter").each(function () {
    const field = $(this);
    updateRemainingCount(field); // Initial update
    field.on("input", function () {
      updateRemainingCount(field); // Update on input
    });
  });
}
var qrappcode;
const qrappCodeDiv = document.getElementById("app_qrcode"); //$("#app_qrcode");

$(document).on("click", ".app-download", function () {
  qrappCodeDiv.innerHTML = "";
  $("#app-view").modal("show");
  qrappcode = new QRCode(qrappCodeDiv, {
    text: $("#app_qrcode").data("src"), // Your URL or text
    width: 200, // QR Code width
    height: 200, // QR Code height
    colorDark: "#000000", // Dark color of the QR code
    colorLight: "#ffffff", // Light color of the background
    correctLevel: QRCode.CorrectLevel.H, // Error correction level
  });
});

function updateRemainingCount(field) {
  const maxLength = field.attr("maxlength");
  const currentLength = field.val().length;
  const remaining = maxLength - currentLength;
  var counter_content =
    currentLength === 0
      ? ""
      : `Characters left: ${remaining} out of ${maxLength}`;
  field.closest(".form-group").find(".count-info").text(counter_content);
}

$(document).on("click", ".dt-show-btn", function () {
  $(".dt-content").addClass("open"); // Use toggleClass in jQuery
});

$(document).on("click", function (event) {
  const div = $(".dt-content"); // The content div
  const button = $(".dt-show-btn"); // The toggle button
  // If the click is outside both the div and the button, close the div
  if (
    !div.is(event.target) &&
    div.has(event.target).length === 0 &&
    !button.is(event.target) &&
    button.has(event.target).length === 0
  ) {
    div.removeClass("open");
  }
});

function reloadDataTable(k, is_del = false) {
  if (!is_del) {
    k.ajax.reload(null, false);
    return true;
  }
  var currentPage = k.page(); // Get current page index
  var totalRecords = k.rows().count(); // Get total number of records
  var pageLength = k.page.len(); // Get number of records per page

  // Check if the last record on the page is deleted and move to the previous page
  if (totalRecords % pageLength === 1 && currentPage > 0) {
    currentPage--; // Move to previous page
  }

  k.ajax.reload(function () {
    k.page(currentPage).draw(false); // Restore page after reload
  }, false);
}


// From Submit
$(".heading-form").on("submit", function (event) {
  event.preventDefault(); // Prevent default form submission
  // Submit the form via AJAX if validation passes
  const formData = new FormData(this);
  common
    .ajax_save_file("saveHeading", formData)
    .then(function (response) {
      if (response.code == 200) {

        Swal2("success", "Success", "Successfully User Saved");
      } else {
        Swal2("error", "Something Error", response.message);
      }
    })
    .catch(function (error) {
      Swal2("error", "Something Error", "Try Some again time");
    });
});



//page video edit modal load

$(document).on("change", "#public_function_manageid", function () {
  var pid = $(this).data("section");
  var update_data = {
    web_content_id: pid,
    for: "status",
    is_active: $(this).prop("checked") ? 1 : 0,
  };

  common
    .ajax_save("pagefunctionmanage", update_data)
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