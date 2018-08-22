<?php
declare(strict_types=1);

namespace examples;

use pocketmine\plugin\PluginBase;

class PluginBaseExample extends PluginBase
{

    public function onEnable(): void
    {
        $this->getServer()->getLogger()->log('Enabled!');
    }

}