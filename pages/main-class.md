# The plugin's main class

Your plugin's main class is one that `extends pocketmine\plugin\PluginBase`.

When PocketMine loads your plugin, it will call the `onLoad()` method of your main class. Then, when it enables it, PocketMine will call the `onEnable()` method.

Let's see what a dummy main class would look like for Slogan:

```php
<?php
// This prevents PHP from juggling between types and promotes type safety
declare(strict_types=1);

// This makes our fully-qualified class name adeynes\Slogan\Slogan, which is what we said our main class was in plugin.yml
namespace adeynes\Slogan;

// This use statement means we can just type PluginBase instead of \pocketmine\plugin\PluginBase
use pocketmine\plugin\PluginBase;

// Extending PluginBase does two things: (1) it allows the plugin to load (plugins must implement the Plugin interface, and PluginBase does that)
// (2) it gives us access to many methods to make our life easier like getServer() and getConfig()
class Slogan extends PluginBase
{
    
}
```

That's it. PocketMine will load this just fine; Slogan is now a fully valid plugin. Except it doesn't do anything.

## `onLoad()` and `onEnable()`
As discussed above, `onLoad()` is run when your plugin is loaded, and `onEnable()` when it is enabled. All plugins are loaded by PocketMine before any of them get enabled. For most purposes, you'll want to put startup code in `onEnable()` rather than `onLoad()`. Let's edit `Slogan.php` and display a message in the console when Slogan enables.

```php
<?php
declare(strict_types=1);

use pocketmine\plugin\PluginBase;

class Slogan extends PluginBase
{
    
    // the ": void" means that the function won't return anything. (onEnable()'s return value wouldn't do anything, so returning something would be useless)
    // PHP will catch a potential bug if we mistakenly return something even though we're not supposed to
    public function onEnable(): void
    {
        // $this->getServer() returns the Server instance, which is the overseer of everything that happens inside our server
        // Server::getLogger() then returns the server's logger, and the notice() method on that logger sends a message to the console
        $this->getServer()->getLogger()->notice('Slogan has been enabled!');
    }
    
}
```

When we run our server, Slogan will now output "Slogan has been enabled!" when PocketMine enables it. This is version `0.1.0` of our plugin. Congrats!

Let's commit our changes:
```
git add *
git commit -m "Log message to console on startup"
git push origin master
```
___

This is lovely, but what good is a plugin if you can't customize it? [Next, we'll look at how to use configuration files to let server owners change the way Slogan works.](configuration)