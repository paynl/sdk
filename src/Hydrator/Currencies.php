<?php

declare(strict_types=1);

namespace PayNL\Sdk\Hydrator;

use PayNL\Sdk\{
    Model\Currencies as CurrenciesModel,
    Model\Currency as CurrencyModel,
    Hydrator\Simple as SimpleHydrator
};

/**
 * Class Currencies
 *
 * @package PayNL\Sdk\Hydrator
 */
class Currencies extends AbstractHydrator
{
    /**
     * @inheritDoc
     *
     * @return CurrenciesModel
     */
    public function hydrate(array $data, $object): CurrenciesModel
    {
        $this->validateGivenObject($object, CurrenciesModel::class);

        if (false === array_key_exists('currencies', $data)) {
            // assume the given array are currencies
            $data = [
                'currencies' => $data,
            ];
        }

        foreach ($data['currencies'] as $key => $currency) {
            $data['currencies'][$key] = $this->hydratorManager->build('simple')->hydrate($currency, $this->modelManager->build('currency'));
        }

        /** @var CurrenciesModel $currencies */
        $currencies = parent::hydrate($data, $object);
        return $currencies;
    }
}
