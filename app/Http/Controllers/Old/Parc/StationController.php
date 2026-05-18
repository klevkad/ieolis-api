<?php

namespace App\Http\Controllers\Old\Parc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Old\Parc\Station;

class StationController extends Controller
{
    public function index()
    {   
        $station = Station::with('distributeurs.produits')->get();
        return response()->json($station, 200);
    }

    public function filter()
    {
        $to = date('Y-m-d');
        $from = date('Y-m-d', strtotime('-60 days',strtotime($to)));

        $req = Station::with('distributeurs.produits');

        if(request()->has('search') && request()->search != '')
        {
            $query->where('stationid','LIKE','%'.request()->search.'%')
            ->orWhere('libellestation','LIKE','%'.request()->search.'%');
            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    public function store(Request $request)
    {
        $station = Station::create($request->all());
        return response()->json($station, 201);
    }

    public function show($id)
    {
        return Station::with('distributeurs.produits')->find($id);
    }

    public function update(Request $request, $id)
    {
        $station = Station::findOrFail($id);
        $station->update($request->all());
        return response()->json($station);
    }

    public function destroy($id)
    {
        Station::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}