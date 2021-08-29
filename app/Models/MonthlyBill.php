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
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
