<?php

$connection = mysqli_connect("localhost", "root", "sukhoi57", "user_project");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$customerSerial = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $paymentDate = $_POST["payment_date"];
    $paymentAmount = $_POST["payment_amount"];
    $description = $_POST["description"];

    $sql = "INSERT INTO payment
            SET
                customer_serial = $customerSerial,
                payment_date = '$paymentDate',
                payment_amount = $paymentAmount,
                description = '$description'";

    $result = mysqli_query($connection, $sql);

    if (!$result) {
        die("Insert failed: " . mysqli_error($connection));
    }

    header("Location: payment.php?id=$customerSerial");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Payment</title>

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

        .customer-id {
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

        input[type="submit"]:hover {
            background-color: #555;
        }

        .cancel-button {
            background-color: #ddd;
            color: #333;
        }

        .cancel-button:hover {
            background-color: #ccc;
        }
    </style>
</head>

<body>

    <div class="form-container">

        <h1>Add Payment</h1>

        <p class="customer-id">
            Customer ID: <?php echo $customerSerial; ?>
        </p>

        <form method="post">

            <label>Payment Date:</label>
            <input
                type="date"
                name="payment_date"
            >

            <label>Payment Amount:</label>
            <input
                type="number"
                name="payment_amount"
                step="0.01"
            >

            <label>Description:</label>
            <input
                type="text"
                name="description"
            >

            <div class="button-container">

                <input type="submit" value="Add Payment">

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