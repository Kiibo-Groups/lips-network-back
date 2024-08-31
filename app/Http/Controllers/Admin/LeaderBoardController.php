<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\LeaderBoard;
use App\Models\Tickets;
use App\Models\AppUser;
use App\Models\Reward;
use DB;
use Validator;
use Redirect;
use IMS;

class LeaderBoardController extends Controller {

	public $folder  = "admin/leaderboard.";

	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{					 

        return View($this->folder.'index',[
            'data' => LeaderBoard::get(),
            'link' => env('admin').'/leaderboard/']
        );
	}	
	
	
	public function EditLeaderboard()
	{
		return View($this->folder.'edit',[
            'data' => LeaderBoard::first(),
            'form_url' => env('admin').'/leaderboard/']
        );
	}

	public function _EditLeaderboard(Request $request)
	{

		$req = LeaderBoard::first();

		$req->score_min = $request->input('score_min');
		$req->reward = $request->input('reward');
		$req->reward_div = $request->input('reward_div');
		$req->date_end = $request->input('date_end');

		$req->save();


		return redirect(env('admin').'/leaderboard')->with('message','La tabla se ha actualizado Correctamente!!');
	}

	public function cashpool()
	{
		$req = LeaderBoard::first();

		$listUsers = $req->GetListLeaders();
	
		if (count($listUsers) > 0) {
			for ($i=0; $i < count($listUsers); $i++) { 
				// Agregamos el saldo a la wallet
				$user = AppUser::find($listUsers[$i]['user_id']);
				$user->saldo += $listUsers[$i]['Premio'];
				$user->save();

				// Cambiamos los estados de los tickets a intercambiado
				foreach ($listUsers[$i]['Ticket'] as $tick) {
					$ticket = Tickets::find($tick->id);
					$ticket->status = 3;
					$ticket->save();
				}

				// Agregamos la recompensa
				$Reward = new Reward;
				$Reward->create([
					'app_user_id' => $listUsers[$i]['user_id'],
					'place_reward' => $listUsers[$i]['Lugar'],
					'reward' => $listUsers[$i]['Premio'],
					'date_reward' => $req->date_end,
					'status' => 0
				]);
			}

			return redirect(env('admin').'/leaderboard')->with('message','Premios dispersados con éxito!!');

		}else {
			 
			return redirect(env('admin').'/leaderboard')->with('message','Sin elementos que entregar!!');
		}
		// return response()->json([
		// 	'data' => $req,
		// 	'listUsers' => $req->GetListLeaders()
		// ]);
	}
}