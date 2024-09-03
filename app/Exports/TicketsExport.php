<?php

namespace App\Exports;

use App\Models\Tickets;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TicketsExport  implements FromView
{
    public $folder  = "admin.tickets.";


    public function title(): string
    {
        return 'Listado de Tickets';
    }

    public function view(): view
    {
        $res = new Tickets;
        
		return View($this->folder.'export',[
		    'data' => $res->getallTicketExport(),
		]);
    }
}