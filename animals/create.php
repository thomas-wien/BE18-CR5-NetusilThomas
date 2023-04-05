<?php
session_start();

include '../inc/htmlhelper.php';

head(" | Create Animal"); ?>

<div class="container">
    <h1 class="text-center">Create an Animal</h1>
</div>
<div>
    <form method="post" action="actions/a_create.php" class="form-group" enctype="multipart/form-data">
        <h1 class="text-center"></h1>
        <div class="row mx-auto needs-validation" novalidate style="width: 75%;">
            <div class="card p-3 mb-5">
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="picture" name="picture">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-animal_name">Animal Name</span>
                        <input type="text" class="form-control" aria-label="animal_name" aria-describedby="inputGroup-animal_name" name="animal_name" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-breed">Breed</span>
                        <input type="text" class="form-control" aria-label="breed" aria-describedby="inputGroup-breed" name="breed" required>
                    </div>
                    <select class="form-select form-select mb-3" aria-label=".form-select example" name="animal_type" required>
                        <option selected disabled>Animal Type</option>
                        <option value="small">small</option>
                        <option value="large">large</option>
                    </select>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Desciption</span>
                        <textarea class="form-control" aria-label="Description" name="short_description" rows="3" required></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-age">Age</span>
                        <input type="text" class="form-control" aria-label="age" aria-describedby="inputGroup-age" name="age" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-vaccines">Vaccines</span>
                        <input type="text" class="form-control" aria-label="vaccines" aria-describedby="inputGroup-vaccines" name="vaccines" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-adoption_date">Adoption Date</span>
                        <input type="date" class="form-control date" aria-label="adoption_date" aria-describedby="inputGroup-adoption_date" name="adoption_date">
                    </div>
                    <select class="form-select mb-3" aria-label="form-select available" name="available" value=<?= $available ?> required>
                        <option disabled>... select</option>
                        <option value="no">Adopted</option>
                        <option value="yes">Available</option>
                    </select>
                    <hgroup class="row">
                        <input class="col-4 p-2 ms-3 btn btn-success btn-sm w-25 text-white" type="submit" name="submit" value="Create the Animal" class="btn btn-success">
                        <a class="col-4 p-2 ms-3 btn btn-secondary btn-sm w-25 text-white" href="index.php">back</a>
                    </hgroup>
                </div>
            </div>
        </div>
    </form>
</div>
<?php htmlend(); ?>