<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite35f0902f10fbdcd42d3c5e9de48a18a
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite35f0902f10fbdcd42d3c5e9de48a18a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite35f0902f10fbdcd42d3c5e9de48a18a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}