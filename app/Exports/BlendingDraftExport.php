<?php

namespace App\Exports;

use App\Models\Settlement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BlendingDraftExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{
    private $lenghRows=0;

    public function __construct()
    {
        $this->lenghRows = 4+Settlement::all()->count();
    }

    public function view(): View
    {
        return view('livewire.blending.exports.blending-draft', [
            'settlements' => Settlement::all()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'bold' => true,
                    'size' =>16
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'height' => [
                    ''
                ]
            ],
            3 => [
                'font' => [
                    'bold' => true,
                    'size' =>12
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            4 => [
                'font' => [
                    'bold' => true,
                    'size' =>12
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'A3:N'.$this->lenghRows => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ]
                ],
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A5:A'.$this->lenghRows => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
