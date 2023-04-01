<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';


isAdmin();
isAnonym();

$res = "SELECT users.*, animal.* FROM users LEFT JOIN animal ON animal.adopted_from = users.user_id WHERE users.user_id = " . $_SESSION['user'];
$result = $mysqli->query($res);
$row = $result->fetch_array(MYSQLI_ASSOC);
$UserImg = $row['image'];


$tbody = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $tbody .= "<tr>
            <td><img class='img-thumbnail userPortrait rounded-circle' src='../pictures/" . $row['picture'] . "' alt=" . $row['firstname'] . "></td>
            <td>" . $row['animal_name'] . "</td>
            <td>" . $row['breed'] . "</td>
            <td>" . substr($row['short_description'], 0, 245) . "....</td>
            </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

$mysqli->close();
?>

<?php head(" | User Info"); ?>

<div class="container">
    <div class="row">
        <div class="col-2">
            <img class="userImg center mx-auto d-block my-3" src="/pictures/<?= $UserImg ?>">

            <a class="btn btn-danger card" href="logout.php?logout">Sign Out</a>

        </div>
        <div class="col-10 mt-2">
            <p class='h2'>Adopted Animals</p>

            <table class='table table-striped'>
                <thead class='table-success'>
                    <tr>
                        <th>Picture</th>
                        <th>Animal Name</th>
                        <th>Breed</th>
                        <th>short description</th>
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