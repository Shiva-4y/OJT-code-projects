<?php

$firstNames = [];
$lastNames = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    for ($i = 1; $i <= 10; $i++) {
        $firstName = $_POST["firstName" . $i];
        $lastName = $_POST["lastName" . $i];

        $firstNames[] = $firstName;
        $lastNames[] = $lastName;
    }
    // JPS 28/09/2026- shuffles names in the array to randomize the order of the names
       shuffle($firstNames);
       shuffle($lastNames);

    echo "<h2>Randomized Names</h2>";

    for ($i = 0; $i < count($firstNames); $i++) {
        echo $firstNames[$i] . " " . $lastNames[$i] . "<br>";
    }

    echo "<h2>Names in Alphabetical Order</h2>";

    for ($i = 0; $i < count($firstNames); $i++) {
        if ($firstNames[$i] <= $lastNames[$i]) {
            echo $firstNames[$i] . " " . $lastNames[$i] . "<br>";
        }
    }

    echo "<h2>Last Names and ASCII Totals</h2>";

    for ($i = 0; $i < count($lastNames); $i++) {
        $asciiTotal = 0;

        for ($j = 0; $j < strlen($lastNames[$i]); $j++) {
            $asciiTotal += ord($lastNames[$i][$j]);
        }

        echo $lastNames[$i] . " " . $asciiTotal . "<br>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>php Exercise 1</title>
</head>
<body>

    <h1>Name Randomizer</h1>

    <form method="post">

        <?php for ($i = 1; $i <= 10; $i++) { ?>

            <div>
                <label>First Name:</label>
                <input type="text" name="firstName<?php echo $i; ?>">

                <label>Last Name:</label>
                <input type="text" name="lastName<?php echo $i; ?>">
            </div>

        <?php } ?>

        <input type="submit" value="Submit">

    </form>

</body>
</html>