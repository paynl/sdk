<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Trademark as TrademarkModel,
    Model\Trademarks as TrademarksModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Trademarks
 *
 * @package PayNL\Sdk\Hydrator
 */
class Trademarks extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return TrademarksModel
     */
    public function hydrate(array $data, $object): TrademarksModel
    {
        $this->validateGivenObject($object, TrademarksModel::class);

        if (false === array_key_exists('trademarks', $data)) {
            // expect given array is the array of trademarks
            $data = array(
                'trademarks' => $data
            );
        }

        foreach ($data['trademarks'] as $key => $trademark) {
            if (false === ($trademark instanceof TrademarkModel)) {
                $data['trademarks'][$key] = (new SimpleHydrator())->hydrate($trademark, new TrademarkModel());
            }
        }

        /** @var TrademarksModel $trademarks */
        $trademarks = parent::hydrate($data, $object);
        return $trademarks;
    }
}
