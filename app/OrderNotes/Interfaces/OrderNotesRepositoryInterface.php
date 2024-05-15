<?php

namespace App\OrderNotes\Interfaces;

interface OrderNotesRepositoryInterface{
   public function add_note($order_id,$note,$admin_id,$company_id);
}
