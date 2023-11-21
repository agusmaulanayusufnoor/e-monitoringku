<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Kunjungannasabah;
use App\Models\User;
use App\Policies\KunjungannasabahPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Kunjungannasabah::class => KunjungannasabahPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
