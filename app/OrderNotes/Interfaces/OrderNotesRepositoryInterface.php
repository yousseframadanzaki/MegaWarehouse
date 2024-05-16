<?php

namespace App\OrderNotes\Interfaces;

interface OrderNotesRepositoryInterface{
   public function add_note($order_id,$note,$admin_id,$company_id);
   public function get_order_notes($order_id);
   public function add_order_note($order_id,$note,$admin_id,$company_id);
}
