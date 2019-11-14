<?php

namespace App\Providers;

use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\UserRepository;
use App\Repositories\AppointmentRepository;

use App\Repositories\Interfaces\IContactRepository;
use App\Repositories\ContactRepository;
use App\Repositories\Interfaces\IAppointmentRepository;
use Illuminate\Support\ServiceProvider;

class EloquentServiceProfider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IContactRepository::class, ContactRepository::class);
        $this->app->bind(IAppointmentRepository::class, AppointmentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
