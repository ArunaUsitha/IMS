<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => [
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'timeout' => false,
        'env'     => [],
        'options' => array(
            'page-size' => 'A4',
            'margin-top' => 5,
            'margin-right' => 5,
            'margin-left' => 5,
            'margin-bottom' => 6,
            'orientation' => 'Portrait',
            'footer-center' => 'System Developed by Aruna Usitha',
            'footer-right' => 'Page [page] of [toPage]',
            'footer-font-size' => 8,
            'footer-font-name' => 'Roboto',
            'footer-left' => '[date]',
            'footer-line' => true,
        ),
    ],

    'image' => [
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],


];
