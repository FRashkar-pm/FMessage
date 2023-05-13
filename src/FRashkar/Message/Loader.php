<?php

/**
*  ______ _____           _     _                                     
* |  ____|  __ \         | |   | |                                    
* | |__  | |__) |__ _ ___| |__ | | ____ _ _ __ ______ _ __  _ __ ___  
* |  __| |  _  // _` / __| '_ \| |/ / _` | '__|______| '_ \| '_ ` _ \ 
* | |    | | \ \ (_| \__ \ | | |   < (_| | |         | |_) | | | | | |
* |_|    |_|  \_\__,_|___/_| |_|_|\_\__,_|_|         | .__/|_| |_| |_|
*                                                    | |              
*                                                    |_|              
* The author of this plugin is FRashkar-pm
* https://github.com/FRashkar-pm
* Discord: FireRashkar#1519
*/

namespace FRashkar\Message;

use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerJoinEvent, PlayerDeathEvent, PlayerQuitEvent};
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener
{

    /** @var string */
    public $joinmsg;

    /** @var string */
    public $quitmsg;

    /** @var string */
    public $deathmsg;

    public function onLoad(): void
    {
        $this->saveDefaultConfig();
    }

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $ev)
    {
        $info = $this->getServer()->getQueryInformation();
        $player = $ev->getPlayer();
        $joinmsg = $this->getConfig()->get("join-message");
        $joinmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $joinmsg);
        $ev->setJoinMessage($joinmsg);
    }

    public function onQuit(PlayerQuitEvent $ev)
    {
        $info = $this->getServer()->getQueryInformation();
        $player = $ev->getPlayer();
        $quitmsg = $this->getConfig()->get("quit-message");
        $quitmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $quitmsg);
        $ev->setQuitMessage($quitmsg);
    }

    public function onDeath(PlayerDeathEvent $ev)
    {
        $info = $this->getServer()->getQueryInformation();
        $player = $ev->getPlayer();
        $deathmsg = $this->getConfig()->get("death-message");
        $deathmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $deathmsg);
        $ev->setDeathMessage($deathmsg);
    }
}