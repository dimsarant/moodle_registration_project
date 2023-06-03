function deleteRecord(recordId,recordEmail) {
    if (confirm('Are you sure you want to delete : ' + recordEmail + ' ?')) {
        // Send an AJAX request to delete the record with the given ID
        $.ajax({
            url: '/local/project/functions/delete_user.php',
            type: 'POST',
            data: {id: recordId},
            success: function(response) {
                    location.reload();
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert('Failed to delete record. Error - ' + errorMessage);
            }
        });
    }
}