<?php

// Defining Constants to use a function also
require_once 'config.inc.php';


/**
 * Establishes a database connection using the provided host, user, password, and database name.
 *
 * @param string $host The hostname of the database server.
 * @param string $user The username to connect to the database.
 * @param string $pass The password to connect to the database.
 * @param string $db The name of the database to connect to.
 * @throws Exception If the connection fails.
 * @return mysqli The mysqli object representing the database connection.
 */
function getDBConnection($host, $user, $pass, $db) {
    $mysqli = mysqli_init();
    mysqli_options($mysqli, MYSQLI_INIT_COMMAND, "SET NAMES utf8");
    if (!mysqli_real_connect($mysqli, $host, $user, $pass, $db)) {
        throw new Exception("Object Orientated Connection failed: " . mysqli_error($mysqli));
    }
    return $mysqli;
}
$mysqli = getDBConnection(HOST, USER, PASS, DB);

/**
 * Executes a database query using the provided mysqli object and query string.
 *
 * @param mysqli $mysqli The mysqli object representing the database connection.
 * @param string $query The SQL query to execute.
 * @throws Exception If the query fails.
 * @return mysqli_result The result of the query.
 */
// function queryDB($mysqli, $query) {
//     $result = mysqli_query($mysqli, $query);
//     if (!$result) {
//         throw new Exception("Query failed: " . mysqli_error($mysqli));
//     }

//     return $result;
// }

function closeDBConnection($mysqli) {
    mysqli_close($mysqli);
}

// Beispielverwendung
// $mysqli = getDBConnection("localhost", "user", "password", "database");
// $result = queryDB($mysqli, "SELECT * FROM users");
// while ($row = mysqli_fetch_assoc($result)) {
//     // Verarbeiten Sie die Ergebnisse
// }

// closeDBConnection($mysqli);
class DBConnection {
    private static $instance;
    private $mysqli;

    /**
     * Constructs a new instance of the class.
     *
     * @param string $host The hostname of the database server.
     * @param string $user The username to connect to the database.
     * @param string $pass The password to connect to the database.
     * @param string $db The name of the database to connect to.
     * @throws Exception If the connection fails.
     */
    private function __construct($host, $user, $pass, $db) {
        $this->mysqli = mysqli_init();
        mysqli_options($this->mysqli, MYSQLI_INIT_COMMAND, "SET NAMES utf8");
        if (!mysqli_real_connect($this->mysqli, $host, $user, $pass, $db)) {
            throw new Exception("Object Orientated Connection failed: " . mysqli_error($this->mysqli));
        }
    }

    /**
     * Returns a singleton instance of the DBConnection class.
     *
     * @param string $host The hostname of the database server.
     * @param string $user The username to connect to the database.
     * @param string $pass The password to connect to the database.
     * @param string $db The name of the database to connect to.
     * @return DBConnection The singleton instance of the DBConnection class.
     */
    public static function getInstance($host, $user, $pass, $db) {
        if (!isset(self::$instance)) {
            self::$instance = new DBConnection($host, $user, $pass, $db);
        }
        return self::$instance;
    }

    /**
     * Returns the mysqli object representing the database connection.
     *
     * @return mysqli The mysqli object representing the database connection.
     */
    public function getMysqli() {
        return $this->mysqli;
    }

    /**
     * Executes a SQL query on the database using the provided query string.
     *
     * @param string $query The SQL query to execute.
     * @throws Exception If the query fails.
     * @return mysqli_result The result of the query.
     */
    public function query($query) {
        $result = mysqli_query($this->mysqli, $query);
        if (!$result) {
            throw new Exception("Query failed: " . mysqli_error($this->mysqli));
        }
        return $result;
    }

/**
     * Executes a SQL query on the database using the provided query string.
     *
     * @param string $query The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     * @throws Exception If the query fails.
     * @return mysqli_stmt The prepared statement representing the query.
     */
    public function queryDB($query, $params = []) {
        $mysqli = $this->getMysqli();
    
        $stmt = $mysqli->prepare($query);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $mysqli->error);
        }
    
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
    
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    
        return $stmt;
    }

    public function close() {
        mysqli_close($this->mysqli);
    }
}

// Beispielverwendung der Klasse 
// $db = DBConnection::getInstance("localhost", "user", "password", "database");
// $result = $db->query("SELECT * FROM users");
// while ($row = mysqli_fetch_assoc($result)) {
//     // Verarbeiten Sie die Ergebnisse
// }
// $db->close();

