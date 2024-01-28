<?php

namespace App\Exports;

use App\Models\Instrument;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InstrumentExport implements FromCollection,WithHeadings,WithStyles,WithMapping,ShouldAutoSize
{
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Instrument Id',
            'Instrument Name',
            'Description',
            'Instrument Type',
            'Station',
            'Instrument Model',
            'Serial No',
            'Instrument Manufacture',
            'Quantity',
            'Date Installation',
        ];
    }

    /**
     * @return array
     * @var $part
     */
    public function map($instrument): array
    {
        
        return [
            $instrument->id,
            $instrument->instrument_id,
            $instrument->name,
            $instrument->description,
            $instrument->instrumentType->name,
            $instrument->station->name ?? null,
            $instrument->model,
            $instrument->serial_no,
            $instrument->manufacture->name,
            $instrument->quantity,
            $instrument->installation_date,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Instrument::all();
    }
}
