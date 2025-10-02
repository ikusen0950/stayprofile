<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Model;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */

    public static function authentication(string $lib = 'local', ?Model $userModel = null, ?Model $loginModel = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('authentication', $lib, $userModel, $loginModel);
        }

        $userModel ??= model(\App\Models\UserModel::class);
        $loginModel ??= model(\Myth\Auth\Models\LoginModel::class);

        $config = config('Auth');
        $class = $config->authenticationLibs[$lib];
        $instance = new $class($config);

        return $instance
            ->setUserModel($userModel)
            ->setLoginModel($loginModel);
    }

    public static function authorization(?Model $groupModel = null, ?Model $permissionModel = null, ?Model $userModel = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('authorization', $groupModel, $permissionModel, $userModel);
        }

        $groupModel ??= model(\Myth\Auth\Authorization\GroupModel::class);
        $permissionModel ??= model(\Myth\Auth\Authorization\PermissionModel::class);
        $userModel ??= model(\App\Models\UserModel::class);

        $instance = new \Myth\Auth\Authorization\FlatAuthorization($groupModel, $permissionModel);

        return $instance->setUserModel($userModel);
    }
}
