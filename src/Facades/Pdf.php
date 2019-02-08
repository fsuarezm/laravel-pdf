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

namespace Pdf\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Pdf extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Pdf';
    }
}