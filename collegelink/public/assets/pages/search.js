(function ($) {
    $(document).on('submit', 'form.AsideSearchForm', function(e) {
       // Stop default form behavior
       e.preventDefault();

       // Get form data
       const formData = $(this).serialize();

       // Ajax request
       $.ajax(
        'http://localhost/collegelink/public/ajax/search_results.php',
        {
        type: "GET",
        dataType: "html",
        data: formData,
        }).done(function(result) {
            // Clear results container
            $('#hotel-list').html('');

            // Append results to container
            $('#hotel-list').append(result);

            // Push url state
            history.pushState({}, '', 'http://localhost/collegelink/public/list.php?' + formData);
        });
    });
})(jQuery);