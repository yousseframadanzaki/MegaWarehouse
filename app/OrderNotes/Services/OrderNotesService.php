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
}
