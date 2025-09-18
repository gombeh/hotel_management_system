<?php

namespace App\Services\Permission;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public const invalidActions = [
        '__construct',
        'defaultValidation',
    ];

    /**
     * @param  $policy
     * @param string $actionName
     * @return string
     */
    public static function createNameWherePolicyAndAction($policy, string $actionName): string
    {
        $namespace = get_class($policy);
        $explodedNamespace = explode('\\', $namespace);

        $policyName = lcfirst(end($explodedNamespace));
        $modelName = Str::remove('Policy', $policyName);

        return sprintf('%s.%s', $modelName, $actionName);
    }

    /**
     * @return void
     */
    public static function syncBaseOnPolicies(): void
    {
        $oldPermissions = Permission::all();

        $policies = glob('app/Policies/*');

        $extraPermissions = config('permission.extra_permissions') ?? [];

        $permissionNames = collect($policies)->flatMap(function ($policyPath) {
            $policyNamespace = convert_path_to_namespace($policyPath);

            $policy = new $policyNamespace();

            $methods = get_class_methods($policy);

            $methods = array_filter($methods, fn($method) => !in_array($method, self::invalidActions));

            return array_map(fn($method) => self::createNameWherePolicyAndAction($policy, $method), $methods);
        })->merge($extraPermissions)
          ->each(fn($permissionName) => Permission::updateOrCreate(['name' => $permissionName]))
          ->toArray();

        $oldPermissions->filter(fn(Permission $permission) => !in_array($permission->name, $permissionNames))
            ->each(function (Permission $permission) {
                $permission->delete();
            });
    }


    /**
     * @param string $permissionName
     * @return array
     */
    public static function translate(string $permissionName): array
    {
        $explodedPermission = explode('.', $permissionName);
        $sections = ['models', 'actions'];

        return array_map(fn($exploded, $i) => __("permission.$sections[$i].$exploded"),
            $explodedPermission, array_keys($explodedPermission));
    }
}
