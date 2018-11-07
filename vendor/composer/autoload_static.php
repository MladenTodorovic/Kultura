<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit386156fcff7a88ea725037e1d2b755f1
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit386156fcff7a88ea725037e1d2b755f1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit386156fcff7a88ea725037e1d2b755f1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
