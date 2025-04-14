<?php
$conn = new mysqli("localhost", "root", "root", "contact_form");
if ($conn->connect_error) die("Connection failed");

$result = $conn->query("SELECT * FROM submissions ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submissions</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid gray;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: darkslategray;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Form Submissions</h2>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
            <td><?= $row['submitted_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
