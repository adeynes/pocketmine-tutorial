# Events

Event-driven programming is a way to control the flow of a program through events. In PocketMine, those events are anything from the server getting queries to an entity spawning to a player being caught cheating. (You can even make your own!) Any class that implements the `pocketmine\event\Listener` interface can subscribe to certain events and run code when that happens.

## Registering an event listener
To keep our code clean, let's create a `SloganEventListener.php` file, next to `Slogan.php`. This is how our directory tree should look:
```
Slogan/
├── plugin.yml
├── src/
│   ├── adeynes/
│       ├── Slogan/
│           ├── Slogan.php
│           └── SloganEventListener.php
└── resources/
    └── config.yml
```

Let's write just enough code to make our event listener technically correct:

```php
<?php
declare(strict_types=1);

namespace adeynes\SLogan;

use pocketmine\event\Listener;
// We don't need to use adeynes\Slogan\Slogan since we're in the same namespace

// Like with our Slogan class, let's make this one final so that it can't be extended: we should never need to do that
// We implement Listener because PocketMine requires any event listeners to do that
final class SloganEventListener implements Listener
{
    
    // We declare a $plugin property and add a PhpDoc specifying its type so that our IDE can help with code completion
    // It's private so that other classes don't access it directly, we want them to use getPlugin() instead
    /** @var Slogan */
    private $plugin;
    
    // We'll pass in our Slogan instance when we make a new SloganEventListener so that we can easily get access to our plugin's API
    public function __construct(Slogan $plugin) {
        // Assign the $plugin variable to the plugin property
        $this->plugin = $plugin;
    }
    
    // It's always a good idea to have getters and use $this->getPlugin() instead of $this->plugin
    // The ": Slogan" means that we're returning an instance of Slogan
    public function getPlugin(): Slogan
    {
        return $this->plugin;
    }
    
}
```

We now have an event listener that PocketMine will let us register. Let's register it, then. This will happen in Slogan's `onEnable()` method, since we want to register the listener as soon as the plugin is enabled.

```php
public function onEnable(): void
{
    // We'll put the console enable message code at the very end so that it won't run until everything is completed
    // (the plugin wouldn't /really/ be enabled if there was an error)
    
    // We use Server::getPluginManager() to get the server's plugin manager, which is where we'll register our event listener
    // We then call PluginManager::registerEvents() and pass it a new instance of SloganEventListener, to which we passed
    // $this, our Slogan instance. We also need to pass our plugin instance as the second parameter to registerEvents()
    $this->getServer()->getPluginManager()->registerEvents(new SloganEventListener($this), $this);
    
    // Enable message code is down here
}
```

Our event listener is now registered. Now let's listen to some events.

To start, let's send players the server's MOTD when they join. We'll need an attribute for it in our config.

`config.yml:`
```yaml
enable-message: 'Slogan has been enabled!'
motd: 'Welcome to the server!'
```

Now, we'll add a handler for PlayerJoinEvent in our listener:

```php
<?php
declare(strict_types=1);

namespace adeynes\SLogan;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

final class SloganEventListener implements Listener
{
    
    /** @var Slogan */
    private $plugin;
    
    public function __construct(Slogan $plugin) {
        $this->plugin = $plugin;
    }
    
    public function getPlugin(): Slogan
    {
        return $this->plugin;
    }
    
    // This is our handler for PlayerJoinEvent. Whenever that event is called (when a player joins),
    // PocketMine will call our onJoin() method and pass it the event
    // The name of the function doesn't matter, only that the first argument is PlayerJoinEvent
    public function onJoin(PlayerJoinEvent $event): void
    {
        // We assign the event's player to the $player variable
        // See, it has a getter for the player, we don't just do $event->player
        $player = $event->getPlayer();
        
        // We get the motd attribute of our plugin's config and send that to the player
        $player->sendMessage(
            $this->getPlugin()->getConfig()->get('motd')
        );
    }
    
}
```

We've added a new feature, so let's bump the version to `0.2.0` in `plugin.yml`.

That was a lot to take in. If you haven't grasped everything yet, study the code for as long as you need until you firmly understand it. [Let's now see how we can use commands to let administrators edit the MOTD in-game](commands)

P.S. remember to commit your changes!