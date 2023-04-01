<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';
require_once '../inc/normalize.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal WHERE id = {$id} AND deleted = 'no'";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 1) {
        $data = $result->fetch_assoc();
        $animal_name = normalize($data['animal_name']);
        $age = normalize($data['age']);
        $short_description = normalize($data['short_description']);
        $animal_type = normalize($data['animal_type']);
        $breed = normalize($data['breed']);
        $vaccines = normalize($data['vaccines']);
        $adoption_date = normalize($data['adoption_date']);
        $available = normalize($data['available']);
        $picture = $data['picture'];
        $Animaldeleted = normalize($data['deleted']);
        $lives_in = normalize($data['lives_in']);
    } else {
        header("location: error.php");
    }
    $mysqli->close();
} else {
    header("location: error.php");
}
?>
<?php head(" | Details"); ?>

<div class="container pb-5">
    <div class="animal_name text-center">
        <h1 class="my-5">Details</h1>
    </div>
    <div class='card'>
        <div class='row'>
            <div class='col-sm-5 col-md-4'>
                <img class='card-img img-fluid rounded-start p-2' src='../pictures/<?= $picture ?>' alt=<?= $animal_name ?>>
                <?php if ($_SESSION["logedin"] == "admin") {
                    echo "<div class='card-footer text-center mx-auto space-around w-100'>
                    <a class='col-4 p-2 ms-3 btn btn-secondary btn-sm w-25 text-white' href='index.php'>Home</a>
                    <a class='col-4 p-2 ms-3 btn btn-secondary btn-sm w-25 text-white' href='update.php?id=$id'>Update</a>
                    <a class='col-4 p-2 ms-3 btn btn-danger btn-sm w-25 text-white' href='delete.php?id=$id'>Delete</a>
                    <div class='mb-3 pt-5 text-center'>
                        <a class='p-2 ms-3 btn btn-success btn-sm w-75 text-white' href='create.php'>Create a new animal</a>
                    </div>
                </div>";
                }
                ?>
                <?php if ($_SESSION["logedin"] == "user" && $available == "yes") {
                    echo "
            <div class='card-footer'>
                <a class='col-4 p-2 ms-3 btn btn-danger btn-sm w-25 text-white' href='adopt.php?id=$id'>Adopt</a>
            </div>
          ";
                } ?>
            </div>
            <div class='col-sm-7 col-md-8'>
                <div class='card-body'>
                    <h5 class='card-animal_name'><?= normalize($animal_name) ?><h5>
                            <p class='card-text'><?= $short_description ?></p>
                            <p class='card-text'>age: <?= normalize($age) ?></p>
                            <p class='card-text'>Type: <?= normalize($animal_type) ?></p>
                            <p class='card-text'>Breed: <?= normalize($breed) ?></p>
                            <p class='card-text'>Vacccines: <?= normalize($vaccines) ?></p>
                            <p class='card-text'>Lives in: <?= normalize($lives_in) ?></p>
                            <p class='card-text'>Adopted: <?= normalize($adoption_date) ?></p>
                            <p class='card-text'>Animal is <?= ($available == 'no') ? 'Adopted' : 'Available'; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php htmlend(); ?>