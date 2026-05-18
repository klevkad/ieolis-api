@extends('layouts.documents')

@section('content')
        <div style="width: 100%" align="center">
            <table border="1px" style="border-collapse: collapse; border-spacing: 0;" width="100%" cellpadding=0 cellspacing=0>
                <tr>
                    <td style="border: none; width: 26%;"></td>
                    <td style="border: none; width: 11%;"></td>
                    <td style="border: none; width: 11%;"></td>
                    <td style="border: none; width: 8%;"></td>
                    <td style="border: none; width: 9%;"></td>
                    <td style="border: none; width: 11%;"></td>
                    <td style="border: none; width: 24%;"></td>
                </tr>

                <tr valign="top">
                    <td colspan="3" style="height: 20mm;">
                        <span style="font-size: 3mm;">Chargeurs</span>
                        <div style="margin-top: 3mm;" align="center"> <strong> {{$data['dmd']->client->liboper}} </strong> </div>
                    </td>
                    <td colspan="4" rowspan="4">
                        <div> 
                          <strong> BULLETIN D'EMBARQUEMENT N° </strong> 
                          <img style="float: right;" src="{{$data['dmd']->qrcodelink}}" alt="qrcode" width="100" height="100">
                        </div>
                        <div style="margin-left: 15mm;">
                          (MATE'S RECEIPT)
                          <div style="margin-left: 25mm; font-size: 2mm;">
                            Booking Ref.:<br>
                            Connaissement n° :<br>
                            N° Dossier :10140421<br>
                            N° Facture Fret :<br>
                            Freight Ref. :<br>
                          </div>
                        </div>
                        <div> <u>CARRIER :</u> &nbsp;&nbsp; <strong style="font-size: 16px;"> {{ $data['req']->carrier }} </strong> </div>
                        <div style="margin: 15mm 0mm; font-size: 5mm;">BOOKING N°{{ $data['dmd']->no_booking }} </div>
                        <u>AGENT :</u>
                        <div align="center" style="font-weight: bold;"> {!! nl2br(e($data['req']->agent,false)) !!} </div>
                    </td>
                </tr>

                <tr valign="top">
                    <td colspan="3" style="height: 30mm;">
                        <span style="font-size: 3mm;">Destinataire</span>
                        <div style="margin-top: 2mm;" align="center"> <strong> {!! nl2br(e($data['req']->destinataire,false)) !!} </strong> </div>
                    </td>
                </tr>

                <tr valign="top">
                    <td colspan="3" style="height: 20mm;">
                        <span style="font-size: 3mm;">A notifier</span>
                        <div style="margin-top: 2mm;" align="center"> <strong> {!! nl2br(e($data['req']->anotifier,false)) !!} </strong> </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <table border="1px" style="border-collapse: collapse; border-spacing: 0;" width="100%" cellpadding=0 cellspacing=0>
                            <tr>
                                <td colspan="2">
                                    <span style="font-size: 3mm;">Pré-Transport</span>
                                    <div align="center"> <strong> {{ $data['req']->pretrans }} </strong> </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <span style="font-size: 3mm;">Navire prévu</span>
                                    <div align="center"> <strong> {{ $data['dmd']->escale->navire->libnavire }} </strong> </div>
                                </td>
                                <td>
                                    <span style="font-size: 3mm;">ETA</span>
                                    <div align="center"> <strong> {{ date('d/m/Y', strtotime($data['dmd']->escale->etad)) }} </strong> </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <table width="100%" cellpadding=0 cellspacing=0>
                                        <tr>
                                            <td>
                                                <span style="font-size: 3mm;">Port de déchargement</span>
                                                <div align="left"> <strong> {{ $data['dmd']->destination->libport }} </strong> </div>
                                            </td>
                                            <td>
                                                <span style="font-size: 3mm;">Destination Finale</span>
                                                <div align="left"> <strong> {{ $data['req']->destfin }} </strong> </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr align="center" style="height: 10mm;">
                    <td style="font-size: 2.5mm;">
                        Marques et numéros &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Numéro de conteneur <br> Numéro de plomb 
                    </td>
                    <td colspan="4" style="font-size: 2.5mm;">
                        Nombre et nature des paquets; <br>
                        description des marchandises
                    </td>
                    <td style="font-size: 2.5mm;"> Poids Brut </td>
                    <td style="font-size: 2.5mm;"> Dimensions </td>
                </tr>

                <tr align="center" valign="top">
                    <td>
                        <strong> {{ $data['dmd']->bookingtc->nb_tcs }} </strong>
                    </td>
                    <td colspan="4" style="font-weight: bold;">
                        <div style="height: 70mm;"> {!! nl2br(e($data['req']->descrmarch,false)) !!} </div>
                        <div> Date de posit. : {{ date('d/m/Y', strtotime($data['dmd']->bookingtc->date_posit_souhait)) }} </div>
                        <table align="center" cellpadding=0 cellspacing=0>
                            <tr>
                                <td> Temperature: {{ $data['dmd']->bookingtc->paramtcreefer->setpoint }} °C </td>
                                <td> Ouverture: {{ $data['dmd']->bookingtc->paramtcreefer->volet }} m<sup>3</sup>/h </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <strong> {{ $data['req']->poidsbrut }} kg </strong>
                    </td>
                    <td>
                        <strong> {!! nl2br(e($data['req']->dimensions,false)) !!} </strong>
                    </td>
                </tr>

                <tr>
                    <td colspan="7" align="center" style="height: 4mm; font-size: 3mm;"> Détails fournis par le Marchand </td>
                </tr>

                <tr valign="top">
                    <td colspan="3" rowspan="4">
                        <span style="font-size: 3mm;">Détails du fret, frais etc</span>
                        <div style="margin-top: 3mm;"> {!! nl2br(e($data['req']->detailsfret,false)) !!} </div>
                    </td>
                    <td colspan="4">
                        <table width="100%">
                            <tr align="center"><td colspan="3"> Mode de transport maritime </td></tr>
                            <tr valign="center">
                                <td> BL direct </td>
                                <td> <input type="checkbox" {{ $data['req']->bldirectoui ? 'checked' : '' }} > Oui </td>
                                <td> <input type="checkbox" {{ $data['req']->bldirectnon ? 'checked' : '' }} > Non </td>
                            </tr>
                            <tr valign="center">
                                <td> Conventionnel </td>
                                <td colspan="2"> <input type="checkbox" {{ $data['req']->conventionnel ? 'checked' : '' }} > </td>
                            </tr>
                            <tr valign="center">
                                <td> Vrac </td>
                                <td colspan="2"> <input type="checkbox" {{ $data['req']->vrac ? 'checked' : '' }} > </td>
                            </tr>
                            <tr valign="center">
                                <td> Conteneur </td>
                                <td> <input type="checkbox" {{ $data['req']->conteneurFCLFCL ? 'checked' : '' }} > FCLFCL </td>
                                <td> <input type="checkbox" {{ $data['req']->conteneurLCLLCL ? 'checked' : '' }} > LCLLCL </td>
                            </tr>
                            <tr><td colspan="3" style="font-size: 3mm;"> Nombre de connaissements originaux </td></tr>
                        </table>
                    </td>
                </tr>

                <tr align="center">
                    <td colspan="4">
                        DEMANDE DE PESEE SOLAS
                    </td>
                </tr>

                <tr align="center">
                    <td colspan="2"> EOLIS CI </td>
                    <td colspan="2"> TIERS </td>
                </tr>

                <tr align="center">
                    <td colspan="2"> {{ $data['req']->solas == 'eolis' ? 'X' : '' }} </td>
                    <td colspan="2"> {{ $data['req']->solas == 'tiers' ? 'X' : '' }} </td>
                </tr>

                <tr>
                    <td colspan="2" style="height: 9mm;" align="center">
                        <table width="100%" cellpadding=0 cellspacing=0>
                            <tr>
                                <td> Chargeur: </td>
                                <td> <strong> {{ $data['req']->chargeur }} </strong> </td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2" valign="top">
                        <span style="font-size: 3mm;">Fret payable à</span>
                        <div align="center"> {{ $data['req']->fretpay }} </div>
                    </td>
                    <td colspan="3" align="center"> <strong> Abidjan, le {{ date( 'd/m/Y', strtotime($data['dmd']->date_demande) ) }} </strong> </td>
                </tr>

                <tr align="center" valign="top" style="font-size: 3mm;">
                    <td style="height: 20mm;"> Le transitaire: </td>
                    <td colspan="2"> L' agent: <br> EOLIS <br>
                        <img style="height: 13mm; width: 32mm;" src="{{ $data['dmd']->si_valider == 1 ? 'storage/cachet-com.png' : '' }}" />
                    </td>
                    <td colspan="2"> L' acconier: <br> EOLIS </td>
                    <td colspan="2"> Le SD capitaine </td>
                </tr>
            </table>    
        </div>
@endsection
