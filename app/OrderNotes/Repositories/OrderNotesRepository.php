<?php

namespace App\OrderNotes\Repositories;

use App\Models\Order;
use App\OrderNotes\Interfaces\OrderNotesRepositoryInterface;
use App\Models\OrderNotes;
use Carbon\Carbon;


class OrderNotesRepository implements OrderNotesRepositoryInterface{
    public function add_note($order_id,$note,$admin_id,$company_id){
        $order_note = new OrderNotes;
        $order_note->order_id = $order_id;
        $order_note->note = $note;
        $order_note->admin_id = $admin_id;
        $order_note->company_id = $company_id;
        $order_note->active = 0;
        return $order_note->save();
    }
    public function get_order_notes($order_id){
        $notes = OrderNotes::with('admin')->where('order_id',$order_id)->get();
        foreach ($notes as $note) {
            $note->formatted_created_at = Carbon::parse($note->created_at)->format('Y-m-d h:i A');
        }
        echo json_encode($notes);die;
    }
    public function add_order_note($order_id,$note,$admin_id,$company_id){
        $order_note = new OrderNotes;
        $order_note->order_id = $order_id;
        $order_note->note = is_array($note) ? $note['note'] : $note;
        $order_note->admin_id = $admin_id;
        $order_note->company_id = $company_id;
        $order_note->active = is_array($note) ? $note['active'] : 0;
        if ($order_note->save()) {
            if (is_array($note)) {
                OrderNotes::where('order_id', $order_id)
                ->where('id', '!=', $order_note->id)
                ->where('active', 1)
                ->update(['active' => 0]);
            }
            return true;
        }
        else
            return false;
    }

    public function get_order_note($note_id) {
        return OrderNotes::with('admin')->find($note_id);
    }

    public function update_order_note($note_id, $details) {
        $order_note = OrderNotes::find($note_id);
        return $order_note->update($details);
    }

    public function update_note_active($note_id) {
        $order_note = OrderNotes::find($note_id);
        OrderNotes::where('order_id', $order_note->order_id)
        ->where('active', 1)->update(['active' => 0]);
        return $order_note->update(['active' => 1]);
    }
}
