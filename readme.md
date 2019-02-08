# laravel-pdf

[Built for Laravel](https://img.shields.io/badge/Built_for-Laravel-green.svg?style=flat-square)

Integración de Rospdf para Laravel

## Requerimientos

- Laravel 5.5 o superior
- PHP 7.0 o superior

## Instalación

Instalar desde composer:

Esta librería no está publicada en `package`, por lo que debe modificar su archivo `composer.json` y añadir las siguientes líneas:

```bash
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/fsuarezm/laravel-pdf.git"
        }
    ],
```

```bash
composer require fsuarezm/laravel-pdf
```

En el archivo `config/app.php` añadir el Provider:

```php
       'providers' => [
            ...
            
            
            Pdf\Laravel\PdfServiceProvider::class
       ]
```

y el Facade:

```php
       'alias' => [
            ...            
            'Pdf' => Pdf\Laravel\Facades\Pdf::class
       ]
```

> **Nota**: Si está usando laravel 5.5 o superior puede obviar el registro del `Service Provider` y `alias`

Para publicar el archivo de configuración ejecuta en el terminal:

```bash
php artisan vendor:publish
```