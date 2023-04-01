<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';
require_once '../inc/file_upload.php';

isAnonym();
isUser();

//initial bootstrap class for the confirmation message
$class = 'd-none';
//the GET method will show the info from the user to be deleted

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE deleted = 'no' and user_id = {$id}";
    $result = $mysqli->query($sql);

    if ($result->num_rows == 1) {
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $username = $data['username'];
        $date_of_birth = $data['date_of_birth'];
        $picture = $data['image'];
    }
}

//the POST method will delete the user permanently
if ($_POST) {
    $id = $_POST['id'];
    $picture = $_POST['picture'];
    // ($picture == "avatar.png") ?: unlink("../pictures/$picture");

    $sql = "UPDATE users SET deleted = 'yes' WHERE user_id = {$id} and deleted = 'no'";
    if ($mysqli->query($sql)) {
        $class = "alert alert-success";
        $message = "Successfully Deleted!";
        header("refresh:3;url=dashboard.php");
    } else {
        $class = "alert alert-danger";
        $message = "The entry was not deleted due to: <br>" . $mysqli->error;
    }
}

$mysqli->close();
?>

<?php head(" | Home"); ?>
<div class="<?php echo $class; ?>" role="alert">
    <p><?php echo ($message) ?? ''; ?></p>
</div>
<fieldset>
    <legend class='h2 mb-3'>Delete request <img class='img-thumbnail userPortrait rounded-circle' src='/pictures/<?php echo $picture ?>' alt="<?php echo $firstname ?>"></legend>
    <h5>You have selected the data below:</h5>
    <table class="table w-75 mt-3">
        <tr>
            <td><?php echo "$firstname $lastname" ?></td>
            <td><?php echo $username ?></td>
            <td><?php echo $date_of_birth ?></td>
        </tr>
    </table>
    <h3 class="mb-4">Do you really want to delete this user?</h3>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        <input type="hidden" name="picture" value="<?php echo $picture ?>" />
        <button class="btn btn-danger card w-100 my-3" type="submit">Yes, delete it!</button>
        <a class="btn btn-warning card w-100" href="dashboard.php">No, go back!</a>
    </form>
</fieldset>
</body>

</html>