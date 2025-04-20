<?php
$serverName = "sql211.infinityfree.com";
$userName = "if0_36531538";
$password = "w7KCxNgQLVnOGX";
$conn = mysqli_connect($serverName, $userName, $password);
if (!$conn) {
    die("Failed to connect: " . mysqli_connect_error());
}

// Creating database if it doesn't exist
$createDatabase = "CREATE DATABASE IF NOT EXISTS if0_36531538_pro3";
if (!mysqli_query($conn, $createDatabase)) {
    die("Failed to create database: " . mysqli_error($conn));
}

// Select the p3 database
mysqli_select_db($conn, 'if0_36531538_pro3');

// Create weather table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS weather (
    city VARCHAR(100) NOT NULL,
    humidity FLOAT NOT NULL,
    wind FLOAT NOT NULL,
    windD FLOAT NOT NULL,
    pressure FLOAT NOT NULL,
    temperature FLOAT NOT NULL,
    main_condition VARCHAR(100) NOT NULL,
    icon VARCHAR(50) NOT NULL,
    condition_details VARCHAR(100) NOT NULL,
    dt VARCHAR(50) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id INT AUTO_INCREMENT PRIMARY KEY
)";

if (!mysqli_query($conn, $createTable)) {
    die("Failed to create table: " . mysqli_error($conn));
}

$cityName = isset($_GET['q']) ? $_GET['q'] : 'Maidstone';

$selectAllData = "SELECT * FROM weather WHERE city = '$cityName'";
$result = mysqli_query($conn, $selectAllData);

if (mysqli_num_rows($result) == 0) {
    $api = "09b5b249087ba046c98e390d3575a2a8";
    $url = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=$cityName&APPID=$api";
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        die("Failed to fetch data from API");
    }
    $data = json_decode($response, true);

    if (isset($data['cod']) && $data['cod'] == 200) {
        $name = $data['name'];
        $humidity = $data['main']['humidity'];
        $wind = $data['wind']['speed'];
        $pressure = $data['main']['pressure'];
        $temperature = $data['main']['temp'];
        $main_condition = $data['weather'][0]['main'];
        $icon = $data['weather'][0]['icon'];
        $condition = $data['weather'][0]['description'];
        $date_time = date('D, M j, Y');
        $windD = $data['wind']['deg'];

        $insertData = "INSERT INTO weather (city, humidity, wind, windD, pressure, temperature, main_condition, icon, condition_details, dt) 
                       VALUES ('$name', '$humidity', '$wind', '$windD', '$pressure', '$temperature', '$main_condition', '$icon', '$condition', '$date_time')";

        if (!mysqli_query($conn, $insertData)) {
            die("Failed to insert data: " . mysqli_error($conn));
        }
    } else {
        die("Invalid API response: " . json_encode($data));
    }
} else {
    $row = mysqli_fetch_assoc($result);
    $lastUpdatedTime = strtotime($row['last_updated']);
    $currentTime = time();
    $timeDifference = $currentTime - $lastUpdatedTime;

    if ($timeDifference > 7200) {
        $api = "09b5b249087ba046c98e390d3575a2a8";
        $url = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=$cityName&APPID=$api";
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            die("Failed to fetch data from API");
        }
        $data = json_decode($response, true);

        if (isset($data['cod']) && $data['cod'] == 200) {
            $name = $data['name'];
            $humidity = $data['main']['humidity'];
            $wind = $data['wind']['speed'];
            $pressure = $data['main']['pressure'];
            $temperature = $data['main']['temp'];
            $main_condition = $data['weather'][0]['main'];
            $icon = $data['weather'][0]['icon'];
            $condition = $data['weather'][0]['description'];
            $date_time = date('D, M j, Y');
            $windD = $data['wind']['deg'];

            $updateData = "UPDATE weather 
                           SET humidity='$humidity', wind='$wind', windD='$windD', pressure='$pressure', temperature='$temperature', 
                               main_condition='$main_condition', icon='$icon', condition_details='$condition', dt='$date_time' 
                           WHERE city='$cityName'";

            if (!mysqli_query($conn, $updateData)) {
                die("Failed to update data: " . mysqli_error($conn));
            }
        } else {
            die("Invalid API response: " . json_encode($data));
        }
    }
}

$result = mysqli_query($conn, $selectAllData);
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

$json_data = json_encode($rows);
header('Content-Type: application/json');
echo $json_data;
?>
<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$conn = mysqli_connect($serverName, $userName, $password);
if (!$conn) {
    die("Failed to connect: " . mysqli_connect_error());
}

// Creating database if it doesn't exist
$createDatabase = "CREATE DATABASE IF NOT EXISTS p3";
if (!mysqli_query($conn, $createDatabase)) {
    die("Failed to create database: " . mysqli_error($conn));
}

// Select the p3 database
mysqli_select_db($conn, 'p3');

// Create weather table if not exists
$createTable = "CREATE TABLE IF NOT EXISTS weather (
    city VARCHAR(100) NOT NULL,
    humidity FLOAT NOT NULL,
    wind FLOAT NOT NULL,
    windD FLOAT NOT NULL,
    pressure FLOAT NOT NULL,
    temperature FLOAT NOT NULL,
    main_condition VARCHAR(100) NOT NULL,
    icon VARCHAR(50) NOT NULL,
    condition_details VARCHAR(100) NOT NULL,
    dt VARCHAR(50) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id INT AUTO_INCREMENT PRIMARY KEY
)";

if (!mysqli_query($conn, $createTable)) {
    die("Failed to create table: " . mysqli_error($conn));
}

$cityName = isset($_GET['q']) ? $_GET['q'] : 'Maidstone';

$selectAllData = "SELECT * FROM weather WHERE city = '$cityName'";
$result = mysqli_query($conn, $selectAllData);

if (mysqli_num_rows($result) == 0) {
    $api = "09b5b249087ba046c98e390d3575a2a8";
    $url = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=$cityName&APPID=$api";
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        die("Failed to fetch data from API");
    }
    $data = json_decode($response, true);

    if (isset($data['cod']) && $data['cod'] == 200) {
        $name = $data['name'];
        $humidity = $data['main']['humidity'];
        $wind = $data['wind']['speed'];
        $pressure = $data['main']['pressure'];
        $temperature = $data['main']['temp'];
        $main_condition = $data['weather'][0]['main'];
        $icon = $data['weather'][0]['icon'];
        $condition = $data['weather'][0]['description'];
        $date_time = date('D, M j, Y');
        $windD = $data['wind']['deg'];

        $insertData = "INSERT INTO weather (city, humidity, wind, windD, pressure, temperature, main_condition, icon, condition_details, dt) 
                       VALUES ('$name', '$humidity', '$wind', '$windD', '$pressure', '$temperature', '$main_condition', '$icon', '$condition', '$date_time')";

        if (!mysqli_query($conn, $insertData)) {
            die("Failed to insert data: " . mysqli_error($conn));
        }
    } else {
        die("Invalid API response: " . json_encode($data));
    }
} else {
    $row = mysqli_fetch_assoc($result);
    $lastUpdatedTime = strtotime($row['last_updated']);
    $currentTime = time();
    $timeDifference = $currentTime - $lastUpdatedTime;

    if ($timeDifference > 7200) {
        $api = "09b5b249087ba046c98e390d3575a2a8";
        $url = "https://api.openweathermap.org/data/2.5/weather?units=metric&q=$cityName&APPID=$api";
        $response = @file_get_contents($url);
        if ($response === FALSE) {
            die("Failed to fetch data from API");
        }
        $data = json_decode($response, true);

        if (isset($data['cod']) && $data['cod'] == 200) {
            $name = $data['name'];
            $humidity = $data['main']['humidity'];
            $wind = $data['wind']['speed'];
            $pressure = $data['main']['pressure'];
            $temperature = $data['main']['temp'];
            $main_condition = $data['weather'][0]['main'];
            $icon = $data['weather'][0]['icon'];
            $condition = $data['weather'][0]['description'];
            $date_time = date('D, M j, Y');
            $windD = $data['wind']['deg'];

            $updateData = "UPDATE weather 
                           SET humidity='$humidity', wind='$wind', windD='$windD', pressure='$pressure', temperature='$temperature', 
                               main_condition='$main_condition', icon='$icon', condition_details='$condition', dt='$date_time' 
                           WHERE city='$cityName'";

            if (!mysqli_query($conn, $updateData)) {
                die("Failed to update data: " . mysqli_error($conn));
            }
        } else {
            die("Invalid API response: " . json_encode($data));
        }
    }
}

$result = mysqli_query($conn, $selectAllData);
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

$json_data = json_encode($rows);
header('Content-Type: application/json');
echo $json_data;
?>
