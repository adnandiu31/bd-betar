<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export</title>
    <style>
        body {
            padding: 20px 15px;
        }

        .header_top {
            text-align: center;
            font-size: large;
            font-weight: 500;
        }

        table, td, th {
            border: 1px solid black;
        }

        th {
            font-size: 12px;
            font-weight: 800;
        }

        td {
            font-size: 12px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Define styles for the container */
        .container {
            display: inline-block;
            width: 80%;
            margin-top: 400px;
        }

        /* Style for each employee card */
        .employee-card {
            width: 32%;
            padding: 2px;
            display: inline-block;
        }

        .employee-card img {
            max-width: 25px;
            max-height: 25px;
        }
        .date {
            text-align: right;
        }
    </style>
</head>

<body>
<div class="header">
    <div class="header_top">
        <p>{{Auth::user()->station->name}}</p>
        <p> Request for Technical/Stationery Supplies</p>
    </div>
    <p class="date">Date: {{date('Y-m-d', strtotime($sib->created_at))}}</p>
</div>
<div class="table_area">
    @if ($sib->product_type === 'instrument')
        <table>
            <tr>
                <th> SL no.</th>
                <th> Description of Goods</th>
                <th> Number of demands</th>
                <th> Ammount of supply</th>
                <th> Stock ledger page</th>
                <th> REMARKS</th>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
            </tr>
            @foreach ($sib->instruments as $key => $indentInstrument)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td></td>
                    <td>{{ $indentInstrument->instrument->instrumentType->name }}</td>
                    <td>Null</td>
                    <td>Null</td>
                    <td>Null</td>
                </tr>
            @endforeach
        </table>
    @else
        <table>
            <tr>
                <th> SL no.</th>
                <th> Description of Goods</th>
                <th> Number of demands</th>
                <th> Ammount of supply</th>
                <th> Stock ledger page</th>
                <th> REMARKS</th>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
            </tr>
            @foreach ($sib->parts as $key => $srbPart)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-center text-muted">{{ $srbPart->part->description }}</td>
                    <td class="text-center">{{ $srbPart->quantity }}</td>
                    <td class="text-center">{{ $srbPart->quantity }}</td>
                    <td class="text-center">{{ $srbPart->part->ledger_information}}</td>
                    <td class="text-center"></td>
                </tr>
            @endforeach
        </table>
    @endif

    <div class="container">
        <div class="employee-card">
            <img
                src="data:image/jpeg;base64,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"
                alt="Signature">
            <p>{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
            <p>{{\Illuminate\Support\Facades\Auth::user()->role->name}}</p>
            <p>{{\Illuminate\Support\Facades\Auth::user()->station->name}}</p>
        </div>
        <div class="employee-card">
            <img
                src="data:image/jpeg;base64,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"
                alt="Signature">
            <p>{{$stationInCharge->name}}</p>
            <p>{{$stationInCharge->role->name}}</p>
            <p>{{$stationInCharge->station->name}}</p>
        </div>

        <div class="employee-card">
            <img
                src="data:image/jpeg;base64,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"
                alt="Signature">
            <p>{{$stationHead->name}}</p>
            <p>{{$stationHead->role->name}}</p>
            <p>{{$stationHead->station->name}}</p>
        </div>
    </div>

</div>

</body>

</html>
