<?php
function tbody($sqlreq)
{
  session_start();
  require_once '../inc/db_connect.php';
  require_once '../inc/htmlhelper.php';
  require_once '../inc/normalize.php';
  require_once '../inc/tbody.inc.php';

  $sql = $sqlreq;
  $result = $mysqli->query($sql);

  $tbody = '';

  if ($result->num_rows > 0) {
    $result->fetch_array(MYSQLI_ASSOC);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
      $tbody .= " <div>
          <div class='card p-3 mb-5'>
            <div class='card-img-body'>
              <a href='details.php?id=" . $row['id'] . "'><img class='img-thumbnail img-fluid overflow-hidden w-100' data-bs-toggle='modal' data-bs-target='#exampleModal' src='../pictures/" . $row['picture'] . "' height='450px' alt=" . normalize($row['animal_name']) . "></a>
            </div>
            <div class='card-body'>
              <h4 class='card-title'>" . $row['breed'] . "</h4>
              <h5 class='card-title'>" . $row['animal_name'] . "</h5>
              <p class='card-text'>" . substr($row['short_description'], 0, 45) . " <a href='details.php?id=" . $row['id'] . "'>...more</a><br></p>
              <p class='card-text'>Age:" . $row['age'] . "</p>
              <p class='card-text'>Type: " . $row['animal_type'] . "</p>
              <!--<p class='card-text'><a href='breed.php?id=" . $row['id'] . "'>" . normalize($row['breed']) . "</a></p>-->
              </div>
              ";
      if ($_SESSION["logedin"] == "admin") {
        $tbody .= "
              <div class='card-footer'>
                <a class='col-4 p-2 ms-3 btn btn-secondary btn-sm w-25 text-white' href='details.php?id=" . $row['id'] . "'>Details</a>
                <a class='col-4 p-2 ms-3 btn btn-secondary btn-sm w-25 text-white' href='update.php?id=" . $row['id'] . "'>Update</a>
                <a class='col-4 p-2 ms-3 btn btn-danger btn-sm w-25 text-white' href='delete.php?id=" . $row['id'] . "'>Delete</a>
              </div>
            ";
      }
      if ($_SESSION["logedin"] == "user") {
        $tbody .= "
              <div class='card-footer'>
                <a class='col-4 p-2 ms-3 btn btn-secondary btn-sm w-25 text-white' href='details.php?id=" . $row['id'] . "'>Details</a>
                ";
        if ($row['available'] == "yes") {
          $tbody .= " <a class='col-4 p-2 ms-3 btn btn-danger btn-sm w-25 text-white' href='adopt.php?id=" . $row['id'] . "'>Adopt</a>";
        }
        $tbody .= "
        </div>";
      }
      $tbody .= "
          </div>
        </div>";
    };
  } else {
    $tbody =  "<tr><td colspan='10'><center>No Data Available </center></td></tr>";
  }
  $mysqli->close();

?>
  <?php head(" | Adopted Animals"); ?>

  <div class="container">
    <h1 class="text-center py-4">Our animals</h1>
  </div>
  <div class="container card py-3">
    <div class="row row-cols-md-2 row-cols-xl-3">
      <?= $tbody; ?>
    </div>
    <?php if ($_SESSION["logedin"] == "admin") {
      echo "<div class='mb-3 mx-auto'>
      <a class='col-4 p-2 ms-3 btn btn-success btn-sm w-100 text-white' href='create.php'>Create a new Animal</a>
    </div>";
    } ?>
  </div>
  </div>
<?php htmlend();
}
?>