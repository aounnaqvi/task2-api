<?php 
header('Content-Type: application/json');

$form_data = $_POST;
$form_id = $form_data['form_id'];
// Fetch form validation rules
$conn = new mysqli("localhost", "root", "", "task2");

$stmt = $conn->prepare("SELECT fields, email FROM forms WHERE id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$stmt->bind_result($fields, $email);
$stmt->fetch();
$fields = json_decode($fields, true);
$email = json_decode($email, true);

// Validate form data
foreach ($fields as $field) {
    if ($field['validation'] == 'required' && empty($form_data[$field['name']])) {
        echo json_encode(['status' => 'error', 'message' => "{$field['name']} is required"]);
        exit;
    }
}
$stmt->close();

// Store form submission in a table
$submission_data = json_encode($form_data);
// die($form_id. $submission_data);
$stmt = $conn->prepare("INSERT INTO form_submissions (form_id, submission_data) VALUES (?, ?)");
$stmt->bind_param("is", $form_id, $submission_data);

if ($stmt->execute()) {
    // Send an email if necessary
    $email_content = 'Message body';
    if($email)
        mail($email, 'Form Submission', $email_content, 'Content-Type: text/html');
    echo json_encode(['status' => 'success', 'message' => 'Form submitted']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit form']);
}

$stmt->close();
$conn->close();