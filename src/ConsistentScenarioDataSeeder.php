<?php

namespace Gcd\Seeding;

use Rhubarb\Stem\Custard\Scenario;
use Rhubarb\Stem\Custard\ScenarioDataSeeder;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A class that makes scenario data seeding consistent when using Faker for data generation.
 */
abstract class ConsistentScenarioDataSeeder extends ScenarioDataSeeder
{
    protected function beforeScenario(Scenario $scenario)
    {
        $key = crc32($scenario->getName());

        // A consitant seed based around the class name of the seeder itself. This way the seed is
        // consistent whether the seed is ran with others or on it's own.
        SeedingFactory::getFaker()->seed($key);

        parent::beforeScenario($scenario);
    }
}