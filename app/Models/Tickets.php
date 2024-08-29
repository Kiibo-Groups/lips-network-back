<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tickets extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'app_user_id',
        'imagen',
        'fecha',
        'valor',
        'description',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(AppUser::class, 'app_user_id', 'id');
    }

    public function dias()
    {
        $fecha = Carbon::now();
        $fechaActual = $fecha->format('Y-m-d');
        $fechaHace6Meses = $fecha->subMonths(6);

        return [
            'fecha' => $fecha,
            'fechaActual' => $fechaActual,
            'fechaHace6Meses' => $fechaHace6Meses,
        ];
    }

    public function getNumDiasAttribute()
    {
        $fecha = $this->fecha;
        $fechahoy = Carbon::now();

        return $fechahoy->diffInDays($fecha);
    }
}
