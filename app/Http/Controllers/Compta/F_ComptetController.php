<?php

namespace App\Http\Controllers\Compta;

use App\Http\Controllers\Controller;
use App\Models\Compta\F_Comptet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class F_ComptetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:fcomptetfilter')->only('filter');
        $this->middleware('permission:fcomptetpaginate')->only('paginate');
        $this->middleware('permission:fcomptetindex')->only('index');
        $this->middleware('permission:fcomptetcreate')->only('store');
        $this->middleware('permission:fcomptetshow')->only('show');
        $this->middleware('permission:fcomptetupdate')->only('update');
        $this->middleware('permission:fcomptetdelete')->only('destroy');

        $this->authorizeResource(App\Models\Compta\F_Comptet::class, 'fcomptet');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = F_Comptet::orderBy('ct_num','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $user = User::find(Auth::user()->id);
            if($user->hasPermissionTo('userclientupdate') && !$user->hasPermissionTo('userupdate'))
            {
                $req->whereIn('ct_num',$user->ct_nums);
            }
            $req->where('ct_num','LIKE','C'.request()->search.'%')->limit(50);
            /*
            $req->where(function ($query) {
                $query->where('no_booking','LIKE','%'.request()->search.'%')
                      ->orWhere('date_demande','LIKE','%'.request()->search.'%');
            });
            */
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
        return response()->json(F_Comptet::orderBy('ct_num','ASC')->paginate(request()->size), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compta\F_Comptet  $f_Comptet
     * @return \Illuminate\Http\Response
     */
    public function show(F_Comptet $f_Comptet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compta\F_Comptet  $f_Comptet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, F_Comptet $f_Comptet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compta\F_Comptet  $f_Comptet
     * @return \Illuminate\Http\Response
     */
    public function destroy(F_Comptet $f_Comptet)
    {
        //
    }
}
