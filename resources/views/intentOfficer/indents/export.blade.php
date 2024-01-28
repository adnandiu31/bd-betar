@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Indent</title>
    <style>
        body {
            padding: 20px 15px;
        }

        .header_top {
            text-align: center;
            font-size: large;
            font-weight: 500;
        }

        .header_top_form {
            position: relative;
            text-align: right;
            font-size: medium;
            font-weight: 100;
        }

        .header_bottom {
            position: relative;
            font-size: 12px;
        }

        .form {
            display: flex;
            font-weight: bold;
        }

        /* .header_bottom .header_top_info {
             line-height: 8px;
             position: relative;
         } */
        /* .header_bottom .header_top_info_right{
             position: absolute;
             top: 0;
             right: 100px;
         } */
        .header_top_info_right {
            position: absolute;
            top: 0;
            right: 0;
        }

        .table_area {
            /* margin: 0px 40px; */
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

        /*.container {*/
        /*    display: inline-block;*/
        /*    justify-content: flex-end; !* Aligns the container to the bottom *!*/
        /*    align-items: flex-end; !* Aligns the content within the container to the bottom *!*/
        /*    position: fixed;*/
        /*    bottom: 0;*/
        /*    left: 0;*/
        /*    right: 0;*/
        /*    padding: 10px; !* Add padding to create some spacing from the bottom of the page *!*/
        /*    !*background-color: #f0f0f0; !* Optional: Add a background color for better visibility *!*!*/
        /*}*/


        /* Style for each employee card */
        .employee-card {
            width: 32%;
            padding: 2px;
            display: inline-block;
        }

        .employee-card h3 {
            /*margin-top: 0;*/
        }

        .employee-card img {
            max-width: 50px;
            max-height: 50px;
        }

        .date {
            text-align: right;
        }

    </style>
</head>

<body>
<div class="header">

    <div class="header_top_form">
        <div class="header_top_info_right">
            <p class="form"><strong>FORM: {{$indent->form}}</strong></p>
        </div>
    </div>
    <div class="header_top">
        <p>{{Auth::user()->station->name}}</p>
    </div>
    <div class="header_bottom" style=" margin-left: 30px;   margin-bottom: 25px; ">
        <p>List of annual requirement for indenting for the : {{Auth::user()->station->name}}</p>
        <div class="header_top_info">
            <span><strong>Spare required for:</strong> 250 KW SW Transmitter TX1 (Ampegon) <strong>Model:</strong> TSW2300D </span>
            <span style=" margin-left: 4px;"><strong>Economic Code:</strong> {{$indent->economic_code}} </span>
            <p><strong>Manufacturer:</strong> Ampegon AG Spinnereistrasse 5, CH5300 TURGI Switzerland</p>
        </div>

    </div>
</div>
<div class="table_area">
    @if ($indent->product_type === 'instrument')
        <table>
            <tr>
                <th>SL no.</th>
                <th>Name/Description of the item</th>
                <th>Symbol No</th>
                <th>serial No</th>
                <th>Req.during the next year</th>
                <th>REMARKS</th>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
            </tr>

            @foreach ($indent->instruments as $key => $indentInstrument)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td> {{  $indentInstrument->instrument->name ?? null }} </td>
                    <td></td>
                    <td>{{ $indentInstrument->instrument->serial_no ?? null }}</td>
                    <td>{{ $indentInstrument->quantity ?? null }}</td>
                    <td></td>
                </tr>
            @endforeach
        </table>
    @else
        <table>
            <tr>
                <th>SL no.</th>
                <th>Name/Description of the Item</th>
                <th>Symbol No</th>
                <th>Parts Position</th>
                <th>Parts No</th>
                <th>Quantity in use</th>
                <th>Balance on</th>
                <th>Cons. of previous two years</th>
                <th>Req.during the next year</th>
                <th>REMARKS</th>
            </tr>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
            </tr>
            @foreach ($indent->parts as $key => $indentPart)
                <tr>
                    <td class="text-center text-muted">{{ $key + 1 }}</td>
                    <td class="text-center">{{ $indentPart->part->name }}</td>
                    <td class="text-center"></td>
                    <td class="text-center">{{ $indentPart->part->parts_pos}}</td>
                    <td class="text-center">{{ $indentPart->part->parts_no }}</td>
                    <td class="text-center">{{ $indentPart->part->in_use }}</td>
                    <td class="text-center">{{ $indentPart->part->quantity }}</td>
                    <td class="text-center">{{$indentPart->part->id}}</td>
                    <td class="text-center">{{ $indentPart->quantity }}</td>
                    <td class="text-center"></td>
                </tr>
            @endforeach
        </table>
    @endif
</div>

<div class="container">
    <div class="employee-card">
        <img src="{{Auth::user()->getFirstMediaUrl('signature','thumb1')}}">
        <p>{{Auth::user()->name}}</p>
        <p>{{Auth::user()->role->name}}</p>
        <p>{{Auth::user()->station->name}}</p>
    </div>
    @foreach ($users as $user)
        @if ($user['role']['slug'] === 'station-incharge')
            @php
                $userData = \App\Models\User::find($user['id'])
            @endphp
            <div class="employee-card">
                <img
                    src="{{$userData->getFirstMediaUrl('signature','thumb1')}}"
                    alt="Signature">
                <p>{{ $user['name'] }}</p>
                <p>{{ $user['role']['name'] }}</p>
                <p>{{$user['station'] ? $user['station']['name'] : "Bangladesh betar"}}</p>
            </div>
        @endif
    @endforeach
    @foreach ($users as $user)
        @if ($user['role']['slug'] === 'station-head')
            @php
                $userData = \App\Models\User::find($user['id'])
            @endphp
            <div class="employee-card">
                <img
                    src="{{$userData->getFirstMediaUrl('signature','thumb1')}}"
                    alt="Signature">
                <p>{{ $user['name'] }}</p>
                <p>{{ $user['role']['name'] }}</p>
                <p>{{$user['station'] ? $user['station']['name'] : "Bangladesh betar"}}</p>
            </div>
        @endif
    @endforeach
    @foreach ($users as $user)
        @if ($user['role']['slug'] === 'central-engineer')
            @php
                $userData = \App\Models\User::find($user['id'])
            @endphp
            <div class="employee-card">
                <img
                    src="{{$userData->getFirstMediaUrl('signature','thumb1')}}"
                    alt="Signature">
                <p>{{ $user['name'] }}</p>
                <p>{{ $user['role']['name'] }}</p>
                <p>{{$user['station'] ? $user['station']['name'] : "Bangladesh betar"}}</p>
            </div>
        @endif
    @endforeach
    @foreach ($users as $user)
        @if ($user['role']['slug'] === 'main-engineer')
            @php
                $userData = \App\Models\User::find($user['id'])
            @endphp
            <div class="employee-card">
                <img
                    src="{{$userData->getFirstMediaUrl('signature','thumb1')}}"
                    alt="Signature">
                <p>{{ $user['name'] }}</p>
                <p>{{ $user['role']['name'] }}</p>
                <p>{{$user['station'] ? $user['station']['name'] : "Bangladesh betar"}}</p>
            </div>
        @endif
    @endforeach
    @foreach ($users as $user)
        @if ($user['role']['slug'] === 'director-general')
            @php
                $userData = \App\Models\User::find($user['id'])
            @endphp
            <div class="employee-card">
                <img
                    src="{{$userData->getFirstMediaUrl('signature','thumb1')}}"
                    alt="Signature">
                <p>{{ $user['name'] }}</p>
                <p>{{ $user['role']['name'] }}</p>
                <p>{{$user['station'] ? $user['station']['name'] : "Bangladesh betar"}}</p>
            </div>
        @endif
    @endforeach
</div>
</body>

</html>
