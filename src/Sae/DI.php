<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/4/9
 * Time: 20:32
 */

namespace Focusman\Sae;

class DI {

    /**
     * @var \DI\Container
     */
    private static $_container;

    /**
     * @return \DI\Container
     */
    public static function getContainer() {
        if ( empty( self::$_container ) ) {
            $builder = new \DI\ContainerBuilder();
            $builder->addDefinitions( __DIR__ . '/config.php' );
            $builder->useAnnotations( false );
            $builder->useAutowiring( false );

            self::$_container = $builder->build();
        }

        return self::$_container;
    }
}