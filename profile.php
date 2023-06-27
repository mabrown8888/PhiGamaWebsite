<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'LocalHost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'Heyvern70!';
$DATABASE_NAME = 'PhiGammaDeltaUmich';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT name, grad_year, city, state, company, position, email FROM MyUsers WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($name, $grad_year, $city, $state, $company, $position, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="styling/styleebrohood.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Brotherhood</h1>
				<a href="brotherhood.php"><i class="fa-solid fa-house"></i>Brotherhood</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Full Name:</td>
						<td><?=$name?></td>
					</tr>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['names']?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
                    <tr>
						<td>Grad Year:</td>
						<td><?=$grad_year?></td>
					</tr>
                    <tr>
						<td>City:</td>
						<td><?=$city?></td>
					</tr>
                    <tr>
						<td>State:</td>
						<td><?=$state?></td>
					</tr>
                    <tr>
						<td>Company:</td>
						<td><?=$company?></td>
					</tr>
                    <tr>
						<td>Position:</td>
						<td><?=$position?></td>
					</tr>
				</table>
				<button onclick="window.location.href = 'edit_profile.php';">Edit</button>
			</div>
		</div>
	</body>
</html>