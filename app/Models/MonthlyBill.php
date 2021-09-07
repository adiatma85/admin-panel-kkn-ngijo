<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyBill extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const BULAN_SELECT = [
        'Januari'   => 'Januari',
        'Februari'  => 'Februari',
        'Maret'     => 'Maret',
        'April'     => 'April',
        'Mei'       => 'Mei',
        'Juni'      => 'Juni',
        'Juli'      => 'Juli',
        'Agustus'   => 'Agustus',
        'September' => 'September',
        'Oktober'   => 'Oktober',
        'November'  => 'November',
        'Desember'  => 'Desember',
    ];

    public $table = 'monthly_bills';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'tahun',
        'bulan',
        'created_at',
        'updated_at',
        'deleted_at',
        'scope_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Relationship to MonthlyBillToBill
    public function monthlyBilltoBill()
    {
        return $this->hasMany(MonthlyBillToBill::class, 'monthly_bill_id');
    }

    // Relationship to Scope
    public function scope()
    {
        return $this->belongsTo(Scope::class, 'scope_id');
    }

    // Get arrayonly bill
    public function getArrayOnlyBills()
    {
        $query = $this->query()
            ->join('monthly_bill_to_bills', 'monthly_bill_to_bills.id', '=', 'monthly_bills.id')
            ->where('monthly_bill_to_bills.deleted_at', '=', null)
            ->select('monthly_bill_to_bills.bill_id')
            ->get();
        if (count($query) != 0) {
            $array = [];
            foreach ($query as $item) {
                array_push($array, $item->bill_id);
            }
            return $array;
        }
        return [];
    }

    // Get Boll
    public function getArrayOfBill()
    {
        $query = $this->query()
            ->join('monthly_bill_to_bills', 'monthly_bill_to_bills.id', '=', 'monthly_bills.id')
            ->join('bills', 'bills.id', '=', 'monthly_bill_to_bills.bill_id')
            // ->where('monthly_bills.id', '=', $this->id)
            ->where('monthly_bill_to_bills.deleted_at', '=', null)
            ->where('bills.deleted_at', '=', null)
            // ->select('bills.id')
            // ->select('bills.name')
            ->get();
        return $query;
    }
}
