<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SystemSettingsController extends Controller
{

    public function userAdministrationOverview()
    {
        $userRoles = Role::all();
        $permissions = Permission::all();
        return view('admin.settings.user_administration')->with(['user_roles' => $userRoles, 'permissions' => $permissions]);
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





    public function storeNewUserRole(Request $request){

        $userRoleName = $request->post('userRoleName');

        if ($userRoleName !== null){


            DB::beginTransaction();

            try {

            $role = new Role();

            $role->name = $userRoleName;
            $role->save();

            $role_id = $role->id;

            $permissions  = DB::table('permissions as p')
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

}
