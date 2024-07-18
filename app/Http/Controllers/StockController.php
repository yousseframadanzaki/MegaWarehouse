<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Products\Interfaces\ProductVariantsRepositoryInterface;
use App\Stock\Filters\StockFilters;

use App\Stock\Requests\CreateStockRequest;
use App\Stock\Requests\DeleteStockRequest;

class StockController extends Controller
{
    public function __construct(
        private readonly CommonDataServiceInterface $CommonDataService,
        private readonly StockOperationServiceInterface $StockOperationService,
        private readonly ProductVariantsRepositoryInterface $ProductVariantsRepository,
    ) {
    }

    public function all(StockFilters $filters)
    {
        $company_id = $this->company_id();
        $stock = $this->StockOperationService->GetCompanyStock($company_id, $filters);

        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $products   = $this->CommonDataService->GetCompanyProducts($company_id);
        $users   = $this->CommonDataService->GetCompanyUsers($company_id);
        $suppliers   = $this->CommonDataService->GetCompanySuppliers($company_id);

        $filters = $filters->get_values();

        $data = array(
            "warehouses" => $warehouses,
            "products" => $products,
            "users" => $users,
            "suppliers" => $suppliers,
            "filters" => $filters,
        );

        return view('Dashboard.Stock.show_all')->with(['stock' => $stock, 'data' => $data]);
    }

    public function create()
    {
        $company_id = $this->company_id();
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $suppliers   = $this->CommonDataService->GetCompanySuppliers($company_id);
        return view('Dashboard.Stock.add')->with(compact('warehouses', 'suppliers'));
    }
    public function move()
    {
        $company_id = $this->company_id();
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $products   = $this->CommonDataService->GetCompanyProducts($company_id);
        return view('Dashboard.Stock.move')->with(compact('warehouses', 'products'));
    }

    public function store(CreateStockRequest $request)
    {
        $user = auth()->user();
        $ids = $this->StockOperationService->CreateOperation($user, $request->all());
        if ($ids) {
            return redirect()->route('all_stocks')->with('success', 'stock_add_success');
        }
        return redirect()->back()->with('error', 'stock_add_error');
    }
    public function delete(DeleteStockRequest $request)
    {
        if ($this->StockOperationService->DeleteOperations($request->input('opertation_ids'))) {
            return redirect()->route('all_stocks')->with('success', 'stock_delete_success');
        }
        return redirect()->back()->with('error', 'stock_delete_error');
    }

    public function variants_stock($variant_id)
    {
        $user = auth()->user();
        $data = $this->StockOperationService->GetVarintsStock($variant_id, $user);
        return response()->json($data);
    }
    public function scan(Request $request)
    {
        $data = $this->ProductVariantsRepository->get_scan_stock($request->input('id'));
        return response()->json($data);
    }
    public function remove_stock($id)
    {
        $data = $this->StockOperationService->DeleteStock($id);
        return response()->json($data);
    }
    public function update_variant_shelf(Request $request)
    {
        $shelf_data = $this->ProductVariantsRepository->get_variant_by_id($request->variant_id)->shelf_num;

        if (empty($shelf_data)) {
            $shelf_data = '{"' . $request->warehouse_id . '":' . $request->shelf_num . '}';
        } else {
            $shelf_data = json_decode($shelf_data, true);
            $shelf_data[$request->warehouse_id] = $request->shelf_num;
            $shelf_data = json_encode($shelf_data);
        }

        $this->ProductVariantsRepository->update_variant_shelf($request->variant_id, $shelf_data);
        return response()->json('تم تعديل رقم الرف بنجاح');
    }
}
