<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';

// isUser("index.php");

if ($_GET['id']) {
  $id = $_GET['id'];

  $sql = "SELECT * FROM animal WHERE id = {$id} AND deleted = 'no'";
  $result = $mysqli->query($sql);
  $data = $result->fetch_assoc();
  if ($result->num_rows == 1) {
    $animal_name = normalize($data['animal_name']);
    $age = normalize($data['age']);
    $short_description = normalize($data['short_description']);
    $animal_type = normalize($data['animal_type']);
    $breed = normalize($data['breed']);
    $vaccines = normalize($data['vaccines']);
    $adoption_date = $data['adoption_date'];
    $available = normalize($data['available']);
    $picture = $data['picture'];
    $Animaldeleted = normalize($data['deleted']);
  } else {
    header("location: error.php");
  }
  $mysqli->close();
} else {
  header("location: error.php");
}
?>

<?php head(" | Adopt Animal"); ?>

<div class="container">

  <h1 class="text-center py-5">Do you really want to Adopt this Animal?:</h1>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
    <div>
      <h1 class="text-center"></h1>
    </div>
    <div>
      <form method="post" action="actions/a_adopt.php" class="form-group" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid'] ?>" />
        <div>
          <div class='card p-3 mb-3'>
            <div class='card-img-body'>
              <img class='card-img mx-auto' data-bs-toggle='modal' data-bs-target='#exampleModal' src='../pictures/<?= $picture ?>' alt="<?= normalize($animal_name) ?>">
            </div>
            <div class='card-body'>
              <h5 class='card-animal_name'><?= normalize($animal_name) ?></h5>
              <p class='card-text'><?php substr(normalize($short_description), 0, 45) ?> <a href='details.php?id=" . <?= $id ?> . "'>...more</a><br></p>
              <p class='card-text'><?= normalize($age) ?></p>
              <p class='card-text'>Type: <?= normalize($animal_type) ?></p>
              <hgroup class="row">
                <input class="col-4 p-2 ms-3 btn btn-danger btn-sm text-white" type="submit" name="submit" value="Yes, adobt it">
                <a class="col-4 p-2 ms-3 btn btn-secondary btn-sm text-white" href="index.php">No, go back!</a>
              </hgroup>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php htmlend(); ?>