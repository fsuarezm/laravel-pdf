<?php
/**
 * Este fichero forma parte de la aplicación laravel-pdf
 *
 * @copyrigth 2019 Francisco Suárez Mulero <francisco.suarez@sepe.es>
 * @copyrigth Servicio Público de Empleo Estatal
 * @copyrigth UCI Barcelona
 *
 * @license For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @author Francisco Suárez Mulero <francisco.suarez@sepe.es>
 */

namespace Pdf\Laravel;

use Illuminate\Support\ServiceProvider;

class PdfServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config = __DIR__.'/config/rospdf.php';

        $this->publishes(
            [$config => config_path('rospdf.php')],
            'rospdf'
        );

        $this->mergeConfigFrom($config, 'rospdf.php');
    }

    public function register()
    {
        $this->app->bind('laravel-pdf', function() {
            return Pdf::create();
        });

        $this->app->bind(Pdf::class, function () {
            return Pdf::create();
        })
    }
}