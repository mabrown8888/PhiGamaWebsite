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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated profile information from the form submission
    $name = $_POST['name'];
    $grad_year = $_POST['grad_year'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $company = $_POST['company'];
    $position = $_POST['position'];
    
    // Prepare and execute the SQL update statement
    $stmt = $con->prepare('UPDATE MyUsers SET name = ?, grad_year = ?, city = ?, state = ?, company = ?, position = ? WHERE id = ?');
    $stmt->bind_param('ssssssi', $name, $grad_year, $city, $state, $company, $position, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
    
    // Redirect the user back to the profile page after the update
    header('Location: profile.php');
    exit;
}

// Retrieve the current user's profile information from the database
$stmt = $con->prepare('SELECT name, grad_year, city, state, company, position FROM MyUsers WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($name, $grad_year, $city, $state, $company, $position);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Edit Profile</title>
		<link href="styling/styleebrohood.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Brotherhood</h1>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Edit Profile</h2>
			<div>
				<form action="edit_profile.php" method="POST">
                    <div>
						<label for="name">Full Name:</label>
						<input type="text" id="name" name="name" value="<?=$name?>" required>
					</div>
					<div>
						<label for="grad_year">Grad Year:</label>
						<input type="text" id="grad_year" name="grad_year" value="<?=$grad_year?>" required>
					</div>
					<div>
						<label for="city">City:</label>
						<input type="text" id="city" name="city" value="<?=$city?>" required>
					</div>
					<div>
						<label for="state">State:</label>
						<input type="text" id="state" name="state" value="<?=$state?>" required>
					</div>
					<div>
						<label for="company">Company:</label>
						<input type="text" id="company" name="company" value="<?=$company?>" required>
					</div>
					<div>
						<label for="position">Position:</label>
						<input type="text" id="position" name="position" value="<?=$position?>" required>
					</div>
					<button type="submit">Save Changes</button>
				</form>
			</div>
		</div>
	</body>
</html>
