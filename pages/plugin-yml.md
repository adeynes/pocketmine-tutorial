# `plugin.yml`

The `plugin.yml` file is at the top level of your plugin directory. It contains information about your plugin, such as the name, main class, and minimum required PocketMine API version. There are many attributes that you can use, but these are the most common, required ones:
* `name`: your plugin's name; in our case, `Slogan`.
* `main:`: your plugin's fully-qualified class name; in our case, `adeynes\Slogan\Slogan`. You don't need to include `src` in there, PocketMine knows that our code is in that folder. This class must be a subclass of `pocketmine\plugin\PluginBase`.
* `version`: your plugin's version. You should follow [semantic versioning](https://semver.org/). In our case, we will start with `0.1.0` during development and bump it to `1.0.0` once our plugin is feature-complete.
* `api`: the minimum PocketMine API version that your plugin requires. As of now (2018-08-22), many plugins use `3.0.0`, even though the latest PocketMine release is `3.1.4`. However, plugins that use new features and bug fixes from after `3.0.0` will require that version number. If our plugin relies on a bug fix from `3.0.8`, we would require `3.0.8`. Plugins will still load if the PocketMine minor or patch versions are higher than required, but not if the major version is.
* `author` or `authors`: the author(s) of your plugin. The former is a string, while the latter is an array. You would usually put your GitHub username, in our case `adeynes`.
* `commands`: the commands that your plugin introduces. This is an array with each command's name as the key, and the description and permission as the value. We'll cover this more in-depth later.
* `permissions`: the permissions for your plugin. These are usually referenced by the `permission` field of each command.

## `commands`
Code speaks more than words, so this is how the `commands` attribute looks:
```yaml
commands:
  setmotd:
    description: "Set the message that will be sent to players when they join"
    permission: slogan.command.setmotd
  setstatus:
    description: "Set the status that will be displayed on the server's query response and as a popup to players"
    permission: slogan.command.setstatus
```

## `permissions`
The `permission` attribute is a list of permissions with a description and a default authorization (usually `true` or `op`, depending on if you want the permission to be given to every player or just OPs). Permissions can be nested, such that if a player has a parent permission, they also have child permissions.
```yaml
permissions:
  slogan:
    description: "Allows for the use of all Slogan features"
    default: op
    children:
      slogan.command: "Allows for the use of all Slogan commands"
      default: op
      children:
        slogan.command.setmotd:
          description: "Allows for setting the server's MOTD"
          default: op
        slogan.command.setstatus:
          description: "Allows for setting the server's status"
          default: op
```

## Slogan's `plugin.yml`
Putting all this information together, this is what Slogan's `plugin.yml` would hypothetically look like:
TODO: gist link