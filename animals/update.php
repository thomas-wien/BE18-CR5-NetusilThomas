<?php
session_start();
require_once '../inc/db_connect.php';
require_once '../inc/htmlhelper.php';

isUser("index.php");
// if (isset($_SESSION['user']) != "") {
// 	header("Location: index.php");
// 	exit;
// }

if ($_GET['id']) {
	$id = $_GET['id'];
	$sql = "SELECT * FROM animal WHERE id = ?";
	$stmt = queryDB($mysqli, $sql, array($id));
	$result = $stmt->get_result();
	if ($result->num_rows == 1) {
		$data = $result->fetch_assoc();
		$animal_name = normalize($data['animal_name']);
		$age = normalize($data['age']);
		$short_description = normalize($data['short_description']);
		$animal_type = normalize($data['animal_type']);
		$breed = normalize($data['breed']);
		$vaccines = normalize($data['vaccines']);
		$adoption_date = normalize($data['adoption_date']);
		$adopted_from = normalize($data['adopted_from']);
		$available = $data['available'];
		$picture = normalize($data['picture']);
		$fk_created_by_user = normalize($data['fk_created_by_user']);
	} else {
		header("location: error.php");
	}
	$mysqli->close();
} else {
	header("location: error.php");
}
?>
<?php head(" | Update"); ?>

<div class="container pb-5 pt-2">
	<h1 class="text-center">Update the Animal</h1>
</div>
<div class="container">
	<form method="post" action="actions/a_update.php" class="form-group" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?= $id ?>" />
		<div class="row mx-auto needs-validation" novalidate style="width: 80%;">
			<div class="card p-3 mb-5 bg-secondary bg-gradient">
				<div class="card-img-body">
					<img class="card-img w-25 mx-auto" data-bs-toggle="modal" data-bs-target="#exampleModal" src="../pictures/<?= $picture ?>" alt="<?= normalize($animal_name) ?>">
					<input type="file" class="form-control" name="picture" placeholder="Please choose a picture...">
				</div>
				<div class="card-body">
					<div class="input-group mb-3">
						<span class="input-group-text" id="inputGroup-animal_name">animal_name</span>
						<input type="text" class="form-control" aria-label="animal_name" aria-describedby="inputGroup-animal_name" name="animal_name" value="<?= normalize($animal_name) ?>">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text" id="inputGroup-breed">Breed</span>
						<input type="text" class="form-control" aria-label="breed" aria-describedby="inputGroup-breed" name="breed" value="<?= normalize($breed) ?>">
					</div>
					<select class="form-select mb-3" aria-label="form-select Type" name="animal_type" value=<?= $animal_type ?> required>
						<option disabled>... select</option>
						<option value="small" <?php if ($animal_type == 'small') echo 'selected="selected"'; ?>>small</option>
						<option value="large" <?php if ($animal_type == 'large') echo 'selected="selected"'; ?>>large</option>
					</select>
					<div class="input-group mb-3">
						<span class="input-group-text">Desciption</span>
						<textarea class="form-control" aria-label="Description" name="short_description" style="height: 100px" value="<?= normalize($short_description) ?>"><?= normalize($short_description) ?></textarea>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text" id="inputGroup-age">age</span>
						<input type="text" class="form-control" aria-label="age" aria-describedby="inputGroup-age" name="age" value="<?= normalize($age) ?>">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text" id="inputGroup-vaccines">Vaccines</span>
						<input type="text" class="form-control" aria-label="vaccines" aria-describedby="inputGroup-vaccines" name="vaccines" value="<?= normalize($vaccines) ?>">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text" id="inputGroup-adoption_date">Adoption Date</span>
						<input type="date" class="form-control date" aria-label="adoption_date" aria-describedby="inputGroup-adoption_date" name="adoption_date" value="<?= $adoption_date ?>">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text" id="inputGroup-adopted_from">Adopted From</span>
						<input type="text" class="form-control" aria-label="adopted_from" aria-describedby="inputGroup-adopted_from" name="adopted_from" value="<?= $adopted_from ?>">
					</div>
					<select class="form-select mb-3" aria-label="form-select available" name="available" value=<?= $available ?> required>
						<option disabled>... select</option>
						<option value="no" <?php if ($available == 0) echo 'selected="selected"'; ?>>Adopted</option>
						<option value="yes" <?php if ($available == 1) echo 'selected="selected"'; ?>>Available</option>
					</select>
				</div>
				<?php if ($_SESSION["logedin"] == "admin") {
					echo "<div class='card-footer text-center mx-auto space-around w-100'>
					<a class='col-4 p-2 ms-3 btn btn-light btn-sm w-25 text-dark' href='index.php'>Home</a>
					<input class='col-4 p-2 ms-3 btn btn-success btn-sm w-25 text-white' type='submit' name='submit' value='Submit Changes' class='btn btn-success'>
					<a class='col-4 p-2 ms-3 btn btn-danger btn-sm w-25 text-white' href='delete.php?id=$id'>Delete</a>
					<div class='mb-3 pt-5 text-center'>
						<a class='col-4 p-2 ms-3 btn btn-success btn-sm w-25 text-white' href='create.php'>Create a new Animal</a>
					</div>
				</div>";
				}	?>

			</div>
		</div>
	</form>
</div>
<?php htmlend(); ?>