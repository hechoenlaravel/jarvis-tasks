<?php

namespace Modules\Tasks\Transformers;

use Modules\Tasks\Entities\Board;
use League\Fractal\TransformerAbstract;
use Modules\Users\Transformers\UserTransformer;
use Hechoenlaravel\JarvisFoundation\UI\Field\EntityFieldPresenter;
use Hechoenlaravel\JarvisFoundation\Flows\Transformers\FlowTransformer;

/**
 * Class BoardTransformer
 * @package Modules\Tasks\Transformers
 */
class BoardTransformer extends TransformerAbstract{

    /**
     * @var array
     */
    protected $availableIncludes = ['flow', 'user', 'users'];

    /**
     * @param Board $board
     * @return array
     */
    public function transform(Board $board)
    {
        return [
            'id' => (int) $board->id,
            'uuid' => $board->uuid,
            'name' => $board->name,
            'description' => $board->description,
            'created' => $board->created_at,
            'updated' => $board->update_at,
            'additional_fields' => $this->getAdditionalFields($board)
        ];
    }

    /**
     * @param Board $board
     * @return \League\Fractal\Resource\Item
     */
    public function includeFlow(Board $board)
    {
        return $this->item($board->flow, new FlowTransformer());
    }

    /**
     * @param Board $board
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Board $board)
    {
        return $this->item($board->user, new UserTransformer());
    }

    /**
     * @param Board $board
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeUsers(Board $board)
    {
        if($board->users->count() === 0)
        {
            return null;
        }
        return $this->collection($board->users, new BoardUserTransformer());
    }

    /**
     * @param Board $board
     * @return array
     */
    protected function getAdditionalFields(Board $board)
    {
        $additionalFields = new EntityFieldPresenter($board->getEntity());
        $additionalFields->setRowId($board->id);
        $additional = [];
        foreach ($additionalFields->getFields() as $field) {
            if (method_exists($field, 'presentJson')) {
                $additional[] = [
                    'name' => $field->fieldName,
                    'value' => $field->presentJson()
                ];
            } else {
                $additional[] = [
                    'name' => $field->fieldName,
                    'value' => $field->presentFront()
                ];
            }
        }

        return $additional;
    }

}