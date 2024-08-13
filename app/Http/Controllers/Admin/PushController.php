<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 
use App\Admin;

use DB;
use Validator;
use Redirect;
use IMS;
class PushController extends Controller {

	public $folder  = "admin/push.";
	
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{	 
		$admin = new Admin;	
		if ($admin->hasperm('Notificaciones push')) {		
		return View($this->folder.'index',[
			'form_url' => Asset(env('admin').'/push'),
			'array'    => []
			]);
		} else {
			return Redirect::to(env('admin').'/home')->with('error', 'No tienes permiso de ver la sección Notificaciones push');
		}
	}	

	public function send(Request $Request)
	{
		$img = null;
		if($Request->has('img'))
		{
			$filename = time().rand(111,699).'.' .$Request->file('img')->getClientOriginalExtension();
            $Request->file('img')->move("public/upload/push/",$filename);
            $img = Asset('upload/push/'.'/'.$filename);
		}
		
		// Tipo de notificaciones
		$destin_notify = $Request->get('destin_notify');

		if($destin_notify == 0) { // Usuarios
			$this->sendPush($Request->get('title'),$Request->get('desc'),0,$img);
		}else if($destin_notify == 1) {// Negocios
			$this->sendPushS($Request->get('title'),$Request->get('desc'),0,$img);
		}else { // Usuarios por defecto
			
			$this->sendPush($Request->get('title'),$Request->get('desc'),0,$img);
		}

		

		return Redirect::back()->with('message','Notifications sent Successfully.');
	}
}