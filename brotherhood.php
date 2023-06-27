<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.html');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home Page</title>
		<link href="styling/stylebrohood.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
			<h2>Connections</h2>
			<p>Welcome back, <?=$_SESSION['names']?>!</p>
		</div>

		<div class="FilterBar"><input type="text" id="myInput" onkeyup="myFunction()" placeholder="Filter for Connections"></div>

		<table class="table" id="myTable">
			<thead>
				<tr>
					<th>Full Name</th>
					<th>Email</th>
					<th>Grad Year</th>
					<th>City</th>
					<th>State</th>
					<th>Company</th>
					<th>Position</th>
				</tr>	
			</thead>

			<tbody>
				<?php
				$DATABASE_HOST = 'LocalHost';
				$DATABASE_USER = 'root';
				$DATABASE_PASS = 'Heyvern70!';
				$DATABASE_NAME = 'PhiGammaDeltaUmich';
				
				// Try and connect using the info above.
				$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

				if ($con->connect_error) {
					die("Connection failed: " . $con->connect_error);
				}

				$sql = "SELECT * FROM MyUsers";
				$result = $con->query($sql);

				if (!$result) {
					die("Invalid query: " . $con->error); 
				}

				while ($row = $result->fetch_assoc()) {
					echo "<tr>
						<td>" . $row["name"] . "</td>
						<td>" . $row["email"] . "</td>
						<td>" . $row["grad_year"] . "</td>
						<td>" . $row["city"] . "</td>
						<td>" . $row["state"] . "</td>
						<td>" . $row["company"] . "</td>
						<td>" . $row["position"] . "</td>
					</tr>";
				}

				?>
			</tbody>
		</table>

		<script>
			function myFunction() {
				// Declare variables 
				var input, filter, table, tr, td, i, j, txtValue;
				input = document.getElementById("myInput");
				filter = input.value.toUpperCase();
				table = document.getElementById("myTable");
				tr = table.getElementsByTagName("tr");

				// Loop through all table rows, and hide those that don't match the search query
				for (i = 1; i < tr.length; i++) {
					var rowDisplayed = false; // Flag to track if a row matches the search query
					var rowCells = tr[i].getElementsByTagName("td");

					// Loop through each cell in the row and check if it matches the search query
					for (j = 0; j < rowCells.length; j++) {
					td = rowCells[j];
					if (td) {
						txtValue = td.textContent || td.innerText;
						if (txtValue.toUpperCase().indexOf(filter) > -1) {
						rowDisplayed = true;
						break; // No need to check other cells in the row if a match is found
						}
					}
					}

					// Display or hide the row based on the search query match
					if (rowDisplayed) {
					tr[i].style.display = "";
					} else {
					tr[i].style.display = "none";
					}
				}
			}
		</script>
	</body>
</html>