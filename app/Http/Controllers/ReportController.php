<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __invoke()
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
        $directory = 'reports';
        if(!Storage::exists($directory)){
            Storage::makeDirectory($directory);
        }
        $pdf = PDF::loadView('report.payments', ['data'=>$data]);
        $filename = 'report_' . date('Ymd_His') . '.pdf';
        $path = $directory . '/' . $filename;
        Storage::put($path, $pdf->output());

        return response()->download(storage_path('app/public/' . $path));
    }
}
