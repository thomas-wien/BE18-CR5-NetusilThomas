<?php
session_start();

require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';

// logged_in('index.php', 'home.php', 'dashboard.php');

// session_start(); // start a new session or continues the previous
isUser();
//isAdmin();

$error = false;
$firstnameError = $lastnameError = $usernameError = $date_of_birthError = $passwordError = $pictureError = $statusError = $fk_user_communicationError = $user_languageError = $UserSessionError = $user_last_modifiedError = $user_modified_fromError = '';



// sanitise user input to prevent sql injection
// trim - strips whitespace (or other characters) from the beginning and end of a string
$user_id = (isset($_POST['user_id'])) ? normalize($_POST['user_id']) : 0;
$firstname = (isset($_POST['firstname'])) ? normalize($_POST['firstname']) : "";
$lastname = (isset($_POST['lastname'])) ? normalize($_POST['lastname']) : "";
$username = (isset($_POST['username'])) ? normalize($_POST['username']) : "";
$date_of_birth = (isset($_POST['date_of_birth'])) ? normalize($_POST['date_of_birth']) : "";
$password = (isset($_POST['password'])) ? normalize($_POST['password']) : "";
$picture = (isset($_POST['picture'])) ? normalize($_POST['picture']) : "";
$status = (isset($_POST['status'])) ? normalize($_POST['status']) : "user";
$fk_user_communication = (isset($_POST['fk_user_communicationname'])) ? normalize($_POST['fk_user_communication']) : 0;
$user_language = (isset($_POST['user_language'])) ? normalize($_POST['user_language']) : "en";
$UserSession = (isset($_POST['UserSession'])) ? normalize($_POST['UserSession']) : "";
$user_last_modified = (isset($_POST['user_last_modified'])) ? normalize($_POST['user_last_modified']) : "";
$user_modified_from = (isset($_POST['user_modified_from'])) ? normalize($_POST['user_modified_from']) : 0;
$deleted = (isset($_POST['deleted'])) ? normalize($_POST['deleted']) : "no";

if (isset($_POST['btn-signup'])) {

    $uploadError = '';
    $picture = file_upload($_FILES['picture']);

    // basic name validation
    if (empty($firstname) || empty($lastname)) {
        $error = true;
        $firstnameError = "Please enter your full name and surname";
    } else if (strlen($firstname) < 3 || strlen($lastname) < 3) {
        $error = true;
        $firstnameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $firstname) || !preg_match("/^[a-zA-Z]+$/", $lastname)) {
        $error = true;
        $firstnameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic email validation
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $usernameError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not

        $query = "SELECT username FROM users WHERE username='$username'";
        $result = $mysqli->query($query);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $result->num_rows;

        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // checks if the date input was left empty
    if (empty($date_of_birth)) {
        $error = true;
        $date_of_birthError = "Please enter your date of birth.";
    }
    // password validation
    if (empty($password)) {
        $error = true;
        $passwordError = "Please enter password.";
    } else if (strlen($password) < 6) {
        $error = true;
        $passwordError = "Password must have at least 6 characters.";
    }

    // password hashing for security
    $passwordhash = hash('sha256', $password);
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO users (username, firstname, lastname, fk_user_communication, password, date_of_birth, image, status, user_language, UserSession, user_last_modified, user_modified_from, deleted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sssisssssssis", $username, $firstname, $lastname, $fk_user_communication, $passwordhash, $date_of_birth, $picture->fileName, $status, $user_language, $UserSession, $user_last_modified, $user_modified_from, $deleted);
        $res = $stmt->execute();

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        }
    }
}

$mysqli->close();
?>

<?php head(" | Register"); ?>

<div class="container">
    <form class="w-75" method="post" action="<?php echo normalize($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
        <h2>Sign Up.</h2>
        <hr />
        <?php
        if (isset($errMSG)) {
        ?>
            <div class="alert alert-<?php echo $errTyp ?>">
                <p><?php echo $errMSG; ?></p>
                <p><?php echo $uploadError; ?></p>
            </div>

        <?php
        }
        ?>

        <input type="text" name="firstname" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $firstname ?>" />
        <span class="text-danger"> <?php echo $firstnameError; ?> </span>

        <input type="text" name="lastname" class="form-control my-3" placeholder="Surname" maxlength="50" value="<?php echo $lastname ?>" />
        <span class="text-danger"> <?php echo $lastnameError; ?> </span>

        <input type="email" name="username" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $username ?>" />
        <span class="text-danger"> <?php echo $usernameError; ?> </span>
        <div class="d-flex my-3">
            <input class='form-control w-50' type="date" name="date_of_birth" value="<?php echo $date_of_birth ?>" />
            <span class="text-danger"> <?php echo $date_of_birthError; ?> </span>

            <input class='form-control w-50' type="file" name="picture">
            <span class="text-danger"> <?php echo $pictureError; ?> </span>
        </div>
        <input type="password" name="password" class="form-control mt-3" placeholder="Enter Password" maxlength="15" />
        <span class="text-danger"> <?php echo $passwordError; ?> </span>
        <hr />
        <span class="row my-5"><button class="btn btn-block btn-tertiary card w-25 mx-auto" type="submit" name="btn-signup">Confirm</button>
            <a class="btn btn-block btn-tertiary card w-25" type="button" href="../user/index.php">Log in</a>
        </span>
        <hr />
    </form>
</div>

<?php htmlend(); ?>