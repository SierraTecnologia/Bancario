<?php

namespace Bancario\Http\Policies;

use App\Models\User;

/**
 * Class BancarioPolicy.
 *
 * @package Finder\Http\Policies
 */
class BancarioPolicy
{
    /**
     * Create a bancario.
     *
     * @param  User   $authUser
     * @param  string $bancarioClass
     * @return bool
     */
    public function create(User $authUser, string $bancarioClass)
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        return false;
    }

    /**
     * Get a bancario.
     *
     * @param  User  $authUser
     * @param  mixed $bancario
     * @return bool
     */
    public function get(User $authUser, $bancario)
    {
        return $this->hasAccessToBancario($authUser, $bancario);
    }

    /**
     * Determine if an authenticated user has access to a bancario.
     *
     * @param  User $authUser
     * @param  $bancario
     * @return bool
     */
    private function hasAccessToBancario(User $authUser, $bancario): bool
    {
        if ($authUser->toEntity()->isAdministrator()) {
            return true;
        }

        if ($bancario instanceof User && $authUser->id === optional($bancario)->id) {
            return true;
        }

        if ($authUser->id === optional($bancario)->created_by_user_id) {
            return true;
        }

        return false;
    }

    /**
     * Update a bancario.
     *
     * @param  User  $authUser
     * @param  mixed $bancario
     * @return bool
     */
    public function update(User $authUser, $bancario)
    {
        return $this->hasAccessToBancario($authUser, $bancario);
    }

    /**
     * Delete a bancario.
     *
     * @param  User  $authUser
     * @param  mixed $bancario
     * @return bool
     */
    public function delete(User $authUser, $bancario)
    {
        return $this->hasAccessToBancario($authUser, $bancario);
    }
}
