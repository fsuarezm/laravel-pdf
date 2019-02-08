<?php

return [
    /*
    |--------------------------------------------------------------------------
    | General configuration
    |--------------------------------------------------------------------------
    |
    | This array stores PDF general configuration
    |
    */

    "font_size"   => 12,                    // document font size
    "font_family" => "Helvetica",           // document font family
    "paper"       => "a4",                  // document page size
    "orientation" => "portrait",            // document page orientation

    /*
    |--------------------------------------------------------------------------
    | Document margins 'cm'
    |--------------------------------------------------------------------------
    |
    */
    "margins"     => [
        "left"   => 2,
        "right"  => 2,
        "top"    => 2.5,
        "bottom" => 2
    ],

    /*
    |--------------------------------------------------------------------------
    | Header configuration
    |--------------------------------------------------------------------------
    |
    | This array stores header definition
    |
    */
    "header"      => [
        "page_numbers" => true,                 // page numbers in header

        /*
        |--------------------------------------------------------------------------
        | Header text
        |--------------------------------------------------------------------------
        |
        | Default is a string. For many lines set an array.
        | Example:
        |   "main"         => [
        |       ["text" => "SEPE Barcelona", "font_size" => 12],
        |       ["text" => "Dirección Provincial", "font_size" => 10],
        |   ],
        |
        */
        "main"         => "Header text",
        "font_size"    => 12,                   // font size for main text
        "align"        => "left",               // align header

        /*
        |--------------------------------------------------------------------------
        | Image header
        |--------------------------------------------------------------------------
        |
        | this array store definition to image header
        |
        */
        "image"        => [
            "path"  => "path/to/image.jpg",     // gif | jpeg | jpg | png
            "align" => "left"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer configuration
    |--------------------------------------------------------------------------
    |
    | This array stores footer definition
    |
    */
    "footer" => [
        "page_numbers" => true,                 // page numbers in footer
        "main"         => "Footer text",        // footer text
        "font_size"    => 12,                   // font size for main text
        "align"        => "left",               // align footer
    ]
];