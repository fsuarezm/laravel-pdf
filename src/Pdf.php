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

class Pdf extends \Cezpdf
{
    private $config;

    public function __construct(
        $paper = 'a4',
        string $orientation = 'portrait',
        string $type = 'none',
        array $options = array()
    ) {
        parent::__construct($paper, $orientation, $type, $options);
    }

    public static function create($options = [])
    {
    }

    public function addHeader($page = 'all', $header = [])
    {
    }

    public function addFooter($page = 'all', $footer = [])
    {
    }

    public function addPageNumber()
    {
    }

    public function response($filename = 'file.pdf')
    {
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}