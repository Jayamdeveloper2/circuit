 
// From Submit
$(".form-setting").on("submit", function (event) {
  event.preventDefault(); // Prevent default form submission
  // Submit the form via AJAX if validation passes
  const formData = new FormData(this);
  formData.append("for", "edit");
  common
    .ajax_save_file("saveSetting", formData)
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
 
 