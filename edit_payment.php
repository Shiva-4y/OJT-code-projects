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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $paymentDate = $_POST["payment_date"];
    $paymentAmount = $_POST["payment_amount"];
    $description = $_POST["description"];

    $sql = "UPDATE payment
            SET
                payment_date = '$paymentDate',
                payment_amount = $paymentAmount,
                description = '$description'
            WHERE payment_serial = $paymentSerial";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Update failed: " . mysqli_error($connection));
    }

    header("Location: payment.php?id=$customerSerial");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>

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
            margin-top: 0;
            margin-bottom: 15px;
        }

        .payment-id {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="date"],
        input[type="number"],
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
            box-sizing: border-box;
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

        <h1>Edit Payment</h1>

        <p class="payment-id">
            Payment ID: <?php echo $payment["payment_serial"]; ?>
        </p>

        <form method="post">

            <label>Payment Date:</label>
            <input
                type="date"
                name="payment_date"
                value="<?php echo $payment["payment_date"]; ?>"
            >

            <label>Payment Amount:</label>
            <input
                type="number"
                name="payment_amount"
                step="0.01"
                value="<?php echo $payment["payment_amount"]; ?>"
            >

            <label>Description:</label>
            <input
                type="text"
                name="description"
                value="<?php echo $payment["description"]; ?>"
            >

            <div class="button-container">

                <input type="submit" value="Save Changes">

                <a
                    href="payment.php?id=<?php echo $customerSerial; ?>"
                    class="cancel-button"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</body>
</html>

<?php

mysqli_close($connection);

?>