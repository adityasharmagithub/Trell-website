<?php
    require('../config/config.php');
    require('../config/db.php');
    
    $query = 'SELECT * FROM movie';
    $result = mysqli_query($conn, $query);
		$movies =  mysqli_fetch_all($result, MYSQLI_ASSOC);

    if(isset($_POST['add'])){
        session_start();
        
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $summary = mysqli_real_escape_string($conn, $_POST['summary']);
        $director = mysqli_real_escape_string($conn, $_POST['director']);
        $duration = mysqli_real_escape_string($conn, $_POST['duration']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $tickets = mysqli_real_escape_string($conn, $_POST['tickets']);

        $query = "INSERT INTO movie(title, summary, director, duration, price, tickets) VALUES ('$title', '$summary', '$director', '$duration', '$price','$tickets')";

        if(mysqli_query($conn, $query)){
            header('Location: '.'http://localhost/sandbox/Theatre-admin/booking/movies.php'.'');
        } else {
            echo 'ERROR: '. mysqli_error($conn);
        }
    }

    if(isset($_POST['edit'])){
        session_start();

        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $duration = mysqli_real_escape_string($conn, $_POST['duration']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $tickets = mysqli_real_escape_string($conn, $_POST['tickets']);
        
        $query = "UPDATE movie SET 
                    duration='$duration',
                    price='$price',
                    tickets='$tickets' 
                  WHERE title = '$title'";
        if(mysqli_query($conn, $query)){
            header('Location: '.'http://localhost/sandbox/Theatre-admin/booking/movies.php'.'');
        } else {
            echo 'ERROR: '. mysqli_error($conn);
        }
    }

    if(isset($_POST['delete'])){
        session_start();

        $articleid = mysqli_real_escape_string($conn, $_POST['title']);

        $query = "DELETE FROM movie WHERE title='$title'";
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
<title>All Movies</title>
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
    <div class="container">
        <br>
        <a href="../login-signup/login.php"><button class="btn btn-danger">Logout</button></a>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><b>Movies </b>Dashboard</h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Movie</span></a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>    
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Summary</th>
                        <th>Director</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($movies as $movie): ?>
                        <tr>
                            <td><?php echo $movie['title']; ?></td>
                            <td><?php echo $movie['summary']; ?></td>
                            <td><?php echo $movie['director']; ?></td>
                            <td><?php echo $movie['duration']; ?></td>
                            <td>
                                <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="view.php?id=<?php echo $movie['title']; ?>" target="_blank" class="view" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="View">&#xE417;</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Add New Movie</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">                    
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Summary</label>
                            <textarea class="form-control" name="summary" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Director</label>
                            <input type="text" name="director" class="form-control" required>
                        </div>
												<div class="form-group">
                            <label>Duration</label>
                            <input type="text" name="duration" class="form-control" required>
                        </div><div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" required>
                        </div>
												<div class="form-group">
                            <label>Tickets</label>
                            <input type="text" name="tickets" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" name="add" class="btn btn-success">Add</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Edit Movie</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>                    
                        <div class="form-group">
                            <div class="form-group">
                            <label>Duration</label>
                            <input type="text" name="duration" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tickets</label>
                            <input type="text" name="tickets" class="form-control" required>
                        </div>                 
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" name="edit" class="btn btn-info">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- Delete Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="modal-header">                      
                        <h4 class="modal-title">Delete Circular</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Enter title of the movie</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>               
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
		
</body>
</html>                                                                 