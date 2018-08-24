# Setting up

## Setting up your environment
First of all, you of course need a server to test your plugins. Setting one up is out of the scope of this tutorial, and there are many guides for doing so out there. Please note that PocketMine does not support 32-bit devices, so even if you do somehow manage to get a server running on your phone, you won't receive support if your plugins aren't working. (Hint: they're not working because you're on an unsupported device!)

Next: writing the code for your plugins. PocketMine doesn't require any specific editor, so you can use whatever code editor or IDE you like best. However, PhpStorm is often considered the most complete IDE for PHP and will facilitate your workflow greatly.

You will want to download the latest PocketMine release from the [Releases page on GitHub](https://github.com/pmmp/PocketMine-MP/releases) and add that as an include path to your project so that your editor can perform auto-completion for the PocketMine API.

## Setting up your plugin
### Choosing a name
It's important to pick a good name for your plugin. It needs to be short yet catchy, and you probably don't want it to be the same name as a plugin that already exists (you can browse [Poggit](https://poggit.pmmp.io) to search through publicly-released plugins). For this tutorial, we'll be making a plugin called `Slogan`. It'll allow administrators to set welcome messages and statuses for their servers.

### Plugin structure
A PocketMine plugin is inside a directory in the `/plugins` directory of the server. At the topmost level of this directory is a `plugin.yml` file that includes information about the plugin, a `src` folder that includes the plugin's code, and an optional `resources` folder that contains files that are not usually PHP code. Examples of these files include config files or `.sql` files.

#### The `src` folder
By convention, directly below the `src` directory is a directory whose name is your GitHub username. Mine is `adeynes`, so we'll use that. Under that is a directory that is your plugin's name, in our case `Slogan`, which contains your code.

Example structure (this is what Slogan will look like at the end of the tutorial!):
```
Slogan/
├── plugin.yml
├── src/
│   └── adeynes/
│       └── Slogan/
│           ├── Slogan.php
│           ├── SloganEventListener.php
│           └── command/
│               ├── SetMotdCommand.php
│               └── SetStatusCommand.php
└── resources/
    ├── config.yml
    └── players.json
```

## Setting up Git
You'll definitely want to use some sort of version control for developing your plugins. Many PocketMine developers use Git, and host their code on GitHub. We'll do that, then.

### Making your first changes locally
To start, we'll want to initialize a Git repository in our plugin's folder (the one under the `plugins/` directory of the server) with the following commands:
```
cd path/to/pocketmine
cd plugins
mkdir Slogan
cd Slogan
git init
```

We'll then make a `plugin.yml` file and a dummy main file (in our case, `Slogan.php`), both of which you can leave blank. We'll also create our `resources` folder, which can also be left empty. We'll get to those later.

This should be our current directory structure:
```
Slogan/
├── plugin.yml
├── src/
│   └── adeynes/
│       └── Slogan/
│           └── Slogan.php
└── resources/
```

### Making a repository on GitHub
Then, you need to create your repository on GitHub. The name should be your plugin's name, and you don't necessarily need to initialize it with a README.

### Pushing your changes
Of course, we need to push our changes to GitHub. To do so, we'll run the following commands:
```
git remote add origin https://github.com/username/repository.git # This sets the remote "origin" to the specified GitHub repository. For us, this would be "git remote add origin https://github.com/adeynes/Slogan.git"
git add * # This adds all your edited files to the staging area
git commit -m "Descriptive commit message"
git push origin master # Pushes your changes to the remote!
```
___

Great! We now have the basic structure for our plugin, both locally and on GitHub. [Next, let's see what actually goes inside all those files!](plugin-yml)