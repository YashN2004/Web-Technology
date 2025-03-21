<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentee Management System</title>
    <script type="text/javascript">
        function validateForm() {
            let fields = ["roll_no", "name", "email", "mobile", "address", "department", "year", "gpa", "certificates", "mentor_name"];
            for (let field of fields) {
                let value = document.forms["f1"][field].value.trim();
                if (value === "") {
                    alert("Please enter " + field.replace("_", " ").toUpperCase());
                    document.forms["f1"][field].focus();
                    return false;
                }
            }
            return true;
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="tel"] {
            padding: 5px;
            margin: 5px;
            width: 200px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            margin: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Mentee Management System</h1>
    <form name="f1" method="post" onsubmit="return validateForm()">
        <table>
            <tr><td>Roll No:</td><td><input type="number" name="roll_no" required></td></tr>
            <tr><td>Name:</td><td><input type="text" name="name" required></td></tr>
            <tr><td>Email:</td><td><input type="email" name="email" required></td></tr>
            <tr><td>Mobile No:</td><td><input type="tel" name="mobile" required></td></tr>
            <tr><td>Address:</td><td><input type="text" name="address" required></td></tr>
            <tr><td>Department:</td><td><input type="text" name="department" required></td></tr>
            <tr><td>Year:</td><td><input type="number" name="year" required></td></tr>
            <tr><td>GPA:</td><td><input type="text" name="gpa" required></td></tr>
            <tr><td>Certificates:</td><td><input type="text" name="certificates" required></td></tr>
            <tr><td>Mentor Name:</td><td><input type="text" name="mentor_name" required></td></tr>
        </table>
        <input type="submit" name="action" value="Add">
        <input type="submit" name="action" value="Update">
        <input type="submit" name="action" value="Delete">
        <input type="submit" name="action" value="Display">
    </form>

    <?php
    $conn = new mysqli("localhost", "root", "", "WT");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $roll_no = $_POST['roll_no'] ?? '';
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $mobile = $_POST['mobile'] ?? '';
        $address = $_POST['address'] ?? '';
        $department = $_POST['department'] ?? '';
        $year = $_POST['year'] ?? '';
        $gpa = $_POST['gpa'] ?? '';
        $certificates = $_POST['certificates'] ?? '';
        $mentor_name = $_POST['mentor_name'] ?? '';

        if (isset($_POST['action'])) {
            $action = $_POST['action'];

            switch ($action) {
                case "Add":
                    $stmt = $conn->prepare("INSERT INTO students (roll_no, name, email, mobile, address, department, year, gpa, certificates, mentor_name) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssssssss", $roll_no, $name, $email, $mobile, $address, $department, $year, $gpa, $certificates, $mentor_name);
                    if ($stmt->execute()) {
                        echo "Record added successfully!";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                    break;

                case "Update":
                    if (!empty($roll_no)) {
                        $stmt = $conn->prepare("SELECT * FROM students WHERE roll_no=?");
                        $stmt->bind_param("s", $roll_no);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $student = $result->fetch_assoc();
                        if ($student) {
                            echo "<h3>Current Data for Roll No: $roll_no</h3>";
                            echo "<table border='1'>
                                    <tr><th>Roll No</th><td>{$student['roll_no']}</td></tr>
                                    <tr><th>Name</th><td>{$student['name']}</td></tr>
                                    <tr><th>Email</th><td>{$student['email']}</td></tr>
                                    <tr><th>Mobile</th><td>{$student['mobile']}</td></tr>
                                    <tr><th>Address</th><td>{$student['address']}</td></tr>
                                    <tr><th>Department</th><td>{$student['department']}</td></tr>
                                    <tr><th>Year</th><td>{$student['year']}</td></tr>
                                    <tr><th>GPA</th><td>{$student['gpa']}</td></tr>
                                    <tr><th>Certificates</th><td>{$student['certificates']}</td></tr>
                                    <tr><th>Mentor Name</th><td>{$student['mentor_name']}</td></tr>
                                  </table>";
                        } else {
                            echo "Record with Roll No $roll_no not found.";
                        }
                        $stmt->close();
                    } else {
                        echo "Roll No is required for update.";
                    }
                    break;

                case "Delete":
                    if (!empty($roll_no)) {
                        $stmt = $conn->prepare("SELECT * FROM students WHERE roll_no=?");
                        $stmt->bind_param("s", $roll_no);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $student = $result->fetch_assoc();
                        if ($student) {
                            echo "<h3>Record to Delete:</h3>";
                            echo "<table border='1'>
                                    <tr><th>Roll No</th><td>{$student['roll_no']}</td></tr>
                                    <tr><th>Name</th><td>{$student['name']}</td></tr>
                                    <tr><th>Email</th><td>{$student['email']}</td></tr>
                                    <tr><th>Mobile</th><td>{$student['mobile']}</td></tr>
                                    <tr><th>Address</th><td>{$student['address']}</td></tr>
                                    <tr><th>Department</th><td>{$student['department']}</td></tr>
                                    <tr><th>Year</th><td>{$student['year']}</td></tr>
                                    <tr><th>GPA</th><td>{$student['gpa']}</td></tr>
                                    <tr><th>Certificates</th><td>{$student['certificates']}</td></tr>
                                    <tr><th>Mentor Name</th><td>{$student['mentor_name']}</td></tr>
                                  </table>";
                        } else {
                            echo "Record with Roll No $roll_no not found.";
                        }
                        $stmt->close();
                    } else {
                        echo "Roll No is required for deletion.";
                    }
                    break;

                case "Display":
                    $sql = "SELECT * FROM students";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table border='1'>
                                <tr><th>Roll No</th><th>Name</th><th>Email</th><th>Mobile</th><th>Address</th><th>Department</th><th>Year</th><th>GPA</th><th>Certificates</th><th>Mentor Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>{$row['roll_no']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['mobile']}</td><td>{$row['address']}</td><td>{$row['department']}</td><td>{$row['year']}</td><td>{$row['gpa']}</td><td>{$row['certificates']}</td><td>{$row['mentor_name']}</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "No records found.";
                    }
                    break;
            }
        }
    }

    $conn->close();
    ?>
</body>
</html>
