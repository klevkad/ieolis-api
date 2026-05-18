<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use \Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:permissionfilter')->only('filter');
        $this->middleware('permission:permissionpaginate')->only('paginate');
        $this->middleware('permission:permissionindex')->only('index');
        $this->middleware('permission:permissioncreate')->only('store');
        $this->middleware('permission:permissionshow')->only('show');
        $this->middleware('permission:permissionupdate')->only('update');
        $this->middleware('permission:permissiondelete')->only('destroy');

        $this->authorizeResource(Spatie\Permission\Models\Permission::class, 'permission');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Permission::orderBy('libelle','ASC');

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
        $req = Permission::with([]);

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
        return response()->json(Permission::orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        $Permission = Permission::create($request->all());
        return response()->json($Permission, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        return response()->json($permission, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, Permission $permission)
    {
        $permission->update($request->except(['id']));
        return response()->json($permission, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        try{
            $permission->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
