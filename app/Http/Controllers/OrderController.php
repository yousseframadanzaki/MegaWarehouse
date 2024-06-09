<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use App\Templates\Interfaces\TemplateServiceInterface;
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
    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        OrdersServiceInterface $OrdersService,
        TemplateServiceInterface $TemplateService,
        OrderNotesServiceInterface $OrderNotesService,
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->OrdersService = $OrdersService;
        $this->TemplateService = $TemplateService;
        $this->OrderNotesService = $OrderNotesService;
    }

    public function all(OrdersFilters $filters) {
        $clients = $this->CommonDataService->GetCompanyClients($this->company_id());
        $cities = $this->CommonDataService->GetCities();
        $statuses = $this->CommonDataService->GetCompanyStatuses($this->company_id());
        $marketers = $this->CommonDataService->GetCompanyMarketers($this->company_id());
        $orders = $this->OrdersService->GetCompanyOrders($this->company_id(),$filters);
        $products = $this->CommonDataService->GetCompanyProducts($this->company_id(),$filters);
        $filters = $filters->get_values();
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        return view('Dashboard.Orders.show_all')->with(
            compact(
                'orders',
                'clients',
                'cities',
                'statuses',
                'marketers',
                'shipping_companies',
                'products',
                'filters'
            ));
    }

    public function show($order_id) {
        $order = $this->OrdersService->GetOrder($order_id);
        $templates = $this->TemplateService->GetTextFromOrdersTemplates($order);
        $statuses = $this->CommonDataService->GetCompanyStatuses();
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
        if( $this->OrdersService->AddOrder(auth()->user(),$request->all()) ){
            $request->session()->flash('success', 'order_created_success');
            return redirect()->back();
        }
        return redirect()->back()->with(['error'=>'order_created_error','old_data'=>($request->except('token'))])->withInput();
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
        $client = $data['client'];
        $old_items = isset($data['old_items']) ? $data['old_items'] : array() ;
        $new_items = isset($data['items']) ? $data['items'] : array();
        $order = $this->OrdersService->UpdateOrder($order_id, $client);
        $old_stock = $this->OrdersService->UpdateStock($order_id, $old_items);
        $new_stock = $this->OrdersService->AddStock(auth()->user() ,$order_id, $new_items);
        $note = 'تم تعديل بيانات الأوردر';
        $order_note = $this->OrderNotesService->AddOrderNote($order_id,$note,auth()->user()->id,$this->company_id());

        if($order || $old_stock || $new_stock){
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
    public function print_order(Request $request ,$order_id){
        $data = $request->all();
        $selected_option = 1;
        $data = $this->OrdersService->GetOrderPrint($data ,$order_id);
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
                return redirect()->route('show_order', [$order_id])->with('success','confirm_order_success');
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

}
