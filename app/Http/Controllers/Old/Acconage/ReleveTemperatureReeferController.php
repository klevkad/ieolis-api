<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Acconage\ReleveTemperatureReeferCreateRequest;
use App\Http\Requests\Old\Acconage\ReleveTemperatureReeferUpdateRequest;
use App\Models\Old\Acconage\ReleveTemperatureReefer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReleveTemperatureReeferController extends Controller
{

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = ReleveTemperatureReefer::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_shift) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereRaw("date_releve LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("return_air LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("supply_air LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("UPPER(codeuser) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereHas('releveshift', function (Builder $q) {
                    $q->whereRaw("UPPER(moment) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('date_releve',request()->statut);
        }

        $displayedColumns = [
            'lib_shift' => 'lib_shift',
            'date_releve' => 'date_releve',
            'return_air' => 'return_air',
            'supply_air' => 'supply_air',
            'codeuser' => 'codeuser',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReleveTemperatureReeferCreateRequest $request)
    {
        $releveTemperatureReefer = ReleveTemperatureReefer::create($request->all() + [
            'date_releve' => date('Y-m-d'),
            'saisie_le' => now(),
            'codeuser' => Auth::user()->name,//Auth::user()->model->codeuser,
        ]);
        return response()->json($releveTemperatureReefer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\ReleveTemperatureReefer  $releveTemperatureReefer
     * @return \Illuminate\Http\Response
     */
    public function show(ReleveTemperatureReefer $releveTemperatureReefer)
    {
        return response()->json($releveTemperatureReefer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\ReleveTemperatureReefer  $releveTemperatureReefer
     * @return \Illuminate\Http\Response
     */
    public function update(ReleveTemperatureReeferUpdateRequest $request, ReleveTemperatureReefer $releveTemperatureReefer)
    {
        $releveTemperatureReefer->update($request->except(['id']));
        return response()->json($releveTemperatureReefer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\ReleveTemperatureReefer  $releveTemperatureReefer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleveTemperatureReefer $releveTemperatureReefer)
    {
        try{
            $releveTemperatureReefer->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
