<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Reglement_Achat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ReglementAchatController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:reglementachatfilter')->only('filter');
        $this->middleware('permission:reglementachatpaginate')->only('paginate');
        $this->middleware('permission:reglementachatindex')->only('index');
        $this->middleware('permission:reglementachatcreate')->only('store');
        $this->middleware('permission:reglementachatshow')->only('show');
        $this->middleware('permission:reglementachatupdate')->only('update');
        $this->middleware('permission:reglementachatdelete')->only('destroy');

        $this->authorizeResource(Reglement_Achat::class, 'reglement_Achat');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Reglement_Achat::orderBy('date_emission','DESC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(idreg_achat) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Reglement_Achat::with(['factures']);

        if(request()->has('status') && request()->status != '' )
        {
            $req->whereRaw("UPPER(code_soci) = ?", [mb_strtoupper(request()->status)]);
        }

        if(request()->has('start') && request()->start != '' )
        {
            $req->whereDate('date_emission', '>=', request()->start);
        }

        if(request()->has('end') && request()->end != '' )
        {
            $req->whereDate('date_emission', '<=', request()->end);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idreg_achat) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
//                      ->orWhereRaw("montantreg = ?", [request()->search])
                      ->orWhereRaw("UPPER(lib_beneficiaire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(num_ref_justif) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(code_banque) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(prelettrage) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(commentaire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(no_piece_reg) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(noreg_achat) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('tiers', function (Builder $q) {
                            $q->whereRaw("UPPER(compte_tiers.no_cpte_tiers) = ?", [mb_strtoupper(request()->search)]);
                        });
            });
        }

        $displayedColumns = [
            'idreg_achat' => 'idreg_achat',
            'montantreg' => 'montantreg',
            'lib_beneficiaire' => 'lib_beneficiaire',
            'num_ref_justif' => 'num_ref_justif',
            'code_banque' => 'code_banque',
            'prelettrage' => 'prelettrage',
            'commentaire' => 'commentaire',
            'no_piece_reg' => 'no_piece_reg',
            'noreg_achat' => 'noreg_achat',
            'date_emission' => 'date_emission',
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Eolis\Reglement_Achat  $reglement_Achat
     * @return \Illuminate\Http\Response
     */
    public function show(Reglement_Achat $reglement_Achat)
    {
        return response()->json($reglement_Achat, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Eolis\Reglement_Achat  $reglement_Achat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reglement_Achat $reglement_Achat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Eolis\Reglement_Achat  $reglement_Achat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reglement_Achat $reglement_Achat)
    {
        //
    }
}
