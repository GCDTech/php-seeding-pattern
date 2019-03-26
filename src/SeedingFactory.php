<?php

namespace Gcd\Seeding;

use Faker\Factory;
use Faker\Generator;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;
use Rhubarb\Stem\Filters\Equals;

class SeedingFactory
{
    private function __construct()
    {
        $this->faker = self::getFaker();
    }

    public static function get()
    {
        return new static();
    }

    /**
     * @var Generator
     */
    private static $_globalFaker;

    /**
     * @var Generator
     */
    protected $faker;

    /**
     * Returns a Faker instance seeded based upon the seeders class name to ensure consistancy
     *
     * @return Generator
     */
    public static function getFaker():Generator
    {
        if (!self::$_globalFaker) {
            self::$_globalFaker = Factory::create('en-gb');
        }

        return self::$_globalFaker;
    }

    public function findByColumns($modelClass, $keyValuePairs = [])
    {
        $filters = [];

        foreach($keyValuePairs as $key => $value){
            $filters[] = new Equals($key, $value);
        }

        return $modelClass::findFirst(...$filters);
    }

    public function findOrCreateByColumns($modelClass, $keyValuePairs = [])
    {
        try {
            return $this->findByColumns($modelClass, $keyValuePairs);
        } catch (RecordNotFoundException $er){
            $model = new $modelClass();

            foreach($keyValuePairs as $key => $value) {
                $model[$key] = $value;
            }

            return $model;
        }
    }
}