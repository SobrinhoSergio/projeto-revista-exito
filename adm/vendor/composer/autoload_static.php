<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3f7ae06f0dc96f3879fae354634e2a5
{
    public static $files = array (
        'e40631d46120a9c38ea139981f8dab26' => __DIR__ . '/..' . '/ircmaxell/password-compat/lib/password.php',
        'd748bd1dc8c5ea46641928171c40d8f2' => __DIR__ . '/../..' . '/src/config/config.php',
        '0ef693abb8f3a0bc2cf7078d78a6eebb' => __DIR__ . '/../..' . '/src/config/session.php',
    );

    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Friweb\\CMS\\Model\\' => 17,
            'Friweb\\CMS\\AppException\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Friweb\\CMS\\Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Model',
        ),
        'Friweb\\CMS\\AppException\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/AppException',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3f7ae06f0dc96f3879fae354634e2a5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3f7ae06f0dc96f3879fae354634e2a5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
