<?php

$connection = mysqli_connect("localhost", "root", "sukhoi57", "user_project");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$customerSerial = $_GET["id"];

if (isset($_GET["confirm"]) && $_GET["confirm"] == "yes") {

    $sql = "DELETE FROM customer
            WHERE customer_serial = $customerSerial";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Delete failed: " . mysqli_error($connection));
    }

    header("Location: project_php.php");
    exit;
}

$sql = "SELECT customer_serial, first_name, last_name, street_address, city, phone
        FROM customer
        WHERE customer_serial = $customerSerial";

$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$customer = mysqli_fetch_assoc($result);

if (!$customer) {
    die("Customer not found.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Customer</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px;
        }

        .delete-container {
            width: 450px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .warning {
            text-align: center;
            margin-bottom: 25px;
        }

        .customer-info {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .customer-info p {
            margin: 8px 0;
        }

        .button-container {
            display: flex;
            gap: 10px;
        }

        .button-container a {
            flex: 1;
            padding: 11px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }

        .delete-button {
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

    <div class="delete-container">

        <h1>Delete Customer</h1>

        <p class="warning">
            Are you sure you want to delete this customer?
        </p>

        <div class="customer-info">

            <p>
                <strong>Name:</strong>
                <?php echo $customer["first_name"] . " " . $customer["last_name"]; ?>
            </p>

            <p>
                <strong>Street Address:</strong>
                <?php echo $customer["street_address"]; ?>
            </p>

            <p>
                <strong>City:</strong>
                <?php echo $customer["city"]; ?>
            </p>

            <p>
                <strong>Phone:</strong>
                <?php echo $customer["phone"]; ?>
            </p>

        </div>

        <div class="button-container">

            <a
                href="delete_customer.php?id=<?php echo $customer["customer_serial"]; ?>&confirm=yes"
                class="delete-button"
            >
                Confirm Delete
            </a>

            <a
                href="project_php.php"
                class="cancel-button"
            >
                Cancel
            </a>

        </div>

    </div>

</body>
</html>

<?php

mysqli_close($connection);

?>