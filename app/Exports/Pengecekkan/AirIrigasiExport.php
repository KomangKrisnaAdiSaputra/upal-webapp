<?php

namespace App\Exports\Pengecekkan;

use App\Http\Controllers\Pengecekkan\AirIrigasiController;
use App\Models\Utilitas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class AirIrigasiExport implements WithEvents
{

    function __construct(private $date) {}

    /**
     * Menambahkan gambar logo di bagian atas Excel (Header).
     *
     * @return array
     */
    public function registerEvents(): array
    {
        $datas = (new AirIrigasiController)->dataExport($this->date);
        // dd($datas);
        return [
            AfterSheet::class => function (AfterSheet $event) use ($datas) {
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Company Logo');
                $drawing->setPath(public_path('assets/images/logo_full.png'));
                $drawing->setHeight(200);
                $drawing->setWidth(200);
                $drawing->setCoordinates('A2');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // $event->sheet->getColumnDimension('A')->setWidth(35);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(30);
                $event->sheet->getColumnDimension("D")->setWidth(20);

                $login = auth()->user();
                $cell = 13;
                $cellTotal = collect();
                $event->sheet->setCellValue('C1', 'Nomor Dokumen :');
                $event->sheet->setCellValue('C2', 'Revisi :');
                $event->sheet->setCellValue('C3', 'Tanggal Efektif :');
                $event->sheet->setCellValue('C4', 'Penanggung Jawab :');
                $event->sheet->setCellValue('C5', 'Pelaksana :');
                $event->sheet->setCellValue('C6', "Di Buat Oleh : {$login->nama}");
                $event->sheet->setCellValue('A8', 'CHECK LIST HARIAN PEMAKAIAN AIR IRIGASI');
                $event->sheet->setCellValue('A9', "TAHUN: {$datas->tahun}");
                $event->sheet->setCellValue('A10', "HARI/TGL/BULAN: {$datas->tanggal}");

                $event->sheet->setCellValue('A11', 'No');
                $event->sheet->setCellValue('B11', 'Konsumen');
                $event->sheet->setCellValue('C11', 'Pembacaan Meteran (M3)');
                $event->sheet->setCellValue('C12', 'Terakhir');
                $event->sheet->setCellValue('D12', 'Sebelumnya');
                $event->sheet->setCellValue('E11', 'Pemakaian');
                $event->sheet->setCellValue('F11', 'Keterangan');
                $event->sheet->setCellValue('G11', 'Petugas');
                foreach ($datas->data_irigasi as $data) {
                    $num = 1;
                    foreach ($data->datas as $valData) {
                        $event->sheet->setCellValue("A$cell", $num);
                        $event->sheet->setCellValue("B$cell", $valData->customer);
                        $event->sheet->setCellValue("C$cell", $valData->nilai_terakhir);
                        $event->sheet->setCellValue("D$cell", $valData->nilai_sebelumnya);
                        $event->sheet->setCellValue("E$cell", $valData->pemakaian);
                        $event->sheet->setCellValue("F$cell", $valData->keterangan);
                        $event->sheet->setCellValue("G$cell", $valData->user);
                        $cell += 1;
                        $num += 1;
                    }
                    $oldCell = $cell - 1;
                    $cellTotal->push($cell);
                    $event->sheet->setCellValue("A$cell", null);
                    $event->sheet->setCellValue("B$cell", "Sub Total");
                    $event->sheet->setCellValue("C$cell", "=sum(C12:C$oldCell)");
                    $event->sheet->setCellValue("D$cell", "=sum(D12:D$oldCell)");
                    $event->sheet->setCellValue("E$cell", "=sum(E12:E$oldCell)");
                    $event->sheet->setCellValue("F$cell", null);
                    $event->sheet->setCellValue("G$cell", null);
                    $cell += 1;
                }
                $event->sheet->getStyle("A11:A$cell")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $event->sheet->getStyle("G11:G$cell")->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $event->sheet->setCellValue("A$cell", null);
                $event->sheet->setCellValue("B$cell", "Total");
                $event->sheet->setCellValue("C$cell", $this->totalCell($cellTotal, "C"));
                $event->sheet->setCellValue("D$cell", $this->totalCell($cellTotal, "D"));
                $event->sheet->setCellValue("E$cell", $this->totalCell($cellTotal, "E"));
                $event->sheet->setCellValue("F$cell", null);
                $event->sheet->setCellValue("G$cell", null);

                foreach ($datas->total_data as $key => $value) {
                    $_text = $key == "total" ? "Penjualan Air Irigasi Dari Tanggal 1 s/d Hari Ini" : "Rata - rata Penjualan Air Irigasi Dari Tanggal 1 s/d Hari Ini";
                    $event->sheet->mergeCells("B$cell:E$cell");
                    $event->sheet->setCellValue("A$cell", null);
                    $event->sheet->setCellValue("B$cell", $_text);
                    $event->sheet->setCellValue("F$cell", $value);
                    $cell += 1;
                }

                $cell += 4;
                $event->sheet->setCellValue("B$cell", "PENGAWAS");
                $event->sheet->mergeCells("B$cell:C$cell");
                $event->sheet->setCellValue("E$cell", "PELAKSANA");
                $event->sheet->mergeCells("E$cell:F$cell");
                $event->sheet->getStyle("B$cell")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $event->sheet->getStyle("E$cell")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $cell += 4;
                $event->sheet->setCellValue("B$cell", "(...........................................)");
                $event->sheet->mergeCells("B$cell:C$cell");
                $event->sheet->setCellValue("E$cell", "(...........................................)");
                $event->sheet->mergeCells("E$cell:F$cell");
                $event->sheet->getStyle("B$cell")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $event->sheet->getStyle("E$cell")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                for ($i = 1; $i <= 6; $i++) {
                    $event->sheet->mergeCells("C$i:D$i");
                }

                $event->sheet->mergeCells('A8:G8');
                $event->sheet->mergeCells('A9:C9');
                $event->sheet->mergeCells('A10:C10');
                $event->sheet->mergeCells('A1:B6');
                $event->sheet->mergeCells('A11:A12');
                $event->sheet->mergeCells('B11:B12');
                $event->sheet->mergeCells('C11:D11');
                $event->sheet->mergeCells('E11:E12');
                $event->sheet->mergeCells('F11:F12');
                $event->sheet->mergeCells('G11:G12');

                $event->sheet->getStyle('A8')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $event->sheet->getStyle('A11:G12')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['argb' => 'FFFFFF'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '4CAF50'], // Green background
                    ],
                    'borders' => [
                        'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                        'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    ],
                ]);
                $cels = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
                foreach ($cels as $valCel) {
                    for ($j = 11; $j <= ($cell - 8); $j++) {
                        $event->sheet->getStyle("{$valCel}{$j}")->applyFromArray([
                            'borders' => [
                                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                            ],
                        ]);
                    }
                }
            },
        ];
    }

    function totalCell($cells, $text)
    {
        $data = $cells->count() > 0 ? "=" : "";
        foreach ($cells as $cell) {
            $data .= "{$text}{$cell}+";
        }
        return rtrim($data, "+");
    }
}
