<?php

namespace App\Http\Controllers\Old\Parc;

use App\Models\Piece;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PieceController extends Controller
{
    public function index()
    {
        return Piece::with('distributeurs.stations')->get();
    }

    public function store(Request $request)
    {
        $Piece = Piece::create($request->all());
        return response()->json($Piece, 201);
    }

    public function show($id)
    {
        return Piece::with('distributeurs.stations')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $Piece = Piece::findOrFail($id);
        $Piece->update($request->all());
        return response()->json($Piece);
    }

    public function destroy($id)
    {
        Piece::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}