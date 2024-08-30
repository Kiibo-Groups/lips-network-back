<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LeaderBoard extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'score_min',
        'reward',
        'reward_min',
        'date_end'
    ];


    public function GetListLeaders()
    {
        $LeaderBoard = LeaderBoard::first();
        $score_min = $LeaderBoard->score_min;

        // Buscaremos entre todos los usuarios quien tenga como minimo este rango de score
        $req = AppUser::withSum('tickets',"score")->get();
        $data = [];
        

        foreach ($req as $key) {
         
            // Validamos si ya llegamos al tope
            if (count($data) < 50) {
                // Validamos si tenemos el score suficiente para ingresar
                if ($key->tickets_sum_score >= $score_min) {
                   
                    $data[] = [
                        'ID' => "LI0".$key->id,
                        'name' => $key->name,
                        'email' => $key->email,
                        'Score' => (int)$key->tickets_sum_score,
                    ];
                }
            }    
        }

        return (count($data) > 1) ? $this->ORDER_ASC_STAFF($data, $LeaderBoard) : $data;

        // return [
        //     'LeaderBoard' => $LeaderBoard,
        //     'users' => (count($data) > 1) ? $this->ORDER_ASC_STAFF($data, $LeaderBoard) : $data
        // ];
    }


    function ORDER_ASC_STAFF($data, $LeaderBoard)
    {
        $placeReward = 0;

        foreach ($data as $key => $row) {
            $aux[$key] = $row['Score'];
        }

        array_multisort($aux, SORT_DESC, $data);

        $RewardTotal = $LeaderBoard->reward;
        $rewardUser  = 0;

        for ($i=0; $i < count($data); $i++) { 
            $placeReward++;
            $data[$i]['Lugar'] = $placeReward;

            // Agregamos la recompensa en base al % asignado
            /**
             * Ejemplo
             * Recompensa = $50,000
             * Premio para el primer lugar = ($50,000 * 10%) / 100 = $5,000
             * Premio para el segundo lugar = ($50,000 - $5,000) (10%) / 100 = $4,500
             * Premio para el segundo lugar = ($40,500 - $4,500) (10%) / 100 = $4,050
             */

            $RewardTotal = $RewardTotal - $rewardUser;

            $rewardUser = ($RewardTotal * $LeaderBoard->reward_div) / 100;

            $data[$i]['Premio'] = $rewardUser;
        }


        return $data;
    }

}