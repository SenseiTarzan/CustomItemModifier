<?php


namespace Tarzan\Custom;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\Player;
use pocketmine\utils\Config;
use Tarzan\Custom\Armor\TArmor;
use Tarzan\Custom\Item\SimpleItem;
use Tarzan\Custom\Item\TAxe;
use Tarzan\Custom\Item\THoe;
use Tarzan\Custom\Item\TPickaxe;
use Tarzan\Custom\Item\TShovel;
use Tarzan\Custom\Item\TSword;
use Tarzan\Main;

class TManager
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Main
     */
    private $plugin;

    /**
     * TManager constructor.
     * @param Main $pl
     */
    public function __construct(Main $pl)
    {
        $this->plugin = $pl;
        $this->config = new Config($pl->getDataFolder() . "config.yml", Config::YAML);

    }

    /**
     *
     */
    public function init()
    {
        $this->ArmorRegister();
        $this->AxeRegister();
        $this->SwordRegister();
        $this->ShovelRegister();
        $this->PickaxeRegister();
        $this->HoeRegister();
        $this->SimpleItemRegister();
       //$this->FoodItemRegister();
        Item::initCreativeItems();
    }

    public function ArmorRegister()
    {
        if ($this->existClass("armor")) {
            foreach ($this->getClassALL("armor") as $name) {
                $item = $this->getSubClassALL("armor", $name);
                ItemFactory::registerItem(new TArmor((int)$item["id"], (int)$item["meta"], $name, (int)$item["dura"], (int)$item["def"]), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

    public function SwordRegister()
    {
        if ($this->existClass("sword")) {
            foreach ($this->getClassALL("sword") as $name) {
                $item = $this->getSubClassALL("sword", $name);
                ItemFactory::registerItem(new TSword((int)$item["id"], (int)$item["meta"], $name, (int)$item["tier"], (int)$item["dura"], (int)$item["attackdamage"]), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

    public function ShovelRegister()
    {
        if ($this->existClass("shovel")) {
            foreach ($this->getClassALL("shovel") as $name) {
                $item = $this->getSubClassALL("shovel", $name);
                ItemFactory::registerItem(new TShovel((int)$item["id"], (int)$item["meta"], $name, (int)$item["tier"], (int)$item["dura"]), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

    public function PickaxeRegister()
    {
        if ($this->existClass("pickaxe")) {
            foreach ($this->getClassALL("pickaxe") as $name) {
                $item = $this->getSubClassALL("pickaxe", $name);
                ItemFactory::registerItem(new TPickaxe((int)$item["id"], (int)$item["meta"], $name, (int)$item["tier"], (int)$item["dura"]), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

    public function AxeRegister()
    {
        if ($this->existClass("axe")) {
            foreach ($this->getClassALL("axe") as $name) {
                $item = $this->getSubClassALL("axe", $name);
                ItemFactory::registerItem(new TAxe((int)$item["id"], (int)$item["meta"], $name, (int)$item["tier"], (int)$item["dura"]), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

    public function HoeRegister()
    {
        if ($this->existClass("hoe")) {
            foreach ($this->getClassALL("hoe") as $name) {
                $item = $this->getSubClassALL("hoe", $name);
                ItemFactory::registerItem(new THoe((int)$item["id"], (int)$item["meta"], $name, (int)$item["tier"], (int)$item["dura"]), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

    public function SimpleItemRegister()
    {
        if ($this->existClass("simpleitem")) {
            foreach ($this->getClassALL("simpleitem") as $name) {
                $item = $this->getSubClassALL("simpleItem", $name);
                ItemFactory::registerItem(new SimpleItem((int)$item["id"], (int)$item["meta"], $name,(int)isset($item["count"]) ? $item["count"] : 64), true);
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }

/*
    public function FoodItemRegister()
    {
        if ($this->existClass("fooditem")) {
            foreach ($this->getClassALL("fooditem") as $name) {
                $item = $this->getSubClassALL("fooditem", $name);
                if ($item["enable_effects"]) {
                    var_dump($item["effects"]);
                    ItemFactory::registerItem(new FoodEffectItem((int)$item["id"], (int)$item["meta"], $name, (int)$item["saturation"], (int)$item["food"], (array)$item["effects"]), true);
                } else {
                    ItemFactory::registerItem(new fooditem((int)$item["id"], (int)$item["meta"], $name, (int)$item["saturation"], (int)$item["food"]), true);
                }
                $this->plugin->getLogger()->info("Resiter §6$name");
            }
        }
    }
*/
    /**
     * @param EntityArmorChangeEvent $event
     */
    public function onChangeArmor(EntityArmorChangeEvent $event)
    {
        $player = $event->getEntity();
        $ItemNew = $event->getNewItem();
        $ItemOld = $event->getOldItem();
        $this->addEffect($ItemNew, $player);
        $this->removeEffect($ItemOld, $player);

    }

    /**
     * @param Item $item
     * @param Entity $entity
     */
    public function removeEffect(Item $item, Entity $entity)
    {
        if ($entity instanceof Player) {
            if ($this->getSubClassExist("armoreffect", $item->getId())) {
                foreach ($this->getSubClassALL("armoreffect", $item->getId()) as $effect => $array) {
                    $entity->removeEffect($effect);
                }
            }
        }
    }

    /**
     * @param Item $item
     * @param Entity $entity
     */
    public function addEffect(Item $item, Entity $entity)
    {
        if ($entity instanceof Player) {
            if ($this->getSubClassExist("armoreffect", $item->getId())) {
                foreach ($this->getSubClassALL("armoreffect", $item->getId()) as $effect => $array) {
                    $entity->addEffect(new EffectInstance(Effect::getEffect($effect), $array["duration"], $array["amplifier"]));
                }
            }
        }
    }

    /**
     * @param string $class
     * @return array
     */
    public function getClassALL(string $class)
    {
        return array_keys($this->config->get($class));
    }

    public function existClass(string $class)
    {
        return $this->config->exists($class);
    }

    /**
     * @param string $class
     * @param string $subclass
     * @return mixed
     */
    public function getSubClassALL(string $class, string $subclass)
    {
        return $this->config->get($class)[$subclass];
    }

    /**
     * @param string $class
     * @param string $subclass
     * @return bool
     */
    public function getSubClassExist(string $class, string $subclass)
    {
        return isset($this->config->get($class)[$subclass]);
    }

}
