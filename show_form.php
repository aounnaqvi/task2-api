<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php 
    $form_id = $_GET['id'];
    $conn = new mysqli("localhost", "root", "", "task2");

    $stmt = $conn->prepare("SELECT fields FROM forms WHERE id = ?");
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $stmt->bind_result($fields);
    $stmt->fetch();

    $fields = json_decode($fields, true);

    echo '<form id="dynamic-form">';
    echo "<input type=hidden name=form_id value={$form_id} />";
    foreach ($fields as $field) {
        switch ($field['type']) {
            case 'input':
                echo '<div class="form-group">';
                echo '<label for="' . $field['name'] . '">' . $field['name'] . '</label>';
                echo '<input type="' . $field['type'] . '" class="form-control" name="' . $field['name'] . '" data-validation="' . $field['validation'] .'">';
                echo '</div>';
                break;
            case 'textarea':
                echo '<div class="form-group">';
                echo '<label for="' . $field['name'] . '">' . $field['name'] . '</label>';
                echo '<textarea class="form-control" name="' . $field['name'] . '" data-validation="' . $field['validation'] .'"></textarea>';
                echo '</div>';
                break;
            case 'checkbox':
                echo '<div class="input-group mb-3">';
                echo '<div class="input-group-text">';
                echo '<input class="form-check-input mt-0" type="checkbox" value="' . $field['name'] . '" aria-label="Checkbox for following text input">';
                echo '</div>';
                echo '<input type="text" class="form-control" value="' . $field['name'] . '"  readonly>';
                echo '</div>';
                break;
        }
    }

    echo '<button type="submit" class="btn btn-primary submit_form">Submit</button>';
    echo '</form>';

    $stmt->close();
    $conn->close();
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
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
</script>
</body>
</html>