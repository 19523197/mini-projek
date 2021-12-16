<?php

namespace App\Treasures\Utility;

use ReflectionClass;

class ReflectionHelper
{
    /**
     * Determine is a class extends the given class.
     *
     * @param  mixed  $class
     * @param  string  $extend
     * @return bool
     *
     * @throws \Exception
     */
    public static function isExtends($class, $extend)
    {
        $getParent = function ($class) {
            return (new ReflectionClass($class))->getParentClass();
        };

        while ($parent = $getParent($class)) {
            $class = $parent->name;

            if ($parent->name === $extend) {
                return true;
            }
        }

        return false;
    }

    /**
     * Dynamically call protected/private method in class.
     *
     * @param  mixed  $class
     * @param  string  $method
     * @param  array  $params
     * @return mixed
     *
     * @throws \Exception
     */
    public static function callRestrictedMethod(
        $class,
        string $method,
        array $params = []
    ) {
        if (is_string($class)) {
            $class = new ReflectionClass($class);
            $reflectionClass = $class;
        } else {
            $reflectionClass = new ReflectionClass($class);
        }

        $classMethod = $reflectionClass->getMethod($method);
        $classMethod->setAccessible(true);

        return $classMethod->invokeArgs($classMethod->isStatic() ? null : $class, $params);
    }

    /**
     * Dynamically get protected/private property in class.
     *
     * @param  mixed  $class
     * @param  string  $property
     * @return mixed
     *
     * @throws \Exception
     */
    public static function getRestrictedProperty($class, string $property)
    {
        if (is_string($class)) {
            $class = new ReflectionClass($class);
            $reflectionClass = $class;
        } else {
            $reflectionClass = new ReflectionClass($class);
        }

        $classProperty = $reflectionClass->getProperty($property);
        $classProperty->setAccessible(true);

        return $classProperty->getValue($class);
    }

    /**
     * Dynamically set value to protected/private property in class.
     *
     * @param  mixed  $class
     * @param  string  $property
     * @param  mixed  $value
     * @return void
     *
     * @throws \Exception
     */
    public static function setRestrictedProperty($class, string $property, $value)
    {
        if (is_string($class)) {
            $class = new ReflectionClass($class);
            $reflectionClass = $class;
        } else {
            $reflectionClass = new ReflectionClass($class);
        }

        $classProperty = $reflectionClass->getProperty($property);
        $classProperty->setAccessible(true);

        $classProperty->setValue($value);
    }
}
