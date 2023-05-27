<?php
$siteUrl = 'http://localhost/wordpress'; // Replace with your WordPress site URL

$username = 'apiUser'; // Replace with your WordPress username
$password = 'l6Y2 ZGg8 9qJo e7HC 66WA YumK'; // Replace with your WordPress password

// Set the API endpoint URL
$apiUrl = $siteUrl . '/wp-json/wp/v2/themes';

// Set the cURL options
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Authorization: Basic ' . base64_encode($username . ':' . $password)
]);

// Make the API request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    die('Error: ' . curl_error($ch));
}

// Close cURL
curl_close($ch);

// Decode the JSON response
$themes = json_decode($response, true);
// header('Content-Type: application/json; charset=utf-8');
// echo json_encode($themes,JSON_UNESCAPED_SLASHES);exit();
// Find the active theme
$activeTheme = null;
foreach ($themes as $theme) {
    if ($theme['status']=="active") {
        $activeTheme = $theme;
        break;
    }
}

// Check if active theme found
if ($activeTheme === null) {
    die('Active theme not found.');
}
// header('Content-Type: application/json; charset=utf-8');
// echo json_encode($activeTheme,JSON_UNESCAPED_SLASHES);exit();
// Get the stylesheet URL of the active theme
$stylesheetUrl = $apiUrl ."/". $activeTheme['stylesheet'];


// Initialize cURL for fetching the stylesheet
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $stylesheetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . base64_encode($username . ':' . $password)
]);

// Fetch the stylesheet content
$stylesheetContent = curl_exec($ch);

// Check for errors
if ($stylesheetContent === false) {
    die('Error: ' . curl_error($ch));
}

// Close cURL
curl_close($ch);


function stdClassToArray($stdClassObject) {
    if (is_object($stdClassObject)) {
        $stdClassObject = (array)$stdClassObject;
    }

    if (is_array($stdClassObject)) {
        $convertedArray = array();

        foreach ($stdClassObject as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $convertedArray[$key] = stdClassToArray($value);
            } else {
                $convertedArray[$key] = $value;
            }
        }

        return $convertedArray;
    } else {
        return $stdClassObject;
    }
}



$respArr = stdClassToArray(json_decode($stylesheetContent));
//header('Content-Type: application/json; charset=utf-8');
// echo json_encode($respArr['_links'],JSON_UNESCAPED_SLASHES);

$stylesheet = $respArr['_links']['wp:user-global-styles'][0]['href'];

echo $stylesheet; 
?>
