<?php

namespace App\OrderNotes\Repositories;

use App\OrderNotes\Interfaces\OrderNotesRepositoryInterface;
use App\Models\OrderNotes;


class OrderNotesRepository implements OrderNotesRepositoryInterface{
    public function add_note($order_id,$note,$admin_id,$company_id){
        $order_note = new OrderNotes;
        $order_note->order_id = $order_id;
        $order_note->note = $note;
        $order_note->admin_id = $admin_id;
        $order_note->company_id = $company_id;
        return $order_note->save();
    }
}
