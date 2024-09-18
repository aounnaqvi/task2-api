<?php
/*
Get the User API request in the form of /create.form.php
Data Format: 
fields: [{FieldType, FieldName, validationRule}, email
*/

header('Content-Type: application/json');

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

if ( isset($data['fields']) && is_array($data['fields']) ) {

    // Loop through each field object
    foreach ($data['fields'] as $field) {
        // Check if the necessary properties are present
        if (isset($field['FieldType']) && isset($field['FieldName'])) {
            // Sanitize and process field data
            $fieldType = $field['FieldType'];
            $fieldName = $field['FieldName'];
            $validationRule = isset($field['validationRule']) ? $field['validationRule'] : '';

            //Prepare to save field configuration in the database
            $fields[] = [
                'type' => $fieldType,
                'name' => $fieldName,
                'validation' => $validationRule
            ];
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid field data']);
            exit;
        }
    }

    // Convert fields array to JSON to store in database
    $fields_json = json_encode($fields);

    $email = isset($data['email']) ? $data['email'] : '';

    //Store in the database
    $conn = new mysqli("localhost", "root", "", "task2");

    $stmt = $conn->prepare("INSERT INTO forms (fields, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $fields_json, $email);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Form data stored successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to store form data']);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
