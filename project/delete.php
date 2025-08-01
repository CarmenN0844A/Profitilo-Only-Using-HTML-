<?php
include 'db.php';


if (isset($_GET['fname']) && isset($_GET['lname'])) {
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];

  
    $stmt = $conn->prepare("DELETE FROM pati WHERE firstname = ? AND lastname = ?");
    $stmt->bind_param("ss", $fname, $lname);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>