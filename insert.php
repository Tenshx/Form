<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $birthdate = $_POST["birthdate"];
    $age = $_POST["age"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and execute SELECT query to check if email exists
    $select_query = "SELECT * FROM users WHERE email = ?";
    $stmt1 = $conn->prepare($select_query);
    $stmt1->bind_param("s", $email);
    $stmt1->execute();
    $result = $stmt1->get_result();

    // Check if the email already exists
    if ($result->num_rows > 0) {
        echo "User with this email already exists.";
    } else {
        // Insert data into database
        $sql = "INSERT INTO users (firstname, middlename, lastname, gender, birthdate, age, username, email, password) VALUES ('$firstname', '$middlename', '$lastname', '$gender', '$birthdate', '$age', '$username', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close statement
    $stmt1->close();
}

// Close database connection
$conn->close();
?>