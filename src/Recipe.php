<?php

namespace Gcd\Seeding;

/**
 * Recipes contain the flags, data and switches for controlling what a
 * SeedingFactory creates.
 */
abstract class Recipe
{
    public static function create()
    {
        return new static();
    }
}