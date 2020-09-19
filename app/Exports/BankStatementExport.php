<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use App\Transaction;

class BankStatementExport implements \Maatwebsite\Excel\Concerns\FromView
{
    public function view() : \Illuminate\Contracts\View\View
    {
        return view('reports.BankStatementExport', [
            'bankTransactions' => \App\Transaction::all()
        ]);
    }
}
