<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Blade::directive('currency', function ($expression) {
            return "Rp. <?php echo number_format($expression, 0, ',', '.'); ?>";
        });

        // View::share('imgFirebase', function ($expression) {
        //     $expiresAt = new \DateTime('tomorrow');
        //     $imageReference = app('firebase.storage')->getBucket()->object($expression);
        //     if($imageReference->exists()) {
        //         return $imageReference->signedUrl($expiresAt);
        //     } else {

        //         return dd($imageReference);
        //     }
        // });
    }
}
