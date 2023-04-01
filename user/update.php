<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';
require_once '../inc/file_upload.php';

$user_id = (isset($_POST['user_id'])) ? normalize($_POST['user_id']) : 0;

// logged_in('index.php', 'home.php', 'dashboard.php');
// if session is not set this will redirect to login page
isAnonym();

$backBtn = '';
//if it is a user it will create a back button to home.php
if (isset($_SESSION["user"])) {
    $backBtn = "home.php";
}
//if it is a adm it will create a back button to dashboard.php
if (isset($_SESSION["admin"])) {
    $backBtn = "dashboard.php";
}

//fetch and populate form
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE user_id = {$id}";
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

//update
$class = 'd-none';
if (isset($_POST["submit"])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $date_of_birth = $_POST['date_of_birth'];
    $id = $_POST['id'];
    //variable for upload pictures errors is initialized
    $uploadError = '';
    $pictureArray = file_upload($_FILES['picture']); //file_upload() called
    $picture = $pictureArray->fileName;
    if ($pictureArray->error === 0) {
        ($_POST["picture"] == "avatar.png") ?: unlink("/pictures/{$_POST["picture"]}");
        $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', username = '$username', date_of_birth = '$date_of_birth', image = '$pictureArray->fileName' WHERE user_id = {$id} and deleted = 'no'";
    } else {
        $sql = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', username = '$username', date_of_birth = '$date_of_birth' WHERE user_id = {$id} and deleted = 'no'";
    }
    if ($mysqli->query($sql)) {
        $class = "alert alert-success";
        $message = "The record was successfully updated";
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=update.php?id={$id}");
    } else {
        $class = "alert alert-danger";
        $message = "Error while updating record : <br>" . $connect->error;
        $uploadError = ($pictureArray->error != 0) ? $pictureArray->ErrorMessage : '';
        header("refresh:3;url=update.php?id={$id}");
    }
}

$mysqli->close();
?>

<?php head(" | Home"); ?>

<div class="container">
    <div class="<?php echo $class; ?>" role="alert">
        <p><?php echo ($message) ?? ''; ?></p>
        <p><?php echo ($uploadError) ?? ''; ?></p>
    </div>
    <h2>Update</h2>
    <img class='img-thumbnail rounded-circle' src='/pictures/<?php echo $data['image'] ?>' alt="<?php echo $firstname ?>">
    <form method="post" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <th>First Name</th>
                <td><input class="form-control" type="text" name="firstname" placeholder="First Name" value="<?php echo $firstname ?>" /></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input class="form-control" type="text" name="lastname" placeholder="Last Name" value="<?php echo $lastname ?>" /></td>
            </tr>
            <tr>
                <th>email</th>
                <td><input class="form-control" type="username" name="username" placeholder="username" value="<?php echo $username ?>" /></td>
            </tr>
            <tr>
                <th>Date of birth</th>
                <td><input class="form-control" type="date" name="date_of_birth" placeholder="Date of birth" value="<?php echo $date_of_birth ?>" /></td>
            </tr>
            <tr>
                <th>Picture</th>
                <td><input class="form-control" type="file" name="picture" /></td>
            </tr>
            <tr>
                <input type="hidden" name="id" value="<?php echo $data['user_id'] ?>" />
                <input type="hidden" name="picture" value="<?php echo $picture ?>" />
                <td><button name="submit" class="btn btn-success" type="submit">Save Changes</button></td>
                <td><a href="<?php echo $backBtn ?>"><button class="btn btn-warning" type="button">Back</button></a></td>
            </tr>
        </table>
    </form>
</div>
<?php htmlend(); ?>