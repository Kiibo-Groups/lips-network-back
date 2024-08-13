<?php namespace App\Http\Controllers\api;

use App\Http\Requests;
use App\Http\Controllers\Controller;  

use Illuminate\Http\Request;
use Auth;
use App\Offer;
use App\User; 
use App\AppUser; 
use App\Banner; 
use App\Admin; 
use App\Language;
use App\Text;
use App\Delivery;
use App\CategoryStore; 
use App\Favorites;
use DB;
use Validator;
use Redirect;
use Excel;
use Stripe;

class ApiController extends Controller {

 
	public function getDataInit()
	{
		$text    = new Text;
		$l 		 = Language::find($_GET['lid']);

		$data = [
			'text'		=> $text->getAppData($_GET['lid']),
			'app_type'	=> isset($l->id) ? $l->type : 0,
			'admin'		=> Admin::find(1),
		];

		return response()->json(['data' => $data]);
		
	}

	public function homepage()
	{
		$banner  = new Banner;
		$store   = new User; 
		$cats    = new CategoryStore; 

		$data = [
			'admin'		=> Admin::find(1),
			'banner'	=> $banner->getAppData(1,0),
			'store'		=> $store->getAppData(1),
			'trending'	=> $store->InTrending(1), //$store->getAppData($city_id,true),
			'Categorys' => $cats->getAllCats()
		];

		return response()->json(['data' => $data]);
	}

	public function ViewAllCats()
	{
		$cats    = new CategoryStore;
	
		$data = [
			'Categorys' => $cats->getAllCats(),
		];

		return response()->json(['data' => $data]);
	}

	public function getStoreOpen($city_id)
	{
		$store   = new User;
	
		$data = [
			'store'		=> $store->getStoreOpen($city_id),
			'admin'		=> Admin::find(1),
		];

		return response()->json(['data' => $data]);		
	}

	public function getStore($id)
	{
		try {
			$store   = new User;  
			return response()->json(['data' => $store->getStore($id)]);
		} catch (\Throwable $th) {
			return response()->json(['data' => "error",'error' => $th->getMessage()]);
		}
	}

	public function GetInfiniteScroll($city_id) {
		
		$store   = new User;
		
		$data = [
			'store'		=> $store->GetAllStores($city_id)
		];

		return response()->json(['data' => $data]);
	}
 
	public function search($query,$type,$city)
	{
		$user = new User;

		return response()->json(['data' => $user->getUser($query,$type,$city)]);
	}

	public function SearchCat($cat)
	{
		try {
			$user = new User;

			return response()->json([
				'cat'	=> CategoryStore::find($cat)->name,
				'data' 	=> $user->SearchCat($cat)
			]);
		} catch (\Throwable $th) {
			return response()->json(['data' => "error",'error' => $th->getMessage()]);
		}
	}

	public function SearchFilters($city_id)
	{
		$user = new User;

		return response()->json([
			'data' 	=> $user->SearchFilters($city_id)
		]);
	}
  

	public function getOffer($cartNo)
	{
		$res = new Offer;

		return response()->json(['data' => $res->getOffer($cartNo)]);
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
		$phone = $Request->phone;
		$hash  = $Request->hash;

		return response()->json(['otp' => app('App\Http\Controllers\Controller')->sendSms($phone,$hash)]);
	}

	public function SignPhone(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->SignPhone($Request->all()));
	}

	public function chkUser(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->chkUser($Request->all()));
	}

	public function login(Request $Request)
	{
		$res = new AppUser; 
		return response()->json($res->login($Request->all()));
	}

	public function Newlogin(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->Newlogin($Request->all()));
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

	public function loginFb(Request $Request)
	{
		$res = new AppUser;

		return response()->json($res->loginFb($Request->all()));
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

	public function signupOP(Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json(['data' => $res->signupOP($Request->all())]);
		} catch (\Exception $th) {
			return response()->json(['data' => "error",'error' => $th->getMessage()]);
		}
	}

	public function updateInfo($id,Request $Request)
	{
		try {
			$res = new AppUser;
			return response()->json($res->updateInfo($Request->all(),$id));
		} catch (\Exception $th) {
			return response()->json(['data' => "error",'error' => $th->getMessage()]);
		}
	}
  

	public function stripe()
	{

		try {
			Stripe\Stripe::setApiKey(Admin::find(1)->stripe_api_id);

			$res = Stripe\Charge::create ([
					"amount" => $_GET['amount'] * 100,
					"currency" => "MXN",
					"source" => $_GET['token'],
					"description" => "Pago de compra en FudiApp"
			]);

			if($res['status'] === "succeeded")
			{
				return response()->json(['data' => "done",'id' => $res['source']['id']]);
			}
			else
			{
				return response()->json(['data' => "error"]);
			}
		} catch (\Throwable $th) {
			return response()->json(['data' => "error"]);
		}
	}
 

	/**
	 * 
	 *  Favorites Funcions
	 * 
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
			return response()->json(['data' => "error",'error' => $th->getMessage()]);
		}
	 }

	 public function TrashFavorite($id, $user)
	 {
		try {
			$req = new Favorites;
			return response()->json(['data' => $req->TrashFavorite($id, $user)]);	
		} catch (\Throwable $th) {
			return response()->json(['data' => "error",'error' => $th]);
		}
	 }

	  

}
