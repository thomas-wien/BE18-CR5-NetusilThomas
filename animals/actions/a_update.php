<?php
require_once '../../inc/db_connect.php';
require_once '../../inc/htmlhelper.php';

if ($_POST) {
    $animal_name = (isset($_POST['animal_name'])) ? normalize($_POST['animal_name']) : "";
    $breed = (isset($_POST['breed'])) ? normalize($_POST['breed']) : "";
    $age = (isset($_POST['age'])) ? normalize($_POST['age']) : 0;
    $short_description = (isset($_POST['short_description'])) ? normalize($_POST['short_description']) : "";
    $animal_type = ((isset($_POST['animal_type'])) && $_POST['animal_type'] != "animal Type") ? normalize($_POST['animal_type']) : "small";
    $picture = (isset($_POST['picture'])) ? normalize($_POST['picture']) : "";
    $vaccines = (isset($_POST['vaccines'])) ? normalize($_POST['vaccines']) : "";
    $adopted_from = (isset($_POST['adopted_from '])) ? normalize($_POST['adopted_from ']) : 0;
    $adoption_date = (isset($_POST['adoption_date'])) ? normalize($_POST['adoption_date']) : "2000-01-01";
    $available = (isset($_POST['available'])) ? normalize($_POST['available']) : 'yes';
    $fk_created_by_user = (isset($_POST['fk_created_by_user'])) ? normalize($_POST['fk_created_by_user']) : 1;
    $Animaldeleted = (isset($_POST['Animaldeleted'])) ? normalize($_POST['Animaldeleted']) : 'no';

    $id = $_POST['id'];
    //variable for upload pictures errors is initialised
    $uploadError = '';
    $pictureArray = file_upload($_FILES['picture']); //file_upload() called
    $picture = $pictureArray->fileName;

    $picture = file_upload($_FILES['picture']);
    // echo $_FILES['picture'];
    // echo $picture->fileName;
    // echo $picture;
    // die();

    // if ($picture->error === 0) { 
    //     ($_POST["picture"] == "animal.png") ?: unlink("/pictures/$_POST[picture]");
    //     $sql = "UPDATE animal SET animal_name = ?, breed = ?, age = ?, short_description = ?, animal_type = ?, picture = ?, vaccines = ?, adopted_from  = ?, adoption_date = ?, available = ?, fk_created_by_user = ?, deleted = ? WHERE id = ?";
    //     $stmt = $mysqli->prepare($sql);
    //     $stmt->bind_param("ssissssissis", $animal_name, $breed, $age, $short_description, $animal_type, $picture->fileName, $vaccines, $adopted_from, $adoption_date, $available, $fk_created_by_user, $id, $Animaldeleted);
    // } else {
    $sql = "UPDATE animal SET animal_name = ?, breed = ?, age = ?, short_description = ?, animal_type = ?, picture = ?, vaccines = ?, adopted_from  = ?, adoption_date = ?, available = ?, fk_created_by_user = ?, deleted = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssissssissisi", $animal_name, $breed, $age, $short_description, $animal_type, $picture->fileName, $vaccines, $adopted_from, $adoption_date, $available, $fk_created_by_user, $Animaldeleted, $id);
    // }

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
    //     $class = "success";
    //     $message = "The record has been updated successfully";
    //     $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    // } else {
    //     $class = "danger";
    //     $message = "Error while updating record : <br>" . mysqli_connect_error();
    //     $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    // }
    $mysqli->close();

    header("location: ../index.php");
} else {
    header("location: ../error.php");
}
?>

<?php head(" | Update"); ?>

<div class="container">
    <div class="mt-3 mb-3">
        <h1>Updating request response</h1>
    </div>
    <div class="alert alert-<?php echo $class; ?>" role="alert">
        <p><?php echo ($message) ?? ''; ?></p>
        <p><?php echo ($uploadError) ?? ''; ?></p>
        <a href='../update.php?id=<?= $id; ?>'><button class="btn btn-warning" type='button'>Back</button></a>
        <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
    </div>
</div>
<?php htmlend(); ?>