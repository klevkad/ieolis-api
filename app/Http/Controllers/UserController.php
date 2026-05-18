<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserResetRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\NouvelUtilisateurTier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:userfilter|userclientfilter')->only('filter');
        $this->middleware('permission:userpaginate|userclientpaginate')->only('paginate');
        $this->middleware('permission:userindex|userclientindex')->only('index');
        $this->middleware('permission:usercreate|userclientcreate')->only('store');
        $this->middleware('permission:usershow|userclientshow')->only('show');
        $this->middleware('permission:userupdate|userclientupdate')->only('update');
        $this->middleware('permission:userpwdupdate|userclientpwdupdate')->only('resetPassword');
        $this->middleware('permission:userdelete|userclientdelete')->only('destroy');

        $this->authorizeResource(\App\Models\User::class, 'user');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        if(request()->has('search') && request()->search != '')
        {
            $req = User::with(['model'])->orderBy('name','ASC')->orderBy('email','ASC');

            $user = User::find(Auth::user()->id);
            if($user->hasPermissionTo('userclientfilter') && !$user->hasPermissionTo('userfilter'))
            {
                $req->whereIn('ct_num',$user->ct_nums);
            }

            $req->whereRaw("UPPER(CONCAT(name, CONCAT(' ', email))) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);
            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = User::with(['model', 'roles', 'ct_nums', 'permissions']);

        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('userclientpaginate') && !$user->hasPermissionTo('userpaginate'))
        {
            $req->whereIn('ct_num',$user->ct_nums);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(name) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(email) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

/*
    {id: '', name: 'Tout'}, 
    {id: '-1', name: 'Autres'}, 
    {id: '0', name: 'Clients'}, 
    {id: '1', name: 'EOLIS'}
*/

        if(request()->has('statut') && request()->statut != '' )
        {
            if( request()->statut == 1 )
            {
                $req->where('model_type','App\Models\Old\Eolis\Username');
            }
            else 
            {
                if( request()->statut == 0 )
                {
                    $req->where('model_type',null)->where('ct_num','LIKE','C%');
                }
                else if( request()->statut == -1 )
                {
                    $req->where('model_type',null)->where('ct_num','NOT LIKE','C%');
                }
            }
        }

        $displayedColumns = [
            'name' => 'name',
            'email' => 'email',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $req = User::with([]);

        $user = User::find(Auth::user()->id);
        if($user->hasPermissionTo('userclientindex') && !$user->hasPermissionTo('userindex'))
        {
            $req->whereIn('ct_num',$user->ct_nums);
        }

        return response()->json($req->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create( $request->except(['role', 'perms', 'password']) + [
            'password' => Hash::make($request->password),
            'enabled' => 1
        ]);

        $user2 = User::find(Auth::user()->id);
        if($user2->hasPermissionTo('userclientcreate') && !$user2->hasPermissionTo('usercreate'))
        {
            if($role = Role::where('name','client-justifs')->get()->first()){
                $user->assignRole( $role );
                $user->update(['home' => $role->home, 'homemobile' => $role->homemobile]);
            }
        }
        else
        {
            if($request->has('role')){
                if($role = Role::find($request->role)){
                    $user->assignRole( $role );
                    $user->update(['home' => $role->home, 'homemobile' => $role->homemobile]);
                }
            }

            if($request->has('perms') && is_array($request->perms)){
                $Perms = Permission::whereIn('id',$request->perms)->get();
                if($Perms->count() > 0){
                    $user->givePermissionTo($Perms->pluck('id')->toArray());
                }
            }
        }

        Mail::send(new NouvelUtilisateurTier($user,$request->password));

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->model;
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $oldRoles = $user->roles;

        $user2 = User::find(Auth::user()->id);
        if(($user2->hasPermissionTo('userclientupdate') && $user2->ct_nums->contains($user->ct_num)) || $user2->hasPermissionTo('userupdate'))
        {
            $user->update( $request->except(['role', 'perms']) );
        }

        if($user2->hasPermissionTo('userupdate'))
        {
            if($request->has('role')){
                if($role = Role::find($request->role)){
                    if( isEmpty($oldRoles) || ($oldRoles[0] && $oldRoles[0]->id != $role->id) ) {
                        $user->syncRoles($role);
                        if( !isEmpty($oldRoles) && $oldRoles[0]->home == $user->home ) {
                            $user->update(['home' => $role->home, 'homemobile' => $role->homemobile]);
                        }
                    }
                }
            }

            if($request->has('perms') && is_array($request->perms)){
                $Perms = Permission::whereIn('id',$request->perms)->get();
                if( $Perms->count() > 0 ){
                    $user->syncPermissions($Perms);
                }
            }
        }

        if($request->has('ct_nums') && is_array($request->ct_nums)){
            $user->ct_nums()->delete();
            $data = [];
            foreach ($request->ct_nums as $ct_num)
            {
                $data[] = ['ct_num' => $ct_num];
            }
            $user->ct_nums()->createMany($data);
        }

        $user->load(['ct_nums','permissions','roles','model']);

        return response()->json($user, 200);
    }

    /**
     * Set the specified user state.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function setUserState(Request $request, User $user)
    {
        $user2 = User::find(Auth::user()->id);
        if(($user2->hasPermissionTo('userclientupdate') && $user2->ct_nums->contains($user->ct_num)) || $user2->hasPermissionTo('userupdate'))
        {
            $user->update(['enabled' => $request->state]);
        }
        return response()->json($user, 200);
    }

    /**
     * Reset the specified user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(UserResetRequest $request, User $user)
    {
        $user2 = User::find(Auth::user()->id);
        if(($user2->hasPermissionTo('userclientpwdupdate') && $user2->ct_nums->contains($user->ct_num)) || $user2->hasPermissionTo('userpwdupdate'))
        {
            $user->update([
                'password' => Hash::make($request->password),
                'change_password' => Auth::user()->id != $user->id ? $request->change_password : 0
            ]);
        }
        return response()->json($user, 200);
    }

    /**
     * Reset the specified user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetSelfPassword(UserResetRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->update([
            'password' => Hash::make($request->password),
            'change_password' => 0
        ]);
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            $user2 = User::find(Auth::user()->id);
            if(($user2->hasPermissionTo('userclientdelete') && $user2->ct_nums->contains($user->ct_num)) || $user2->hasPermissionTo('userdelete'))
            {
                $user->delete();
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
