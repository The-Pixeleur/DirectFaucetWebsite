<?php
include "./data/data.php"
?>
<main>
		<h2>DCF <br>
			<a href="https://discord.gg/AEr5zQHnty">Join our discord for more drops !</a>
		</h2>
        <?php


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from CryptoFaucet table
$sql = "SELECT * FROM CryptoFaucet";
$result = $conn->query($sql);

// Create array to hold each section data
$sections = array();

if ($result->num_rows > 0) {
    // Loop through each row of the result
    while ($row = $result->fetch_assoc()) {
        $tokenName = $row["TokenName"];
        // If section doesn't exist -> create it
        if (!isset($sections[$tokenName])) {
            $sections[$tokenName] = array();
        }
        // Add the row to appropriate section
        $sections[$tokenName][] = $row;
    }
}

// Output sections and their respective tables
foreach ($sections as $tokenName => $sectionData) {
    echo '<section id="' . strtolower($tokenName) . '">';
    echo '<h2><img src="' . $sectionData[0]["TokenLogo"] . '" alt="' . $tokenName . '" width="32" height="32">' . $tokenName . '</h2>';
    echo '<table>';
    echo '<thead>
            <tr>
                <th>Site Name</th>
                <th>Blockchain</th>
                <th>Time Between Withdrawals</th>
                <th>Average Payout</th>
            </tr>
          </thead>';
    echo '<tbody>';
    foreach ($sectionData as $row) {
        echo '<tr>';
        echo '<td><a href="' . $row["SiteURL"] . '">' . $row["SiteName"] . '</a></td>';
        echo '<td><img src="' . $row["BlockchainLogo"] . '" alt="' . $row["Blockchain"] . '" width="32" height="32"></td>';
        echo '<td>' . $row["Delay"] . '</td>';
        echo '<td>' . $row["AveragePayout"] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</section>';
}

$conn->close();
?>
    </main>