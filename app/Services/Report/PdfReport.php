<?php

namespace App\Services\Report;

use App\Services\Report\Contracts\ReportServiceContract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PdfReport extends  AbstactReport implements ReportServiceContract
{
    private string $directory = 'reports/pdf';

    public function createReport()
    {
        $groupedPaymentsByCategory = Auth::user()->payments()
            ->with('category.icon')
            ->latest()
            ->get()
            ->groupBy('category.name');

        $formattedData = $groupedPaymentsByCategory->map(function ($payments) {
            return [
                'category' => $payments->first()->category,
                'payments' => $payments,
                'count' => $payments->count(),
                'total_amount' => $payments->sum('amount'),
            ];
        });

        $sortedData = $formattedData->sortByDesc('total_amount');

        $data = $sortedData->values()->toArray();

        $this->makeDir($this->directory);

        $pdf = PDF::loadView('report.payments', ['data'=>$data]);

        $path = $this->getPath($this->directory, 'pdf');

        Storage::put($path, $pdf->output());
        return $path;
    }
}
