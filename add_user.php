<?php include 'db_connect.php'; ?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มรายชื่อครู</title>
    <style>
        body {
            font-family: "Prompt", sans-serif;
            background: #f8fafc;
            color: #333;
            line-height: 1.7;
            padding: 40px;
        }
        h2, h3 {
            color: #004d80;
            text-align: center;
        }
        .container {
            max-width: 650px;
            background: #fff;
            margin: 0 auto;
            padding: 25px 35px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }
        label {
            font-size: 18px;
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 17px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-top: 5px;
        }
        input[type="submit"] {
            background-color: #0074D9;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 18px;
            margin-top: 25px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #005fa3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 17px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #0074D9;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .message {
            text-align: center;
            font-size: 18px;
            margin-top: 10px;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        .footer-note {
            text-align: center;
            color: #777;
            font-size: 15px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>เพิ่มรายชื่อครูใหม่</h2>

        <form method="POST" action="">
            <label>ชื่อ - นามสกุล:</label>
            <input type="text" name="name" placeholder="กรอกชื่อ-นามสกุล" required>

            <label>อีเมล:</label>
            <input type="email" name="email" placeholder="กรอกอีเมล" required>

            <label>เบอร์โทรศัพท์:</label>
            <input type="text" name="mobile" placeholder="กรอกเบอร์โทร" required>

            <label>รหัสผ่าน:</label>
            <input type="password" name="password" placeholder="ตั้งรหัสผ่าน" required>

            <input type="submit" name="submit" value="เพิ่มข้อมูลครู">
        </form>

        <?php
        // เมื่อกดปุ่ม submit
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO teacher (name, email, mobile, password)
                    VALUES ('$name', '$email', '$mobile', '$password')";

            if ($conn->query($sql) === TRUE) {
                echo "<p class='message success'>✅ เพิ่มข้อมูลครูเรียบร้อยแล้ว!</p>";
            } else {
                echo "<p class='message error'>❌ เกิดข้อผิดพลาด: " . $conn->error . "</p>";
            }
        }

        echo "<h3>รายชื่อครูทั้งหมด</h3>";

        $result = $conn->query("SELECT * FROM teacher ORDER BY id DESC");
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>อีเมล</th>
                        <th>เบอร์โทร</th>
                    </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['name']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['mobile']."</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='message'>ยังไม่มีข้อมูลครู</p>";
        }

        $conn->close();
        ?>

        <p class="footer-note">ระบบจัดเก็บข้อมูลครู © <?php echo date("Y"); ?></p>
    </div>
</body>
</html>