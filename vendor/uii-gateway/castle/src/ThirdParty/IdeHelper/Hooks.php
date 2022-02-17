<?php

namespace UIIGateway\Castle\ThirdParty\IdeHelper;

use Barryvdh\LaravelIdeHelper\Console\ModelsCommand;
use Barryvdh\LaravelIdeHelper\Contracts\ModelHookInterface;
use Illuminate\Database\Eloquent\Model;
use UIIGateway\Castle\Utility\ReflectionHelper;

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
        $command->setMethod('fromSub', $builder . '|' . $modelName, ['$query', '$as']);
        $command->setMethod('take', $builder . '|' . $modelName, ['$value']);
        $command->setMethod('limit', $builder . '|' . $modelName, ['$value']);
        $command->setMethod('skip', $builder . '|' . $modelName, ['$value']);
        $command->setMethod('offset', $builder . '|' . $modelName, ['$value']);
        $command->setMethod('toSql', 'string', ['$value']);
        $command->setMethod('orderBy', $builder . '|' . $modelName, ['$column', '$direction=\'asc\'']);
        $command->setMethod('orderByDesc', $builder . '|' . $modelName, ['$column']);
        $command->setMethod('latest', $builder . '|' . $modelName, ['$column=\'created_at\'']);
        $command->setMethod('oldest', $builder . '|' . $modelName, ['$column=\'created_at\'']);
        $command->setMethod('count', 'int', ['$columns=\'*\'']);
        $command->setMethod('dd', 'void');
        $command->setMethod(
            'where',
            $builder . '|' . $modelName,
            ['$column', '$operator=null', '$value=null', '$boolean=\'and\'']
        );
        $command->setMethod(
            'orWhere',
            $builder . '|' . $modelName,
            ['$column', '$operator=null', '$value=null']
        );
        $command->setMethod(
            'whereIn',
            $builder . '|' . $modelName,
            ['$column', '$values', '$boolean=\'and\'', '$not=false']
        );
        $command->setMethod(
            'orWhereIn',
            $builder . '|' . $modelName,
            ['$column', '$values']
        );
        $command->setMethod(
            'whereNotIn',
            $builder . '|' . $modelName,
            ['$column', '$values', '$boolean=\'and\'']
        );
        $command->setMethod(
            'orWhereNotIn',
            $builder . '|' . $modelName,
            ['$column', '$values']
        );
        $command->setMethod(
            'whereBetween',
            $builder . '|' . $modelName,
            ['$column', 'array $values', '$boolean=\'and\'', '$not=false']
        );
        $command->setMethod(
            'orWhereBetween',
            $builder . '|' . $modelName,
            ['$column', 'array $values']
        );
        $command->setMethod(
            'whereNotBetween',
            $builder . '|' . $modelName,
            ['$column', 'array $values', '$boolean=\'and\'']
        );
        $command->setMethod(
            'orWhereNotBetween',
            $builder . '|' . $modelName,
            ['$column', 'array $values']
        );
        $command->setMethod(
            'whereSub',
            $builder . '|' . $modelName,
            ['$column', '$operator', '\Closure $callback', '$boolean']
        );
        $command->setMethod('inRandomOrder', $builder . '|' . $modelName, ['$seed=\'\'']);
        $command->setMethod('create', $builder . '|' . $modelName, ['array $attributes=[]']);
        $command->setMethod('forceCreate', $builder . '|' . $modelName, ['array $attributes']);
        $command->setMethod('newModelInstance', $builder . '|' . $modelName, ['array $attributes=[]']);
        $command->setMethod('get', $builder . '|' . $modelName, ['$columns=[\'*\']']);
        $command->setMethod('getModels', $builder . '[]|' . $modelName . '[]', ['$columns=[\'*\']']);
        $command->setMethod(
            'findOrNew',
            $builder . '|' . $modelName,
            ['$id', '$columns=[\'*\']']
        );
        $command->setMethod(
            'firstOrNew',
            $builder . '|' . $modelName,
            ['array $attributes=[]', 'array $values=[]']
        );
        $command->setMethod(
            'firstOrCreate',
            $builder . '|' . $modelName,
            ['array $attributes=[]', 'array $values=[]']
        );
        $command->setMethod(
            'updateOrCreate',
            $builder . '|' . $modelName,
            ['array $attributes=[]', 'array $values=[]']
        );
        $command->setMethod(
            'firstOrFail',
            $builder . '|' . $modelName,
            ['$columns=[\'*\']']
        );
        $command->setMethod(
            'firstOr',
            $builder . '|' . $modelName,
            ['$columns=[\'*\']', '\Closure $callback=null']
        );
        $command->setMethod(
            'paginate',
            '\Illuminate\Contracts\Pagination\LengthAwarePaginator',
            ['$perPage=null', '$columns=[\'*\']', '$pageName=\'page\'', '$page=null']
        );

        $traits = class_uses_recursive(get_class($model));

        $this->getActivableScopeMethods($command, $builder, $modelName, $traits);
    }

    protected function getActivableScopeMethods(ModelsCommand $command, $builder, $modelName, array $traits)
    {
        if (in_array('UIIGateway\\Castle\\Database\\Activable', $traits)) {
            $command->setMethod('onlyActive', $builder . '|' . $modelName, []);
            $command->setMethod('withoutInactive', $builder . '|' . $modelName, []);
            $command->setMethod('onlyInactive', $builder . '|' . $modelName, []);
        }
    }
}
