<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OrderNotes\Interfaces\OrderNotesServiceInterface;

class OrderNotesController extends Controller
{
    private OrderNotesServiceInterface $OrderNotesService;
    public function __construct(
        OrderNotesServiceInterface $OrderNotesService,
    )
    {
        $this->OrderNotesService = $OrderNotesService;
    }
    public function notes($order_id){
        $notes = $this->OrderNotesService->GetOrderNotes($order_id);
        return response()->json($notes, 200);
    }
    public function create_note(Request $request){
        $data = $request->all();
        $order_id = $data['order_id'];
        unset($data['order_id']);
        $note = $data;
        $admin_id = auth()->user()->id;
        $company_id = $this->company_id();
        $new_note = $this->OrderNotesService->AddOrderNote($order_id,$note,$admin_id,$company_id);
        return response()->json($new_note, 200);
    }

}
