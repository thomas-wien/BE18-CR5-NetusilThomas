<?php
require_once '../../inc/db_connect.php';
require_once '../../inc/file_upload.php';
require_once '../../inc/normalize.php';
require_once '../../inc/htmlhelper.php';

if ($_POST) {
    $animal_name = (isset($_POST['animal_name'])) ? normalize($_POST['animal_name']) : "";
    $age = (isset($_POST['age'])) ? normalize($_POST['age']) : 0;
    $short_description = (isset($_POST['short_description'])) ? normalize($_POST['short_description']) : "";
    $animal_type = ((isset($_POST['animal_type'])) && $_POST['animal_type'] != "Animal Type") ? normalize($_POST['animal_type']) : "small";
    $breed = (isset($_POST['breed'])) ? normalize($_POST['breed']) : "";
    $vaccines = (isset($_POST['vaccines'])) ? normalize($_POST['vaccines']) : "";
    $adoption_date = (isset($_POST['adoption_date'])) ? normalize($_POST['adoption_date']) : "2000-01-01";
    $available = (isset($_POST['available'])) ? normalize($_POST['available']) : 'yes';
    $fk_created_by_user = (isset($_POST['fk_created_by_user'])) ? normalize($_POST['fk_created_by_user']) : 1;
    $Animaldeleted = (isset($_POST['Animaldeleted'])) ? normalize($_POST['Animaldeleted']) : 'no';

    $uploadError = '';
    $picture = file_upload($_FILES['picture']);


    $sql = "INSERT INTO animal (animal_name, age, short_description, animal_type, breed, vaccines, adoption_date, available, picture, fk_created_by_user, deleted) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sisssssssis", $animal_name, $age, $short_description, $animal_type, $breed, $vaccines, $adoption_date, $available, $picture->fileName, $fk_created_by_user, $Animaldeleted);


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
    // if ($stmt->execute()) {
    //     $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    //     header("Location: ../index.php");
    // } else {
    //     $class = "danger";
    //     $message = "Error while creating record. Try again: <br>" . $connect->error;
    //     $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    // }
    $mysqli->close();
} else {
    header("location: ../error.php");
}
?>

<?php
head(" | Create Animal"); ?>
<div class="container">
    <div class="mt-3 mb-3">
        <h1>Create request response</h1>
    </div>
    <div class="alert alert-<?= $class; ?>" role="alert">
        <p><?php echo ($message) ?? ''; ?></p>
        <p><?php echo ($uploadError) ?? ''; ?></p>
        <a href='../index.php'><button class="btn btn-primary" type='button'>Home</button></a>
    </div>
</div>
<?php htmlend(); ?>