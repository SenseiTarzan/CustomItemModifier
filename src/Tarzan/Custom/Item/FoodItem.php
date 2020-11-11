<?php


namespace Tarzan\Custom\Item;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Food;

class FoodItem extends Food
{
    private $saturation;
    private $food;
    /**
     * @var array|null
     */
    private $effect;

    public function __construct(int $id, int $meta, string $name, int $saturation, int $food)
    {
        $this->saturation = $saturation;
        $this->food = $food;
        parent::__construct($id, $meta, $name);
    }
    public function getFoodRestore(): int
    {
       return $this->saturation;
    }

    public function getSaturationRestore(): float
    {
        return $this->food;
    }
}