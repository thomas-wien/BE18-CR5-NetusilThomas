<?php
require_once '../../inc/htmlhelper.php';

head(" | create ");

include 'db_connection';

if (!$mysqli->set_charset('utf8mb4')) {
  echo 'Error with Charset: ' . $mysqli->error;
}

$sql = 'CREATE TABLE IF NOT EXISTS animals  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `animal_name` varchar(64) NOT NULL,
  `age` char(13) NOT NULL,
  `short_description` text NOT NULL,
  `animal_type` enum(\'small\',\'large\',) NOT NULL DEFAULT \'smal\',
  `picture` varchar(64) NOT NULL DEFAULT \'product.png\',
  `breed` varchar(32) NOT NULL,
  `vaccines` varchar(255) NOT NULL,
  `adoption_date` date NOT NULL DEFAULT \'2000-10-10\',
  `available` enum(\'0\',\'1\') NOT NULL DEFAULT \'1\',
  PRIMARY KEY (`id`)
)';
if ($mysqli->query($sql)) {
  echo 'SQL-Command executed: ' . $sql;
} else {
  echo 'Error';
}


$mysqli->close();

htmlend();
