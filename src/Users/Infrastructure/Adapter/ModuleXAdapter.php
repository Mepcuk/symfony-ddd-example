<?php

declare(strict_types=1);


namespace App\Users\Infrastructure\Adapter;

use App\Provider\Infrastructure\API\API;

class ModuleXAdapter
{
    public function __construct(private readonly API $dataProvider)
    {
    }

    public function adaptFakeData():array
    {
        $receivedFakeData = $this->dataProvider->getFakeArrayOfData();
        // mapping data -> convert API object to Users array

        return $receivedFakeData;
    }
}