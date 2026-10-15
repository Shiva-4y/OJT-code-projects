<?php

$connection = mysqli_connect("localhost", "root", "sukhoi57", "user_project");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$paymentSerial = $_GET["id"];

$sql = "SELECT payment_serial, customer_serial, payment_date, payment_amount, description
        FROM payment
        WHERE payment_serial = $paymentSerial";

$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$payment = mysqli_fetch_assoc($result);

if (!$payment) {
    die("Payment not found.");
}

$customerSerial = $payment["customer_serial"];

if (isset($_GET["confirm"]) && $_GET["confirm"] == "yes") {

    $sql = "DELETE FROM payment
            WHERE payment_serial = $paymentSerial";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Delete failed: " . mysqli_error($connection));
    }

    header("Location: payment.php?id=$customerSerial");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Payment</title>

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

        .payment-info {
            background-color: #f7f7f7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
        }

        .payment-info p {
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

        <h1>Delete Payment</h1>

        <p class="warning">
            Are you sure you want to delete this payment?
        </p>

        <div class="payment-info">

            <p>
                <strong>Payment Date:</strong>
                <?php echo $payment["payment_date"]; ?>
            </p>

            <p>
                <strong>Payment Amount:</strong>
                <?php echo $payment["payment_amount"]; ?>
            </p>

            <p>
                <strong>Description:</strong>
                <?php echo $payment["description"]; ?>
            </p>

        </div>

        <div class="button-container">

            <a
                href="delete_payment.php?id=<?php echo $payment["payment_serial"]; ?>&confirm=yes"
                class="delete-button"
            >
                Confirm Delete
            </a>

            <a
                href="payment.php?id=<?php echo $customerSerial; ?>"
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