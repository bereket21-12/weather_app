<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Weather App</title>
</head>
<body>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted using POST method

    // Retrieve the value from the input field
    $city = $_POST["userInput"];

    // Use the user input in PHP code
    // echo "<p>You entered: $city</p>";
}else{
    $city = 'Ethiopia';
}
// Replace 'YOUR_API_KEY' with your actual API key
$apiKey = '07b6a1b5ae3f4584a52132403232811';
  // Replace with the desired city
$numberOfDays = 1;

// Build the API URL
$apiUrl = "http://api.worldweatheronline.com/premium/v1/weather.ashx?key={$apiKey}&q={$city}&format=json&num_of_days={$numberOfDays}";

// Fetch data from the API
$response = file_get_contents($apiUrl);

// Check for errors in the response
if ($response === false) {
    die('Error fetching data from the World Weather Online API. Check your internet connection.');
}

// Decode the JSON response
$data = json_decode($response, true);

// Check if the response was successfully decoded
if ($data === null) {
    die('Error decoding JSON data from the World Weather Online API.');
}

// Check for API errors
if (isset($data['data']['error'])) {
    die('World Weather Online API Error: ' . $data['data']['error'][0]['msg']);
}

for ($i=0; $i <12 ; $i++) { 
    # code...
  $month =   $data['data']['ClimateAverages'][0]['month'][1]['name'];
}

$img = $data['data']['current_condition'][0]['weatherIconUrl'][0]['value'];
?>
    <div class="weather-container">
        <h1>Weather App</h1>
        <form method="post" action="
        <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="countryInput">Enter Country:</label>
            <input value =<?php echo $city;?>  type="text" id="countryInput"  name="userInput" placeholder="Enter country...">
            <button type="submit" onclick="getWeather()">Get Weather</button>
        </form>
        <div id="weatherResult" class="">
            <h2>Weather Details</h2>
            <span><image src="<?php echo $img; ?>" ></span>

            <p><strong>Average Temperature:</strong> <span id="currentTemp">
                 <?php

                    echo "<span>" . $data['data']['weather'][0]['avgtempC'] . "</span>";
                 ?>
              </span>&deg;C</p>

              <p><strong>Min Temperature:</strong> <span id="currentTemp">
                 <?php

                    echo "<span>" . $data['data']['weather'][0]['mintempC'] . "</span>";
                 ?>
              </span>&deg;C</p>

              <p><strong>Max Temperature:</strong> <span id="currentTemp">
                 <?php

                    echo "<span>" . $data['data']['weather'][0]['maxtempC'] . "</span>";
                 ?>
              </span>&deg;C</p>

              <p><strong>Country Name:</strong> <span id="currentTemp">
                 <?php

                    echo "<span>" . $data['data']['request'][0]['query']. "</span>";
                 ?>
              </span></p>
            <p><strong>Current Date:</strong> <span id="currentDate"> 
            <?php

                 echo "<span>" . $data['data']['weather'][0]['date']. "</span>";
            ?>
            </span></p>
            <p><strong>Weather Description:</strong>
             <span id="weatherDesc">
                <?php
             echo "<span>". $data['data']['current_condition'][0]['weatherDesc'][0]['value']. "</span>";
             ?>
             </span></p>

            <h2>Average Temperatures for Each Month</h2>
            <ul id="averageTemps">
                <?php
                
                echo "<table>";
                echo "<tr><th>Month</th><th>Temperature (°C)</th></tr>";
            
                // Simulate average temperatures for each month (replace with actual data)
                $averageTemps = [20, 22, 25, 28, 30, 32, 34, 30, 28, 25, 22, 20];
            
                for ($i=0; $i <12 ; $i++) {
                    echo "<tr>";
                    echo "<td>" . $data['data']['ClimateAverages'][0]['month'][$i]['name'] . "</td>"; // Display month names
                    echo "<td>{$data['data']['ClimateAverages'][0]['month'][$i]['avgMinTemp']}</td>";
                    echo "</tr>";
                }
            
                echo "</table>";
                ?>
            </ul>
        </div>
    </div>

    <script src="app.js"></script>
</body>
</html>
