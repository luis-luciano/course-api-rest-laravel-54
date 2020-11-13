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
            'titulo' => (string) $category->name,
            'descripcion' => (string) $category->description,
            'fecha_creacion' => (string) $category->created_at,
            'fecha_actualizacion' => (string) $category->updated_at,
            'fecha_eliminacion' => ((string) $category->deleted_at) ?? null,
        ];
    }
}
