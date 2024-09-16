<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli('localhost', 'root', '', 'js_practice');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check which request is being made
if (isset($_GET['type'])) {
    $type = $_GET['type'];

    switch ($type) {
        case 'countries':
            // Fetch and return all countries
            $sql = "SELECT id, name FROM countries";
            $result = $conn->query($sql);

            $countries = array();
            while ($row = $result->fetch_assoc()) {
                $countries[] = $row;
            }

            echo json_encode($countries);
            break;

        case 'states':
            if (isset($_GET['country_id'])) {
                $country_id = $_GET['country_id'];

                // Fetch and return states based on country_id
                $sql = "SELECT id, name FROM states WHERE country_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $country_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $states = array();
                while ($row = $result->fetch_assoc()) {
                    $states[] = $row;
                }

                echo json_encode($states);
            }
            break;

        case 'cities':
            if (isset($_GET['state_id'])) {
                $state_id = $_GET['state_id'];

                // Fetch and return cities based on state_id
                $sql = "SELECT id, name FROM cities WHERE state_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $state_id);
                $stmt->execute();
                $result = $stmt->get_result();

                $cities = array();
                while ($row = $result->fetch_assoc()) {
                    $cities[] = $row;
                }

                echo json_encode($cities);
            }
            break;

        default:
            echo json_encode(['error' => 'Invalid type']);
            break;
    }
} else {
    echo json_encode(['error' => 'No type specified']);
}

$conn->close();
?>
