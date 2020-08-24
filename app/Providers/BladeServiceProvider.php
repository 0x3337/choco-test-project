<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    Blade::directive('role', function ($expression) {
      return "<?php if (Auth::user() && {$expression} == Auth::user()->role): ?>";
    });

    Blade::directive('endrole', function ($expression) {
      return '<?php endif; ?>';
    });
  }
}
