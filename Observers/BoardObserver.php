<?php

namespace Modules\Tasks\Observers;


use Webpatser\Uuid\Uuid;

/**
 * Class BoardObserver
 * @package Modules\Tasks\Observers
 */
class BoardObserver
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