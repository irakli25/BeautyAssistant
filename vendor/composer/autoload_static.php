<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita63532c6b486bc11c0f87c614782e9c0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita63532c6b486bc11c0f87c614782e9c0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita63532c6b486bc11c0f87c614782e9c0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
