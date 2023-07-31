<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Media\Interfaces\MediaCrudServiceInterface;
class MediaController extends Controller
{
    public function __construct(
        MediaCrudServiceInterface $MediaCrudService
    ) {
        $this->MediaCrudService = $MediaCrudService;
    }
    
    public function destroy(string $id)
    {
        $response = $this->MediaCrudService->remove($id);
        return response()->json($response);
    }
}
