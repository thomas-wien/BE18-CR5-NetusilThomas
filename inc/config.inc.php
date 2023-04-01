<?php
if (str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
  // Local
  DEFINE("HOST", "localhost");
  DEFINE("USER", "root");
  DEFINE("PASS", "");
  DEFINE("DB", "BE18_CR5_animal_adoption_netusilthomas");
} else {
  // Codefactory  
  DEFINE("HOST", "173.212.235.205");
  DEFINE("USER", "netusilcodefacto_thomas");
  DEFINE("PASS", "U9BcyKixxr44fSL");
  DEFINE("DB", "netusilcodefacto_be18_cr5_animal_adoption_netusilthomas");
}
