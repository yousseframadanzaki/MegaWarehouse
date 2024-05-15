<?php

namespace App\Http\Controllers;

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

}
