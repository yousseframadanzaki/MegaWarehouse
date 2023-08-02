<?php



class StockOperationService implements StockOperationServiceInterface{

    public function CreateOperation($user,array $details){
        return $this->{$details['type']}($user,$details);
    }

    function move($user,$details) {

        $details['admin_id'] = $user->id;

        if(isset($details['image'])){
            $image = $details['image'];
            unset($details['image']);
        }

        $remove_details = $details;
        $add_details = $details;

        $remove_details['quantity'] = $remove_details['quantity']*-1;
        unset($remove_details['warehouse_to']);
        $remove_id = $this->StockOperationRepository->create($remove_details);

        $add_details['warehouse'] = $add_details['warehouse_to'];
        unset($add_details['warehouse_to']);
        $add_id = $this->StockOperationRepository->create();

        if($image){
            $file = $this->FileUploadService->stock($image,$user->company_id,$remove_id);
            $this->MediaService->save($file);
    
            $file->collection_id = $add_id;
            $this->MediaService->save($file);
        }

        return $add_id;

    }

    function buy($details) {
        $id   = $this->StockOperationRepository->create($details);
        if(isset($details['image'])){
            $file = $this->FileUploadService->stock($details['image'],$user->company_id,$id);
            $this->MediaService->save($file);
        }
        return $id;
    }

    function sell($details) {

    }

    function returned_orders($details) { 

    }

    function returned_suppliers($details) {

    }

}