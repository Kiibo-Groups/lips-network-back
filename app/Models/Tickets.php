<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tickets extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id',
        'app_user_id',
        'categorystore_id',
        'imagen',
        'fecha',
        'valor',
        'score',
        'description',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(AppUser::class,'app_user_id','id');
    }

    public function Category()
    {
        return $this->belongsTo(CategoryStore::class,'categorystore_id','id');
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

    public function getAll()
    {
        $req = Tickets::OrderBy('status','ASC')->get();
        $data = [];

        foreach ($req as $key) {
            $data[] = (object)[
                'id' => $key->id,
                'app_user_id' => $key->app_user_id,
                'imagen' => asset('upload/tickets/'.$key->imagen),
                'fecha' => $key->fecha,
                'valor' => $key->valor,
                'score' => $key->score,
                'description' => $key->description,
                'status' => $key->status,
                'usuario' => $key->usuario,
                'Category'  => $key->Category
            ];
        }

        return $data;
    }

    public function getAllTickets($id)
    {
        $req = Tickets::where('app_user_id', $id)->OrderBy('created_at','DESC')->get();
        $data = [];

        foreach ($req as $key) {
            $data[] = [
                'id' => $key->id,
                'app_user_id' => $key->app_user_id,
                'imagen' => asset('upload/tickets/'.$key->imagen),
                'fecha' => $key->fecha,
                'valor' => $key->valor,
                'score' => $key->score,
                'description' => $key->description,
                'status' => $key->status,
                'Category'  => $key->Category
            ];
        }

        return $data;
    }

    public function getLastTicket($id)
    {

        $req = Tickets::where('app_user_id', $id)->OrderBy('created_at','DESC')->first();
        

        $data = [
            'id' => $req->id,
            'app_user_id' => $req->app_user_id,
            'imagen' => asset('upload/tickets/'.$req->imagen),
            'fecha' => $req->fecha,
            'valor' => $req->valor,
            'score' => $req->score,
            'description' => $req->description,
            'status' => $req->status,
        ];

        return $data;
    }

    public function viewTicket($id)
    {
        $req = Tickets::where('id',$id)->with('usuario')->first();
        

        $data = (object)[
            'id' => $req->id,
            'app_user_id' => $req->app_user_id,
            'imagen' => asset('upload/tickets/'.$req->imagen),
            'fecha' => $req->fecha,
            'valor' => $req->valor,
            'score' => $req->score,
            'description' => $req->description,
            'status' => $req->status,
            'usuario' => $req->usuario,
            'categorystore_id' => $req->categorystore_id
        ];

        return $data;
    }
}
