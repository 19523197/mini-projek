<?php

namespace App\Treasures\IdeHelper;

use App\Treasures\Utility\ReflectionHelper;
use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;

class Hooks implements ModelHookInterface
{
    public function run(ModelsCommand $command, Model $model): void
    {
        $modelName = ReflectionHelper::callRestrictedMethod(
            $command,
            'getClassNameInDestinationFile',
            [$model, get_class($model)]
        );
        $builder = ReflectionHelper::callRestrictedMethod(
            $command,
            'getClassNameInDestinationFile',
            [$model, \Illuminate\Database\Query\Builder::class]
        );

        $command->setMethod('with', $builder . '|' . $modelName, ['$relations']);
        $command->setMethod('on', $builder . '|' . $modelName, ['$connection=null']);

        $traits = class_uses_recursive(get_class($model));

        $this->getSoftDeleteMethods($command, $builder, $modelName, $traits);
        $this->getActivableScopeMethods($command, $builder, $modelName, $traits);
    }

    protected function getActivableScopeMethods(ModelsCommand $command, $builder, $modelName, array $traits)
    {
        if (in_array('App\\Treasures\\Illuminate\\Activable', $traits)) {
            $command->setMethod('onlyActive', $builder . '|' . $modelName, []);
            $command->setMethod('withoutInactive', $builder . '|' . $modelName, []);
            $command->setMethod('onlyInactive', $builder . '|' . $modelName, []);
        }
    }

    /**
     * Temporary fix, until fix version released.
     */
    protected function getSoftDeleteMethods(ModelsCommand $command, $builder, $modelName, array $traits)
    {
        if (
            in_array('Illuminate\\Database\\Eloquent\\SoftDeletes', $traits) &&
            !$this->methodHasBeenSet($command, 'withTrashed')
        ) {
            $command->setMethod('withTrashed', $builder . '|' . $modelName, []);
            $command->setMethod('withoutTrashed', $builder . '|' . $modelName, []);
            $command->setMethod('onlyTrashed', $builder . '|' . $modelName, []);
        }
    }

    protected function methodHasBeenSet(ModelsCommand $command, $method)
    {
        $methods = (array) ReflectionHelper::getRestrictedProperty($command, 'methods');

        return array_key_exists($method, $methods);
    }
}
