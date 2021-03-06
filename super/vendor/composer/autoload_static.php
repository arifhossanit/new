<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf309f2ff542d4dc812ac0bc05296fb95
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf309f2ff542d4dc812ac0bc05296fb95::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf309f2ff542d4dc812ac0bc05296fb95::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf309f2ff542d4dc812ac0bc05296fb95::$classMap;

        }, null, ClassLoader::class);
    }
}
