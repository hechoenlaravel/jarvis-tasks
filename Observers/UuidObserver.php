<?php

namespace Modules\Tasks\Observers;

use Webpatser\Uuid\Uuid;

/**
 * Class UuidObserver
 * @package Modules\Tasks\Observers
 */
class UuidObserver
{

    /**
     * @param $model
     * @throws \Exception
     */
    public function creating($model)
    {
        $model->uuid = Uuid::generate(4);
    }

}