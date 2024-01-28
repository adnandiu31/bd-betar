<?php

namespace App\Imports;

use App\Models\Instrument;
use App\Models\Manufacture;
use App\Models\Part;
use App\Models\PartType;
use App\Models\Station;
use DateInterval;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        function excelSerialDateToStandardDate($excelSerialDate)
        {
            // Adjust the base date for Excel serial dates (December 31, 1899 for Google Sheets)
            $baseDate = new DateTime('1899-12-30');

            // Calculate the number of days to add to the base date
            $daysToAdd = (int)$excelSerialDate;

            // Excel considers the fraction of a day as the time, so we need to convert it to seconds
            $secondsToAdd = round(($excelSerialDate - $daysToAdd) * 86400);

            // Add the days to the base date
            $convertedDate = $baseDate->add(new DateInterval('P' . $daysToAdd . 'D'))->setTime(0, 0, $secondsToAdd);

            // Format the date in the desired format (e.g., 2023-12-21)
            return $convertedDate->format('Y-m-d');
        }

        foreach ($rows as $row) {
            // dd($row);
            // Part types 
            $partsType = PartType::where('name', $row['parts_type'])->first()->id ?? null;
            
            if($partsType == null ){
                $createPartType = PartType::create([
                    'name' => $row['parts_type'] ??"Others" ,
                    'slug' => Str::slug($row['parts_type'])
                ]);

                $partTypeId = $createPartType->id;
            }
            else{
                $partTypeId = $partsType;
            }

            // Manufacture 
            $manufacture = Manufacture::where('name', $row['manufacturer'])->first()->id ?? null;
            
            if($manufacture == null ){
                $createManufacture = Manufacture::create([
                    'name' => $row['manufacturer'],
                ]);

                $manufactureId = $createManufacture->id;
            }
            else{
                $manufactureId = $manufacture;
            }

            // station
            $station = Station::where('name', $row['station'])->first()->id ?? null;
            
            if($station == null ){
                $createStation = Station::create([
                    'name' => $row['station'],
                ]);

                $stationId = $createStation->id;
            }
            else{
                $stationId = $station;
            }

            

            Part::updateOrCreate ([
                'part_id'=>$row['part_id'] ?? rand(0,99999), // item_id to part_id
                'name'=>$row['part_name'] ?? null, // parts_name TO part_name
                'instrument_id'=> Instrument::where('name', $row['instrument'])->first()->id ?? null, // lookup_to_instrument TO instrument
                'station_id'=> $stationId,
//                'station_id'=> Station::where('name', 'Khulna')->first()->id ?? null,
                'part_type_id'=> $partTypeId,
//                'part_type_id'=> PartType::where('name', 'Crystal')->first()->id ?? null,
                'description'=> $row['description'] ?? null, //isset
                'specification'=> $row['specification'] ?? null,
                'designation'=>$row['designation'] ?? null,
                'parts_no'=>$row['parts_no'] ?? null,
                'parts_pos'=>$row['part_pos'] ?? null,
                // 'manufacture_id'=>$row['manufacture'],
                'manufacture_id'=> $manufactureId,
                // 'manufacture_id'=>Manufacture::where('name', $row['manufacture'])->first()->id ?? null,
//                'manufacture_id' => Manufacture::where('name', 'Ampegon AG')->first()->id ?? null, // parts_manufacturer to manufacture
                'quantity'=>$row['quantity'] ?? null,
                'in_use'=>$row['in_use'] ?? null, // number_in_use to in_use
                'present_stock'=>$row['present_stock'] ?? null,
                'comments'=>$row['comment'] ?? null, // comments to comment
                'ledger_information'=>$row['ledger_information'] ?? null,
                'purchase_date'=>$row['purchase_date'] ? excelSerialDateToStandardDate ($row['purchase_date']) : null,
            ]);

        }
    }
}
