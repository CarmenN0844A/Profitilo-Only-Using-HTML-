<?php
include 'db.php';

$sql = "SELECT * FROM pati";
$result = $conn->query($sql);

function generateRandomDate() {
    $randomDays = rand(1, 30);
    return date('Y-m-d', strtotime("+$randomDays days"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details with Appointment</title>
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
        .navbar {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            z-index: 1;
            font-weight: bold;
        }
        .navbar a {
            color: #f2f2f2;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            flex: 1;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
            text-shadow: 0 0 10px #fff, 0 0 20px #fff;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px 40px;
            border: 2px solid #ccc;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            text-align: center;
            margin-top: 80px;
        }
        h2 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #333;
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
        .add-button {
            background-color: #007bff;
            color: white;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
        }
        .add-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <video class="video-background" autoplay muted loop>
        <source src="https://www.example.com/your-video-link.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="appointments.php">Appointments</a>
        <a href="doctors.php">Doctors</a>
        <a href="services.php">Services</a>
        <a href="patients.php">Patients</a>
    </div>

    <div class="container">
        <h2>Patient Details with Appointment</h2>

        <a href="create.php" class="add-button">Add New User</a>

        <table border="1">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Appointment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()):
                        $appointment_date = generateRandomDate();
                ?>
                <tr>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['lastname']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $appointment_date; ?></td>
                    <td>
                        <a href="create.php?fname=<?php echo urlencode($row['firstname']); ?>&lname=<?php echo urlencode($row['lastname']); ?>">Edit</a> |
                        <a href="delete.php?fname=<?php echo urlencode($row['firstname']); ?>&lname=<?php echo urlencode($row['lastname']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>