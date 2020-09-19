<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        
        "trn_ref_no",
        "transaction_date",
        "product_type",
        "liters",
        "rate",
        "total_cost",
        "amount_paid",
        "balance",
        "narration",
        "transaction_code",
        "customer_name",
        "shortages",
        "supplier_name",
        "unit_price",
        "payment_mode",
        "bank_name",
        "cheque_number",
        "payment_status",
        "discount_rate",
        "cash_discount_allowed",
        "approval_status",
        "approval_date",
        "approved_by",
        "created_at",
        "account_number",
        "supplier_rate",
        "updated_at"
        
        ];
    public $table = 'transactions';
}
