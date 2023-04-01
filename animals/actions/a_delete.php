<?php
require_once '../../inc/db_connect.php';
require_once '../../inc/htmlhelper.php';

if ($_POST) {
  $id = $_POST['id'];
  $picture = $_POST['picture'];
  //  ($picture == "animal.png") ?: unlink("../../pictures/$picture");

  $sql = "UPDATE animal SET deleted = 'yes' WHERE id = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    header("location: ../index.php");
  } else {
    $class = "danger";
    $message = "The entry was not deleted due to: <br>" . $connect->error;
  }
  $mysqli->close();
} else {
  header("location: ../error.php");
}
?>

<?php head(" | Delete"); ?>

<div class="container">
  <div class="mt-3 mb-3">
    <h1>Deletion request response</h1>
  </div>
  <div class="alert alert-<?= $class; ?>" role="alert">
    <p><?= $message; ?></p>
    <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
  </div>
</div>
<?php htmlend(); ?>