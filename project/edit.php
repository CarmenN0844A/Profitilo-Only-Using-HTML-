<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pati WHERE id = $id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $phone = $_POST['phone'];

        // Prepare and bind
        $stmt = $conn->prepare("UPDATE pati SET firstname=?, lastname=?, age=?, phone=? WHERE id=?");
        $stmt->bind_param("ssisi", $fname, $lname, $age, $phone, $id);

        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect to the main page after success
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    echo "User not found!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST" action="">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?= $user['firstname']; ?>" required><br><br>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" value="<?= $user['lastname']; ?>" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?= $user['age']; ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?= $user['phone']; ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>