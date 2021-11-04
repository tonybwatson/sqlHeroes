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

// CREATE 
function createHero($name, $about_me, $biography)
{
    $sql = "INSERT INTO heroes (name, about_me, biography)
    VALUES ('$name', '$about_me', '$biography')";
    global $conn;

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function createAbility(
    $ability
) {
    $sql = "INSERT INTO ability_type (ability)
    VALUES ('$ability')";
    global $conn;

    if ($conn->query($sql) === TRUE) {
        echo "New ability type created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// READ
function readAllHeroes()
{
    $sql = "SELECT * FROM heroes";
    global $conn;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: "
                . $row['id'] . " - Name: "
                . $row['name'] . "<br>"
                . $row['about_me'] .  "<br>"
                . $row['biography'] . "<br>";
        }
    } else {
        echo "0 results";
    }
}

function readAbilities()
{
    $sql = "SELECT * FROM ability_type";
    global $conn;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: "
                . $row['id'] . " - ability: "
                . $row['ability'] . "<br>";
        }
    } else {
        echo "0 results";
    }
}

function getAll()
{
    $sql = "SELECT 
    heroes.name, 
    heroes.about_me, 
    GROUP_CONCAT(ability_type.ability separator ', ') ability_type
    FROM ((heroes
    INNER JOIN abilities on heroes.id = abilities.hero_id)
    INNER JOIN ability_type ON abilities.ability_id = ability_type.id)
    GROUP BY heroes.name, heroes.about_me";
    global $conn;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
    } else {
        echo $conn->errors;
    }
}

// UPDATE
function updateHero($id, $name, $about_me, $biography)
{
    $sql = "UPDATE heroes SET about_me='$about_me', name='$name', biography='$biography'  
    WHERE id='$id'";
    global $conn;

    if ($conn->query($sql) === TRUE) {
        echo "Hero updated successfully";
    } else {
        echo "Error updating Hero: " . $conn->error;
    }
    $conn->close();
}

function addHeroAbility() {
    
}

// DELETE
function deleteHero($id)
{

    $sql = "DELETE FROM heroes WHERE id='$id'";
    global $conn;

    if ($conn->query($sql) === TRUE) {
        echo "Hero deleted successfully";
    } else {
        echo "Error deleting Hero: " . $conn->error;
    }
}

function deleteAbility($id)
{
    $sql = "DELETE FROM ability_type WHERE id='$id'";
    global $conn;

    if ($conn->query($sql) === TRUE) {
        echo "Ability deleted successfully";
    } else {
        echo "Error deleting Ability: " . $conn->error;
    }
}

$action = $_GET["action"];

if ($action != "") {
    switch ($action) {
        case "create":
            createHero(
                $_POST["name"],
                $_POST["about_me"],
                $_POST["biography"]
            );
            break;
        case "createability":
            createAbility(
                $_POST["ability"]
            );
            break;
        case "read":
            readAllHeroes();
            break;
        case "readabilities":
            readAbilities();
            break;
        case "update":
            updateHero(
                $_POST["id"],
                $_POST["name"],
                $_POST["about_me"],
                $_POST["biography"]
            );
            break;
        case "delete":
            deleteHero(
                $_GET["id"]
            );
            break;
        case "deleteability":
            deleteAbility(
                $_GET["id"]
            );
            break;
        case "getall":
            getAll();
            break;
        default:
            return;
    }
}
