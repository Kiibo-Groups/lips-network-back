<?php
namespace App\Http\Controllers\api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;
use App\Models\User;
use App\Models\AppUser;
use App\Models\Banner;
use App\Models\Admin;
use App\Models\CategoryStore;
use App\Models\Favorites;
use App\Models\Tickets;
use App\Models\Reward;
use App\Models\LeaderBoard;
use DB;  
class ApiController extends Controller
{


	public function getDataInit()
	{
		$text = new Text;
		$l = Language::find($_GET['lid']);

		$data = [
			'text' => $text->getAppData($_GET['lid']),
			'app_type' => isset($l->id) ? $l->type : 0,
			'admin' => Admin::find(1),
		];

		return response()->json(['data' => $data]);

	}

	public function homepage()
	{
		$banner = new Banner;
		$store = new User;
		$cats = new CategoryStore;
		

		$data = [
			'admin' => Admin::find(1),
			'banner' => $banner->getAppData(1, 0),
			'store' => $store->getAppData(1),
			'trending' => $store->InTrending(1), //$store->getAppData($city_id,true),
			'Categorys' => $cats->getAllCats()
		];

		return response()->json(['data' => $data]);
	}

	/**
	 * Signup / Login
	 * @param \Illuminate\Http\Request $Request
	 * @return mixed|\Illuminate\Http\JsonResponse
	 */
	public function login(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->login($Request->all()));
		} catch (\Throwable $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function signup(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->addNew($Request->all()));
		} catch (\Throwable $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function sendOTP(Request $Request)
	{
		try {
			$phone = $Request->phone;
			$hash = $Request->hash;
			return response()->json(['otp' => app('App\Http\Controllers\Controller')->sendSms($phone, $hash)]);
		} catch (\Throwable $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	/**
	 * Validacion de usuario
	 * @param \Illuminate\Http\Request $Request
	 * @return mixed|\Illuminate\Http\JsonResponse
	 */
	public function chkUser(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->chkUser($Request->all()));
		} catch (\Throwable $th) {
			return response()->json(['msg' => 'error', 'error' => $th->getMessage()]);
		}
	}

	public function userinfo($id)
	{
		try {
			$user = AppUser::find($id);
			return response()->json([
				'data' => $user,
				// 'balance' => Balance::where('user_id',$id)->get(),
				// 'cashBack' => $comm->getCashBack($id)
			]);
		} catch (\Exception $th) {
			return response()->json(['data' => 'error', 'error' => $th->getMessage()]);
		}
	}


	/**
	 * Recuperacion de cuenta
	 * @param \Illuminate\Http\Request $Request
	 * @return mixed|\Illuminate\Http\JsonResponse
	 */
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

	public function updateInfo($id, Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->updateInfo($Request->all(), $id));
		} catch (\Exception $th) {
			return response()->json(['data' => "error", 'error' => $th->getMessage()]);
		}
	}

	/**
	 * Favorites Funcions
	 * @param \Illuminate\Http\Request $Request
	 * @return mixed|\Illuminate\Http\JsonResponse
	 */
	public function SetFavorite(Request $Request)
	{
		try {
			$req = new Favorites;

			return response()->json(['data' => $req->addNew($Request->all())]);
		} catch (\Throwable $th) {
			return response()->json(['data' => "error"]);
		}
	}

	public function GetFavorites($id)
	{
		try {
			$req = new Favorites;

			return response()->json(['data' => $req->GetFavorites($id)]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error", 'error' => $th->getMessage()]);
		}
	}

	public function TrashFavorite($id, $user)
	{
		try {
			$req = new Favorites;
			return response()->json(['data' => $req->TrashFavorite($id, $user)]);
		} catch (\Throwable $th) {
			return response()->json(['data' => "error", 'error' => $th]);
		}
	}


	/**
	 * Control de Tickets
	 * @param \Illuminate\Http\Request $Request
	 * @return void
	 */
	public function UploadTicket(Request $request)
	{
		try { 
			$input  = $request->all();
			$imagen = $input['imagen'];
			$userId	= $input['id_cliente'];
			
			
			$target_path = "public/upload/tickets/";
			if (!file_exists("public/upload/tickets/")) {
				mkdir("public/upload/tickets/", 0777, true);
			}

			$base64Image = $imagen; // 

			// Obtener el tipo y los datos binarios desde la cadena base64
			list($type, $data) = explode(';', $base64Image);
			list(, $data)      = explode(',', $data);

			// Decodificar los datos binarios de base64
			$filename   = time() . rand(1119, 6999) . '.png';
			$imageData = base64_decode($data);
			$rutaImagenJPG = "public/upload/tickets/" . $filename;

			file_put_contents($rutaImagenJPG, $imageData);

			$data = [
				'app_user_id'  => $userId,
				'imagen'       => $filename,
				'fecha'        => Carbon::now()->format('Y-m-d'),
			];

			$tickets   = Tickets::create($data);

			return response()->json(['code' => 200, 'data' => $tickets, 'message' => 'Se ha creado el Tickets.']);
		} catch (\Exception $th) {
			return response()->json(['data' => $th->getMessage()]);
		}
	}

	public function GetAllTickets($id)
	{
		try {
			$Tickets = new Tickets;
			return response()->json(['data' => $Tickets->getAllTickets($id)]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error", 'error' => $th->getMessage()]);
		}
	}

	public function GetLastTicket($id)
	{
		try {
			$Tickets = new Tickets;
			return response()->json(['data' => $Tickets->getLastTicket($id)]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error", 'error' => $th->getMessage()]);
		}
	}

	/**
	 * Recompensas
	 * @param mixed $id
	 * @return void
	 */
	public function GetMyRewards($id)
	{
		try {
			$rewards = new Reward;
			return response()->json(['data' => $rewards->GetMyRewards($id)]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error", 'error' => $th->getMessage()]);
		}
	}

	public function overview($id)
	{
		try {
			$rewards = new AppUser;
			return response()->json(['data' => $rewards->overview($id)]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error", 'error' => $th->getMessage()]);
		}
	}

	public function GetListLeaders()
	{
		$leaders = new LeaderBoard;

		return response()->json(['data' => $leaders->GetListLeaders()]);
	}
}