<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'identifier' => (int) $category->id,
            'title' => (string) $category->name,
            'details' => (string) $category->description,
            'dateCreated' => (string) $category->created_at,
            'dateUpdated' => (string) $category->updated_at,
            'dateDeleted' => ((string) $category->deleted_at) ?? null,
        ];
    }
}
