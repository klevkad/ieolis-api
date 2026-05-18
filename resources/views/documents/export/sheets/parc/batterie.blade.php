<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>

        <table>
            <thead>
                <tr>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 100px;" valign="center" align="center"> CODE </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> CAPACITE </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 100px;" valign="center" align="center"> TENSION </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> ACQUISITION </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> ETAT </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 300px; word-wrap: break-word;" valign="center" align="center"> STATUT </th>
                    <!--
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> TPS TRAVAIL MOY. </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> TPS CHARGE MOY. </th>
                    -->
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 100px;" valign="center" align="center"> ACTIF </th>
                </tr>
            </thead>
            <tbody>
            @foreach($batteries as $key => $batterie)
                <tr>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($batterie->libelle) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($batterie->capacite) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($batterie->tension) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_substr($batterie->acquisition,0,10) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($batterie->batterieetat->libelle) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500; word-wrap: break-word;" valign="center" align="center" nowrap>{{ mb_strtoupper($batterie->status) }}</td>
                    <!--
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ $batterie->workingtimemoy }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ $batterie->tpschargemoy }}</td>
                    -->
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ $batterie->enabled == 1 ? 'OUI' : 'NON' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @foreach($batteries as $key => $batterie)
        @if(sizeof($batterie->workingtimes) > 0)
        <br>
        <br>
        <table>
            <thead>
                <tr>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 100px;" valign="center" align="center"> DATE </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> ENGINS </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 100px;" valign="center" align="center"> DUREE TRAVAIL </th>
                    <th style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 200px;" valign="center" align="center"> DUREE CHARGE </th>
                </tr>
            </thead>
            <tbody>
            @foreach($batterie->workingtimes as $key => $workingtime)
                <tr>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $workingtime['attribution']->debut)->format('d-m-Y') }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($workingtime['attribution']->idengin) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($workingtime['tpsactivite']) }}</td>
                    <td style="border: 1px solid #000; font-size: 11px; font-weight: 500;" valign="center" align="center" nowrap>{{ mb_strtoupper($workingtime['charge']->tpscharge) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="border: 1px solid #000; font-size: 11px; font-weight: 500; width: 100px;" valign="center" align="center">
                        {{mb_strtoupper($batterie->libelle)}}
                    </td>
                </tr>
            </tfoot>
        </table>
        @endif
    @endforeach

    </body>
</html>
