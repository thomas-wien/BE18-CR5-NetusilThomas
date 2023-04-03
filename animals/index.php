<?php
require_once '../inc/htmlhelper.php';

$filter = (isset($_REQUEST['filter'])) ? $_REQUEST['filter'] : "all";

$filters = [
  "senior" => [
    "head" => "Senior Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no' AND age > 8"
  ],
  "junior" => [
    "head" => "Junior Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no' AND age <= 8"
  ],
  "small" => [
    "head" => "Small Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no' AND animal_type = 'small'"
  ],
  "large" => [
    "head" => "Big Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no' AND animal_type = 'large'"
  ],
  "adopted" => [
    "head" => "Adopted Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no' AND available = 'no'"
  ],
  "notadopted" => [
    "head" => "Available Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no' AND available = 'yes'"
  ],
  "default" => [
    "head" => "Our Animals",
    "sql" => "SELECT * FROM animal Where deleted = 'no'"
  ]
];

$selected_filter = isset($_GET['filter']) ? $_GET['filter'] : 'default';

if (array_key_exists($selected_filter, $filters)) {
  $head = $filters[$selected_filter]['head'];
  $sql = $filters[$selected_filter]['sql'];
} else {
  $head = $filters['default']['head'];
  $sql = $filters['default']['sql'];
}

display_animals($sql, $head);
