<?php

namespace App\OrderNotes\Interfaces;

interface OrderNotesServiceInterface{
    public function AddNote($order_id,$note,$admin_id,$company_id);
    public function GetOrderNotes($order_id);
    public function AddOrderNote($order_id,$note,$admin_id,$company_id);
    public function GetOrderNote($note_id);
    public function UpdateOrderNote($note_id, $details);
}
