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

    $conn = new mysqli("localhost", "root", "", "task2");

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
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
