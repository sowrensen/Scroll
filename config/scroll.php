<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Driver
    |--------------------------------------------------------------------------
    |
    | Defines the source for your blog posts. Currently, the default and
    | supported driver is File, however, you can write your own driver
    | and add its configuration here and set the driver key.
    |
    | Supported: "file"
    |
    */

    'driver' => 'file',

    /*
    |--------------------------------------------------------------------------
    | File Driver Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify any configuration options that should be used with
    | the file driver. The path option is a path to the directory with all
    | of the markdown files that will be processed inside the command.
    |
    */

    'file' => [
        'path' => 'scrolls',
    ],

    /*
    |--------------------------------------------------------------------------
    | URI Address Prefix
    |--------------------------------------------------------------------------
    |
    | Use this path value to determine on what URI we are going to serve the
    | blog. For example, if you wanted to serve it at a different prefix
    | like www.example.com/my-blog, change the value to '/my-blog'.
    |
    */

    'prefix' => 'scrolls',
];
