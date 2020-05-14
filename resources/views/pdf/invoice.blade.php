<h1>{{ config('app.name') }}</h1>

<h2>Invoice #{{ $payment->invoice_nr }}</h2>

<p><b>Item: {{ $payment->description }}</b></p>

<p>We hereby charge you {{ $payment->currency }} {{ $payment->amount }}. Thank's a lot!</p>

<p>Your Marqant Team!</p>

{{-- new --}}

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Invoice #{{ $payment->invoice_nr }}</title>

    <style type="text/css">
        body {
            font-family: 'Verdana';
            color: #222;
        }

        body, html {
            padding: 0;
            margin: 0;
        }

        .page {
            page-break-inside: avoid;
            padding: 0 60px 0 60px;
            position: relative;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fontXS {
            font-size: 0.8em;
        }

        table td {
            padding: 4px 6px;
            margin: 0;
        }

        tr.top2border td,
        td.top2border,
        th.top2border {
            border-top: 1pt solid black;
        }

        tr.bottom2border th {
            border-bottom: 1pt solid black;
        }

        td.bottomDoubleBorder,
        th.bottomDoubleBorder {
            border-bottom: 4pt double #999;
        }

        .leistungsrow {
        }

        .paddrow td {
            height: 5px;
            line-height: 0;
        }

        .heads th {
            font-size: 0.9em;
            height: 1.6em;
            color: #444;
        }

        .anschriftright {
            font-size: 0.9em;
            color: #666;
            float: right;
            text-align: right;
        }

        .zahlbarbis {
            margin: 70px 0 20px 0;
        }

        .zahlbarbis div {
            font-size: 0.8em;
        }

        .previewstamp {
            position: absolute;
            top: 120px;
            right: 50px;
            font-size: 20pt;
            color: darkred;
            font-weight: bold;
            text-transform: uppercase;
            transform: rotate(-5deg);
        }
    </style>

</head>

<body>

<div class="page">
    <div class="anschriftright">
        <br>
        <br>
        <br><br>
        <p>&nbsp;</p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
    <div>
        <br>
        <br>
        <p>&nbsp;</p>
        <b>{{ $payment->billable->name }}</b><br>
        {{ $payment->billable->street }}<br>
        {{ $payment->billable->zip }}&nbsp;{{ $payment->billable->city }}<br>
        @if ($payment->billable->uid)
            {{ $payment->billable->uid }}
        @endif
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div style="float:right;font-size:0.9em;">
        <br>
        <br>
        Wien, am {{ $payment->created_at->format('d.m.Y') }}
    </div>
    @if($payment->status == 'pending')
        <div class="previewstamp">
            RECHNUNGSVORSCHAU
        </div>
    @endif
    @if($payment->status == 'canceled')
        <div class="previewstamp">
            STORNIERT
        </div>
    @endif
    <h2 style="margin:0 0 2px 0;padding:0;font-size:1.3em;">
        Rechnung
        <span style="font-size:0.9em">#{{ $payment->invoice_nr }}</span>
    </h2>
    <br/>
    <div style="font-size:0.9em">
        <b>Leistungszeitraum:</b> &nbsp; {{ $payment->created_at->subMonth()->format('d.m.Y') }}
        - {{ $payment->created_at->format('d.m.Y') }}<br>
        <b>Projekt:</b> &nbsp; {{ $payment->description }}
    </div>
    <br>
    <table class="table table-striped table-hover" border="0" cellpadding="0" cellspacing="0" width="100%"
           style="font-size:0.94em;">
        <tbody>
        <tr class="bottom2border heads">
            <th width="10%" class="text-center">Anzahl</th>
            <th width="58%" style="text-align:left">Leistung</th>
            <th width="16%" class="text-right">Preis</th>
            <th width="16%" class="text-right">Gesamt</th>
        </tr>
        <tr class="paddrow">
            <td colspan="4"></td>
        </tr>
        @if ($payment->subscription)
            @foreach($payment->billable->plans()->whereNull('provider')->get() as $plan)
                <tr class="leistungsrow">
                    <td class="text-center">
                        1
                    </td>
                    <td>
                        {{ $plan->name }}
                    </td>
                    <td class="text-right" style="font-size:0.93em;">
                        {{ $plan->amount }}
                    </td>
                    <td class="text-right" style="font-size:0.93em;">
                        {{ $plan->amount_gross }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr class="leistungsrow">
                <td class="text-center">
                    1
                </td>
                <td>
                    {{ $payment->description }}
                </td>
                <td class="text-right" style="font-size:0.93em;">
                    {{ $payment->amount }}
                </td>
                <td class="text-right" style="font-size:0.93em;">
                    {{ $payment->amount_gross }}
                </td>
            </tr>
        @endif
        <tr class="paddrow">
            <td colspan="4">
            </td>
        </tr>
        <tr class="top2border">
            <td>
                &nbsp;
            </td>
            <td class="text-right">
                <b>Gesamt Netto:</b>
            </td>
            <td colspan="2" class="text-right bottom2border">
                <b id="sum_before_taxes">
                    {{ $payment->amount }}
                </b>
            </td>
        </tr>
        @if(!$payment->billable->uid ?? true)
            <tr>
                <td>
                    &nbsp;
                </td>
                <td class="text-right">
                    Ust. 20%:
                </td>
                <td colspan="2" class="text-right">
                    <!-- TODO: add tax amount to payment -->
                    {{ $payment->amount_gross - $payment->amount }}
                </td>
            </tr>
        @endif
        <tr>
            <td>
                &nbsp;
            </td>
            <td class="text-right">
                <b>Gesamt Brutto:</b>
            </td>
            <td colspan="2" class="text-right top2border bottomDoubleBorder">
                <b>
                    {{ $payment->amount_gross }}
                </b>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>