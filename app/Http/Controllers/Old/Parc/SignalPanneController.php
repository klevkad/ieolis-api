<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engins\SignalPanneCreateRequest;
use App\Http\Requests\Engins\SignalPanneUpdateRequest;
use App\Models\Old\Parc\SignalPanne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Ladumor\OneSignal\OneSignal;


class SignalPanneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(SignalPanne::orderBy('created_at','DESC')->get(), 200);
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = SignalPanne::with(['lieu', 'engin']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(description) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('incharge'))
        {
            if(request()->incharge == 'BEAC')
            {
                $req->whereDoesntHave('reception_batterie', function (Builder $q) {// En attente de charge
                    //$q->doesntHave('charges');
                });
            }
        }

        if(request()->has('type') && request()->type != '')
        {
            $req->where('categorie_panne_id', request()->type);
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->whereHas('engin', function (Builder $q) {
                $q->where('codetype', request()->statut);
            });
        }

        $displayedColumns = [
            'idengin' => 'idengin',
            'lieu' => 'lieu',
            'description' => 'description',
            'created_at' => 'created_at',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignalPanneCreateRequest $request)
    {
        $request->merge([
            'idengin' => mb_strtoupper($request->idengin),
        ]);

        if($request->categorie_panne_id == 2) //SI BATTERIE DECHARGEE
        {
            $sps = SignalPanne::where([
                ['idengin', '=', $request->idengin],
                ['categorie_panne_id', '=', $request->categorie_panne_id]
            ])->whereDoesntHave('attribution_batterie')->get();

            if($sps->count())
            {
//                return response()->json($sps, 403);
            }
        }

        $signalPanne = SignalPanne::create($request->all());
        $signalPanne->lieu;

        $notificationMsg = ($signalPanne->categorie_panne_id === 2 ? 'Batterie Déchargée' : 'Panne signalée').' sur le '.$signalPanne->idengin;
//        OneSignal::sendPush([], $notificationMsg);
/*
        $response = $this->sendMessage($signalPanne->categorie_panne_id === 2 ? 'Batterie Déchargée' : 'Nouvelle Panne',$notificationMsg,$signalPanne);
        $return["allresponses"] = $response;
        $return = json_encode($return);
*/
        return response()->json($signalPanne, 201);
    }

    public function storeWithVideo(SignalPanneCreateRequest $request)
    {
        $request->merge([
            'idengin' => mb_strtoupper($request->idengin),
        ]);

        $signalPanne = SignalPanne::create($request->except(['video']));

        if( $request->has('file') && ($file = $request['file']) )
        {
            $path = Storage::disk('public')->path('video/signalpanne/'.$signalPanne->idengin);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('video/signalpanne/'.$signalPanne->idengin.'/'.$signalPanne->id.$file['ext']);
            Storage::disk('public')->delete($path);

            $image = $file['data'];  // base64 encoded
            $image = preg_replace('#(data:image\/[^;]+;base64,)#', '', $image);
            $image = str_replace(' ', '+', $image);
            File::put($path, base64_decode($image));
        }

        if( $video = $request->file('video') )
        {
            $path = Storage::disk('public')->path('video/signalpanne/'.$signalPanne->idengin);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('video/signalpanne/'.$signalPanne->idengin.'/'.$signalPanne->id.'.mp4');
            Storage::delete($path);

            Storage::disk('public')->putFileAs('video/signalpanne/'.$signalPanne->idengin, $request->file('video'), $signalPanne->id.'.mp4');
        }
        $signalPanne->lieu;

        $notificationMsg = ($signalPanne->categorie_panne_id === 2 ? 'Batterie Déchargée' : 'Panne signalée').' sur le '.$signalPanne->idengin;
//        OneSignal::sendPush([], $notificationMsg);
/*
        $response = $this->sendMessage($signalPanne->categorie_panne_id === 2 ? 'Batterie Déchargée' : 'Nouvelle Panne',$notificationMsg,$signalPanne);
        $return["allresponses"] = $response;
        $return = json_encode($return);
*/
//        $data = json_decode($response, true);
//        print_r($data);
//        $id = $data['id'];
//        print_r($id);

//        print("\n\nJSON received:\n");
//        print($return);
//        print("\n");

        return response()->json($signalPanne, 201);
    }

    public function sendMessage($title, $message, $spanne) {
        $headings = array(
            "en" => $title
        );
        $content = array(
            "en" => $message
        );
        $hashes_array = array();
        /*
        array_push($hashes_array, array(
            "id" => "like-button",
            "text" => "Like",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://yoursite.com"
        ));
        array_push($hashes_array, array(
            "id" => "like-button-2",
            "text" => "Like2",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://yoursite.com"
        ));
        */
        $fields = array(
            'app_id' => env('ONE_SIGNAL_APP_ID'),
            'included_segments' => array(
                /*'Subscribed Users',*/ $spanne->categorie_panne_id === 2 ? 'Battery Low Users' : 'Mechanic Issue Users'
            ),
            'data' => array(
                "panneId" => $spanne->id,
                "panne" => $spanne,
            ),
            'contents' => $content,
            'headings' => $headings,
            'web_buttons' => $hashes_array
        );        

        $fields = json_encode($fields);
//        print("\nJSON sent:\n");
//        print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.env('ONE_SIGNAL_AUTHORIZE')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return \Illuminate\Http\Response
     */
    public function show(SignalPanne $signalPanne)
    {
        $signalPanne->load(['lieu']);
        return response()->json($signalPanne, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return \Illuminate\Http\Response
     */
    public function update(SignalPanneUpdateRequest $request, SignalPanne $signalPanne)
    {
        $signalPanne->update($request->except(['id']));
        $signalPanne->lieu;
        return response()->json($signalPanne, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\SignalPanne  $signalPanne
     * @return \Illuminate\Http\Response
     */
    public function destroy(SignalPanne $signalPanne)
    {
        try{
            $signalPanne->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
