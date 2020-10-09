<?php
	require('../config/config.php');
	require('../config/db.php');
 
	// Check For Submit
	if(isset($_POST['signup'])){
		// Get form data
		$pname = mysqli_real_escape_string($conn, $_POST['pname']);
		$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
		$pwd = md5($pwd);
    $dob = mysqli_real_escape_string($conn,$_POST['dob']);
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);

    $query = "INSERT INTO user(pname, dob, uname, pwd) 
    SELECT * FROM(SELECT '$pname', '$dob', '$uname', '$pwd') AS tmp 
    WHERE NOT EXISTS (SELECT * FROM user WHERE uname='$uname')
    LIMIT 1";

		if(mysqli_query($conn, $query)){
			header('Location: '.'http://localhost/sandbox/Theatre-admin/login-signup/login.php'.'');
		} else {
			echo 'ERROR: '. mysqli_error($conn);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <div class="container"></div>
        <br>
        <div class="container">
            <label for="name"><b>Name</b></label>
            <input type="text" placeholder="Enter your name" name="pname" required><br>

            <label for="dob"><b>Date of Birth</b></label><br>
            <input type="date" placeholder="Enter date of birth" name="dob" required>
						<br><br>

            <label for="uname"><b>Username</b>(should be unique)</label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" required>

            <button type="submit" name="signup">Signup</button>
        </div>
    </form>
</body>