<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\AppUser;
use App\Models\Admin;
use App\Models\Withdrawals;
use DB;
use Validator;
use Redirect;
use IMS;
class WithdrawalController extends Controller {

	public $folder  = "admin/withdrawals.";


	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{					 
        return View($this->folder.'index',[
            'data' => Withdrawals::where('status',0)->get(),
            'link' => env('admin').'/withdrawal/']
        );
	}	

    public function changeStatus($id)
    {

        $withdrawal = Withdrawals::find($id);
        $withdrawal->status = 1;
        $withdrawal->save();

        return redirect(env('admin').'/withdrawal')->with('message','Traslado realizado con éxito!!');
    }

    public function cancelWithdrawal($id)
    {
        $withdrawal = Withdrawals::find($id);
        $withdrawal->status = 2;
        $withdrawal->save();

        // Agregamos el saldo de nuevo al usuario
        $user = AppUser::find($withdrawal->app_user_id);
        $user->saldo = $withdrawal->amount;
        $user->save();

        return redirect(env('admin').'/withdrawal')->with('message','Traslado cancelado con éxito!!');
    }
}