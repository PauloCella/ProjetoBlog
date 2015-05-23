<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    // ...
    
    'acl' => array(
        'roles' => array(
              'VISITANTE' => null,
            'CATALOGADOR' => 'VISITANTE',
            'ADMIN' => 'CATALOGADOR',
        ),
        'resources' => array(
            'Application\Controller\Index.index',
            'Admin\Cntroller\Login.login',
            'Admin\Cntroller\Login.logout',
            'Admin\Cntroller\Usuarios.index',
            'Admin\Cntroller\Usuarios.save',
            'Admin\Cntroller\Usuarios.delete',
            'Admin\Cntroller\Interesses.index',
            'Admin\Cntroller\Interesses.save',
            'Admin\Cntroller\Interesses.delete',
            'Admin\Cntroller\Sexos.index',
            'Admin\Cntroller\Sexos.save',
            'Admin\Cntroller\Sexos.delete',
        ),
        'privilege' => array(
            'VISITANTE' => array(
                'allow' => array(
                    'Application\Controller\Index.index',
                    'Admin\Controller\Login.login',
                )
            ),
            'CATALOGADOR' => array(
                'allow' => array(
                    'Admin\Controller\Login.logout',
                    'Admin\Controller\Interesses.index',
                    'Admin\Controller\Interesses.save',
                    'Admin\Controller\Interesses.delete',
                    'Admin\Controller\Sexos.index',
                    'Admin\Controller\Sexos.save',
                    'Admin\Controller\Sexos.delete',
                )
            ),
            'ADMIN' => array(
                'allow' => array(
                    'Admin\Controller\Usuarios.index',
                    'Admin\Controller\Usuarios.save',
                    'Admin\Controller\Usuarios.delete',
                )
            ),
        )
    )
    
);
