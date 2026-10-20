<?php

$firstNames = [];
$lastNames = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // JPS 09/28/26 - Collect first and last names from the form submission.
    for ($i = 1; $i <= 10; $i++) {
        $firstName = $_POST["firstName" . $i];
        $lastName = $_POST["lastName" . $i];

        $firstNames[] = $firstName;
        $lastNames[] = $lastName;
    }

    // JPS 09/28/26 - Shuffle the name lists independently so first names and last names are randomized separately.
    shuffle($firstNames);
    shuffle($lastNames);

    echo "<h2>Randomized Names</h2>";
        
    for ($i = 0; $i < count($firstNames); $i++) {
        echo $firstNames[$i] . " " . $lastNames[$i] . "<br>";
    }

    echo "<h2>Names in Alphabetical Order</h2>";

    // JPS 09/28/26 - Display only pairs where the first name comes alphabetically before or matches the last name, ignoring letter case.
    for ($i = 0; $i < count($firstNames); $i++) {
        if (strcasecmp($firstNames[$i], $lastNames[$i]) <= 0) {
            echo $firstNames[$i] . " " . $lastNames[$i] . "<br>";
        }
    }

    echo "<h2>Last Names and ASCII Totals</h2>";

    for ($i = 0; $i < count($lastNames); $i++) {
        $asciiTotal = 0;

        // JPS 09/28/26 - Add the character code of each character to calculate the total for the current last name.
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
