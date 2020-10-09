<?php
	require('../config/config.php');
	require('../config/db.php');
	
	$query = "SELECT COUNT(*) FROM user";
	$result = mysqli_query($conn, $query);
	$users = mysqli_fetch_assoc($result);
	if ($users['COUNT(*)'] == 0) {
		header('Location: '.'http://localhost/sandbox/Theatre-admin/login-signup/signup.php'.'');
	}
	
	// Check For Submit
	if(isset($_POST['login'])){
		session_start();

		$uname = mysqli_real_escape_string($conn, $_POST['uname']);
		$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
		$pwd = md5($pwd);
		
		$query = "SELECT uname, pname FROM user WHERE uname = '$uname' AND pwd = '$pwd'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_array($result);
			$_SESSION['uname'] = $row['uname'];
			$_SESSION['pname'] = $row['pname'];

			//Redirect after fetching session vars
			header('Location: '.'http://localhost/sandbox/Theatre-admin/booking/movies.php'.'');
		} else {
			//the username and password are incorrect so set error message
			?>
			<div class="alert alert-warning">
  			No such user exists! You should first <a href="signup.php" class="alert-link">sign up</a>.
			</div>
			<?php
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <div class="imgcontainer">
            <img src="form_img.jpg" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="uname" required>

            <label for="pwd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pwd" required>

            <button type="submit" name="login">Login</button>
            <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
            </label>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button onclick="document.location='../landing/index.php'" class="cancelbtn">Return Home</button>
            <span class="psw">New User <a href="signup.php">Signup</a></span>
        </div>
    </form>
</body>