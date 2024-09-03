<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;
use App\Models\Tickets;
use App\Models\Admin;
use App\Models\CategoryStore;
 
class TicketsController extends Controller {

	public $folder  = "admin/tickets.";
	/*
	|---------------------------------------
	|@Showing all records
	|---------------------------------------
	*/
	public function index()
	{					 
        $res = new Tickets;
      
        return View($this->folder.'index',[
            'data' => $res->getAll(),
            'link' => env('admin').'/tickets/']
        );
	}	
	
	/*
	|---------------------------------------
	|@Add new page
	|---------------------------------------
	*/
	public function ViewTicket($id)
	{	

        $ticket = new Tickets;

        // return response()->json($ticket->viewTicket($id));

		return View($this->folder.'view',[
            'data' 		=> $ticket->viewTicket($id),
            'categorys'    => CategoryStore::where('status',0)->get(),
            'form_url' => env('admin').'/ticket_edit/'.$id,
        ]);
	}

    public function ticket_edit(Request $request, $id)
    {
        $ticket = Tickets::findOrFail($id);

        $ticket->update([
            'valor' => $request->input('valor'),
			'score' => $request->input('score'),
            'categorystore_id' => $request->input('categorystore_id'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
        ]);

        return redirect(env('admin').'/tickets')->with('message','El ticket se ha actualizado Correctamente!!');
        // return response()->json($request->all());
    }
	
	public function exportData_tickets()
	{
		return Excel::download(new TicketsExport, 'list_tickets.xlsx');
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