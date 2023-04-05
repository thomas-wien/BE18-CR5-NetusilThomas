<?php
require_once 'config.inc.php';

$_SESSION['username'] = (isset($_SESSION['username'])) ? normalize($_SESSION['username']) : "";
$_SESSION['logedin'] = (isset($_SESSION['logedin'])) ? $_SESSION['logedin'] : "";
$_SESSION['userid'] = (isset($_SESSION['userid'])) ? $_SESSION['userid'] : 0;

function head($titel = " | Thomas ")
{
  echo '<!DOCTYPE html> 
  <html lang="en" data-bs-theme="auto">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="../css/style.css">
      <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
      <meta name="author" content="Thomas Netusil">
      <meta name="description" content="CodeReview 4">
      <title>Adopt a Pet' . $titel . '</title>
      <link href="../favicon.ico" rel="icon">
      <script src="../js/darkLight.js" defer></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous" defer></script>

    </head>
    <body>
    
  <header class="position-relative">';

  include_once 'menue.php';

  echo '<div style="height: 35vh" class="banner-image w-100 d-flex justify-content-center align-items-center pt-5"></div>
  <h1 class="vw-auto d-block display-5 position-absolute top-50 start-50 translate-middle text-center text-white bg-dark  bg-opacity-75 px-4 py-4">
      Adopt a Pet</h1>
  </header>';
}

function htmlend()
{
  echo ' <footer class="container-fluid mt-5 bg-dark text-white text-center ">
  
  <p class="fs-6 m-2 p-2">&copy; 2023 Copyright Thomas Netusil</p>
</footer>
</body>
  </html>';
}

function getCon()
{
  $connect = new mysqli(HOST, USER, PASS, DB);
  return $connect;
}

function logged_in()
{
  isUser();
  isAdmin();
}

function isUser($locuser = 'home.php')
{
  if (isset($_SESSION['user']) != "") {
    header("Location: $locuser");
    return true;
  }
}

function isAdmin($locadmin = 'dashboard.php')
{
  if (isset($_SESSION['admin'])) {
    header("Location: $locadmin");
    return true;
  }
}

function isAnonym($locdef = 'index.php')
{
  if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) {
    header("Location: $locdef");
    $_SESSION['username'] = "";
    return true;
  }
}

function logout()
{
  isAnonym();
  logged_in();

  if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    unset($_SESSION['admin']);
    session_unset();
    session_destroy();
    header("Location: index.php");
    return true;
  }
}

function file_upload($picture, $src = "animal")
{
  $result = new stdClass(); //this object will carry status from file upload
  $result->fileName = 'avatar.png';

  if ($src == "animal") {
    $result->fileName = 'animal.jpg';
  }

  $result->error = 1; //it could also be a boolean true/false
  //collect data from object $picture
  $fileName = $picture["name"];
  $fileType = $picture["type"];
  $fileTmpName = $picture["tmp_name"];
  $fileError = $picture["error"];
  $fileSize = $picture["size"];
  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $filesAllowed = ["png", "jpg", "jpeg", "webp"];

  // echo var_dump($picture);
  // die();

  if ($fileError == 4) {
    $result->ErrorMessage = "No picture was chosen. It can always be updated later.";
    return $result;
  } else {
    if (in_array($fileExtension, $filesAllowed)) {
      if ($fileError === 0) {
        if ($fileSize < 500000) { //500kb this number is in bytes
          //it gives a file name based microseconds
          $fileNewName = uniqid('') . "." . $fileExtension; // 1233343434.jpg i.e
          $destination = "../pictures/$fileNewName";
          // if ($src == "user") {
          //     $destination = "../pictures/$fileNewName";
          // }
          if (move_uploaded_file($fileTmpName, $destination)) {
            $result->error = 0;
            $result->fileName = $fileNewName;
            return $result;
          } else {
            $result->ErrorMessage = "There was an error uploading this file.";
            return $result;
          }
        } else {
          $result->ErrorMessage = "This picture is bigger than the allowed 500Kb. <br> Please choose a smaller one and Update your profile.";
          return $result;
        }
      } else {
        $result->ErrorMessage = "There was an error uploading - $fileError code. Check php documentation.";
        return $result;
      }
    } else {
      $result->ErrorMessage = "This file type cant be uploaded.";
      return $result;
    }
  }
}

// function file_upload(array $file, string $src = "animal"): array
// {
//   $result = [
//     "error" => 1,
//     "file_name" => "avatar.png",
//     "error_message" => ""
//   ];

//   $allowed_extensions = ["png", "jpg", "jpeg", "webp"];
//   $max_size = 500000; // 500kb

//   if ($file["error"] == UPLOAD_ERR_NO_FILE) {
//     $result["error_message"] = "No file was chosen. It can always be updated later.";
//     return $result;
//   }

//   if (!in_array(pathinfo($file["name"], PATHINFO_EXTENSION), $allowed_extensions)) {
//     $result["error_message"] = "This file type can't be uploaded.";
//     return $result;
//   }

//   if ($file["error"] !== UPLOAD_ERR_OK) {
//     $result["error_message"] = "There was an error uploading - {$file['error']} code. Check PHP documentation.";
//     return $result;
//   }

//   if ($file["size"] > $max_size) {
//     $result["error_message"] = "This file is bigger than the allowed 500KB. Please choose a smaller one and update your profile.";
//     return $result;
//   }

//   $file_name = $src == "animal" ? "animal.jpg" : uniqid("") . "." . pathinfo($file["name"], PATHINFO_EXTENSION);
//   $destination = "../pictures/$file_name";

//   if (!move_uploaded_file($file["tmp_name"], $destination)) {
//     $result["error_message"] = "There was an error uploading this file.";
//     return $result;
//   }

//   $result["error"] = 0;
//   $result["file_name"] = $file_name;

//   return $result;
// }

function normalize($var)
{
  $var = trim($var);
  $var = strip_tags($var);
  $var = htmlspecialchars($var);
  $var = mysqli_real_escape_string(getCon(), $var);
  return $var;
}

function display_animals($query, $head)
{
  session_start();
  require_once '../inc/db_connect.php';
  require_once '../inc/htmlhelper.php';

  $result = $mysqli->query($query);

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
  <?php head(" | " . $head); ?>

  <div class="container">
    <h1 class="text-center py-4"><?= $head ?></h1>
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
