jQuery(document).ready(function($){
    $('.submit_form').on('click', function(e) {
        e.preventDefault();

        $('#dynamic-form input').each(function(){
            var validationRule = $(this).attr('data-validation');
            if(validationRule == 'email'){
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(! regex.test( $(this).val() ) ){
                   alert("Please check email input"); 
                }
            }
            if(validationRule == 'required' && $(this).val() == ''){
                alert("Empty input");
            }
        });
        $('#dynamic-form textarea').each(function(){
            var validationRule = $(this).attr('data-validation');
            if(validationRule == 'required' && $(this).val() == ''){
                alert("Empty textarea");
            }
        });
        var formData = $('form').serialize();
        $.ajax({
            url: 'http://localhost/task2-api/submit_form.php',
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Form submitted successfully!');
            },
            error: function() {
                alert('Error submitting the form.');
            }
        });
    });
});