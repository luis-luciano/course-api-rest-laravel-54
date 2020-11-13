<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identifier' => (int) $user->id,
            'nombre' => (string) $user->name,
            'correo' => (string) $user->email,
            'es_verificado' => (boolean) $user->verified,
            'es_administrador' => (boolean) $user->is_admin,
            'fecha_creacion' => (string) $user->created_at,
            'fecha_actualizacion' => ((string) $user->updated_at) ?? null,
            'fecha_eliminacion' => ((string) $user->deleted_at) ?? null,
        ];
    }
}
