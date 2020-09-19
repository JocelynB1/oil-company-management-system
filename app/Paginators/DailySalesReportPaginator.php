<?php
namespace App\Paginators;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Transaction;

class DailySalesReportPaginator {
    public $transactions;
    public $perPage=15;
    public $offsetPages;  
    public function __construct(){
//Request $request
        $transactionDates=\DB::table('transactions')
        ->select('transaction_date')
        ->distinct()
        ->orderBy('transaction_date', 'asc')->get();
      $resultRows=[];
    for($i=0;$i<count($transactionDates);$i++){
    $resultRows[$transactionDates[$i]->transaction_date]= \DB::table('transactions')
    ->where('transaction_date', '=',$transactionDates[$i]->transaction_date)
    ->get();
//    $this->offsetPages=$offsetPages = $request->input('page', 1) - 1;
    $this->offsetPages=  15;
  // $this->transactions=array_slice($resultRows,$this->offsetPages,$this->perPage);
    $this->transactions=$resultRows;
//dd($this->transactions);
    }
    

    }
    public function getPaginator(){
        return new Paginator(
            $this->transactions,
            $this->perPage
        );        
    }

  

}


?>