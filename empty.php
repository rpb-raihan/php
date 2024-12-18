<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>
</head>
<body>
    <h1>Simple Form Validation</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $password = $_POST['password'];

        // Validation
        if (empty($name) || strlen($password) != 6) {
            echo "<p style='color: red;'>All fields need to be filled, and the password must be 6 characters long.</p>";
        } else {
            echo "<p style='color: green;'>Form submitted successfully!</p>";
        }
    }
   
?>
    <!-- Form -->
    <form method="POST">
        <label>Name:</label>   
        <input style="algin: center;" type="text" name="name" placeholder="Name"><br><br>

        <label>Password:</label>   
        <input type="password" name="password" placeholder="Password"><br><br>

        <button type="submit"  >submit</button>
    </form>
</body>
</html>
