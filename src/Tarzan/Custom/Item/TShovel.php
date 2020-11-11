<?php


namespace Tarzan\Custom\Item;


use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\item\Shovel;
use pocketmine\utils\TextFormat;

class TShovel extends Shovel
{
    private $maxdura = 0;

    public function __construct(int $id, int $meta, string $name, int $tier, int $maxdura)
    {
        $this->maxdura = $maxdura;
        parent::__construct($id, $meta, $name, $tier);
    }

    /**
     * @return int
     */
    public function getMaxDurability(): int
    {
        return $this->maxdura;
    }

    public function onDestroyBlock(Block $block) : bool{
        if($block->getHardness() > 0){
            return $this->applyDamage(1);
        }
        return false;
    }

    public function onAttackEntity(Entity $victim) : bool{
        return $this->applyDamage(2);
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