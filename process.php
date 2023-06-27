<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $grad_year = $_POST['graduation-year'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $company = $_POST['company'];
  $position = $_POST['position'];


  // // Print out the form data
  // echo "<h2>Form Data:</h2>";
  // echo "<p>Name: $name</p>";
  // echo "<p>Email: $email</p>";
  // echo "<p>Username: $username</p>";
  // echo "<p>Password: $password</p>";
  // echo "<p>Graduation Year: $grad_year</p>";
  // echo "<p>City: $city</p>";
  // echo "<p>State: $state</p>";
  // echo "<p>Company: $company</p>";
  // echo "<p>Position: $position</p>";
}

$DATABASE_HOST = 'LocalHost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'Heyvern70!';
$DATABASE_NAME = 'PhiGammaDeltaUmich';

// Try and connect using the info above.
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_errno()) {
  die("Connection error: " . mysqli_connect_error());
}

$sql = "INSERT INTO MyUsers (name, email, username, password, grad_year, city, state, company, position)
        VALUE(?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if ( ! mysqli_stmt_prepare($stmt, $sql)) {
  die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssssissss",
                        $name,
                        $email,
                        $username,
                        $hashedPassword,
                        $grad_year,
                        $city,
                        $state,
                        $company,
                        $position);

mysqli_stmt_execute($stmt);

echo "Record saved.";
?>
