@php
    $wmt_total = 0;
    $amount_total = 0;
    $dnwmt_total = 0;
    $copper_total = 0;
    $silver_total = 0;
    $gold_total = 0;
    $arsenic_total = 0;
    $antomony_total = 0;
    $lead_total = 0;
    $zinc_total = 0;
    $bismuth_total = 0;
    $mercury_total = 0;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Liquidación {{ $batch }} - Innova Mining Company</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        html{
            margin-top: 1.4rem;
            margin-left: 4rem;
            margin-right: 4rem;
            font-size: 14px;
        }
        .container {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            text-align: center;
        }
        table {
        }
        table td, table th {
            text-align: center;
            padding: 0.25rem !important;
        }

    </style>
</head>
<body>
	<div class="container">
		<div class="">
            <table style="width: 100%" class="text-center">
                <tr>
                    <td width="33.4%">
                        <div class="mb-3 ml-6">
                            <img src="https://i.ibb.co/LJ5dBfF/innova-logo.png" alt="Innova Mining Company" style="max-width: 140px;">
                        </div>
                    </td>
                    <td>
                        <div>
                            <p style="margin-bottom: 0px">Los Pinos, Mza. K Lote 10 - San Juan de Lurigancho</p>
                            <p style="margin-bottom: 0px">Teléfono: 943 358 092</p>
                            <p style="margin-bottom: 0px">info@innovaminingcompany.com</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
		<div class="container">
            <hr>
            <div class="mt-4">
                <h2 class="text-center">
                    Órdenes {{ $shipped ? 'Enviadas' : 'Despachadas' }}
                </h2>
            </div>
            <table class="table table-bordered" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">LOTE</th>
                        <th scope="col">CONCENTRADO</th>
                        <th scope="col">TMH</th>
                        <th scope="col">TMNS</th>
                        <th scope="col">SUBTOTAL</th>
                        <th scope="col">IGV</th>
                        <th scope="col">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dispatchDetails as $dispatchDetail)
                    @php
                        $factor = $dispatchDetail->Settlement->Law->tmns/$dispatchDetail->Settlement->Order->wmt;
                        $wmt = round($dispatchDetail->wmt,3);
                        $dnwmt = round($wmt*$factor,3);
                        $igv = round($dispatchDetail->Settlement->SettlementTotal->igv*$wmt/$dispatchDetail->Settlement->Order->wmt,2);
                        $amount = round(($dispatchDetail->Settlement->SettlementTotal->batch_price+$dispatchDetail->Settlement->SettlementTotal->igv)*$wmt/$dispatchDetail->Settlement->Order->wmt,2);
                        $wmt_total += $wmt;
                        $amount_total += $amount;
                        $dnwmt_total += $dnwmt;
                        $copper_total += $dnwmt*$dispatchDetail->Settlement->Law->copper;
                        $silver_total += $dnwmt*$dispatchDetail->Settlement->Law->silver;
                        $gold_total += $dnwmt*$dispatchDetail->Settlement->Law->gold;
                        $arsenic_total += $dnwmt*$dispatchDetail->Settlement->Penalty->arsenic;
                        $antomony_total += $dnwmt*$dispatchDetail->Settlement->Penalty->antomony;
                        $lead_total += $dnwmt*$dispatchDetail->Settlement->Penalty->lead;
                        $zinc_total += $dnwmt*$dispatchDetail->Settlement->Penalty->zinc;
                        $bismuth_total += $dnwmt*$dispatchDetail->Settlement->Penalty->bismuth;
                        $mercury_total += $dnwmt*$dispatchDetail->Settlement->Penalty->mercury;
                    @endphp
                    <tr>
                        <td>{{ $dispatchDetail->Settlement->batch }}</td>
                        <td>{{ $dispatchDetail->Settlement->Order->Concentrate->concentrate }}</td>
                        <td>{{ number_format($wmt,3) }}</td>
                        <td>{{ number_format($dnwmt,3) }}</td>
                        <td>$ {{ number_format($amount-$igv,2) }}</td>
                        <td>$ {{ number_format($igv,2) }}</td>
                        <td>$ {{ number_format($amount,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <h3 class="text-center">
                    Promedio de Leyes
                </h3>
            </div>
            <table class="table table-bordered" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Cobre</th>
                        <th scope="col">Plata</th>
                        <th scope="col">Oro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($copper_total/$dnwmt_total,3) }}</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($silver_total/$dnwmt_total,3) }}</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($gold_total/$dnwmt_total,3) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="m-4">
                <h3 class="text-center">
                    Promedio de Penalidades
                </h3>
            </div>
            <table class="table table-bordered" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Elemento</th>
                        <th scope="col">Penalidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>As</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($arsenic_total/$dnwmt_total,3) }}</td>
                    </tr>
                    <tr>
                        <td>Sb</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($antomony_total/$dnwmt_total,3) }}</td>
                    </tr>
                    <tr>
                        <td>Bi</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($bismuth_total/$dnwmt_total,3) }}</td>
                    </tr>
                    <tr>
                        <td>Pb</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($lead_total/$dnwmt_total,3) }}</td>
                    </tr>
                    <tr>
                        <td>Zn</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($zinc_total/$dnwmt_total,3) }}</td>
                    </tr>
                    <tr>
                        <td>Hg</td>
                        <td>{{ $dnwmt_total == 0 ? 0 : number_format($mercury_total/$dnwmt_total,3) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="m-4">
                <h3 class="text-center">
                    Total
                </h3>
            </div>
            <table class="table table-bordered" style="width: 100%">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">TMH</th>
                        <th scope="col">TMNS</th>
                        <th scope="col">MONTO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">{{ number_format($wmt_total,3) }}</th>
                        <th scope="row">{{ number_format($dnwmt_total,3) }}</th>
                        <th scope="row">$ {{ number_format($amount_total,2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
	</div>
</body>
</html>
