<?php


namespace Tarzan\Custom\Armor;


use pocketmine\item\Armor;
use pocketmine\utils\TextFormat;

class TArmor extends Armor
{

    private $dura;
    private $def;

    public function __construct(int $id, int $meta, string $name, int $dura, int $def)
    {
        $this->dura = $dura;
        $this->def = $def;
        parent::__construct($id, $meta, $name);
    }

    public function getMaxDurability(): int
    {
        return $this->dura;
    }

    public function getDefensePoints(): int
    {
        return $this->def;
    }


    public function applyDamage(int $amount): bool
    {

        if($this->isUnbreakable() or $this->isBroken()){
        return false;
    }

        $amount -= $this->getUnbreakingDamageReduction($amount);

        $this->meta = min($this->meta + $amount, $this->getMaxDurability());
        if($this->isBroken()){
            $this->onBroken();
        }
        $durability = $this->getMaxDurability() - $this->getDamage();
        $txt = TextFormat::GRAY .$durability . "/" . TextFormat::DARK_GRAY .$this->getMaxDurability();
        $this->setLore([$txt]);
        return true;
    }


}