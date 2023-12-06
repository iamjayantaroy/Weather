<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $city = $_POST['city'];

    // Make API request to OpenWeatherMap
    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Extract relevant data
    $temperature_kelvin = $data['main']['temp'];
    $description = $data['weather'][0]['description'];


    // Convert temperature to Celsius and Fahrenheit
    $temperature_celsius = $temperature_kelvin - 273.15;
    $temperature_fahrenheit = ($temperature_kelvin - 273.15) * 9 / 5 + 32;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Weather Website</title>
</head>
<body>
    <div class="container">
        <h1>Weather Website</h1>

        <form method="post">
            <label for="city">Enter City:</label>
            <input type="text" name="city" required>
            <button type="submit">Get Weather</button>
        </form>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($temperature_kelvin)): ?>
            <div class="result">
                <p>Temperature: <?php echo round($temperature_celsius, 2); ?> &#8451; / <?php echo round($temperature_fahrenheit, 2); ?> &#8457;</p>
                <p>Description: <?php echo $description; ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
