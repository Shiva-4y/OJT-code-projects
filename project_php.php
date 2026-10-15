<?php

$connection = mysqli_connect("localhost", "root", "sukhoi57", "user_project");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sort = $_GET["sort"] ?? "last_name";
$order = $_GET["order"] ?? "ASC";

$allowedSort = ["last_name", "first_name", "city", "phone"];

if (!in_array($sort, $allowedSort)) {
    $sort = "last_name";
}

if ($order !== "ASC" && $order !== "DESC") {
    $order = "ASC";
}

$sql = "SELECT customer_serial, last_name, first_name, city, phone
        FROM customer
        ORDER BY $sort $order";

$result = mysqli_query($connection, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

$nextLastNameOrder = ($sort === "last_name" && $order === "ASC") ? "DESC" : "ASC";
$nextFirstNameOrder = ($sort === "first_name" && $order === "ASC") ? "DESC" : "ASC";
$nextCityOrder = ($sort === "city" && $order === "ASC") ? "DESC" : "ASC";
$nextPhoneOrder = ($sort === "phone" && $order === "ASC") ? "DESC" : "ASC";

?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Customer List</title>
    <!--  JPS 02/10/2026 - applied CSS styling for a cleaner look -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
        }

        .add-button {
            display: inline-block;
            padding: 11px 18px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-button:hover {
            background-color: #555;
        }

        table {
            width: 100%;
            background-color: white;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        th, td {
            padding: 14px 16px;
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

        th a:hover {
            text-decoration: underline;
        }

        tr:hover {
            background-color: #f7f7f7;
        }

.action-link {
    display: inline-block;
    padding: 7px 10px;
    margin-right: 5px;
    border-radius: 5px;
    text-decoration: none;
    background-color: #ddd;
    color: #333;
    font-size: 13px;
}

.action-link:hover {
    background-color: #ccc;
}

.payments-link {
    background-color: #333;
    color: white;
}

.payments-link:hover {
    background-color: #555;
}

        .empty-message {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        
    </style>
</head>

<body>

    <div class="container">

        <div class="header">

            <h1>Customer List</h1>

            <a href="add_customer.php" class="add-button">
                + Add Customer
            </a>

        </div>

        <table>

            <tr>

                <th>
                    <a href="?sort=last_name&order=<?php echo $nextLastNameOrder; ?>">
                        Last Name
                    </a>
                </th>

                <th>
                    <a href="?sort=first_name&order=<?php echo $nextFirstNameOrder; ?>">
                        First Name
                    </a>
                </th>

                <th>
                    <a href="?sort=city&order=<?php echo $nextCityOrder; ?>">
                        City
                    </a>
                </th>

                <th>
                    <a href="?sort=phone&order=<?php echo $nextPhoneOrder; ?>">
                        Phone
                    </a>
                </th>

                <th>Actions</th>

            </tr>

            <?php if (mysqli_num_rows($result) > 0) { ?>

                <?php while ($customer = mysqli_fetch_assoc($result)) { ?>

                    <tr>

                        <td>
                            <?php echo $customer["last_name"]; ?>
                        </td>

                        <td>
                            <?php echo $customer["first_name"]; ?>
                        </td>

                        <td>
                            <?php echo $customer["city"]; ?>
                        </td>

                        <td>
                            <?php echo $customer["phone"]; ?>
                        </td>

                        <td>

                        <a
                            href="edit_customer.php?id=<?php echo $customer["customer_serial"]; ?>"
                            class="action-link"
                        >
                            Edit
                        </a>

                        <a
                            href="delete_customer.php?id=<?php echo $customer["customer_serial"]; ?>"
                            class="action-link"
                        >
                            Delete
                        </a>

                        <a
                        href="payment.php?id=<?php echo $customer["customer_serial"]; ?>"
                        class="action-link payments-link"
                        >
                        Payments
                        </a>

                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="5" class="empty-message">
                        No customers found.
                    </td>
                </tr>

            <?php } ?>

        </table>

    </div>

</body>
</html>

<?php

mysqli_close($connection);

?>