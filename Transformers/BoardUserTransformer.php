<?php

namespace Modules\Tasks\Transformers;

use Modules\Tasks\Entities\BoardUser;
use League\Fractal\TransformerAbstract;
use Modules\Users\Transformers\UserTransformer;

/**
 * Class BoardUserTransformer
 * @package Modules\Tasks\Transformers
 */
class BoardUserTransformer extends TransformerAbstract{

    /**
     * @var array
     */
    protected $defaultIncludes = ['user'];

    /**
     * @param BoardUser $boardUser
     * @return array
     */
    public function transform(BoardUser $boardUser)
    {
        return [
            'id' => (int) $boardUser->id,
            'can_assign' => (bool) $boardUser->can_assign,
            'created' => $boardUser->created_at,
            'updated' => $boardUser->updated_at
        ];
    }

    /**
     * @param BoardUser $boardUser
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(BoardUser $boardUser)
    {
        return $this->item($boardUser->user, new UserTransformer());
    }

}