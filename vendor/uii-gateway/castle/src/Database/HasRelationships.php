<?php

namespace UIIGateway\Castle\Database;

use Awobaz\Compoships\Compoships;

trait HasRelationships
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use Compoships;
}
