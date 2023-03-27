<?php
    $con = mysqli_connect("localhost", "root", "", "parking");
    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM all_parking WHERE id = $id";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo "Záznam byl úspěšně smazán.";
        } else {
            echo "Chyba při mazání záznamu: " . mysqli_error($con);
        }
    } else {
        echo "Neplatný požadavek.";
    }
?>

<a href="index.php">Zpět</a>