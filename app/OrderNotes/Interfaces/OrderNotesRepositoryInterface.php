<?php

namespace App\OrderNotes\Interfaces;

interface OrderNotesRepositoryInterface{
   public function add_note($order_id,$note,$admin_id,$company_id);
   public function get_order_notes($order_id);
   public function add_order_note($order_id,$note,$admin_id,$company_id);
   public function get_order_note($note_id);
   public function update_order_note($note_id, $details);
   public function update_note_active($note_id);
}
