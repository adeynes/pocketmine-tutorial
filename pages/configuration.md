# Configuration

Plugin developers generally store configuration options in YAML files, namely `config.yml`. Any file name and type can be used, but PocketMine provides a `Config` class that's great at parsing YAML, and `PluginBase` has methods already written for you to handle the `config.yml` file.

## Resources
Before we get started writing code, we need to understand the concept of resources. A resource is any file that is in the `resources` folder. Configuration files are resources, .sql files often are as well, and so are many SQLite databases and JSON files.

When your plugin is loaded in folder form, the `resources` folder is a sibling of the `src` directory. However, when a plugin is distributed for production, it is in `.phar` format. This means that the concept of directories does not exist anymore, and everything is packaged into one file. So how do you access your resources? PocketMine creates a folder in the `plugins` folder (since 3.1.4, in the `plugin_data` folder for new installations) whose name is your plugin's name (for us, `Slogan`), that will contain your plugin's resources.

The directory structure now looks like this with packaged plugins:
```
plugins/
├── Slogan.phar
├── Slogan/
    ├── config.yml
    └── players.sql
```
Or, since PocketMine 3.1.4:
```
plugins/
├── Slogan.phar

plugin_data/
├── Slogan/
    ├── config.yml
    └── players.sql
```

### Saving resources
Here's the thing, though: PocketMine won't automatically copy your resources into your plugin's folder. For that, you'll need to call `$this->saveResource('resource name')`. This will copy the resource into the folder, and it will be in the same state as when you were developing your plugin.

## Slogan's resources
Right now, Slogan logs a message to the console when it gets enabled. Let's give server owners the ability to customize that message. We'll have an option in `config.yml` to configure that.

Here's how our `config.yml` will look:
```yaml
enable-message: 'Slogan has been enabled!'
```

Users will be able to edit `config.yml` and put whatever message they want. Great, let's implement this.

First, we need to put our `config.yml` file into the `resources` folder. We'll end up with the following directory structure:
```
Slogan/
├── plugin.yml
├── src/
│   └── adeynes/
│       └── Slogan/
│           └── Slogan.php
└── resources/
    └── config.yml
```

Now, let's edit `Slogan.php`. I'll just include the `onEnable` function, the rest will stay the same:

```php
public function onEnable(): void
{
    // $this->getDataFolder() returns the folder where we'll store our plugin's resources
    // This checks that it doesn't already exist before we attempt to create it
    if (!is_dir($this->getDataFolder()) {
        // Create the folder where we'll store our resources
        // You might see plugins put @ in front of this, as in @mkdir(...). It suppresses error messages
        // You probably shouldn't do that, as the user needs to be informed if something goes wrong (a likely cause would be insufficient permissions)
        mkdir($this->getDataFolder());
    }
    
    // This is the equivalent of $this->saveResource('config.yml'). PluginBase provides this function for us
    // If we're in a .phar, it will copy our config.yml resource over to Slogan's data folder
    $this->saveDefaultConfig();
    
    // Instead of logging a hardcoded message, we now retrieve the enable-message attribute from the config and log that
    // $this->getConfig() returns a Config instead, which has a `get` method to retrieve the specified value
    $this->getServer()->getLogger()->notice(
        $this->getConfig()->get('enable-message)
    );
}
```

If we edit our config, Slogan will now log whatever we put there.

Amazing, now let's commit our changes:
```
git add *
git commit -m "Add ability to customize enable message"
git push origin master
```
From now on, you should remind yourself to commit your progress after every significant change (you don't have to push after every commit, you can do that at the end of your coding session).
___

Each server can now customize the enable message. [Next, we'll add commands so that it can be changed in-game or from the console directly](commands)