<?php

$connection = mysqli_connect("localhost", "root", "sukhoi57", "user_project");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$customerSerial = $_GET["id"];

$sort = $_GET["sort"] ?? "payment_date";
$order = $_GET["order"] ?? "ASC";

$allowedSort = [
    "payment_serial",
    "customer_serial",
    "payment_date",
    "payment_amount",
    "description"
];

if (!in_array($sort, $allowedSort)) {
    $sort = "payment_date";
}

if ($order !== "ASC" && $order !== "DESC") {
    $order = "ASC";
}

$sql = "SELECT payment_serial, customer_serial, payment_date, payment_amount, description
        FROM payment
        WHERE customer_serial = $customerSerial
        ORDER BY $sort $order";

$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$nextPaymentSerialOrder = ($sort === "payment_serial" && $order === "ASC") ? "DESC" : "ASC";
$nextCustomerSerialOrder = ($sort === "customer_serial" && $order === "ASC") ? "DESC" : "ASC";
$nextPaymentDateOrder = ($sort === "payment_date" && $order === "ASC") ? "DESC" : "ASC";
$nextPaymentAmountOrder = ($sort === "payment_amount" && $order === "ASC") ? "DESC" : "ASC";
$nextDescriptionOrder = ($sort === "description" && $order === "ASC") ? "DESC" : "ASC";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .add-button {
            display: inline-block;
            padding: 10px 16px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        th a {
            color: white;
            text-decoration: none;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-link {
            margin-right: 10px;
            text-decoration: none;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Customer Payments</h1>

        <a
            href="add_payment.php?id=<?php echo $customerSerial; ?>"
            class="add-button"
        >
            Add Payment
        </a>

        <table>

            <tr>

                <th>
                    <a href="?id=<?php echo $customerSerial; ?>&sort=payment_serial&order=<?php echo $nextPaymentSerialOrder; ?>">
                        Payment Serial
                    </a>
                </th>

                <th>
                    <a href="?id=<?php echo $customerSerial; ?>&sort=customer_serial&order=<?php echo $nextCustomerSerialOrder; ?>">
                        Customer Serial
                    </a>
                </th>

                <th>
                    <a href="?id=<?php echo $customerSerial; ?>&sort=payment_date&order=<?php echo $nextPaymentDateOrder; ?>">
                        Payment Date
                    </a>
                </th>

                <th>
                    <a href="?id=<?php echo $customerSerial; ?>&sort=payment_amount&order=<?php echo $nextPaymentAmountOrder; ?>">
                        Payment Amount
                    </a>
                </th>

                <th>
                    <a href="?id=<?php echo $customerSerial; ?>&sort=description&order=<?php echo $nextDescriptionOrder; ?>">
                        Description
                    </a>
                </th>

                <th>Action</th>

            </tr>

            <?php while ($payment = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?php echo $payment["payment_serial"]; ?></td>

                    <td><?php echo $payment["customer_serial"]; ?></td>

                    <td><?php echo $payment["payment_date"]; ?></td>

                    <td><?php echo $payment["payment_amount"]; ?></td>

                    <td><?php echo $payment["description"]; ?></td>

                    <td>
                        <a
                            href="edit_payment.php?id=<?php echo $payment["payment_serial"]; ?>"
                            class="action-link"
                        >
                            [Edit]
                        </a>

                        <a
                            href="delete_payment.php?id=<?php echo $payment["payment_serial"]; ?>"
                            class="action-link"
                        >
                            [Delete]
                        </a>
                    </td>

                </tr>

            <?php } ?>

        </table>

        <a href="project_php.php" class="back-link">
            Back to Customer List
        </a>

    </div>

</body>
</html>

<?php

mysqli_close($connection);

?>