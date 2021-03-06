<?php


namespace Tarzan\Custom\Item;


use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Food;

class FoodEffectItem extends Food
{
    private $saturation;
    private $food;
    /**
     * @var array
     */
    private $effect;

    public function __construct(int $id, int $meta, string $name, int $saturation, int $food, array $effect)
    {
        $this->saturation = $saturation;
        $this->food = $food;
        $this->effect = $effect;
        $this->getAdditionalEffects();
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

    public function getAdditionalEffects(): array
    {
        $test = [];
        foreach ($this->effect as $effect => $array){
            $test[] = new EffectInstance(Effect::getEffect($effect),$array["duration"],$array["amplifier"]);
        }
        var_dump($test);
        return $test; // TODO: Change the autogenerated stub
    }
}