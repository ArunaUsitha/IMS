<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;
use Spatie\Activitylog\Models\Activity;


class UserController extends Controller
{
    private $imageExtention;
    private $imagePath;

    public function __construct()
    {
        $this->imageExtention = 'jpeg';
        $this->imagePath = 'users_data';
    }



    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
//        //  $this->authorize('read', Auth::user());

        $users = User::all();
        $roles = Role::all();

        return view('admin.users.overview')->with(['users' => $users, 'roles' => $roles]);
    }


    /**
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getAllUsersNRoles(){
//        //  $this->authorize('read', Auth::user());

        $users = User::all();
        $roles = Role::all();

        return response()->json(['users' => $users, 'roles' => $roles]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $user = new User;
//        //  $this->authorize('create', $user);
        $roles = Role::all();

        return view('admin.users.create')->with('roles', $roles);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        //  $this->authorize('create', Auth::user());

        $request->validate([
            'title' => 'required',
            'initials' => 'required',
            'initials_full' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|min:10',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city' => 'required',
            'birthday' => 'required|date',
            'nic' => 'required|min:10',
            'email' => 'required',
            'profile_img' => 'required|image',
            'role_id' => 'required',
            'password' => 'required',
        ]);

        try {

            $nic = $request->post('nic');

            $imageData = $this->getImagePath($nic);
            $pathWithNIC = $imageData['pathWithNic'];
            $path = $imageData['fullPath'];
            $pathForDB = $imageData['pathForDB'];
            $fullPathWithExt = $imageData['fullPathWithExt'];

            DB::beginTransaction();

            $user = new User();

            $user->title = $request->post('title');
            $user->initials = $request->post('initials');
            $user->initials_full = $request->post('initials_full');
            $user->first_name = $request->post('first_name');
            $user->gender = $request->post('gender');
            $user->mobile = $request->post('mobile');
            $user->address_no = $request->post('address_no');
            $user->address_street = $request->post('address_street');
            $user->address_city = $request->post('address_city');
            $user->DOB = $request->post('birthday');
            $user->NIC = $request->post('nic');
            $user->email = $request->post('email');
            $user->password = Hash::make($request->post('password'));
//            $user->role_id = $request->post('role_id');
            $user->profile_img = $pathForDB;

            $user->save();

            $user->syncRoles($request->post('role_id'));

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
            DB::rollback();
        }

        if (!File::isDirectory($path)) {
            File::makeDirectory($path);
        }

        if ($request->hasFile('profile_img')) {
            $this->saveImage($request->file('profile_img'), $fullPathWithExt);
            DB::commit();
            activity()->by(Auth::id())->log('created User with ID '.$user->id);
        } else {
            DB::rollback();
        }

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! A new user was added!!',
            ''
        ));
    }





    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function show(Request $request)
    {


        try {
//            //  $this->authorize('read', Auth::user());
//            $userData = User::find($request->id, ['status', 'first_name'])->with('role')->get();

            $user = User::find($request->id);
            $role = $user->getRoleNames()->first();


        } catch (Exception $e) {

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $e->getMessage(),
                ''
            ));
        }

        return response()->json(self::getJSONResponse(
            true,
            '',
            '',
            ['userdata' => $user,'role' => $role]
        ));

    }




    /**
     * @param Request $request
     * @return Factory|View
     */
    public function showUser(Request $request){
        $userID = $request->get('id');

        $userInfo = User::find($userID);
        $role = $userInfo->roles()->pluck('name')->first();

        $logs = Activity::where('causer_id',$userID)->get();

        return view('admin.users.advancedView')->with(['user'=>$userInfo,'role'=>$role,'logs'=> $logs]);
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function edit(Request $request)
    {
        $user = User::find($request->id);
        $roles = Role::all();
        return view('admin.users.edit')->with(['user' => $user, 'roles' => $roles]);
    }






    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateQuick(Request $request)
    {
        $userID = $request->post('userID');
        $userType = $request->post('userType');
        $status = $request->post('userStatus');

        $user = User::find($userID);

        $status = $status == null ? 0 : 1;

        $user->status = $status;


        try {

            $user->syncRoles($userType);


        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];
            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));
        }


        activity()->by(Auth::id())->log('Used quick update to update the User with ID '.$userID);
        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'The user was updated!',
            ''
        ));
    }



    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function updateUser(Request $request)
    {
        $userID = $request->post('id');
        $oldNIC = User::find($userID,['NIC'])['NIC'];

        $newPathData = $this->getImagePath($request->post('nic'));
        $oldPathData = $this->getImagePath($oldNIC);

        $pathForDB = $newPathData['pathForDB'];

        //  $this->authorize('update', Auth::user());

        $request->validate([
            'title' => 'required',
            'initials' => 'required',
            'initials_full' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'mobile' => 'required|min:10',
            'address_no' => 'required',
            'address_street' => 'required',
            'address_city' => 'required',
            'birthday' => 'required|date',
            'nic' => 'required|min:10',
            'email' => 'required',
            'role_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = User::find($userID);

            $user->title = $request->post('title');
            $user->initials = $request->post('initials');
            $user->initials_full = $request->post('initials_full');
            $user->first_name = $request->post('first_name');
            $user->last_name = $request->post('last_name');
            $user->gender = $request->post('gender');
            $user->mobile = $request->post('mobile');
            $user->mobile = $request->post('mobile');
            $user->address_no = $request->post('address_no');
            $user->address_street = $request->post('address_street');
            $user->address_city = $request->post('address_city');
            $user->DOB = $request->post('birthday');
            $user->NIC = $request->post('nic');
            $user->profile_img = $pathForDB;
            $user->email = $request->post('email');
//            $user->role_id = $request->post('role_id');

            $user->save();
            $user->syncRoles($request->post('role_id'));

        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));

            DB::rollback();
        }


        if ($oldNIC !== $request->post('nic')){



            if (File::move($oldPathData['fullPath'],$newPathData['fullPath'])){
                DB::commit();
            }else{
                DB::rollBack();
            }

        }

        DB::commit();


        activity()->by(Auth::id())->log('updated the User with ID '.$userID);

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! User was updated!!',
            ''

        ));
    }




    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePic(Request $request)
    {
        $request->validate([
            'profile_img' => 'required|image'
        ]);

        $nic = $request->post('NIC');
        $users = User::where([
            'NIC' => $nic,
        ])->get(['id'])->first();

        $userID = $users->id;

        $pathInfo = $this->getImagePath($nic);
        $fullPath = $pathInfo['fullPath'];
        $fullPathWithExt = $pathInfo['fullPathWithExt'];



        if (File::exists($fullPathWithExt)){
            File::delete($fullPathWithExt);
        }

        try {
            $this->saveImage($request->file('profile_img'), $fullPathWithExt);
        }catch (Exception $e){

            return response()->json(self::getJSONResponse(
                false,
                'toast',
                $e->getMessage(),
                ''

            ));
        }
        activity()->by(Auth::id())->log('User profile picture was changed for the user '.$userID);
        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! The Profile picture was updated',
            ''

        ));
    }




    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePass(Request $request){


        $request->validate([
            'password' => 'required'
        ]);

        $password = $request->post('password');
        $userID = $request->post('userID');
        $user = User::find($userID);


        $user->password = Hash::make($password);

        try {
            $user->save();
        } catch (QueryException $e) {
            $errorMessage = $e->errorInfo[2];

            return response()->json(self::getJSONResponse(
                false,
                'header',
                $errorMessage,
                ''
            ));

        }

        return response()->json(self::getJSONResponse(
            true,
            'toast',
            'Hooray..! The Password was updated',
            ''

        ));

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

    }




    //Other functions

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function checkUserData(Request $request)
    {
        $type = '';
        $result = [];

        if ($request->post('email')) {
            $type = 'email';
            $result = User::where('email', 'LIKE', $request->post('email'))
                ->get(['id', 'email']);
        }

        if ($request->post('nic')) {
            $type = 'nic';
            $result = User::where('nic', 'LIKE', $request->post('nic'))
                ->get(['id', 'nic']);
        }

        return response()->json((count($result)) > 0 ? array('result' => true, 'id' => $request->post('id'), 'type' => $type) : array('result' => false, 'id' => $request->post('id'), 'type' => $type));

    }




    /**
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getAuthData(){


        $user = Auth::user();

       $permissions  =  $user->getAllPermissions()->pluck('name');


        return \response()->json($permissions);

    }






    /**
     * @param $file
     * @param $path
     */
    private function saveImage($file, $path)
    {
        $img = Image::make($file)->orientate()->resize(600, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->stream($this->imageExtention, 60);
        File::put($path, $img);
    }




    /**
     * @param $nic
     * @return array
     */
    private function getImagePath($nic)
    {
        $pathWithNIC = $this->imagePath . '/' . $nic . '/';
        $fullPath = public_path() . '/images/' . $pathWithNIC;
        $fullPathWithExt = $fullPath.'profile_img'.'.'.$this->imageExtention;
        $pathForDB = $pathWithNIC.'profile_img'.'.'.$this->imageExtention;
        return array('pathWithNic' => $pathWithNIC,
            'fullPath' => $fullPath,
            'fullPathWithExt' => $fullPathWithExt,
            'pathForDB'=>$pathForDB);
    }




}
