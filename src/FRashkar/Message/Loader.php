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

use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerJoinEvent, PlayerDeathEvent, PlayerQuitEvent, PlayerPreLoginEvent};
use pocketmine\permission\BanList;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase implements Listener
{
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
        $cause = $player->getLastDamageCause();
        $source = $cause->getCause();
        $deathmsg = $this->getConfig()->get("death-message");
        $deathmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $deathmsg);
        $fallmsg = $this->getConfig()->get("death-fall-message");
        $killmsg = $this->getConfig()->get("death-kill-message");
        $voidmsg = $this->getConfig()->get("death-void-message");
        $sfcmsg = $this->getConfig()->get("death-suffocation-message");
        $lavamsg = $this->getConfig()->get("death-lava-message");
        $drownmsg = $this->getConfig()->get("death-drown-message");
        $exbmsg = $this->getConfig()->get("death-block-message");
        $exemsg = $this->getConfig()->get("death-entity-message");
        
        if($source === EntityDamageEvent::CAUSE_FALL)
        {
            $fallmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $fallmsg);
            $ev->setDeathMessage($fallmsg);
        }
        if($cause instanceof EntityDamageByEntityEvent)
        {
            $killer = $cause->getDamager();
            if($killer instanceof Player)
            {
                $killmsg = str_replace(["{name}", "{online}", "{max-players}", "{killer}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount(), $killer->getName()], $killmsg);
                $ev->setDeathMessage($killmsg);
            }
        }
        if($source === EntityDamageEvent::CAUSE_VOID)
        {
            $voidmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $voidmsg);
            $ev->setDeathMessage($voidmsg);
        }
        if($source === EntityDamageEvent::CAUSE_SUFFOCATION)
        {
            $sfcmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $sfcmsg);
            $ev->setDeathMessage($sfcmsg);
        }
        if($source === EntityDamageEvent::CAUSE_LAVA)
        {
            $lavamsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $lavamsg);
            $ev->setDeathMessage($lavamsg);
        }
        if($source === EntityDamageEvent::CAUSE_DROWNING)
        {
            $drownmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $drownmsg);
            $ev->setDeathMessage($drownmsg);
        }
        if($source === EntityDamageEvent::CAUSE_BLOCK_EXPLOSION)
        {
            $exbmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $exbmsg);
            $ev->setDeathMessage($exbmsg);
        }
        if($source === EntityDamageEvent::CAUSE_ENTITY_EXPLOSION)
        {
            $exemsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getName(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $exemsg);
            $ev->setDeathMessage($exemsg);
        }else{
            //default death message
            $ev->setDeathMessage($deathmsg);
        }
    }

    public function onPreLogin(PlayerPreLoginEvent $ev)
    {
        $player = $ev->getPlayerInfo();
        $info = $this->getServer()->getQueryInformation();
        $wlmsg = $this->getConfig()->get("whitelist-message");
        $sfmsg = $this->getConfig()->get("serverfull-message");
        $banmsg = $this->getConfig()->get("banned-message");
        $wlmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getUsername(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $wlmsg);
        $sfmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getUsername(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $sfmsg);
        $banmsg = str_replace(["{name}", "{online}", "{max-players}"], [$player->getUsername(), $info->getPlayerCount(), $info->getMaxPlayerCount()], $banmsg);
        if(!$this->getServer()->isWhitelisted($player->getUsername()))
        {
            $ev->setKickReason(PlayerPreLoginEvent::KICK_REASON_SERVER_WHITELISTED, $wlmsg);
        }
        if($info->getPlayerCount() > $this->getServer()->getMaxPlayers())
        {
            $ev->setKickReason(PlayerPreLoginEvent::KICK_REASON_SERVER_FULL, $sfmsg);
        }
        if($this->getServer()->getNameBans()->isBanned($player->getUsername()))
        {
            $ev->setKickReason(PlayerPreLoginEvent::KICK_REASON_BANNED, $banmsg);
        }   
    }
}