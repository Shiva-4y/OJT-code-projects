<?php

$connection = mysqli_connect("localhost", "root", "sukhoi57", "user_project");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $streetAddress = $_POST["street_address"];
    $city = $_POST["city"];
    $phone = $_POST["phone"];

    $sql = "INSERT INTO customer
            SET
                first_name = '$firstName',
                last_name = '$lastName',
                street_address = '$streetAddress',
                city = '$city',
                phone = '$phone'";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Insert failed: " . mysqli_error($connection));
    }

    header("Location: project_php.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px;
        }

        .form-container {
            width: 450px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        input[type="submit"],
        .cancel-button {
            flex: 1;
            padding: 11px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        input[type="submit"] {
            border: none;
            background-color: #333;
            color: white;
        }

        .cancel-button {
            background-color: #ddd;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="form-container">

        <h1>Add Customer</h1>

        <form method="post">

            <label>First Name:</label>
            <input type="text" name="first_name">

            <label>Last Name:</label>
            <input type="text" name="last_name">

            <label>Street Address:</label>
            <input type="text" name="street_address">

            <label>City:</label>
            <input type="text" name="city">

            <label>Phone:</label>
            <input type="text" name="phone">

            <div class="button-container">
                <input type="submit" value="Add Record">
                <a href="project_php.php" class="cancel-button">Cancel</a>
            </div>

        </form>

    </div>

</body>
</html>

<?php

mysqli_close($connection);

?>