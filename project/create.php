<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];

    if (isset($_POST['id']) && $_POST['id'] != '') {
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE pati SET firstname = ?, lastname = ?, age = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $fname, $lname, $age, $phone, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO pati (firstname, lastname, age, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $fname, $lname, $age, $phone);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_GET['fname']) && isset($_GET['lname'])) {
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $stmt = $conn->prepare("SELECT * FROM pati WHERE firstname = ? AND lastname = ?");
    $stmt->bind_param("ss", $fname, $lname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $age = $row['age'];
        $phone = $row['phone'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create or Edit User</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #eef2f7;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .video-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -1;
    }
    .container {
      width: 90%;
      max-width: 1000px;
      background: #fff;
      padding: 30px 40px;
      border: 2px solid #ccc;
      border-radius: 12px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      text-align: center;
    }
    h1 {
      font-size: 40px;
      color: #333;
      margin-bottom: 10px;
    }
    h2 {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 30px;
      color: #333;
    }
    .action-buttons {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .action-buttons .add-button,
    .action-buttons .user-list-button {
      padding: 15px 40px;
      background-color: #007bff;
      color: #fff;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
      border-radius: 5px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
    }
    .action-buttons .add-button:hover,
    .action-buttons .user-list-button:hover {
      background-color: #0056b3;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    table th, table td {
      padding: 20px;
      border: 2px solid #ddd;
      font-size: 18px;
      font-weight: bold;
    }
    table th {
      background-color: #28a745;
      color: #fff;
    }
    table tr {
      transition: background-color 0.3s ease;
    }
    table tr:hover {
      background-color: #f1f1f1;
    }
    table td a {
      display: inline-block;
      padding: 12px 20px;
      background-color: #28a745;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      margin: 4px;
      font-size: 16px;
      font-weight: bold;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
    }
    table td a:hover {
      background-color: #218838;
    }
    .alert {
      color: #dc3545;
      font-size: 18px;
      font-weight: bold;
      margin-top: 20px;
    }
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 30px;
    }
    form input {
      width: 80%;
      max-width: 450px;
      padding: 15px;
      font-size: 16px;
      margin: 10px 0;
      border: 2px solid #ccc;
      border-radius: 5px;
      font-weight: bold;
    }
    form button {
      padding: 15px 30px;
      font-size: 20px;
      font-weight: bold;
      color: #fff;
      background-color: #28a745;
      border: none;
      border-radius: 5px;
      margin-top: 20px;
      cursor: pointer;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: background-color 0.3s ease;
    }
    form button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
 
  <div class="container">
    <h1>Patient Details</h1>
    <h2><?php echo isset($id) ? 'Edit User' : 'Add New User'; ?></h2>
    <form action="create.php" method="POST">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">

        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" value="<?php echo isset($fname) ? $fname : ''; ?>" required><br><br>

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" value="<?php echo isset($lname) ? $lname : ''; ?>" required><br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo isset($age) ? $age : ''; ?>" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" required><br><br>

        <button type="submit">Submit</button>
    </form>
  </div>
</body>
</html>

<?php
$conn->close();
?>