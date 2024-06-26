<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check2" viewBox="0 0 16 16">
    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
  </symbol>
  <symbol id="circle-half" viewBox="0 0 16 16">
    <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
  </symbol>
  <symbol id="moon-stars-fill" viewBox="0 0 16 16">
    <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
    <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
  </symbol>
  <symbol id="sun-fill" viewBox="0 0 16 16">
    <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
  </symbol>
</svg>

<!-- Navbar starts here -->
<nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top p-md-2 bg-opacity-75 shadow">
  <div class="container-fluid">
    <a class="navbar-brand" href="../animals/index.php"><img src="../assets/images/logo.jpg" height="50px" alt="Adopt a Pet"> Adopt a Pet</a>
    <!-- Button for small devices -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Login Button -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- For alligning the rest of the menue to the right -->
      <div class="mx-auto"></div>

      <ul class="navbar-nav opacity-75">
        <li class="nav-item">
          <!-- if you are loged in as a User -->
          <?php if ($_SESSION["username"] != "") {
            echo '<a class="btn btn-link nav-link card" type="button" data-bs-target=".navbar-collapse.show" href="../user/home.php?">Your Account ' . $_SESSION["username"] . '</a>';
          } else {
            echo '<a class="btn btn-link nav-link card" type="button" data-bs-target=".navbar-collapse.show" href="../user/index.php">Login</a>';
          }
          ?>
        </li>
        <!-- if you are an admin you can add animals -->
        <li class="nav-item">
          <?php if ($_SESSION["logedin"] == "admin") {
            echo '<a class="btn btn-link nav-link card mx-3" data-bs-target=".navbar-collapse.show" href="../animals/create.php">New Animal</a>';
          } ?>
        </li>

        <!-- the animal selectin starts here -->
        <li class="nav-item dropdown">
          <button type="button" class="btn btn-link nav-link card py-2 ms-3 dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
            <span class="d-lg-none" aria-hidden="true"></span><span class="visually-hidden"></span> Animal Filter <span class="visually-hidden"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item d-flex align-items-center justify-content-between active" aria-current="true" href="../animals/index.php">
                All
                <!-- <svg class="bi">
                  <use xlink:href="#check2"></use>
                </svg> -->
              </a>
            </li>
        </li>
        <li><a class="dropdown-item" href="../animals/index.php?filter=senior">Adult</a></li>
        <li><a class="dropdown-item" href="../animals/index.php?filter=junior">Junior</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="../animals/index.php?filter=small">Small</a></li>
        <li><a class="dropdown-item" href="../animals/index.php?filter=large">Large</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="../animals/index.php?filter=adopted">Adopted</a></li>
        <li><a class="dropdown-item" href="../animals/index.php?filter=notadopted">Available</a></li>
      </ul>
      </li>

      <!-- light dark mode selectio starts here -->
      <li class="nav-item dropdown">

        <button class="btn btn-link nav-link card py-2 px-2 ms-3 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" data-bs-display="static" aria-label="Toggle theme (auto)">
          <svg class="bi my-1 theme-icon-active">
            <use href="#circle-half"></use>
          </svg>
          <span class="d-lg-none ms-2" id="bd-theme-text"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="bd-theme-text">
          <li>
            <button type="button" class="dropdown-item d-flex h-0 align-items-center" data-bs-theme-value="light" aria-pressed="false">
              <svg class="bi me-2 opacity-50 theme-icon">
                <use href="#sun-fill"></use>
              </svg>
              Light
              <svg class="bi ms-auto d-none">
                <use href="#check2"></use>
              </svg>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
              <svg class="bi me-2 opacity-50 theme-icon">
                <use href="#moon-stars-fill"></use>
              </svg>
              Dark
              <svg class="bi ms-auto d-none">
                <use href="#check2"></use>
              </svg>
            </button>
          </li>
          <li>
            <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
              <svg class="bi me-2 opacity-50 theme-icon">
                <use href="#circle-half"></use>
              </svg>
              Auto
              <svg class="bi ms-auto d-none">
                <use href="#check2"></use>
              </svg>
            </button>
          </li>
        </ul>
      </li>
      </ul>
    </div>
  </div>
</nav>