<?php


namespace Tarzan;


use pocketmine\plugin\PluginBase;
use Tarzan\Custom\TManager;
use Tarzan\Event\PlayerArmor;

class Main extends PluginBase
{
    public static $main;

    public function onLoad()
    {
        $t = new TManager($this);
        $t->init();
        parent::onLoad();
    }

    public function onEnable()
    {
        self::$main = $this;
        $this->getServer()->getPluginManager()->registerEvents(new PlayerArmor(), $this);
        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();
        parent::onEnable();
    }

    public function onDisable()
    {
        parent::onDisable();
    }


    public static function getInstance(): Main
    {
        return self::$main;
    }

}