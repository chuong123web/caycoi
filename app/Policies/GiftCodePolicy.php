<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GiftCode;
use Illuminate\Auth\Access\HandlesAuthorization;

class GiftCodePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GiftCode');
    }

    public function view(AuthUser $authUser, GiftCode $giftCode): bool
    {
        return $authUser->can('View:GiftCode');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GiftCode');
    }

    public function update(AuthUser $authUser, GiftCode $giftCode): bool
    {
        return $authUser->can('Update:GiftCode');
    }

    public function delete(AuthUser $authUser, GiftCode $giftCode): bool
    {
        return $authUser->can('Delete:GiftCode');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GiftCode');
    }

    public function restore(AuthUser $authUser, GiftCode $giftCode): bool
    {
        return $authUser->can('Restore:GiftCode');
    }

    public function forceDelete(AuthUser $authUser, GiftCode $giftCode): bool
    {
        return $authUser->can('ForceDelete:GiftCode');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GiftCode');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GiftCode');
    }

    public function replicate(AuthUser $authUser, GiftCode $giftCode): bool
    {
        return $authUser->can('Replicate:GiftCode');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GiftCode');
    }

}