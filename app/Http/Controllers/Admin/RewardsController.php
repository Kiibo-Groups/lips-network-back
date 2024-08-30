<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Reward;
use App\Models\Admin;
use App\Models\CategoryStore;
use DB;
use Validator;
use Redirect;
use IMS;
class RewardsController extends Controller {

	public $folder  = "admin/rewards.";


	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{					 
        return View($this->folder.'index',[
            'data' => Reward::get(),
            'link' => env('admin').'/tickets/']
        );
	}	
}