<?php
session_start();

require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';

logged_in();

$error = false;
$email = $password = $emailError = $passError = '';

if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $email = normalize($_POST['email']);
    $pass = normalize($_POST['pass']);


    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing

        $sql = "SELECT user_id, username, firstname, lastname, fk_user_communication, password, date_of_birth, image, status, user_language, UserSession, user_last_modified FROM users WHERE username = '$email' and deleted = 'no'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $count = $result->num_rows;
        $_SESSION['username'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['logedin'] = $row['status'];
        $_SESSION['userimg'] = $row['image'];
        $_SESSION['userid'] = $row['user_id'];

        if ($count == 1 && $row['password'] == $password) {
            if ($row['status'] == 'admin') {
                $_SESSION['admin'] = $row['user_id'];
                header("Location: dashboard.php");
            } else {
                $_SESSION['user'] = $row['user_id'];
                header("Location: home.php");
            }
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }
    }
}
$mysqli->close();
?>

<?php head(" | Login"); ?>


<div class="container">
    <form class="w-75" method="post" action="<?php echo normalize($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        <h2>Login</h2>
        <hr />
        <?php
        if (isset($errMSG)) {
            echo $errMSG;
        }
        ?>

        <input type="email" autocomplete="on" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
        <span class="text-danger"><?php echo $emailError; ?></span>

        <input type="password" name="pass" class="form-control mt-3" placeholder="Your Password" maxlength="15" />
        <span class="text-danger"><?php echo $passError; ?></span>
        <hr />
        <span class="row my-5"><button class="btn btn-block btn-tertiary card w-25 mx-auto" type="submit" name="btn-login">Sign In</button>
            <a class="btn btn-block btn-tertiary card w-50" type="button" href="../user/register.php">Not registered yet? Click here</a>
        </span>
        <hr />
    </form>
</div>
<?php htmlend(); ?>