<?php

namespace App\Services\Report;

use App\Models\User;
use App\Services\Report\Contracts\ReportServiceContract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;

class PdfReport extends  AbstractReport implements ReportServiceContract
{
    private string $directory = 'reports/pdf';
    public string $type = 'application/pdf';

    public function createReport(User|Authenticatable $user)
    {
        $groupedPaymentsByCategory = $user->payments()
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

        $pdf = PDF::loadView('report.payments', ['data'=>$data]);

        $path = $this->getPath($this->directory, 'pdf');

        Storage::put($path, $pdf->output());
        Storage::setVisibility($path, 'public');

        return $path;
    }
}
