<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Services\WhatsApp\WhatsAppServiceInterface::class,
            \App\Services\WhatsApp\LogWhatsAppService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            // Only query database if table exists to prevent migration errors
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $platformName = \App\Models\Setting::get('platform_name', config('app.name', 'Dental SaaS'));
                $platformLogo = \App\Models\Setting::get('platform_logo');
                
                $view->with('globalPlatformName', $platformName);
                $view->with('globalPlatformLogo', $platformLogo);
            }
        });
    }
}
