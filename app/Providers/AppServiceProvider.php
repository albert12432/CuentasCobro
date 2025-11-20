<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notificacion;

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
        // Compartir contador de notificaciones no leídas en todas las vistas
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $notificacionesNoLeidas = Notificacion::where('user_id', auth()->id())
                    ->noLeidas()
                    ->count();
                $view->with('notificacionesNoLeidas', $notificacionesNoLeidas);
            } else {
                $view->with('notificacionesNoLeidas', 0);
            }
        });
    }
}
