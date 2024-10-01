<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;

class PaymentExport implements FromCollection, WithHeadings, ShouldAutoSize,WithStyles,WithDefaultStyles
{

    public function __construct(public User|Authenticatable $user)
    {

    }

    public function headings(): array {
        return [
            "Amount",
            "Payment_date",
            "Category"
        ];
    }

    /**
    * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function collection()
    {
        return $this->user->payments()->with('category')->latest()->get()->map(function ($payment){
            return [
                'amount'=>$payment->amount,
                'payment_date'=>$payment->payment_date,
                'category'=>$payment->category->name,
            ];
        });
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        // Configure the default styles
        return $defaultStyle->getFont()->setSize(13);

    }
}
