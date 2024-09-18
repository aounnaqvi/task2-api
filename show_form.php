<?php
require_once('includes/database.php');
require_once('includes/header.php');

$form_id = $_GET['id'];

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

require_once('includes/footer.php');
?>