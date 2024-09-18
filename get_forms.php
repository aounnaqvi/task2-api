<?php
require_once('includes/database.php');
require_once('includes/header.php');


$result = $conn->query("SELECT id, fields, email FROM forms");

if(!$result){
    echo "No data submitted yet. <br />";
    return;
}

echo "<h1>All Forms</h1>";
echo "<table class='table table-striped'>";
echo "<tr><th>Fields</th><th>Email</th><th></th></tr>";
while ($row = $result->fetch_assoc()) {
    $fields_json = json_decode($row['fields'], true);
    echo "<tr><td>{$row['fields']}</td><td>{$row['email']}</td><td><a href='./show_form.php?id={$row['id']}' class='btn btn-primary'>Show Form</a></td></tr>";
}
echo "</table>";

$conn->close();

require_once('includes/footer.php');
?>