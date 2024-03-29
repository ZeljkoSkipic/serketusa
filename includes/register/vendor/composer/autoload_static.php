<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0f4cdb1bcc954cf3431e031a90eece7d
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\Register\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\Register\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0f4cdb1bcc954cf3431e031a90eece7d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0f4cdb1bcc954cf3431e031a90eece7d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0f4cdb1bcc954cf3431e031a90eece7d::$classMap;

        }, null, ClassLoader::class);
    }
}
