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
        <!-- <div class="header_top_info_right">
            <p class="form"><strong>FORM: Indent from </strong></p>
        </div> -->
    </div>
    <div class="header_top">
        <p>Bangladesh Betar Dhaka</p>
    </div>
    <div class="header_bottom" style=" margin-left: 30px;   margin-bottom: 25px; ">
        <!-- <p>List of annual requirement for indenting for the : stating name</p> -->
        <div class="header_top_info">
            <!-- <span><strong>Spare required for:</strong> 250 KW SW Transmitter TX1 (Ampegon) <strong>Model:</strong> TSW2300D </span> -->
            <!-- <span style=" margin-left: 4px;"><strong>Economic Code:</strong> 112233 </span> -->
            <p><strong>Manufacturer: </strong>{{ $manufacture['name'] }} <span><strong> Year : </strong> 2023-2024</span></p>
        </div>

    </div>
</div>
<div class="table_area">
    <table>
        <tr>
            <th>SL no.</th>
            <th>Parts Id</th>
            <th>Name</th>
            <th>Parts No</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Requisition</th>
        </tr>

        @php
            $totalSum = 0;
        @endphp

        @foreach ($details as $key => $indent)
            <tr>
                <td class="text-center text-muted">{{ $key + 1 }}</td>
                <td class="text-center">{{ $indent->part_id }}</td>
                <td class="text-center">{{ $indent->name }}</td>
                <td class="text-center">{{ $indent->parts_no }}</td>
                <td class="text-center">{{ $indent->type }}</td>
                <td class="text-center">{{ $indent->quantity }}</td>
                <td class="text-center">{{ $indent->remaining }}</td>
            </tr>
        @endforeach
    </table>

</div>

</body>

</html>
