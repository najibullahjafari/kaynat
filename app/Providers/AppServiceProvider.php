<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useTailwind();

        Blade::component('table', \App\View\Components\Table::class);
        Blade::component('modal', \App\View\Components\Modal::class);

        Blade::directive('money', function ($expression) {
            return "<?php echo number_format($expression, 2) . ' ' . config('app.currency', '$'); ?>";
        });

        Schema::defaultStringLength(191);
    }
}
