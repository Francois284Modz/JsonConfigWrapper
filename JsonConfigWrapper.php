<?php
class JsonConfigWrapper {
    private $configFile;

    public function __construct($configFile) {
        $this->configFile = $configFile;
    }

    // Read the JSON configuration file and return its contents as an associative array
    public function read() {
        if (file_exists($this->configFile)) {
            $configData = file_get_contents($this->configFile);
            return json_decode($configData, true);
        } else {
            return array(); // Return an empty array if the file doesn't exist
        }
    }

    // Update the JSON configuration file with the provided data
    public function update($configData) {
        $jsonConfig = json_encode($configData, JSON_PRETTY_PRINT);
        file_put_contents($this->configFile, $jsonConfig);
    }

    // Retrieve the value associated with a specific key from the configuration
    public function retrieve($key) {
        $configData = $this->read();
        if (isset($configData[$key])) {
            return $configData[$key];
        } else {
            return "Value ('$key') was not found";
        }
    }

    // Create or update a key-value pair in the configuration
    public function create($key, $value) {
        $configData = $this->read();
        if (isset($key) && !empty($key)) {
            $configData[$key] = $value;
            $this->update($configData);
            return "Value ('$key') created or updated successfully";
        } else {
            return "Invalid key ('$key') provided";
        }
    }

    // Delete a key-value pair from the configuration
    public function delete($key) {
        $configData = $this->read();
        if (isset($configData[$key])) {
            unset($configData[$key]);
            $this->update($configData);
        } else {
            return "Value ('$key') was not found";
        }
    }
}

