<?php

namespace Gcd\Seeding\Logic\Shared\Seeding;

use Rhubarb\Stem\Custard\ScenarioDataSeeder;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A class that makes scenario data seeding consistent when using Faker for data generation.
 */
abstract class ConsistentScenarioDataSeeder extends ScenarioDataSeeder
{
    public function seedData(OutputInterface $output, $includeBulk = false)
    {
        $key = crc32(get_class($this));

        // A consitant seed based around the class name of the seeder itself. This way the seed is
        // consistent whether the seed is ran with others or on it's own.
        SeedingFactory::getFaker()->seed($key);

        parent::seedData($output, $includeBulk);
    }
}