<?php

namespace App\OrderNotes\Interfaces;

interface OrderNotesServiceInterface{
    public function AddNote($order_id,$note,$admin_id,$company_id);
}
