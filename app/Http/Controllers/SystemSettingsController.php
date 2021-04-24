<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemSettingsController extends Controller
{

    public function userAdministrationOverview()
    {
//        $userRoles = Role::all();
//        $permissions = Permission::all();
        return view('admin.settings.user_administration');
//            ->with(['user_roles' => $userRoles, 'permissions' => $permissions]);
    }

    public function getUserModulesNPermissions(Request $request)
    {

        $role_id = $request->post('role_id');

        $role_permission_data = DB::select(DB::raw('SELECT p.id AS permission_id,p.module,rp.id AS role_permission_id,rp.role_id,rp.`create`,rp.`read`,rp.`update`,rp.`delete` FROM role_permissions rp
                                                              INNER JOIN permissions p ON rp.permission_id = p.id
                                                              WHERE rp.role_id = ' . $role_id));

        $permission_data = [];


        foreach ($role_permission_data as $permissions) {

            $permission_data[$permissions->role_permission_id]['module_data'] = [
                'role_permission_id' => $permissions->role_permission_id,
                'module' => $permissions->module,
                'permission_id' => $permissions->permission_id,
                'role_id' => $permissions->role_id,
            ];

            $permission_data[$permissions->role_permission_id]['permission_data'] = [
                'create' => $permissions->create,
                'read' => $permissions->read,
                'update' => $permissions->update,
                'delete' => $permissions->delete,
            ];
        }


        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            $permission_data

        ));

    }


    public function getPermissions(Request $request)
    {

        $module = $request->post('module_id');
        $user_role = $request->post('user_role');

        $permissions = DB::select(DB::raw('SELECT rp.id as rp_id,rp.`create`,rp.`read`,rp.`update`,rp.`delete` FROM role_permissions rp
                                            WHERE rp.role_id = ' . $user_role . ' AND rp.permission_id = ' . $module));


        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            $permissions

        ));

    }

    public function updatePermission(Request $request)
    {

        $rp_id = $request->post('rp_id');
        $role = $request->post('role');
        $role_val = $request->post('role_val');

        $db_role = '';
        if ($role == 'c') {
            $db_role = 'create';
        }
        if ($role == 'r') {
            $db_role = 'read';
        }
        if ($role == 'u') {
            $db_role = 'update';
        }
        if ($role == 'd') {
            $db_role = 'delete';
        }


        try {
            $update = DB::table('role_permissions')->where('id', $rp_id)->update(array($db_role => $role_val));

        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));

        }

        activity()->by(Auth::id())->log('updated the roles of role permission id : ' . $rp_id);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! User permission was updated!!',
            ''

        ));


    }

    public function storeNewModule(Request $request)
    {

        $moduleName = $request->post('moduleName');

        if ($moduleName !== null) {

            DB::beginTransaction();

            $permission = new Permission();
            $permission->module = $moduleName;

            $permission->save();

            $permission_id = $permission->id;

            try {
                $user_roles = DB::table('roles as r')
                    ->select('r.id', 'r.name')
                    ->get()->toArray();


                foreach ($user_roles as $role) {

                    $timestamp = now();

                    DB::insert('INSERT INTO  role_permissions (role_id, permission_id, `create`, `read`, `update`, `delete`, created_at, updated_at)
                                                            values (?,?,?,?,?,?,?,?)',
                        [$role->id, $permission_id, 0, 0, 0, 0, $timestamp, $timestamp]);

                }

            } catch (QueryException $e) {

                DB::rollBack();
                $errorMessage = $e->errorInfo[2];

                return response()->json(self::getJSONResponse(
                    false,
                    'header',
                    $errorMessage,
                    ''
                ));

            }

            DB::commit();


            activity()->by(Auth::id())->log('Added new user module : ' . $moduleName);

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Hooray..! User module was added.',
                ''

            ));


        }


    }


    public function storeNewUserRole(Request $request)
    {

        $userRoleName = $request->post('userRoleName');

        if ($userRoleName !== null) {


            DB::beginTransaction();

            try {

                $role = new Role();

                $role->name = $userRoleName;
                $role->save();

                $role_id = $role->id;

                $permissions = DB::table('permissions as p')
                    ->select('p.id', 'p.module')
                    ->get()->toArray();


                foreach ($permissions as $permission) {

                    $timestamp = now();

                    DB::insert('INSERT INTO  role_permissions (role_id, permission_id, `create`, `read`, `update`, `delete`, created_at, updated_at)
                                                            values (?,?,?,?,?,?,?,?)',
                        [$role_id, $permission->id, 0, 0, 0, 0, $timestamp, $timestamp]);

                }


            } catch (QueryException $e) {

                DB::rollBack();
                $errorMessage = $e->errorInfo[2];

                return response()->json(self::getJSONResponse(
                    false,
                    'header',
                    $errorMessage,
                    ''
                ));

            }

            DB::commit();


            activity()->by(Auth::id())->log('Added new user role : ' . $userRoleName);

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Hooray..! User role was added.',
                ''

            ));


        }


    }


    public function getRoles()
    {

        $rolesWithPermissions = Role::select(['roles.id', 'roles.name as role_name', DB::raw('group_concat(permissions.name SEPARATOR ", ") as permissions')])
            ->leftJoin('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
            ->leftJoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->groupBy('roles.id', 'roles.name')
            ->get();


        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            $rolesWithPermissions

        ));

    }

    public function editRolePermissions(Request $request)
    {

        //get all the permissions for the role

        //get role details
        $role = Role::findById($request->roleID);


        $all_permissions = Permission::all();

        $permissions_list = [];

        foreach ($all_permissions as $all_permission) {

            array_push($permissions_list, [
                'id' => $all_permission->id,
                'name' => $all_permission->name,
                'checked' => $role->hasPermissionTo($all_permission->name)
            ]);

        }

        return view('admin.settings.edit_role_permissions')->with(['role' => $role, 'permissions_list' => $permissions_list]);

    }


    public function updateRolePermissions(Request $request)
    {

        try {

            $updated_permission_list = [];
            parse_str($request->permissions, $updated_permission_list);
            $updated_permission_list = array_keys($updated_permission_list);
            $role_id = $request->role_id;

            $role = Role::find($role_id);

            $role->syncPermissions($updated_permission_list);

        } catch (\Exception  $e) {
            return response()->json(self::getJSONResponse(
                false,
                'toast',
                'System error!.',
                ''

            ));
        }


        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! User Permissions were updated.',
            ''

        ));


    }


    public function showCreateNewRoleView()
    {

        $permissions = Permission::all();

        return view('admin.settings.create_new_role_view')->with(['permissions' => $permissions]);
    }

    public function createNewRole(Request $request)
    {

        try {

            $updated_permission_list = [];

            parse_str($request->permissions, $updated_permission_list);
            $updated_permission_list = array_keys($updated_permission_list);


            if ($role = Role::create(['name' => $request->role_name])) {
                if (!empty($updated_permission_list)) {
                    $role->syncPermissions($updated_permission_list);
                }

            }


        } catch (\Exception  $e) {
            return response()->json(self::getJSONResponse(
                false,
                'toast',
                $e->getMessage(),
                ''

            ));
        }


        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! User Permissions were updated.',
            ''

        ));
    }


    public function deleteRole(Request $request)
    {
        if ($request->has('role_id')) {

            try {

                $role = Role::findOrFail($request->role_id);
                $role->delete();


            } catch (\Exception $e) {
                return response()->json(self::getJSONResponse(
                    false,
                    'toast',
                    $e->getMessage(),
                    ''

                ));
            }

            return response()->json(self::getJSONResponse(
                true,
                'toast',
                'Hooray..! User Permissions were updated.',
                ''

            ));
        }
    }
}
