<?php
function normalize($var)
{
  $var = trim($var);
  $var = strip_tags($var);
  $var = htmlspecialchars($var);
  $var = mysqli_real_escape_string(getCon(), $var);
  return $var;
}
