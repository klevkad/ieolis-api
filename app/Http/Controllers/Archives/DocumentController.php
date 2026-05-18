<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Models\Archives\Document;
use App\Models\Old\Eolis\Facentet;
use App\Models\Old\Eolis\View_Facentet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:documentfilter')->only('filter');
        $this->middleware('permission:documentpaginate')->only('paginate');
        $this->middleware('permission:documentindex')->only('index');
        $this->middleware('permission:documentcreate')->only('store');
        $this->middleware('permission:documentshow')->only('show');
        $this->middleware('permission:documentupdate')->only('update');
        $this->middleware('permission:documentdelete')->only('destroy');

        $this->authorizeResource(Document::class, 'document');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Document::orderBy('nodossier','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(nodossier) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Document::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(nodossier) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->whereRaw("UPPER(description) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->whereRaw("UPPER(titre) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->whereRaw("UPPER(nodocument) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->whereRaw("UPPER(destinataire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        $displayedColumns = [
            'nodossier' => 'nodossier',
            'description' => 'description',
            'titre' => 'titre',
            'nodocument' => 'nodocument',
            'destinataire' => 'destinataire',
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
    public function file($id)
    {
        $values = mb_split('_', $id);
        $document = Document::where([
            ['doctypes_second_level_id', '=', $values[0]],
            ['nodossier', '=', $values[1]],
            ['doctypes_ligne', '=', $values[2]],
        ])->firstOrFail();

        $start = 15;
        $filename = str_replace('/', '\\', mb_substr($document->chemin_enregistre, $start));

        $facture = View_Facentet::find($values[1]);
        if($facture && sizeof($facture->consultations) == 0)
        {
            $facture->consultations()->attach(Auth::user()->id,['date_consult' => now()]);
        }

        return Storage::disk('ftp')->download(mb_strtoupper(pathinfo($filename, PATHINFO_DIRNAME).'\\'.pathinfo($filename, PATHINFO_FILENAME)).".".pathinfo($filename, PATHINFO_EXTENSION));
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
     * @param  \App\Models\Archives\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return response()->json($document, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Archives\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archives\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
