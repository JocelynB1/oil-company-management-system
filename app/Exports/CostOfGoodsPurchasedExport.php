<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use App\Purchase;

class CostOfGoodsPurchasedExport implements \Maatwebsite\Excel\Concerns\FromView
{
    public function view() : \Illuminate\Contracts\View\View
    {
        return view('reports.costOfGoodsPurchased', [
            'supplierPayments' => \App\Purchase::all()
        ]);
    }
}