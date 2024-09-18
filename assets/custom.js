jQuery(document).ready(function($){
    $('.submit_form').on('click', function(e) {
        e.preventDefault();

        var validated = true;

        if($('#captcha').val() !== $('#captcha').attr('data-value')){
            alert("Please verify you are human");
            validated = false;
        }

        $('#dynamic-form input').each(function(){
            var validationRule = $(this).attr('data-validation');
            if(validationRule == 'email'){
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(! regex.test( $(this).val() ) ){
                   alert("Please check email input");
                   validated = false;
                }
            }
            if(validationRule == 'required' && $(this).val() == ''){
                alert("Empty input");
                validated = false;
            }
        });
        $('#dynamic-form textarea').each(function(){
            var validationRule = $(this).attr('data-validation');
            if(validationRule == 'required' && $(this).val() == ''){
                alert("Empty textarea");
                validated = false;
            }
        });
        var formData = $('form').serialize();
        if(!validated){
            return false;
        }
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