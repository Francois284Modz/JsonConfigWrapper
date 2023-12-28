
# JSON Configuration Wrapper

This simple PHP class, `JsonConfigWrapper`, allows you to easily manage a JSON configuration file by providing methods for reading, updating, adding, and deleting configuration settings.

## Usage

1. Include the `JsonConfigWrapper` class in your PHP project:

   ```php
   include 'JsonConfigWrapper.php';

2.Initialize the JsonConfigWrapper with the path to your JSON configuration file:

```php
$configFile = 'config.json';
$configWrapper = new JsonConfigWrapper($configFile);
```

3.Read the configuration settings:
```php
$configData = $configWrapper->read();
```
4. Retrieve a specific configuration setting:
   ```php
   $websiteName = $configWrapper->retrieve('name');
   ```
5. Modify a specific configuration setting:
   ```php
   $configWrapper->create('name', 'New Website Name');
   ```
6. Delete a specific configuration setting:
   ```php
   $configWrapper->delete('name');
   ```
   7.Update the configuration
```php
   settings:$configData['title'] = 'New Website Title';
$configWrapper->update($configData);
```
##Example

```php
// Initialize the wrapper with the path to your JSON config file
$configFile = 'config.json';
$configWrapper = new JsonConfigWrapper($configFile);

// Read the configuration settings
$configData = $configWrapper->read();

// Retrieve a specific configuration setting
$websiteName = $configWrapper->retrieve('name');

// Modify a specific configuration setting
$configWrapper->create('name', 'New Website Name');

// Delete a specific configuration setting
$configWrapper->delete('name');

// Update the configuration settings
$configData['title'] = 'New Website Title';
$configWrapper->update($configData);
```

This class makes it easy to manage your JSON configuration file dynamically within your PHP application.Feel free to customize the usage instructions and example as needed for your specific project.
