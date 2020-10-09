<?php
    require('../config/config.php');
    require('../config/db.php');
    session_start();
		
    $title = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM movie WHERE title='$title'";
    $result = mysqli_query($conn, $query);
    $movie = mysqli_fetch_assoc($result);
    //$movies = reset($movies);
		if(isset($_POST['buy'])){
        session_start();
				$tickets = mysqli_real_escape_string($conn, $_POST['tickets']);
				$query = "UPDATE movie SET
                  tickets=tickets-'$tickets'  
                  WHERE title = '$title'
									AND tickets > 0";
				if(mysqli_query($conn, $query)){
            header('Location: '.'http://localhost/sandbox/Theatre-admin/booking/movies.php'.'');
        } else {
            echo 'ERROR: '. mysqli_error($conn);
        }
		}
				
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Book Tickets</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="main.js"></script>
</head>

<body>
	<br>
    <div class="container"><br><br>
    	<div class="modal-content">
    		<div class="modal-header">                      
            <h2 class="modal-title"><b><?php echo $movie['title']; ?></b></h2>
        </div>
        <div class="modal-body">                    
        		<h3><?php echo $movie['summary']; ?></h3><hr>
        		<p><b>Director: </b><?php echo $movie['director']; ?></p><hr>
        		<p><b>Duration: </b><?php echo $movie['duration']; ?></p><hr>
						<p><b>Price: </b><?php echo $movie['price']; ?></p><hr>
						<p><b>Tickets Available: </b><?php echo $movie['tickets']; ?></p>
        </div>
        <div class="modal-footer">
					<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        		<div class="form-group" >
                <label>Enter Tickets:</label>
                <input type="text" name="tickets" class="form-control" required>
						</div>
						<label for="deptCode">Select Timings:</label>
	          <select class="form-group" name="deptCode" id="deptCode">
	              <option value="09">9 AM</option>
                <option value="13">1 PM</option>
	              <option value="17">5 PM</option>
								<option value="21">9 PM</option>
						</select>
						<br>
					<button type="submit" name="buy" class="btn btn-success">Buy</button>
        </div>
      </div>
    </div>
</body>