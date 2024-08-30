<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\LeaderBoard;
use App\Models\Admin;
use App\Models\User;
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
		return response()->json([
			'data' => 'any'
		]);
	}
}