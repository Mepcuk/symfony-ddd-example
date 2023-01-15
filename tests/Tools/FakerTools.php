<?php

declare(strict_types=1);


namespace App\Tests\Tools;

use Faker\Factory;
use Faker\Generator;

trait FakerTools
{
    public function getFakerInstance(): Generator
    {
        return Factory::create();
    }
}