<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hero_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_GET["action"];

echo "<pre" . print_r($action, 1) . "</pre>";
if ($action != "") {
    switch ($action) {
        case "create":
            createHero(
                $_GET["name"],
                $_GET["about_me"],
                $_GET["biography"],
                // $_GET["ability"], 
                $conn
            );
            break;
        case "abilities":
            createAbility(
                $_GET["abilities"],
                $conn
            );
            break;
        case "read":
            // readAllHeroes();
            break;
        case "update":
            updateHero(
                $_GET["id"],
                $_GET["name"],
                $_GET["about_me"],
                $_GET["biography"],
                $conn
            );
            break;
        case "delete":
            deleteHero(
                $_GET["id"],
                $conn
            );
            break;
        default:
    }
    readAllHeroes($conn);
}

// CREATE 
function createHero($name, $about_me, $biography, $conn)
{
    $sql = "INSERT INTO heroes (name, about_me, biography)
    VALUES ('$name', '$about_me', '$biography')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function createAbility($ability, $conn)
{
    $sql = "INSERT INTO heroes (abilities)
    VALUES ('abilities')";

    if ($conn->query($sql) === TRUE) {
        echo "New ability created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ
function readAllHeroes($conn)
{
    //output heroes from the array
    echo "<h1>READ</h1><pre>";

    $sql = "SELECT * FROM heroes";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: "
                . $row['id'] . " - Name: "
                . $row['name'] . "<br>"
                . $row['about_me'] .  "<br>"
                . $row['biography'] . "<br>"
                // . $row['ability']
            ;
        }
    } else {
        echo "0 results";
    }
}

// UPDATE
function updateHero($id, $name, $about_me, $biography, $conn)
{

    $sql = "UPDATE heroes SET about_me='$about_me', name='$name', biography='$biography'  
    WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
}

// DELETE
function deleteHero($id, $conn)
{

    // sql to delete a record
    $sql = "DELETE FROM heroes WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// echo "end of script";

function createNewDatabase($conn)
{

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Create database
    $sql = "CREATE DATABASE " . $_GET["dbname"];
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
}

// work with this to create other tables
function createTableinDB($db, $conn)
{
    $sql = "CREATE TABLE heroes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        about_me VARCHAR(30) NOT NULL,
        created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    if ($conn->query($sql) === TRUE) {
        echo "Table created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    $conn->close();
}
