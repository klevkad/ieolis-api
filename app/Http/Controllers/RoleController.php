<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\User;
use \Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rolefilter')->only('filter');
        $this->middleware('permission:rolepaginate')->only('paginate');
        $this->middleware('permission:roleindex')->only('index');
        $this->middleware('permission:rolecreate')->only('store');
        $this->middleware('permission:roleshow')->only('show');
        $this->middleware('permission:roleupdate')->only('update');
        $this->middleware('permission:roledelete')->only('destroy');

        $this->authorizeResource(Spatie\Permission\Models\Role::class, 'role');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Role::orderBy('libelle','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Role::with(['permissions']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(name) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(guard_name) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }

        $displayedColumns = [
            'name' => 'name',
            'libelle' => 'libelle',
            'guard_name' => 'guard_name',
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
        return response()->json(Role::orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        $role = Role::create($request->all());

        $Perms = Permission::whereIn('id',$request->perms)->get();
        if( $Perms->count() > 0 ){
            $role->givePermissionTo($Perms);
        }
        return response()->json($role, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return response()->json($role, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $oldHome = $role->home;
        $role->update($request->except(['id']));

        $Perms = Permission::whereIn('id',$request->perms)->get();
        if( $Perms->count() > 0 ){
            $role->syncPermissions($Perms);
        }

        User::role($role->name)/*->where('home',$oldHome)*/->update(['home' => $request->home]);

        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        try{
            $role->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
