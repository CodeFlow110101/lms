<?php

namespace App\Policies;

use App\Filament\Resources\Courses\CourseResource;
use App\Filament\Resources\Courses\Pages\ListCourses;
use App\Models\Course;
use App\Models\User;
use App\Providers\Filament\AdminPanelProvider;
use Filament\Facades\Filament;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class CoursePolicy
{
    /**
     * Determine whether the user can view any models.
     */

    public function before(User $user, string $ability): bool|null
    {

        AdminPanelProvider::getResourcePageUrlPatters(CourseResource::class)->contains(function ($value) {
            return request()->routeIs($value);
        });


        if (Gate::check('is-administrator')) {
            return true;
        } else if (Gate::check('is-member') && AdminPanelProvider::getResourcePageUrlPatters(CourseResource::class)->contains(function ($value) {
            return request()->routeIs($value);
        })) {
            return false;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Course $course): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Course $course): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Course $course): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Course $course): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return false;
    }

    public function access(User $user, Course $course): bool
    {
        // Admins always allowed
        if (Gate::check("is-administrator")) {
            return true;
        }

        // Members only
        if (Gate::check("is-member")) {

            // Yearly members always allowed
            if ($user->current_plan === 'yearly') {
                return true;
            }

            // Monthly members only allowed if course is in monthly plan
            if ($user->current_plan === 'monthly') {
                return $course->available_in_monthly_plan;
            }
        }

        // Default deny
        return false;
    }

    public function showModal(User $user, Course $course): bool
    {
        // Admins never see modal
        if (Gate::check("is-administrator")) {
            return false;
        }

        // Monthly users see modal **only if** course is in monthly plan
        if (Gate::check("is-member")) {
            return $course->available_in_monthly_plan === false;
        }

        // All yearly users bypass modal
        if ($user->current_plan === 'yearly') {
            return false;
        }

        return false;
    }
}
