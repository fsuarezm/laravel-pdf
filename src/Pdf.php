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

use Illuminate\Support\Facades\Config;

class Pdf extends \Cezpdf
{
    const EXTENSIONS = [
        'gif',
        'jpeg',
        'jpg',
        'png'
    ];

    const IMAGE_FUNC = [
        'gif'  => 'addGifFromFile',
        'jpeg' => 'addJpegFromFile',
        'jpg'  => 'addJpegFromFile',
        'png'  => 'addPngFromFile',
    ];

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $config;

    /**
     * @inheritdoc
     */
    public function __construct(
        $paper = 'a4',
        string $orientation = 'portrait',
        string $type = 'none',
        array $options = array()
    ) {
        parent::__construct($paper, $orientation, $type, $options);

        $this->setConfig(Config::get('rospdf'));
        $this->initGeneralConfigDocument();
    }

    /**
     * @param array $options
     * @return Pdf
     */
    public static function create($options = []): self
    {
        $config   = array_merge(Config::get('rospdf'), $options);
        $document = new self($config['paper'], $config['orientation']);

        $document->setConfig($config);
        $document->initGeneralConfigDocument();

        return $document;
    }

    /**
     * @param string $page
     * @param array $header
     * @return Pdf
     */
    public function addHeader($page = 'all', $header = []): self
    {
        $headPage = $this->openObject();
        $this->saveState();

        $config = array_merge($this->config['header'], $header);

        $this->addHeaderImage($config['image']);
        $this->addHeaderText($config);

        $this->restoreState();
        $this->closeObject();
        $this->addObject($headPage, $page);

        return $this;
    }

    /**
     * @param string $page
     * @param array $footer
     * @return $this
     */
    public function addFooter($page = 'all', $footer = []): self
    {
        $footerPage = $this->openObject();
        $this->saveState();

        $config = array_merge($this->config['footer'], $footer);

        if ($config['main']) {
            $this->addText(
                20,
                $this->ez['bottomMargin'] - $this->getFontHeight($config['font_size'] + 2),
                $config['font_size'],
                $config['main'],
                $this->ez['pageWidth'] - 40,
                $config['align']
            );
        }

        $this->restoreState();
        $this->closeObject();
        $this->addObject($footerPage, $page);

        return $this;
    }

    /**
     * @return Pdf
     */
    public function addPageNumber(): self
    {
        if ($this->config['header']['page_numbers']) {
            $this->ezStartPageNumbers(
                $this->ez['pageWidth'] - $this->ez['rightMargin'],
                $this->y + $this->getFontHeight(10),
                7,
                'right',
                '{PAGENUM}',
                1
            );
        }

        if ($this->config['footer']['page_numbers']) {
            $this->ezStartPageNumbers(
                $this->config['footer']['align'] == 'right' ? $this->ez['leftMargin'] : $this->ez['pageWidth'] - $this->ez['rightMargin'],
                $this->ez['bottomMargin'] - $this->getFontHeight(10),
                7,
                'right',
                '{PAGENUM}',
                1
            );
        }

        return $this;
    }

    /**
     * @param string $filename
     * @return mixed
     */
    public function response($filename = 'file.pdf')
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if ('pdf' !== strtolower($ext)) {
            $filename .= '.pdf';
        }

        header('Content-Type: application/pdf');
        header('Pragma: public'); // HTTP/1.0
        header('Cache-Control: max-age=0');
        header(sprintf('Content-Disposition: attachment; filename="%s"', $filename));
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1

        return $this->ezOutput();
    }

    /**
     * @param array $config
     * @return Pdf
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param array $config
     * @return Pdf
     */
    private function addHeaderImage(array $config): self
    {
        if ($config['path']) {
            $ext = pathinfo($config['path'], PATHINFO_EXTENSION);
            if (in_array($ext, static::EXTENSIONS)) {
                $imageSize = getimagesize($config['path']);
                switch ($config['align']) {
                    case 'left':
                        $x = 20;
                        break;
                    case 'right':
                        $x = $this->ez['pageWidth'] - 20 - $imageSize[0];
                        break;
                    default:
                        $x = $this->ez['pageWidth'] / 2 - $imageSize[0] / 2;
                }

                $this->{static::IMAGE_FUNC[$ext]}(
                    $config['path'],
                    $x,
                    $this->ez['pageHeight'] - $imageSize[1] - 5
                );
            }
        }

        return $this;
    }

    /**
     * @param array $config
     * @return Pdf
     */
    public function addHeaderText(array $config): self
    {
        if (is_array($config['main'])) {
            $y = $this->ez['pageHeight'] - 5;
            foreach ($config['main'] as $line) {
                $y = $y - $this->getFontHeight(isset($line['font_size']) ? $line['font_size'] : $config['main']['font_size']);
                $this->addText(
                    20,
                    $y,
                    isset($line['font_size']) ? $line['font_size'] : $config['main']['font_size'],
                    $line['text'],
                    $this->ez['pageWidth'] - 40,
                    $config['align']
                );
            }
        }
        else {
            $this->addText(
                20,
                $this->ez['pageHeight'] - $this->getFontHeight($this->ez['fontSize']) - 5,
                $config['main']['font_size'],
                $config['main'],
                $this->ez['pageWidth'] - 40, $this->config['header']['align']
            );
        }

        return $this;
    }

    /**
     * @return Pdf
     */
    private function initGeneralConfigDocument(): self
    {
        $margins = $this->config['margins'];

        $this->ezSetCmMargins($margins['top'], $margins['bottom'], $margins['left'], $margins['right']);
        $this->selectFont($this->config['font_family']);

        return $this;
    }
}