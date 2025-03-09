<?php

namespace App\Exports\Pencatatan;

use App\Models\Utilitas;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class AirLimbahExport implements WithEvents
{

    function __construct(private $date) {}

    /**
     * Menambahkan gambar logo di bagian atas Excel (Header).
     *
     * @return array
     */
    public function registerEvents(): array
    {
        $datas = Utilitas::with(['customer', 'user'])->where('type', Utilitas::TYPE_AIR_LIMBAH)
            ->where("tanggal", $this->date)
            ->whereHas('customer', function ($customer) {
                $customer->where("status", 1)->where("air_limbah", 1);
            })->get();

        $month = Carbon::parse($this->date)->format('F');
        return [
            AfterSheet::class => function (AfterSheet $event) use ($datas, $month) {
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Company Logo');
                $drawing->setPath(public_path('assets/images/logo_full.png'));
                $drawing->setHeight(200);
                $drawing->setWidth(200);
                $drawing->setCoordinates('A2');
                $drawing->setWorksheet($event->sheet->getDelegate());


                $event->sheet->getColumnDimension('A')->setWidth(35);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('C')->setWidth(20);
                $event->sheet->getColumnDimension('D')->setWidth(20);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(30);
                $event->sheet->getColumnDimension("D")->setWidth(20);

                $cell = 12;
                $event->sheet->setCellValue('B1', 'Nomor Dokumen :');
                $event->sheet->setCellValue('B2', 'Revisi :');
                $event->sheet->setCellValue('B3', 'Tanggal Efektif :');
                $event->sheet->setCellValue('B4', 'Penanggung Jawab :');
                $event->sheet->setCellValue('B5', 'Pelaksana :');
                $event->sheet->setCellValue('A8', 'LAPORAN JASA PENGELOLAAN AIR LIMBAH');
                $event->sheet->setCellValue('A9', "BULAN: $month");
                $event->sheet->setCellValue('A11', 'Nama');
                $event->sheet->setCellValue('B11', 'Perhitungan');
                $event->sheet->setCellValue('C11', 'Room');
                $event->sheet->setCellValue('D11', 'V.WM');
                $event->sheet->setCellValue('E11', 'Koefisien');
                $event->sheet->setCellValue('F11', 'V.Limbah');
                $event->sheet->setCellValue('G11', 'H.Air');
                $event->sheet->setCellValue('H11', 'Sub Total');
                foreach ($datas as $data) {
                    $customer = $data->customer;
                    $type = $customer->type_perhitungan;
                    $perhitungan = $customer->perhitungan;
                    $nilai = $data->nilai;
                    $harga = $customer->harga_air_limbah;

                    $volLimbah = $nilai * $perhitungan;
                    $subTotal = $volLimbah * $harga;

                    $event->sheet->setCellValue("A$cell", $customer->nama);
                    $event->sheet->setCellValue("B$cell", $type);
                    $event->sheet->setCellValue("C$cell", $type == "RNS" ? $nilai : "-");
                    $event->sheet->setCellValue("D$cell", $type != "RNS" ? $nilai : "-");
                    $event->sheet->setCellValue("E$cell", $perhitungan);
                    $event->sheet->setCellValue("F$cell", $volLimbah);
                    $event->sheet->setCellValue("G$cell", $harga);
                    $event->sheet->setCellValue("H$cell", $subTotal);
                    $cell += 1;
                }
                $oldCell = $cell - 1;
                $event->sheet->setCellValue("F$cell", "=sum(F12:F$oldCell)");
                $event->sheet->setCellValue("H$cell", "=sum(H12:H$oldCell)");

                for ($i = 1; $i <= 5; $i++) {
                    $event->sheet->mergeCells("C$i:D$i");
                }
                $event->sheet->mergeCells('A8:H8');
                $event->sheet->mergeCells('A1:A6');

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
                $event->sheet->getStyle('A11:H11')->applyFromArray([
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
                $cels = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                foreach ($cels as $valCel) {
                    for ($j = 11; $j <= $cell; $j++) {
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
}
