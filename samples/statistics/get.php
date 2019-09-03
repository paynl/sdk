<?php
declare(strict_types=1);
throw new Exception('TODO: fixen met Mike!!');
require_once __DIR__ . '/../init.php';

use PayNL\Sdk\Api;
use PayNL\Sdk\Request\Statistics\Get as GetStatisticsRequest;
use PayNL\Sdk\Filter;

$authAdapter = getAuthAdapter();

$request = (new GetStatisticsRequest(GetStatisticsRequest::TYPE_SESSIONS))
    ->setFormat('json')
    ->addFilter(new Filter\StartDate('01-05-2019'))
    ->addFilter(new Filter\EndDate(DateTime::createFromFormat('Y-m-d', '2019-05-01')))
//    ->addFilter(new Filter\Staffels(1))
    ->addFilter(new Filter\GroupBy([ 'transactions' ]))
//    ->addFilter(new Filter\Currency('EUR'))
    ->addFilter(new Filter\Filters([
        [
            'type'     => 'created',
            'operator' => 'lt',
            'value'    => '2019-05-02'
        ]
    ])) // I know weird naming...
//    ->addFilter(new Filter\Page(2))
;

$api = new Api($authAdapter);
$response = $api->handleCall($request);

print '<pre/>';
print_r($response);
exit(0);


