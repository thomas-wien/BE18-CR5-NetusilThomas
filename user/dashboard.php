<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';
require_once '../inc/normalize.php';

// if session is not set this will redirect to login page
isAnonym("/animals/index.php");

//if session user exist it shouldn't access dashboard.php
isUser(); // Redirect Users to home.php


$id = $_SESSION['admin'];
$status = 'admin';
$sql = "SELECT * FROM users WHERE deleted = 'no' and status != '$status'";
$result = $mysqli->query($sql);


//this variable will hold the body for the table
$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail userPortrait rounded-circle' src='../pictures/" . $row['image'] . "' alt=" . $row['firstname'] . "></td>
            <td>" . $row['firstname'] . " " . $row['lastname'] . "</td>
            <td>" . $row['date_of_birth'] . "</td>
            <td>" . $row['username'] . "</td>
            <td><a class='btn btn-secondary card btn-sm mb-3 w-100' href='update.php?id=" . $row['user_id'] . "'>Edit</a>
            <a class='btn btn-danger card btn-sm w-100' href='delete.php?id=" . $row['user_id'] . "'>Delete</button></a></td>
         </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

$mysqli->close();
?>

<?php head(" | Dashboard"); ?>

<div class="container">
    <div class="row">
        <div class="col-2">
            <img class="userImg center mx-auto d-block my-3" src="/pictures/admavatar.png" alt="Adm avatar">
            <p class="text-tertiary-emphasis fs-4 my-2 text-center">Admin Panel</p>
            <a class="btn btn-secondary card" href="../animals/index.php">Animals</a>
            <a class="btn btn-secondary my-3  card" href="register.php">Add User</a>
            <a class="btn btn-danger card" href="logout.php?logout">Sign Out</a>
        </div>
        <div class="col-9 mt-2">
            <p class='h2'>Users</p>

            <table class='table table-striped'>
                <thead class='table-success'>
                    <tr>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Date of birth</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $tbody ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php htmlend(); ?>