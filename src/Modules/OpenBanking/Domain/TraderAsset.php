<?php

namespace Bancario\Modules\OpenBanking\Domain;

use Muleta\Modules\Generic\Domain\Container\InvalidMoneyValue;
use Muleta\Modules\Generic\Domain\Container\NotEnoughMoneyToRemove;

class TraderAsset extends Asset
{
    /**
     * @var float
     */
    private $value;

    public function __construct(Asset $asset, float $value)
    {
        parent::__construct(
            $asset->getId(),
            $asset->getName()
            // $asset->getDescription(),
            // $asset->getImageFilePath(),
            // $asset->getType(),
            // $asset->getEffects(),
            // $asset->getPrice(),
            // $asset->getPrototypeId(),
            // $asset->getCreatorCharacterId()
        );

        if ($value < 0)
        {
           throw new InvalidMoneyValue('Negative asset amount not allowed');
        }
 
        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function withdraw(float $value)
    {
        if ($this->getValue() < $value) {
            throw new NotEnoughMoneyToRemove('Cannot remove more asset than there is');
        }
        $this->value = $this->getValue() - $value;
    }

    public function deposit(float $value)
    {
        $this->value = $this->getValue() + $value;
    }

    public function toBaseAsset(): Asset
    {
        return new Asset(
            $this->getId(),
            $this->getName()
            // $this->getDescription(),
            // $this->getImageFilePath(),
            // $this->getType(),
            // $this->getEffects(),
            // $this->getPrice(),
            // $this->getPrototypeId(),
            // $this->getCreatorCharacterId()
        );
    }
}
