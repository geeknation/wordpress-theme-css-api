<?php
$themeApiUrl = 'http://localhost/wordpress/wp-json/wp/v2/themes'; // Replace with your WordPress site URL and API endpoint

$username = 'apiUser'; // Replace with your WordPress username
$password = 'l6Y2 ZGg8 9qJo e7HC 66WA YumK'; // Replace with your WordPress Application password

// Create a stream context with basic authentication headers
$auth = base64_encode($username . ':' . $password);
$context = stream_context_create([
    'http' => [
        'header' => "Authorization: Basic $auth"
    ]
]);

// Make the API request
$response = file_get_contents($themeApiUrl, false, $context);

// Check for errors
if ($response === false) {
    die('Error fetching theme data.');
}

// Process the response
$themes = json_decode($response, true);
if ($themes === null) {
    die('Error decoding JSON response.');
}

// echo json_encode($themes[0],JSON_UNESCAPED_SLASHES) ;
// echo json_encode($themes,JSON_UNESCAPED_SLASHES);
// Output the theme data

$siteThemes = [];
$themeProfile =[];

foreach ($themes as $theme) {
    // echo 'Theme Name: ' . $theme['name']['raw'] . '<br>';
    // echo 'Version: ' . $theme['version'] . '<br>';
    // echo 'Status: ' . $theme['status'] . '<br>';
    // echo 'Author: ' . $theme['author']['raw'] . '<br><br>';

    
    $themeProfile = [
        $theme['name']['raw'],
        $theme['version'],
        $theme['status'],
        $theme['author']['raw'],
        $theme['stylesheet']
                
    ];
    array_push($siteThemes, $themeProfile);

}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($siteThemes);

?>
