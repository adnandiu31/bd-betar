<?php

namespace App\Exports;

use App\Models\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PartExport implements FromCollection,WithMapping,WithHeadings, WithStyles, ShouldAutoSize
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
            'Part Id',
            'Part Name',
            'Station',
            'Instrument',
            'Part Types',
            'Description',
            'Specification',
            'Designation',
            'Parts No',
            'Purchase Date',
            'Part Position',
            'Manufacture',
            'Quantity',
            'In Use',
            'Present Stock',
            'Comment',
            'Ledger Information',
        ];
    }

    /**
     * @return array
     * @var $part
     */
    public function map($part): array
    {
        return [
            $part->id,
            $part->part_id,
            $part->name,
            $part->station->name ?? null,
            $part->instrument->name ?? null,
            $part->partType->name ?? null,
            $part->description,
            $part->specification,
            $part->designation,
            $part->parts_no,
            $part->purchase_date,
            $part->parts_pos,
            $part->manufacture->name ?? null,
            $part->quantity,
            $part->in_use,
            $part->present_stock,
            $part->comments,
            $part->ledger_information,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Part::all();
    }
}
