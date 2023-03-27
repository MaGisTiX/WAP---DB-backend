<?php
    // db connection
    $con = mysqli_connect("localhost", "root", "", "parking");
    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    // load data
    $sql = 'SELECT ALL* FROM all_parking';
    $result = mysqli_query($con, $sql);

    
    // generate html
    echo '
        <!DOCTYPE html>
        <html lang="cs">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Parkoviště</title>
        </head>
        <body>
            <h1>Spravované parkoviště</h1>
        
            <form action="" method="POST">
                
                <label for="town">Město</label>
                <input type="text" name="town" id="town" placeholder="Česká Kamenice" required>
        
                <label for="address">Adresa</label>
                <input type="text" name="address" id="address" placeholder="U Jezu" required>
        
                <label for="places">Počet míst</label>
                <input type="number" name="places" id="places" placeholder="69" required>
        
                <input type="submit" value="Uložit">
            </form>

            <table>
                <tr>
                    <th>Město</th>
                    <th>Adresa</th>
                    <th>Počet Míst</th>
                    <th>Smazat</th>
                </tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr>
                            <td>' . $row['town'] . '</td>
                            <td>' . $row['address'] . '</td>
                            <td>' . $row['places'] . '</td>
                            <td><a href="delete.php?id=' . $row['id'] . '">Smazat</a></td>
                        </tr>
                    ';
                }
            echo '</table>
        </body>
        </html>
    ';

    // save new data
    if ($mysql = $con->prepare('SELECT id FROM all_parking WHERE address = ?')) {
        
        $mysql->bind_param('s', $_POST['address']);
        $mysql->execute();
        $mysql->store_result();
        
        if ($mysql->num_rows > 0) {
            
            echo('Parkoviště na této adrese je již v systému zaznamenáno');
            exit;
        
        } else if (!empty($_POST['town']) && $mysql = $con->prepare('INSERT INTO all_parking (town, address, places) VALUES (?, ?, ?)')) {
            $mysql->bind_param('sss', $_POST['town'], $_POST['address'], $_POST['places']);
            $mysql->execute();
            
            echo('Parkoviště úspěně přidáno');
            exit;
        }
        $mysql->close();
    }
?>