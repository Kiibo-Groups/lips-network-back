<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Banner;
use App\City;
use App\User;
use App\Admin;
use App\BannerStore;
use DB;
use Validator;
use Redirect;
use IMS;
class BannerController extends Controller {

	public $folder  = "admin/banner.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{					
		$admin = new Admin;
        $city = Auth::guard('admin')->user()->city_id;

		if ($admin->hasperm('Banners')) {
			$res = new Banner;

			return View($this->folder.'index',[
				'data' => $res->getAll(),
				'link' => env('admin').'/banner/']
			);

		}else {
			return Redirect::to(env('admin').'/home')->with('error', 'No tienes permiso de ver la sección Banners');
		}
	}	
	
	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function show()
	{	
		$admin = new Admin;

		if ($admin->hasperm('Banners')) {
			$city = new City;
			$user = new User;

			return View($this->folder.'add',[

				'data' 		=> new Banner,
				'form_url' 	=> env('admin').'/banner',
				'citys' 	=> $city->getAll(0),
				'users'		=> $user->getAll(0)

			]);
		}else {
			return Redirect::to(env('admin').'/home')->with('error', 'No tienes permiso de ver la sección Banners');
		}
	}
	
	/*
	|---------------------------------------
	|@Save data in DB
	|---------------------------------------
	*/
	public function store(Request $Request)
	{			
		$data = new Banner;	
		
		$data->addNew($Request->all(),"add");
		
		return redirect(env('admin').'/banner')->with('message','New Record Added Successfully.');
	}
	
	/*
	|---------------------------------------
	|@Edit Page 
	|---------------------------------------
	*/
	public function edit($id)
	{				
		$admin = new Admin;

		if ($admin->hasperm('Banners')) {
			$user = new User;

			return View($this->folder.'edit',[

				'data' 		=> Banner::find($id),
				'form_url' 	=> env('admin').'/banner/'.$id, 
				'users'		=> $user->getAll(0),

			]);
		}else {
			return Redirect::to(env('admin').'/home')->with('error', 'No tienes permiso de ver la sección Banners');
		}
	}
	
	/*
	|---------------------------------------
	|@update data in DB
	|---------------------------------------
	*/
	public function update(Request $Request,$id)
	{	
		$data = new Banner;
		
		$data->addNew($Request->all(),$id);
		
		return redirect(env('admin').'/banner')->with('message','Record Updated Successfully.');
	}
	
	/*
	|---------------------------------------------
	|@Delete Data
	|---------------------------------------------
	*/
	public function delete($id)
	{
		$res = Banner::find($id);

		BannerStore::where('banner_id',$id)->delete();

		@unlink("upload/banner/".$res->img);

		$res->delete();

		return redirect(env('admin').'/banner')->with('message','Record Deleted Successfully.');
	}

	/*
	|---------------------------------------------
	|@Change Status
	|---------------------------------------------
	*/
	public function status($id)
	{
		$res 			= Banner::find($id);
		$res->status 	= $res->status == 0 ? 1 : 0;
		$res->save();

		return redirect(env('admin').'/banner')->with('message','Status Updated Successfully.');
	}
}