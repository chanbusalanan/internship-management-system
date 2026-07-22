<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
        if ($user->isAdmin() || $user->isHr()) {
            return true;
        }

        if ($user->isIntern()) {
            return $application->intern_id === $user->intern?->id;
        }

        if ($user->isSupervisor()) {
            return $application->assignment?->supervisor_id === $user->supervisor?->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isIntern();
    }

    public function approve(User $user, Application $application): bool
    {
        return $user->isHr();
    }

    public function reject(User $user, Application $application): bool
    {
        return $user->isHr();
    }
}
