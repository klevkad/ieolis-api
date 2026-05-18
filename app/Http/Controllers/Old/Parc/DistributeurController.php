<?php

namespace App\Http\Controllers\Old\Parc;

use App\Models\Distributeur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistributeurController extends Controller
{
    public function index()
    {
        $distributeur = Distributeur::with('stations', 'produits')->get();
        return response()->json($distributeur, 200);
    }

    public function store(Request $request)
    {
        $distributeur = Distributeur::create($request->all());
        return response()->json($distributeur, 201);
    }

    public function show($id)
    {
        return Distributeur::with('stations', 'produits')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $distributeur = Distributeur::findOrFail($id);
        $distributeur->update($request->all());
        return response()->json($distributeur);
    }

    public function destroy($id)
    {
        Distributeur::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}