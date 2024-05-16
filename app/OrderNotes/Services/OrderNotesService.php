<?php

namespace App\OrderNotes\Services;

use App\OrderNotes\Interfaces\OrderNotesRepositoryInterface;
use App\OrderNotes\Interfaces\OrderNotesServiceInterface;



class OrderNotesService implements OrderNotesServiceInterface{

    public function __construct(
        protected readonly  OrderNotesRepositoryInterface $order_notes_crud_repository,
    ) {}
    public function AddNote($order_id,$note,$admin_id,$company_id){
        $this->order_notes_crud_repository->add_note($order_id,$note,$admin_id,$company_id);
    }
    public function GetOrderNotes($order_id){
        $this->order_notes_crud_repository->get_order_notes($order_id);
    }
    public function AddOrderNote($order_id,$note,$admin_id,$company_id){
        $this->order_notes_crud_repository->add_order_note($order_id,$note,$admin_id,$company_id);
    }
}
