<?php namespace App\Http\Controllers\api;

use App\Http\Requests;
use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use Auth;
use App\Delivery;
use App\Order;
use App\Language;
use App\Order_staff;
use App\Text;
use App\Admin;
use App\User;
use App\Rate_staff;
use DB;
use Validator;
use Redirect;
use Excel;
use Stripe;
class DboyController extends Controller {

	public function homepage()
	{
		try {
			$res 	 = new Order;
			$text    = new Text;
			$l 		 = Language::find($_GET['lid']);

			return response()->json([

				'data' 		=> $res->history(0),
				'text'		=> $text->getAppData($_GET['lid']),
				'app_type'	=> isset($l->id) ? $l->type : 0,
				'admin'		=> Admin::find(1)
			
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error",'error' => $th->getMessage()]);
		}
	}

	public function homepage_ext()
	{
		try {
			$res 	 = new Order;
			$text    = new Text;
			$l 		 = Language::find($_GET['lid']);
			$Neworder = Order_staff::where('d_boy',$_GET['id'])->whereIn('status',[0])->count();
			$Ruteorder = Order_staff::where('d_boy',$_GET['id'])->whereIn('status',[3,4])->count();

			return response()->json([
				'data' 		=> $res->history_ext(0),
				'Neworder'  => $Neworder,
				'Ruteorder' => $Ruteorder,
				'text'		=> $text->getAppData($_GET['lid']),
				'app_type'	=> isset($l->id) ? $l->type : 0,
				'admin'		=> Admin::find(1)	
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function overview()
	{
		$res 	 = new Delivery;

		return response()->json([
			'data' 		=> $res->overview(),
			'admin'		=> Admin::find(1),
		]);
	}


	public function staffStatus($type)
	{
		$res 			= Delivery::find($_GET['user_id']);
		$res->status 	= $type;
		$res->save();

		return response()->json(['data' => true]);
	}

	public function login(Request $Request)
	{
		$res = new Delivery;
		
		return response()->json($res->login($Request->all()));
	}

	public function signup(Request $Request)
	{
		$data = new Delivery;
		
		try {
			$valid = $data->ValidateAppSign($Request->all());

			if ($valid['msg'] == 'done') {
				return response()->json(['data' => $data->addNew($Request->all(),'add','app')]);
			}else {
				return response()->json(['data' => $valid]);
			}
		} catch (\Throwable $th) {
			return response()->json(['data' => ['msg' => "Error interno del servidor..."]]);
		}
		
	}

	public function forgot(Request $Request)
	{
		$res = new AppUser;
		
		return response()->json($res->forgot($Request->all()));
	}

	public function verify(Request $Request)
	{
		$res = new AppUser;
		
		return response()->json($res->verify($Request->all()));
	}

	public function updatePassword(Request $Request)
	{
		$res = new AppUser;
		
		return response()->json($res->updatePassword($Request->all()));
	}

	public function startRide()
	{
		try {
			$res 		 = Order::find($_GET['id']);
			$res->status = $_GET['status'];
			$res->save();
			 

			// Pedido Aceptado
			if ($_GET['status'] == 3) {
				// Verificamos que el pedido no ha sido tomado por alguien mas
				if ($res->d_boy != 0) {
					return response()->json(['data' => 'inUse']);	
				}else {
					$res->d_boy = $_GET['d_boy'];
					$res->save();

				
					// Notificamos al comercio que el repartidor acepto el pedido
					app('App\Http\Controllers\Controller')->sendPushS("Repartidor en camino","El repartidor ha aceptado el pedido, y va en camino.",$res->store_id);
					
					// Reseteamos
					Order_staff::where('order_id',$_GET['id'])->delete();
					// Guardamos el repartidor que tomo el pedido
					$order_Ext = new Order_staff;
					$order_Ext->d_boy 	= $_GET['d_boy'];
					$order_Ext->order_id = $_GET['id'];
					$order_Ext->status 	= 3;
					$order_Ext->save();
				}
			}
			// Pedido Recolectado
			if ($_GET['status'] == 4) {
				// Notificamos al usuario que su pedido va en camino.
				$res->sendSms($res->id);

				// Cambiamos el status en el pedido
				$order_Ext 		 = Order_staff::where('order_id',$_GET['id'])->first();
				$order_Ext->status = 4;
				$order_Ext->save();
			// Pedido Entregado
			}else if ($_GET['status'] == 5) {
				Order_staff::where('order_id',$_GET['id'])->delete();
				
				$staff = Delivery::find($res->d_boy);
				$staff->status_send = 0;
				$staff->save();

				// Agregamos la comision al repartidor
				$staff = new Delivery;
				$staff->Commset_delivery($res->id,$_GET['d_boy']);
				
				// Agregamos la comision al comercio 
				$user = new User;
				$user->amounts_mat($_GET['id']);

				// Notificamos al usuario
				$res->sendSms($res->id);
			}
			return response()->json(['data' => 'done']);			
		} catch (\Exception $th) {
			return response()->json(['data' => 'fail', 'err' => $th->getMessage()]);	
		}
	}

	public function rejected(Request $Request)
	{
		try {
			// Agregamos en calificaciones
			$order = $Request->get('order');
			$dboy  = $Request->get('dboy');

			$req    = Rate_staff::where('order_id',$order)->where('d_boy',$dboy)->first();
			$req->status = 2;
			$req->save();
			return response()->json(['data' => 'done']);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function cancelOrder()
	{
		try {
			$order		= isset($_GET['id']) ? $_GET['id'] : 0;
			$dboy		= isset($_GET['d_boy']) ? $_GET['d_boy'] : 0;

			// Marcamos su Score
			$score 		= Rate_staff::where('order_id',$order)->where('d_boy',$dboy)->first();
			if ($score) {
				$score->status = 2;
				$score->save();
			}else {
				$sc      = new Rate_staff;
				$sc->order_id    = $order;
				$sc->d_boy 		 = $dboy;
				$sc->status      = 2;
				$sc->save();
			}

			// Eliminamos el pedido en ruta 
			$inrute 	= Order_staff::where('order_id',$order)->where('d_boy',$dboy)->first();

			if ($inrute) {
				$inrute->delete();
			}

			// Reseteamos el pedido 
			$rorder 	= Order::find($order);
			$rorder->status = 1;
			$rorder->d_boy  = 0;
			$rorder->save();
 

			// Notificamos al comercio
			app('App\Http\Controllers\Controller')->sendPushS("Pedido Cancelado","El repartidor no ha podido recolectar el pedido, por favor reasigna nuevamente.",$rorder->store_id);
		
			// Notificamos al usuario
			app('App\Http\Controllers\Controller')->sendPush("Tu pedido sera reasignado","El repartidor no ha podido recolectar el pedido, en un momento sera reasignado por el comercio.",$rorder->user_id);
		

			return response()->json(['data' => 'done']);
		} catch (\Throwable $th) {
			return response()->json(['data' => 'fail']);
		}
	}

	public function userInfo($id)
	{
		try {
			$count = Order::where('d_boy',$id)->where('status',6)->count();
			return response()->json(['data' => Delivery::find($id),'order' => $count]);
 		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}

	
	public function updateInfo(Request $Request)
	{
		$res 				= Delivery::find($Request->get('id'));

		$res->type_driver   = $Request->get('type_driver');

		if ($Request->get('password') != '') {
			$res->password      = bcrypt($Request->get('password'));
			$res->shw_password  = $Request->get('password');
		}

		$res->save();
		return response()->json(['data' => 'done','res' => $res]);
	}

	public function updateLocation(Request $Request)
	{
		if($Request->get('user_id') > 0)
		{
			$add 			= Delivery::find($Request->get('user_id'));
			$add->lat 		= $Request->get('lat');
			$add->lng 		= $Request->get('lng');
			$add->save();
		}

		return response()->json(['data' => true]);
	}


	public function getPolylines()
	{
		$url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$_GET['latOr'].",".$_GET['lngOr']."&destination=".$_GET['latDest'].",".$_GET['lngDest']."&mode=driving&key=".Admin::find(1)->ApiKey_google;
		$max      = 0;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec ($ch);
        $info = curl_getinfo($ch);
        $http_result = $info ['http_code'];
        curl_close ($ch);


		$request = json_decode($output, true);
		
		return response()->json($request);
	}

	public function chkNotify()
	{
		$content = ["en" => "Prueba de audio, Notificaciones Push"];
		$head 	 = ["en" => "Notificacion Comercios"];		

	
		$fields = array(
		'app_id' => "ca6cf39d-b0f7-49ce-aa12-e624b6bd8a9d",
		'included_segments' => array('All'),	
		// 'filters' => [$daTags],
		'data' => array("foo" => "bar"),
		'contents' => $content,
		'headings' => $head,
		'android_channel_id' => '80321c11-2ef0-4c8a-813b-7456492d3db9'
		);
		
		
		$fields = json_encode($fields);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
		'Authorization: Basic YmNkODEyM2YtYWE4OS00MGI1LWI2ZGEtYjJjOGVhYjdiNDk1'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);

		

		$req = json_decode($response, TRUE);
       
	    return response()->json(['data' => $req]);
	}

}