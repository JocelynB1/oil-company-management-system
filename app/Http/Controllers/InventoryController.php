<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\TotalLitres;
use App\Transaction;

use Illuminate\Http\Request;
use Session;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::paginate(25);
        
        if (!empty($inventory[0])) {
            return view('inventory.index')->withInventory($inventory);
        }
        Session::flash('flash_message', 'No records found!');
        return view('inventory.index')->withInventory($inventory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier_name'=>'required',
            'litres_loaded'=>'required|numeric',
            'product_type'=>"required",
            'created_by'=>'required',
            'transaction_date'=>'required',
            'supplier_rate'=>'required',
            'modified_by'=>'required'
        ]);
       
        $input=$request->all();
        
        if (!empty($input['split'])) {
            $input['litres_loaded']=0;
        }
        
        Inventory::create($input);
        $supplierId=$request->supplier_number;
        $productType=$request->product_type;
       
        $result = \App\TotalLitres::where('supplier_id', '=', $supplierId)
        ->where('product_type', '=', $productType)
        ->get();
        if (empty($input['split'])) {
            if (empty($result[0])) {
                $totalLitres = new TotalLitres();
                $totalLitres->supplier_id = $supplierId;
                $totalLitres->product_type = $productType;
                $totalLitres->total_litres = $request->litres_loaded;
                $totalLitres->save();
            } else {
                $totalLitres = $result[0];
                $totalLitres->total_litres += $request->litres_loaded;
                $totalLitres->save();
            }
        }
        /*
        if (empty($result[0])) {
            $totalLitres=new TotalLitres();
            $totalLitres->supplier_id=$supplierId;
            $totalLitres->product_type=$productType;
            $totalLitres->total_litres=$request->litres_loaded;
            $totalLitres->save();
        } else {
            $totalLitres=$result[0];
            $totalLitres->total_litres+=$request->litres_loaded;
            $totalLitres->save();
        }
*/

        $trans = \App\Transaction::all();
        $lastTrans = $trans->pop();
        if (!isset($lastTrans)) {
            $lastTransId = 0;
        } else {
            $lastTransId = $lastTrans->id;
        }
        $inv=Inventory::all();
        $inv=$inv->pop();
        $transaction = new Transaction();
        $transaction->trn_ref_no = "Stock" . "-" . $inv->id;
        $transaction->transaction_date = $request->transaction_date;
        $transaction->account_number = $supplierId;
        $transaction->product_type = $request->product_type;
        $transaction->liters = $request->litres_loaded;
        $transaction->total_cost = $request->total_cost;
        $transaction->amount_paid = 0;
        if (!empty($input['split'])) {
            $transaction->narration = "Stock Supplied Split";
        } else {
            $transaction->narration = "Stock Supplied";
        }

        $transaction->balance = $request->total_cost;
        $transaction->shortages = $request->shortages_in_litres;
        $transaction->supplier_rate = $request->supplier_rate;
        $transaction->supplier_name = $request->supplier_name;
        $transaction->posted_from = "Inventory";
        $transaction->save();


        Session::flash('flash_message', 'Inventory successfully added!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);

        return view('inventory.show')->with(['inventory'=>$inventory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);

        return view('inventory.edit')->with(['inventory'=>$inventory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $this->validate($request, [
            'supplier_name' => 'required',
            'litres_loaded' => 'required|numeric',
            'product_type' => "required",
            'created_by' => 'required',
            'transaction_date' => 'required',
            'supplier_rate' => 'required',
            'modified_by' => 'required'
       
            ]);
        $input=$request->all();
        $inventory->update($input);

        $trn_ref_no = "Stock" . "-" . $id;

        $transactions = \DB::table('transactions')
            ->where('trn_ref_no', '=', $trn_ref_no)
            ->get();
        $transactionId= $transactions[0]->id;
        $transactions = Transaction::findOrFail($transactionId);
        $transactions->product_type= $request->product_type;
        $transactions->liters = $request->litres_loaded;
        $transactions->supplier_rate = $request->supplier_rate;
        $transactions->account_number = $request->supplier_number;
        $transactions->total_cost = $request->total_cost;
        $transactions->supplier_name = $request->supplier_name;
        $transactions->update();
        

        Session::flash('flash_message', 'Record updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->delete();
    
        Session::flash('flash_message', 'Inventory successfully deleted!');
    
        return redirect()->route('inventory.index');
    }
    public function search(Request $request)
    {
        $q = $request->q;
        if ($q != "") {
            $user = Inventory::where('supplier_name', 'LIKE', '%' . $q . '%')->paginate(5)->setPath('');
            $pagination = $user->appends(array(
                    'q' =>  $request->q
            ));
            if (count($user) > 0) {
                return view('inventory.index')->withInventory($user)->withQuery($q);
            }
        }
        Session::flash('flash_message', 'No records found!');
        return redirect()->route('inventory.index')->withInventory($user);
    }
}
