<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function (ViewInstance $view): void {
            $errors = $view->getData()['errors']
                ?? $view->getFactory()->getShared()['errors']
                ?? null;

            $view->with([
                'navigationGuestClass' => Auth::guest() ? '' : 'd-none',
                'navigationAuthClass' => Auth::check() ? '' : 'd-none',
                'successMessageClass' => session()->has('sucesso') ? '' : 'd-none',
                'validationAlertsClass' => $errors instanceof ViewErrorBag && $errors->any()
                    ? ''
                    : 'd-none',
            ]);
        });
    }
}
