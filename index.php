<?php
header('Content-Type: text/plain');

$token = $_SERVER['HTTP_X_API_KEY'] ?? null;
$valid_token = 'apitoken';
if ($token !== $valid_token) {
    echo 'UnAuthorized';
    exit;
} else {


    try {
        $database_name = 'databaseName';
        $user = 'databaseUsername';
        $password = 'databasePassword';

        $bdd = new PDO('mysql:host=yourhost;dbname=' . $database_name . ';charset=utf8', $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('<b> Erreur: </b>' . $e->getMessage());
    }

    $stmt = $bdd->prepare('SELECT * FROM yourtable');
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo generateSqlInserts($data);
}
function generateSqlInserts($data)
{
    $sql = "INSERT INTO yourtable (";
    $columns = array_keys($data[0]);
    $sql .= implode(", ", $columns);
    $sql .= ") VALUES ";

    $values = [];
    foreach ($data as $row) {
        $rowValues = [];
        foreach ($row as $value) {
            $rowValues[] = "'" . addslashes($value) . "'";
        }
        $values[] = "(" . implode(", ", $rowValues) . ")";
    }

    $sql .= implode(", ", $values);

    return $sql;
}
