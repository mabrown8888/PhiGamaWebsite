<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'LocalHost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'Heyvern70!';
$DATABASE_NAME = 'PhiGammaDeltaUmich';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, name FROM MyUsers WHERE username = ? OR email = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc)
    // In this case, both username and email are strings, so we use "ss" for two string parameters.
    $stmt->bind_param('ss', $_POST['username'], $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $name);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in.
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['names'] = $name; // Assuming you want to use the username for session name.
            $_SESSION['id'] = $id;
            header('Location: brotherhood.php');
        } else {
            // Incorrect password
            echo 'Incorrect username or password!';
        }
    } else {
        // Incorrect username or email
        echo 'Incorrect username or password!';
    }

    $stmt->close();
}
?>
