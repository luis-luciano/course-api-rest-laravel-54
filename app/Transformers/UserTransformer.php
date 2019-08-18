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
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'isVerified' => (boolean) $user->verified,
            'isAdministrator' => (boolean) $user->is_admin,
            'dateCreated' => (string) $user->created_at,
            'dateUpdated' => (string) $user->updated_at,
            'dateDeleted' => ((string) $user->deleted_at) ?? null,
        ];
    }
}
