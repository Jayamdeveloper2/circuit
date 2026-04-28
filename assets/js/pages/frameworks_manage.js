$(document).ready(function() {
    // Hide loader
    if(typeof hideLoader === 'function') hideLoader();

    $('#heroForm').on('submit', function(e) {
        e.preventDefault();
        let btn = $(this).find('button[type="submit"]');
        let originalText = btn.text();
        btn.prop('disabled', true).text('Saving...');
        $.ajax({
            url: ADMIN_URL + 'api/saveFrameworkHero',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                Swal.fire({
                    title: response.status === 'success' ? 'Success' : 'Error',
                    text: response.message || 'Saved successfully.',
                    icon: response.status === 'success' ? 'success' : 'error',
                });
            },
            error: function() {
                Swal.fire('Error', 'An unexpected server error occurred.', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).text(originalText);
            }
        });
    });

    $('.save-framework-btn').on('click', function(e) {
        e.preventDefault();
        
        let btn = $(this);
        let form = btn.closest('form');
        let formData = form.serialize();
        let originalText = btn.html();

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: ADMIN_URL + 'api/saveFrameworkContent',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message || 'Content saved successfully.', 'success');
                } else {
                    Swal.fire('Error', response.message || 'Error saving content.', 'error');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire('Error', 'An unexpected server error occurred.', 'error');
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
