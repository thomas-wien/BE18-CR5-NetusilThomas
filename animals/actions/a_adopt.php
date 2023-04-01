<?php
require_once '../../inc/db_connect.php';
require_once '../../inc/htmlhelper.php';
// echo var_dump($_REQUEST);
// die();
if ($_POST) {
    $id = $_POST['id'];
    //   $picture = $_POST['picture'];


    // $sql = "UPDATE animal SET `available` = 1, `adopted_from`= ? WHERE id = ?";

    $sql = "UPDATE animal SET `available` = 'no', `adopted_from` = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $_REQUEST['userid'], $id);

    if ($stmt->execute()) {
        header("location: ../index.php");
    } else {
        $class = "danger";
        $message = "The adoption was not performed due to: <br>" . $connect->error;
    }
    $mysqli->close();
} else {
    header("location: ../error.php");
}
?>

<?php head(" | Adopt"); ?>

<div class="container">
    <div class="mt-3 mb-3">
        <h1>Adopt request response</h1>
    </div>
    <div class="alert alert-<?= $class; ?>" role="alert">
        <p><?= $message; ?></p>
        <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
    </div>
</div>
<?php htmlend(); ?>