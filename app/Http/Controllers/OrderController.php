<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use App\Templates\Interfaces\TemplateServiceInterface;
use App\Products\Interfaces\ProductCrudServiceInterface;
use App\Orders\Requests\CreateOrderRequest;
use App\Orders\Filters\OrdersFilters;
use App\OrderNotes\Interfaces\OrderNotesServiceInterface;

use function Ramsey\Uuid\v1;

class OrderController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private OrdersServiceInterface $OrdersService;
    private TemplateServiceInterface $TemplateService;
    private OrderNotesServiceInterface $OrderNotesService;
    private ProductCrudServiceInterface $ProductCrudService;

    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        OrdersServiceInterface $OrdersService,
        TemplateServiceInterface $TemplateService,
        OrderNotesServiceInterface $OrderNotesService,
        ProductCrudServiceInterface $ProductCrudService,
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->OrdersService = $OrdersService;
        $this->TemplateService = $TemplateService;
        $this->OrderNotesService = $OrderNotesService;
        $this->ProductCrudService = $ProductCrudService;
    }

    public function all(OrdersFilters $filters, Request $request) {
        // dd($request->all());
        $clients = $this->CommonDataService->GetCompanyClients($this->company_id());
        $cities = $this->CommonDataService->GetCities();
        $statuses = $this->CommonDataService->GetCompanyStatuses($this->company_id());
        $marketers = $this->CommonDataService->GetCompanyMarketers($this->company_id());
        $orders = $this->OrdersService->GetCompanyOrders($this->company_id(),$filters, $request->all());
        $products = $this->CommonDataService->GetCompanyProducts($this->company_id(),$filters);
        $filters = $filters->get_values();
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        $admins = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 1)->pluck('name', 'id');
        return view('Dashboard.Orders.show_all')->with(
            compact(
                'orders',
                'clients',
                'cities',
                'statuses',
                'marketers',
                'shipping_companies',
                'products',
                'admins',
                'filters'
            ));
    }

    public function show($order_id) {
        $order = $this->OrdersService->GetOrder($order_id);
        $templates = $this->TemplateService->GetTextFromOrdersTemplates($order);
        $statuses = $order->status->getRelatedStatuses();
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        return view('Dashboard.Orders.show_one',compact('order','statuses','shipping_companies','templates'));
    }

    public function create() {
        $company_id = $this->company_id();
        $clients = $this->CommonDataService->GetCompanyClients($company_id);
        $countries = $this->CommonDataService->GetCountries();
        $products = $this->CommonDataService->GetCompanyProductsData($company_id);
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $marketers = $this->CommonDataService->GetCompanyMarketers($company_id);
        return view('Dashboard.Orders.add')->with(compact('clients','countries','products','warehouses','marketers'));
    }

    public function store(CreateOrderRequest $request){
        $order = $this->OrdersService->AddOrder(auth()->user(),$request->all());
        if(!empty($order->id)){
            $request->session()->flash('success', trans('global.created_success'));
            return redirect()->route('show_order', $order->id);
        }
        return redirect()->back()->with(['error'=>trans('global.created_error'),'old_data'=>($request->except('token'))])->withInput();
    }
    public function edit($order_id){
        $company_id = $this->company_id();
        $order = $this->OrdersService->GetOrder($order_id);
        $clients = $this->CommonDataService->GetCompanyClients($company_id);
        $countries = $this->CommonDataService->GetCountries();
        $areas = $this->CommonDataService->GetAreas();
        $cities = $this->CommonDataService->GetCities();
        $products = $this->CommonDataService->GetCompanyProducts($company_id);
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $marketers = $this->CommonDataService->GetCompanyMarketers($company_id);
        return view('Dashboard.Orders.edit')->with(compact('clients','countries', 'areas', 'cities','products','warehouses','marketers','order'));
    }

    public function update_order($order_id, Request $request){
        $data = $request->all();
        $order = $this->OrdersService->UpdateOrder($order_id, $data);

        if($order){
            return redirect()->route('show_order', [$order_id])->with('success','order_edited_success');
        }
    }
    public function scan_order($order_id){
        $order = $this->OrdersService->GetOrder($order_id);
        return view('Dashboard.Orders.scan_order')->with(compact('order'));
    }

    public function change_status(Request $request,$order_id) {

        $data = $request->all();
        $data['admin_id'] = auth()->user()->id;
        $data['company_id'] = $this->company_id();
        // dd($data);
        if($this->OrdersService->ChangeOrderStatus($order_id,$data)){
            return redirect()->back()->with('success','order_status_change_success');
        }
        return redirect()->back()->with('error','order_status_change_error');
    }

    public function change_status_bulk(Request $request)
    {
        $data = $request->except('_token');
        $data['admin_id'] = auth()->user()->id;
        $data['company_id'] = $this->company_id();

        if($this->OrdersService->ChangeOrderStatusBulk($data)){
            return redirect()->back()->with('success','order_status_change_bulk_success');
        }
        return redirect()->back()->with('error','order_status_change_bulk_error');
    }

    public function status_callback(Request $request) {
        $id = $this->OrdersService->ChangeOrderStatusCallback($request->all());
        return response()->json($id, 200);
    }
    public function status_callback_delete(Request $request) {
        $id = $this->OrdersService->DeleteOrderStatusCallback($request->all());
        return response()->json($id, 200);
    }
    public function mega_cost(Request $request) {
        if ($this->OrdersService->UpdateShippingCoCostCallback($request->all()))
            return response()->json(true, 200);
        else
            return response()->json(false, 400);
    }
    public function mega_payment(Request $request){
        $id = $this->OrdersService->SendOrderPaymentCallback($request->all());
        return response()->json($id, 200);
    }
    public function print_order($order_id){
        $selected_option = 1;
        $data = $this->OrdersService->GetOrderPrint($order_id);
        // dd($data);
        return view('Dashboard.Orders.print')->with(compact('data' ,'selected_option'));
    }
    public function print_orders(Request $request){
        $selected_option = $request->get('selected_option');
        $data = $this->OrdersService->GetOrdersPrint($request->all());
        return view('Dashboard.Orders.print')->with(compact('data','selected_option'));
    }
    public function print_label(Request $request ,$order_id){
        $selected_option = 1;
        $data = $request->all();
        $data = $this->OrdersService->GetLabelPrint($data ,$order_id);
        return view('Dashboard.Orders.print_label')->with(compact('data','selected_option'));
    }
    public function print_labels(Request $request){
        $selected_option = $request->get('selected_option');
        $data = $this->OrdersService->GetLabelsPrint($request->all());
        return view('Dashboard.Orders.print_label')->with(compact('data','selected_option'));
    }
    public function scan_items(Request $request){
        $data = $this->OrdersService->get_scan_items($request->input('id'));
        return response()->json($data);
    }
    public function confirm_order(Request $request){
        $data = $request->all();
        $order_id = $data['id'];

        $res['admin_id'] = auth()->user()->id;
        $res['company_id'] = $this->company_id();
        $res['status_id'] = '15';
            if($this->OrdersService->ChangeOrderStatus($order_id,$res)){
                return redirect()->back()->with('success','confirm_order_success');
            }
    }
    public function change_after_sale($order_id, Request $request){
        $data = $request->all();
        unset($data['_token']);
        $total_after_sale = $data['total_after_sale'];
        $order = $this->OrdersService->GetOrder($order_id);
        $note = 'تم تغيير اجمالى بعد الخصم من '.$order['total_after_sale'].' الى '.$total_after_sale.'';
        $order_note = $this->OrderNotesService->AddOrderNote($order_id,$note,auth()->user()->id,$this->company_id());
        $after_sale_order = $this->OrdersService->UpdateAfterSaleOrder($order_id,$this->company_id(),$data);
        return redirect()->route('show_order',$order_id)->with('success','change_after_sale_success');
    }

    public function search_orders(Request $request) {
        $data = explode("\n", $request->search_data);
        $orders = $this->OrdersService->SearchOrders($this->company_id(), $data);

        if ($request->ajax())
            return response()->json($orders);
        else if (!empty($request->scan)) {
            if ($orders->count() > 0)
                return redirect()->route('scan_order', $orders->first()->id);
            else
                return redirect()->back()->with('error', 'هذا الأوردر غير موجود');
        }
    }
    public function destroy(Request $request) {
        return response()->json($this->OrdersService->DeleteOrder($request->order_id));
    }
    public function incomplete_orders_variants() {
        $variants = $this->ProductCrudService->IncompleteOrdersVariants($this->company_id());
        return view('Dashboard.Orders.incomplete_orders', compact('variants'));
    }

    public function validate_shipping_report_orders(Request $request) {
        $order_codes = explode("\n", $request->searchOrders);

        // Step 1: Fetch all orders based on provided order codes and company ID
        $orders = $this->OrdersService->SearchOrdersNoPaginate($this->company_id(), $order_codes);

        // Step 2: Initialize arrays to hold orders in different categories
        $not_found = [];
        $not_related_shipping = [];
        $already_exist_in_reports = [];
        $not_in_statuses = [];

        // Step 3: Get all order codes found in the database
        $found_order_codes = $orders->pluck('order_code')->toArray();

        // Step 4: Determine orders that were not found
        $not_found = array_values(array_diff($order_codes, $found_order_codes));

        // Step 5: Filter through found orders and categorize them
        foreach ($orders as $order) {
            if (in_array($order->code, $not_found)) {
                continue; // Skip orders already categorized as not found
            }

            if ($order->shipping_company_id != $request->shipping_company_id) {
                $not_related_shipping[] = $order->order_code;
            } elseif ($order->payment_report_id !== null) {
                $already_exist_in_reports[] = $order->order_code;
            } elseif ($order->order_status->whereIn('id', [45, 50, 55, 75])->count() == 0) {
                $not_in_statuses[] = $order->order_code;
            }
        }

        // Step 6: Return any errors
        if (!empty($not_found) || !empty($not_in_statuses) || !empty($not_related_shipping) || !empty($already_exist_in_reports)) {
            return response()->json([
                'error' => true,
                'not_found' => $not_found,
                'not_in_statuses' => $not_in_statuses,
                'not_related_shipping' => $not_related_shipping,
                'already_exist_in_reports' => $already_exist_in_reports
            ]);
        }

        // Step 7: Return valid orders
        return response()->json(['orders' => $orders]);
    }
}
