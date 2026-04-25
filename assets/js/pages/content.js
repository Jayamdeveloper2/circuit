 
 
// From Submit
$(".form-content").on("submit", function (event) {
  event.preventDefault(); // Prevent default form submission

  // Sync CKEditor instances
  if (common.editors) {
    for (let selector in common.editors) {
      common.editors[selector].updateSourceElement();
    }
  }

  // Submit the form via AJAX if validation passes
  const formData = new FormData(this);
  formData.append("for", "edit");
  common
    .ajax_save_file("saveContent", formData)
    .then(function (response) {
      if (response.code == 200) {         
        Swal2("success", "Success", "Content saved successfully");
      } else {
        Swal2("error", "Something Error", response.message);
      }
    })
    .catch(function (error) {     
      Swal2("error", "Something Error", "Try Some again time");
    });
});
 