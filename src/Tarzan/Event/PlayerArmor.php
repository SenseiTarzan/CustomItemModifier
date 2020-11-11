<?php


namespace Tarzan\Event;


use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\event\Listener;
use Tarzan\Custom\TManager;
use Tarzan\Main;

class PlayerArmor implements Listener
{
    public function onPlayerArmorChange(EntityArmorChangeEvent $event){
        $events = new TManager(Main::getInstance());
        $events->onChangeArmor($event);
    }
}