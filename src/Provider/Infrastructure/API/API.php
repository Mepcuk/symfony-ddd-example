<?php

declare(strict_types=1);


namespace App\Provider\Infrastructure\API;

class API
{
    public function getFakeArrayOfData():array
    {
        return ['data' => 'Here is data'];
    }
}