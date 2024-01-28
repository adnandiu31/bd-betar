<?php

namespace App\Imports;

use App\Models\Instrument;
use App\Models\InstrumentType;
use App\Models\Manufacture;
use App\Models\Station;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InstrumentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // $stations = Station::all();
            // foreach ($stations as $station) {

            // }
//            dd($row);
            Instrument::updateOrCreate([
                'instrument_id' => $row['instrument_id'],
                'name' => $row['instrument_name'],
                'instrument_type_id' => InstrumentType::where('name', $row['instrument_type'])->first()->id ?? null,
                'station_id' => Station::where('name', $row['station'])->first()->id ?? null,
//                'station_id' => Station::where('name', 'Khulna')->first()->id ?? null,
                'description' => $row['description'],
                'model' => $row['instrument_model'],
                'serial_no' => $row['serial_no'],
                'quantity' => isset($row['quantity']) ? $row['quantity'] : null,
                'manufacture_id' => Manufacture::where('name', $row['instrument_manufacturer'])->first()->id ?? null,
                'installation_date' => isset($row['date_installation']) ? $row['date_installation'] : null,
            ]);
        }
    }
}
