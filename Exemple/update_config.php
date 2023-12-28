<?php
include 'JsonConfigWrapper.php';

// Initialize the wrapper with the path to your JSON config file
$configFile = 'config.json';
$configWrapper = new JsonConfigWrapper($configFile);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and update the configuration settings
    $newName = $_POST['name'];
    $newTitle = $_POST['title'];
    
    $configWrapper->create('name', $newName);
    $configWrapper->create('title', $newTitle);
    
    // Redirect back to the editing page or another desired page
    header('Location: edit_config.php');
    exit();
}
?>
