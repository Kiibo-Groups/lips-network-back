<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use App\Models\Admin;
use App\Models\AppUser; 
use DB;
use Validator;
use Redirect;
class AppUserController extends Controller {

	public $folder = "admin.AppUser.";

	/*
	|------------------------------------------------------------------
	|Index page for login
	|------------------------------------------------------------------
	*/
	public function index()
	{
		$users = new AppUser;

		// return response()->json([
		// 		'data' => $users->getAll()
		// ]);

		return View(
			$this->folder.'index',
			[
				'data' => $users->getAll(),
				'link' => env('admin').'/appUser/'
			]
		);
	}
   
	public function wallet($id)
	{
		$res = AppUser::find($id);

		// return response()->json([
		// 	'data' => $res,
		// ]);

		return View( $this->folder.'wallet',[
			'data' => $res,
			'link' => env('admin').'/appUser/',
            'form_url' => env('admin').'/appUser/update_wallet/'.$id,
		]);
	}

    public function resetWallet($id)
    {
        $res = AppUser::find($id);

        $res->update([
            'saldo' => 0
        ]);

        return redirect(env('admin').'/appUser')->with('message','El Saldo se ha reseteado Correctamente!!');
    }

    public function update_wallet(Request $request, $id)
    {

        $user = AppUser::findOrFail($id);
        $user->update([
            'saldo' => $request->input('saldo'),
        ]);

        return redirect(env('admin').'/appUser')->with('message','El Saldo se ha actualizado Correctamente!!');

    }

    public function score($id)
	{
		$res = AppUser::find($id);

		return View( $this->folder.'score',[
			'data' => $res,
			'link' => env('admin').'/appUser/',
            'form_url' => env('admin').'/appUser/update_score/'.$id,
		]);
	}

    public function resetScore($id)
    {
        $res = AppUser::find($id);

        $res->update([
            'score' => 0
        ]);

        return redirect(env('admin').'/appUser')->with('message','El Score se ha reseteado Correctamente!!');
    }

    public function update_score(Request $request, $id)
    {

        $user = AppUser::findOrFail($id);
        $user->update([
            'score' => $request->input('score'),
        ]);

        return redirect(env('admin').'/appUser')->with('message','El Score se ha actualizado Correctamente!!');

    }

	public function status($id)
	{
		$res = AppUser::find($id);
		if ($res) {
			$res->status = $res->status == 0 ? 1 : 0;
			$res->save();
			return redirect(env('admin').'/appUser')->with('message','Status del usuario Actualizado');
		}else {
			return redirect(env('admin').'/appUser')->with('error','Usuarios No Encontrado');
		}
	}

	public function trash($id)
	{
		AppUser::where('id',$id)->delete();

		return redirect(env('admin').'/appUser')->with('message','Usuario Eliminado.');
	}
}
