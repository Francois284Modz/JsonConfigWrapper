<?php

/**
 * Class JsonConfigWrapper
 *
 * A class for managing a JSON configuration file, providing methods for reading, updating,
 * adding, retrieving, and deleting configuration settings with caching support.
 */
class JsonConfigWrapper {
    private $configFile;
    private $autoCreate;
    private $cacheFile;

    /**
     * Constructor for the JsonConfigWrapper class.
     *
     * @param string $configFile Path to the JSON configuration file.
     * @param bool $autoCreate If true, automatically create the JSON file if it doesn't exist.
     * @param string $cacheFile Path to the cache file for storing configuration data.
     */
    public function __construct($configFile, $autoCreate = true, $cacheFile = 'config.cache.json') {
        $this->configFile = $configFile;
        $this->autoCreate = $autoCreate;
        $this->cacheFile = $cacheFile;
    }

    /**
     * Read the JSON configuration file and return its contents as an associative array.
     *
     * @return array Associative array containing the configuration settings.
     * @throws Exception If autoCreate is false and the configuration file is not found.
     */
    public function read() {
        if (file_exists($this->cacheFile)) {
            // Check if the cache file exists
            $cacheData = file_get_contents($this->cacheFile);
            return json_decode($cacheData, true);
        }

        if (file_exists($this->configFile)) {
            $configData = file_get_contents($this->configFile);
            $configArray = json_decode($configData, true);

            // Cache the configuration data in the cache file
            file_put_contents($this->cacheFile, json_encode($configArray, JSON_PRETTY_PRINT));

            return $configArray;
        } elseif ($this->autoCreate) {
            $this->update(array());
            return array();
        } else {
            throw new Exception("Configuration file '{$this->configFile}' not found.");
        }
    }

    /**
     * Update the JSON configuration file with the provided data.
     *
     * @param array $configData An associative array containing the updated configuration settings.
     */
    public function update($configData) {
        $jsonConfig = json_encode($configData, JSON_PRETTY_PRINT);
        file_put_contents($this->configFile, $jsonConfig);

        // Update the cache file with the new configuration data
        file_put_contents($this->cacheFile, $jsonConfig);
    }


    /**
     * Retrieve the value associated with a specific key from the configuration.
     *
     * @param string $key The key for the configuration setting to retrieve.
     * @return mixed|string The value associated with the key, or an error message if not found.
     */
    public function retrieve($key) {
        $configData = $this->read();
        if (isset($configData[$key])) {
            return $configData[$key];
        } else {
            return "Value ('$key') was not found";
        }
    }

    /**
     * Retrieve a value from the configuration using a nested key path.
     *
     * @param string $keyPath The key path to the desired value, e.g., "Settings.website.name".
     * @return mixed|string The retrieved value or an error message if not found.
     */
    public function retrieveNested($keyPath) {
        $configData = $this->read();
        $keys = explode('.', $keyPath);

        foreach ($keys as $key) {
            if (isset($configData[$key])) {
                $configData = $configData[$key];
            } else {
                return "Value ('$keyPath') was not found";
            }
        }

        return $configData;
    }


    /**
     * Create or update a key-value pair in the configuration.
     *
     * @param string $key The key for the configuration setting to create or update.
     * @param mixed $value The value to set for the configuration setting.
     * @return string Error message or success message.
     */
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

}
