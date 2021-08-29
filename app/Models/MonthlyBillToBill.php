<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyBillToBill extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'monthly_bill_to_bills';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'bill_id',
        'monthly_bill_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function monthly_bill()
    {
        return $this->belongsTo(MonthlyBill::class, 'monthly_bill_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
