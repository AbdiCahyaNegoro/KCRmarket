<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbpenjualanikanhias";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling POST request to insert data into 'suhuairiot' table
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming 'data2' is the parameter sent via POST request
    if (isset($_POST['data2'])) {
        $data2 = $_POST['data2'];

        $sql = "INSERT INTO suhuairiot (nilaisuhu) VALUES ('$data2')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Required data not provided";
    }
}

// Handling GET request to retrieve latest record from 'pakanikaniot' table
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM pakanikaniot ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

$conn->close();
?>
