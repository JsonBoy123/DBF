<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });
	// Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Auth::routes(['register' => false]);


Route::get('/update_item_quantity', 'HomeController@update_item_quantity')->name('update_item_quantity');

Route::get('/show_discount_alert', 'HomeController@showDiscountAlert')->name('show_discount_alert');
Route::post('/change_discount_status/{id}/{status}', 'HomeController@changeStatus')->name('change_discount_status');
Auth::routes(['register' => false]);

Route::post('shop_open', 'HomeController@storeLoginTime')->name('shop_open');
Route::get('req_for_item', 'Receivings\ReceivingsController@requestForItems')->name('req_for_item');
Route::get('show_list_of_item', 'Receivings\ReceivingsController@generate_list')->name('show_list_of_item');
Route::get('delete-list', 'Receivings\ReceivingsController@delete_list')->name('delete-list');
Route::post('repair_items', 'Receivings\ReceivingsController@repair_items')->name('repair_items');
Route::get('delete_all', 'Receivings\ReceivingsController@delete_all')->name('delete_all');

Route::post('receivings_item_save', 'Receivings\ReceivingsController@store')->name('receivings_item_save');
Route::post('save_category_on_item', 'Receivings\ReceivingsController@save_category_on_item')->name('save_category_on_item');

Route::get('shop_open_all', 'HomeController@getAllLoginTime')->name('shop_open_all');
Route::get('all_shop_details', 'HomeController@getAllShopsDetails')->name('all_shop_details');
Route::post('single_shop_details', 'HomeController@getSingleShopsDetails')->name('single_shop_details');
	
Route::get('/show_discount_alert', 'HomeController@showDiscountAlert')->name('show_discount_alert');

Route::resource('/customers', 'CustomerController');
	Route::post('/customers_update', 'CustomerController@edit')->name('customers_update');
	Route::post('/update_customer', 'CustomerController@update_customer')->name('update_customer');
	Route::post('/delete', 'CustomerController@delete')->name('delete');

	// Route::post('/sms_data', 'CustomerController@sms_data')->name('sms_data');

	Route::get('/allcustomer', 'CustomerController@getCustomer')->name('allcustomer');

// });

	Route::resource('/manager', 'Manager\ManagerController');
	Route::get('/item_manage_rack', 'Manager\ManageItem\ManageItemByRack@index')->name('item_manage_rack.index');
	Route::get('/item_manage_rack/rack_index', 'Manager\ManageItem\ManageItemByRack@create_rack')->name('item_manage_rack.create_rack');

	Route::get('/item_manage_rack/destroy/{id}', 'Manager\ManageItem\ManageItemByRack@destroy')->name('item_manage_rack.destroy');

	Route::post('/item_manage_rack/delete/', 'Manager\ManageItem\ManageItemByRack@delete')->name('item_manage_rack.delete');

	Route::post('/item_manage_rack/create_rack', 'Manager\ManageItem\ManageItemByRack@create_update')->name('item_manage_rack.update_edit_rack');

	Route::get('/item_manage_rack/edit_rack/{id}', 'Manager\ManageItem\ManageItemByRack@edit_rack');

	Route::post('/item_manage_rack/save_rack', 'Manager\ManageItem\ManageItemByRack@save_rack')->name('item_manage_rack.save_rack');


	Route::get('/item_manage_rack/create', 'Manager\ManageItem\ManageItemByRack@create')->name('item_manage_rack.create');

	Route::post('/item_manage_rack/store', 'Manager\ManageItem\ManageItemByRack@store')->name('item_manage_rack.store');

	/**Searching items based on Rack***/

	Route::get('rack-items/search', 'Manager\ManageItem\ManageItemByRack@searchItems')->name('rack-items.search');

	/******/

	Route::get('rack-items', 'Manager\ManageItem\ManageItemByRack@itemsInRack')->name('rack-items.index');

	Route::get('/issue_items', 'Manager\ManageItem\IssueItemController@index')->name('issue_items.index');
	Route::get('/issue_items/create', 'Manager\ManageItem\IssueItemController@create')->name('issue_items.create');
	Route::get('/issue_items/destroy/{id}', 'Manager\ManageItem\IssueItemController@destroy')->name('issue_items.destroy');

	Route::get('/issue_items/store', 'Manager\ManageItem\IssueItemController@store')->name('issue_items.store');

	Route::post('/issue_items/item_in_session', 'Manager\ManageItem\IssueItemController@itemInSession')->name('issue_items.itemInSession');

	Route::get('/issue_items/add_qty/{id}/{qty}', 'Manager\ManageItem\IssueItemController@add_qty')->name('issue_items.add_qty');


	Route::post('/excelDiscountUpdate', 'Manager\ManageItem\IssueItemController@excelDiscountUpdate')->name('excelDiscountUpdate');

	Route::resource('/reports', 'ReportsConroller');

	Route::resource('/sales', 'SalesConroller');

	Route::post('/update_bill_number', 'Sales\SalesController@updateBill')->name('update_bill_number');

	Route::post('import', 'CustomerController@import')->name('import');

	Route::get('export', 'CustomerController@export')->name('export');

	Route::get('phone-export', 'CustomerController@exportPhonenumber')->name('phone-export');

	Route::resource('/mci', 'Manager\ManagerMCIController');

	Route::resource('/mci-category', 'Manager\MCICategoryController');

	Route::resource('/mci-subcategory', 'Manager\MCISubCategoryController');

	Route::resource('/mci-size', 'Manager\MCISizeController');

	Route::resource('/mci-color', 'Manager\MCIColorController');

	Route::resource('/mci-brand', 'Manager\MCIBrandController');

	Route::post('/mci-category-import', 'Manager\MCICategoryController@categoryImport')->name('mci-category-import');
	
	Route::post('/mci-sub-category-import', 'Manager\MCISubCategoryController@subCategoryImport')->name('mci-sub-category-import');
	
	Route::post('/mci-brand-import', 'Manager\MCIBrandController@brandImport')->name('mci-brand-import');
	
	Route::post('/mci-color-import', 'Manager\MCIColorController@colorImport')->name('mci-color-import');
	
	Route::post('/mci-size-import', 'Manager\MCISizeController@sizeImport')->name('mci-size-import');

// ====================   shop   ======================================//

	Route::resource('/office', 'Office\OfficeController');

	Route::resource('shop', 'Office\Shop\ShopController');

	Route::resource('configuration', 'Office\Configuration\ConfigurationController');

	Route::get('test', 'Office\Shop\ShopController@testUser')->name('test');

/*---------------employee-----------------------*/

	Route::resource('employees', 'Office\Employees\EmployeesController');

	Route::get('permissions_show/{id}', 'Office\Employees\EmployeesController@permissions_show')->name('permissions_show');

	Route::post('get_model_permission', 'Office\Employees\EmployeesController@get_model_permission')->name('get_model_permission');

	Route::post('give_permission', 'Office\Employees\EmployeesController@give_permission')->name('give_permission');

	Route::get('show_store/{id}', 'Office\Employees\EmployeesController@location_permission')->name('location_permission');

	Route::post('get_shop', 'Office\Employees\EmployeesController@getShop')->name('get_shop');

	Route::post('give_shop_permission', 'Office\Employees\EmployeesController@give_shop_permission')->name('give_shop_permission');

	Route::post('send-message', 'Office\Employees\EmployeesController@sendMessage')->name('send-message');

/* Items */
	Route::resource('/items', 'Item\ItemController');

	

	Route::get('/items_edit/{id}', 'Item\ItemController@edit');

	Route::post('fetch_item', 'Item\ItemController@fetchData')->name('fetch_item');

	Route::post('getSubcategory', 'Item\ItemController@getSubcategory')->name('getSubcategory');

	Route::post('update_quantity', 'Item\ItemController@updateQty')->name('update_quantity');
	Route::post('percentage_update', 'Sales\SalesController@updatePecen')->name('percentage_update');

	Route::post('receiving_quantity', 'Item\ItemController@updateReceivingQuantity')->name('receiving_quantity');

	Route::post('excel_import', 'Item\ItemController@excelImportItems')->name('excel_import');

	Route::post('excel_update_import', 'Item\ItemController@excelUpdateImportItems')->name('excel_update_import');

	Route::post('item_sheet_password', 'Item\ItemController@getValidPasswordItems')->name('item_sheet_password');

	Route::get('download_sheet', 'Item\ItemController@downloadSheetFormat')->name('download_sheet');

	Route::post('excel-purchase-price/import', 'Item\ItemController@ExcelPurchasePriceUpdate')->name('purchase-price.update');

	Route::post('update_repair_cost', 'Item\ItemController@updateRepairCost')->name('update_repair_cost');

/* Items */


/* Managers */

	/* control Panel */
		Route::get('adjusted_history/{id}', 'Office\WholesaleCustomer\WholesaleCustomerController@adjustedPaymentHistory')->name('adjusted_history');

		Route::resource('control_panel', 'Manager\ControlPanel\ControlPanel');

		Route::get('cashier', 'Manager\ControlPanel\ControlPanel@Cashier')->name('cashier');
		Route::post('gte_shop_details', 'Manager\ControlPanel\ControlPanel@getShopDetails')->name('getShopDetails');

		Route::get('cashier_detail', 'Manager\ControlPanel\ControlPanel@CashierDetail')->name('cashier_detail');

		Route::get('offer_bundle', 'Manager\ControlPanel\ControlPanel@OfferBundle')->name('offer_bundle');

		Route::get('group_location', 'Manager\ControlPanel\ControlPanel@GroupLocation')->name('group_location');

		Route::get('custom_tab', 'Manager\ControlPanel\ControlPanel@CustomTab')->name('custom_tab');

		/* cashier_details */

		Route::post('add_cashier', 'Manager\ControlPanel\ControlPanel@AddCashierDetail')->name('add_cashier');

		Route::post('update_status', 'Manager\ControlPanel\ControlPanel@UpdateCashierStatusDetail')->name('update_status');

		Route::post('update_cashier', 'Manager\ControlPanel\ControlPanel@UpdateCashierDetail')->name('update_cashier');

		/* cashier_details */

		/* cashier */

		Route::post('AddCashier', 'Manager\ControlPanel\ControlPanel@AddCashier')->name('AddCashier');

		Route::post('fetch', 'Manager\ControlPanel\ControlPanel@fetchCashierShop')->name('fetch');

		/* cashier */

		/* Custom Tab */

		Route::post('custom', 'Manager\ControlPanel\ControlPanel@UpdateCustomTab')->name('custom');

		Route::post('fetchCustom', 'Manager\ControlPanel\ControlPanel@UpdateFetchCustomData')->name('fetchCustom');

		Route::post('custom_status', 'Manager\ControlPanel\ControlPanel@UpdateCustomStatus')->name('custom_status');


		/* Offer Bundle */

		Route::post('add_bundle', 'Manager\ControlPanel\ControlPanel@AddOfferBundle')->name('add_bundle');

		Route::post('get_list', 'Manager\ControlPanel\ControlPanel@GetOfferBundleTypes')->name('get_list');

		/* Offer Bundle */	

		/* Group Locations */

		Route::post('add_locations', 'Manager\ControlPanel\ControlPanel@AddLocationGroup')->name('add_locations');

		/* Group Locations */	

	/* control Panel */

		Route::resource('manager_reports', 'Manager\Reports\ReportController');

		Route::get('tally_format', 'Manager\Reports\ReportController@tallyFormatReport')->name('tally_format');
		Route::post('tally_format_report_gen', 'Manager\Reports\ReportController@tallyFormatReportGen')->name('tally_format_report_gen');

		Route::get('monthly_format', 'Manager\Reports\ReportController@monthlyFormatReport')->name('monthly_format');

		Route::get('custom_format', 'Manager\Reports\ReportController@customFormatReport')->name('custom_format');

		Route::get('email_format', 'Manager\Reports\ReportController@emailReport')->name('email_format');

	/* Sale Items Report */
		Route::get('sale-items-report', 'Manager\Reports\ReportController@itemsReport')->name('sale-items-report');
		Route::post('sale-items-report/get-categories', 'Manager\Reports\ReportController@getCategories')->name('get-categories');
		Route::post('sale-items-report/search', 'Manager\Reports\ReportController@itemsReportSearch')->name('sale-items-report.search');
		Route::post('sale-items-report/generate', 'Manager\Reports\ReportController@itemsReportGenerate')->name('sale-items-report.generate');
		Route::get('sale-items-report/challan/{id}', 'Manager\Reports\ReportController@itemsReportChallan')->name('sale-items-report.challan');
	
	/*  count action  */

		Route::resource('count_action', 'Manager\CountAction\countAction');

		Route::get('get_all_items/{id}', 'Manager\CountAction\countAction@getAllItems');
		
		Route::post('get_sub_cat', 'Manager\CountAction\countAction@getItemSubCategories');

		Route::get('get_size', 'Manager\CountAction\countAction@getItemSize')->name('get_size');

		Route::get('get_color', 'Manager\CountAction\countAction@getItemColor');

		Route::post('get_all_items_count', 'Manager\CountAction\countAction@getAllItemsCount');

	/*  count action  */

		Route::resource('bulk_action', 'Manager\BulkAction\bulkAction');

		Route::post('get_bulk_data', 'Manager\BulkAction\bulkAction@GetBulkActionData');

		Route::post('get_bulk_sub_cat', 'Manager\BulkAction\bulkAction@GettBulkActionSubCatData');

		Route::post('bulk_hsn_update', 'Manager\BulkAction\bulkAction@bulkHsnUpdate')->name('bulk_hsn_update');

		Route::post('bulk_discount_update', 'Manager\BulkAction\bulkAction@bulkDiscountUpdate')->name('bulk_discount_update');
		 
	   Route::post('bulk_offer_create', 'Manager\BulkAction\bulkAction@createOffer')->name('bulk_offer_create');
	   Route::post('bulk_offer_delete', 'Manager\BulkAction\bulkAction@deleteOffer')->name('bulk_offer_delete');

	/*  count action  */

	/* Extras */

		Route::resource('extras', 'Manager\Extras\Extras');

		Route::post('quickdata', 'Manager\Extras\Extras@QuickConvert')->name('quickdata');

	/* Extras */

	/* Extras */ 
		Route::resource('list_actions', 'Manager\ListAction\ListAction');

		Route::get('download/{id}', 'Manager\ListAction\ListAction@CSVDownload')->name('download');

		Route::post('getListActionMCI', 'Manager\ListAction\ListAction@GettListActionMCI')->name('getListActionMCI');

		Route::post('get_listaction_data', 'Manager\ListAction\ListAction@GettListActionData')->name('get_listaction_data');
	/* Extras */

	/* Enventory */

		Route::resource('enventory', 'Manager\Enventory\EnventoryController');
		Route::get('get_barcode/{id}', 'Manager\Enventory\EnventoryController@getBarcode')->name('get_barcode');
		Route::post('sheet_approval', 'Item\ItemController@sheetApproval')->name('sheet_approval');
		Route::post('sheet_decline', 'Item\ItemController@sheetDecline')->name('sheet_decline');

	/* Enventory */
/* Managers */

/* Offers */
Route::prefix('Office')->group(function () {
		Route::resource('offers', 'Office\Offer\OfferController');
		Route::get('/dicount_on_purchase', 'Office\Offer\DiscountOnPurchase@index')->name('dicount_on_purchase.index');
		Route::get('/dicount_on_purchase/create', 'Office\Offer\DiscountOnPurchase@create')->name('dicount_on_purchase.create');
		Route::post('/dicount_on_purchase/save', 'Office\Offer\DiscountOnPurchase@store')->name('dicount_on_purchase.store');
		Route::get('/dicount_on_purchase/edit/{id}', 'Office\Offer\DiscountOnPurchase@edit')->name('dicount_on_purchase.edit');
		Route::get('/dicount_on_purchase/delete/{id}', 'Office\Offer\DiscountOnPurchase@destroy')->name('dicount_on_purchase.delete');

		Route::resource('acl', 'Office\permission\RoleandPermissionController');

		Route::get('acl/get/{id}', 'Office\permission\RoleandPermissionController@get');

		Route::resource('module', 'Office\permission\ModuleContoller');

		Route::get('module/edit/{id}', 'Office\permission\ModuleContoller@edit')->name('moduleedit');

		Route::post('module/update/{id}', 'Office\permission\ModuleContoller@update')->name('moduleupdate');

	Route::prefix('offer')->group(function () {

		/* Dynamic Pricing */

		Route::get('view_dynamic_pricing', 'Office\Offer\OfferController@DynamicPricings')->name('view_dynamic_pricing');
		Route::post('add_pricing', 'Office\Offer\OfferController@AddPricing')->name('add_pricing');

		/* Dynamic Pricing */
		
		/* Vouchers */	

		Route::get('view_vouchers', 'Office\Offer\OfferController@Vouchers')->name('view_vouchers');

		Route::post('add_voucher', 'Office\Offer\OfferController@AddVouchers')->name('add_voucher');

		Route::put('update_voucher', 'Office\Offer\OfferController@UpdateVouchers')->name('update_voucher');

		Route::post('print_voucher', 'Office\Offer\OfferController@PrintVouchers')->name('print_voucher');

		Route::get('view_voucher', 'Office\Offer\OfferController@ViewVouchers')->name('view_voucher');

		Route::post('apply-voucher', 'Office\Offer\OfferController@applyVoucher')->name('apply.voucher');

		/* Vouchers */	


		/* Purchase Limits */

		Route::get('view_purchase_limits', 'Office\Offer\OfferController@PurchaseLimits')->name('view_purchase_limits');

		Route::post('add_limits', 'Office\Offer\OfferController@AddPurchaseLimit')->name('add_limits');

		Route::post('update__limiter_status', 'Office\Offer\OfferController@UpdateLimitStatus')->name('update__limiter_status');	

		Route::put('update_limit_counts', 'Office\Offer\OfferController@UpdateLimitCounts')->name('update_limit_counts');	

		/* Purchase Limits */
	});
});
	Route::resource('broker', 'Office\Broker\BrokerController');
	Route::get('broker_destroy/{id}', 'Office\Broker\BrokerController@destroy')->name('broker_destroy');
	Route::get('complete_commission/{id}', 'Office\Broker\BrokerController@completeCommission')->name('complete_commission');

	Route::resource('broker_commisssion', 'Office\Broker\BrokerCommissionController');


/* wholesale customer */

	Route::resource('wholesale_customer', 'Office\WholesaleCustomer\WholesaleCustomerController');
    Route::get('complete_payment/{id}', 'Office\WholesaleCustomer\WholesaleCustomerController@completePayment')->name('complete_payment');

    Route::post('pay_installment', 'Office\WholesaleCustomer\WholesaleCustomerController@paymentInstallment')->name('pay_installment');
    Route::post('adjust_amt', 'Office\WholesaleCustomer\WholesaleCustomerController@adjustAmount')->name('adjust_amt');
    Route::get('due_history/{id}', 'Office\WholesaleCustomer\WholesaleCustomerController@duePaymentHistory')->name('due_history');
/* wholesale customer */

/* Offers */

/* Receivings */

	// Receivings Items Check
	Route::resource('receivings-check', 'Receivings\ReceivingsCheckController');

	Route::get('receiving-check/history', 'Receivings\ReceivingsCheckController@receivingCheckHistory')->name('receiving-check.history');
	Route::get('receiving-check/{id}/history-show', 'Receivings\ReceivingsCheckController@receivingShowHistory')->name('receiving-show.history');

	Route::get('sales-check', 'Receivings\ReceivingsCheckController@salesIndex')->name('sales-check.index');
	Route::get('sales-check/{id}/show', 'Receivings\ReceivingsCheckController@salesShow')->name('sales-check.show');
	Route::get('sales-check/history', 'Receivings\ReceivingsCheckController@salesCheckHistory')->name('sales-check.history');
	Route::get('sales-check/{id}/history-show', 'Receivings\ReceivingsCheckController@salesShowHistory')->name('sales-show.history');

	Route::resource('/receivings', 'Receivings\ReceivingsController');

	Route::post('/get-item', 'Receivings\ReceivingsController@getItem')->name('get-item');

	// Route::post('/update_quantity', 'Receivings\ReceivingsController@updateQty')->name('update_quantity');

	Route::get('/view-manage-transfer', 'Receivings\ReceivingsController@viewManageTransfer')->name('view-manage-transfer');

	/***** Receiving Request ******/
	Route::get('show-requested-items/{id}', 'Receivings\ManageTransfer\ManagetransferController@showRequestedItems')->name('request-items.show');
	Route::post('receiving-request/update' , 'Receivings\ManageTransfer\ManagetransferController@receivingRequestUpdate')->name('receiving-request.update');
	Route::get('generate-receiving/show', 'Receivings\ManageTransfer\ManagetransferController@generateReceivingShow')->name('generate-receiving.show');
	Route::post('receiving-approve', 'Receivings\ManageTransfer\ManagetransferController@receivingApprove')->name('receiving.approve');

	Route::post('requested-dc/decline', 'Receivings\ManageTransfer\ManagetransferController@declineRecevingRequest')->name('generated-dc.decline');
	Route::post('delete-dc', 'Receivings\ManageTransfer\ManagetransferController@deleteDC')->name('delete-dc');

	Route::get('receivings-session/destroy', 'Receivings\ManageTransfer\ManagetransferController@receivingSessionDestroy')->name('receivings-session.destroy');
	//Search Items

	Route::get('request-items/search', 'Receivings\ManageTransfer\ManagetransferController@searchItems')->name('search-items');

	Route::get('all-items-shop/export', 'Receivings\ManageTransfer\ManagetransferController@exportAllShopsItem')->name('all-items-shop.export');

	Route::get('manage-receivings/{id}/notification', 'Receivings\ManageTransfer\ManagetransferController@receivingNotification')->name('receiving-notification');


	/***Item quantities update***/

	Route::get('items-quantity/index', 'Receivings\ManageTransfer\ManagetransferController@itemsQuantityIndex')->name('items-quantity.index');
	Route::post('items-detail/update', 'Receivings\ManageTransfer\ManagetransferController@itemsDetailsUpdate')->name('items-detail.update');
	Route::get('item-search', 'Receivings\ManageTransfer\ManagetransferController@itemsDetailSearch')->name('items-detail.search');

	Route::post('update-items-and-racks', 'Receivings\ManageTransfer\ManagetransferController@updateItemsracks')->name('update.items-racks');

	/********************************/

	Route::post('/all-chalances', 'Receivings\ReceivingsController@allChalances')->name('all-chalances');

	Route::post('/save_receiving_items', 'Receivings\ReceivingsController@save_receiving_items')->name('save_receiving_items');

/* End Receivings */

/* Sales */
Route::resource('/sales', 'Sales\SalesController');
Route::post('/get-sale-item', 'Sales\SalesController@getSaleItem')->name('get-sale-item');
Route::post('/get-customer', 'Sales\SalesController@getCustomer')->name('get-customer');
Route::post('/add-customer', 'Sales\SalesController@addCustomer')->name('add-customer');
// Route::post('/store-customer', 'Sales\SalesController@storeCustomer')->name('store-customer');
Route::post('/customer-cert-destroy/{id}', 'Sales\SalesController@customerCertDestroy')->name('customer-cert-destroy');
Route::post('/updatSaleItemeQty', 'Sales\SalesController@updateQty')->name('updatSaleItemeQty');
// Route::resource('/sales-manage', 'Sales\SalesManageController');
Route::get('/sales-invoice/{id}','Sales\SalesManageController@salesInvoice')->name('sales-invoice');
Route::post('/cert-items','Sales\SalesManageController@certItems')->name('cert-items');
Route::post('/igst-tax','Sales\SalesManageController@IgstTax')->name('igst-tax');
Route::post('/getSales','Sales\SalesManageController@getSales')->name('getSales');
Route::post('/getBro','Sales\SalesManageController@getBro')->name('getBro');
Route::get('/return_item/{id}','Sales\SalesManageController@return_item')->name('return_item');

Route::post('cashier_auth', 'Sales\SalesController@cashier_auth')->name('cashier_auth');


	Route::resource('/sales', 'Sales\SalesController');

	Route::post('/get-sale-item', 'Sales\SalesController@getSaleItem')->name('get-sale-item');

	Route::post('/get-customer', 'Sales\SalesController@getCustomer')->name('get-customer');

	Route::post('/add-customer', 'Sales\SalesController@addCustomer')->name('add-customer');

	Route::post('/store-customer', 'Sales\SalesController@storeCustomer')->name('store-customer');

	Route::post('cashier_auth', 'Sales\SalesController@cashier_auth')->name('cashier_auth');

	Route::post('/customer-cert-destroy/{id}', 'Sales\SalesController@customerCertDestroy')->name('customer-cert-destroy');

	Route::post('/updatSaleItemeQty', 'Sales\SalesController@updateQty')->name('updatSaleItemeQty');

	Route::resource('/sales-manage', 'Sales\SalesManageController');

	/***** Daily Sales *****/

		Route::get('daily-sales', 'Sales\SalesManageController@dailyIndex')->name('daily-sales.index');
		Route::post('daily-sales/search', 'Sales\SalesManageController@dailySearch')->name('sales.search');
		Route::post('sale-cancellation', 'Sales\SalesManageController@saleCancelation')->name('sale-cancellation');

	/*******************/

	Route::get('/sales-invoice/{id}','Sales\SalesManageController@salesInvoice')->name('sales-invoice');

	/*********/
	Route::get('sales-rack-info/{sales_id}', 'Sales\SalesManageController@SalesRackInfo')->name('sales-rack-info');

	Route::post('/cert-items','Sales\SalesManageController@certItems')->name('cert-items');

	Route::post('/igst-tax','Sales\SalesManageController@IgstTax')->name('igst-tax');
	Route::get('/remove_session','Sales\SalesManageController@RemoveSession')->name('remove_session');

	Route::post('/add_person_percentage','Sales\SalesManageController@addPersonPercentage')->name('addPersonPercentage');

/* End Sales */
/* Messages */
	Route::resource('message', 'Office\Messages\MessagesController');

	Route::post('message', 'Office\Messages\MessagesController@sendMessage')->name('message');
/* Messages */

// Stock items Transfer management

	Route::post('/get-receiving-item', 'Receivings\ReceivingsController@getSaleItem')->name('get-receiving-item');
	Route::post('stock-request', 'Receivings\ReceivingsController@stockRequest');
	Route::post('stock-request/show', 'Receivings\ReceivingsController@stockRequestShow')->name('stock-request.show');
	Route::post('stock-request/store', 'Receivings\ReceivingsController@stockRequestStore')->name('stock-request.store');

// Route::get('/word_match','word_match\WordMatchController@word_match')->name('word_match');

	Route::post('/save_item_session','word_match\WordMatchController@save_item_session')->name('save_item_session');
	Route::post('/remove_entry_session/{id}','Receivings\ReceivingsController@remove_entry_session')->name('remove_entry_session');

// Word Match Controller End

//Receiving Chalan Controller Start
	Route::resource('receiving_chalan','Receivings\ChalanController');
//Receiving Chalan Controller End

//Manage Transfer Controller Start

	Route::resource('manage_transfer','Receivings\ManageTransfer\ManagetransferController');
	
	//test
	Route::get('manage_transfer_show','Receivings\ManageTransfer\ManagetransferController@manage_transfer_show');

	Route::get('receivings/challan-excel-table/{id}', 'Receivings\ChalanController@chalanExcelTable')->name('challan.table');

	Route::get('receivings/update-repair/{id}', 'Receivings\ChalanController@UpdateRepairItem')->name('update_repair');
	Route::post('receivings/ReturnRepairItem', 'Receivings\ChalanController@ReturnRepairItem')->name('ReturnRepairItem');

	Route::post('stock_in_data','Receivings\ManageTransfer\ManagetransferController@stock_in_data')->name('stock_in_data');

	Route::post('accept_data_stockIn','Receivings\ManageTransfer\ManagetransferController@accept_data_stockIn')->name('accept_data_stockIn');

	Route::post('f_comment_stockIn','Receivings\ManageTransfer\ManagetransferController@f_comment_stockIn')->name('f_comment_stockIn');

//Manage Transfer Controller End

// Summary Report Start

	// Categories Controller Start

	
	Route::get('category-index', 'SummeryReportController@indexCategory')->name('categories-report.index');
	Route::post('category-show', 'SummeryReportController@showCategories')->name('categories-report.show');

	// Categories Controller End

	// CustomersReportController Start


	Route::get('customer-index', 'SummeryReportController@indexCustomer')->name('customers-report.index');
	Route::post('customer-show', 'SummeryReportController@showCustomers')->name('customers-report.show');

	// CustomersReportController End

	// DiscountsReportController Start

	Route::get('discount-index', 'SummeryReportController@indexDiscount')->name('discount-report.index');
	Route::post('discount-show', 'SummeryReportController@showDiscount')->name('discount-report.show');

	// DiscountsReportController End

	// EmployeesReportController Start

	Route::get('employees-index', 'SummeryReportController@indexEmployees')->name('employees-report.index');
	Route::post('employees-show', 'SummeryReportController@showEmployees')->name('employees-report.show');

	// EmployeesReportController End


	Route::get('expanses-index', 'SummeryReportController@indexExpanses')->name('expanses-report.index');
	Route::post('expanses-show', 'SummeryReportController@showExpanses')->name('expanses-report.show');

	Route::get('items-index', 'SummeryReportController@indexItems')->name('items-report.index');
	Route::post('show_items_report', 'SummeryReportController@getItemTotal')->name('show_items_report');

	Route::post('items-show', 'SummeryReportController@showItems')->name('items-report.show');

	// PaymentsReportController Start

	Route::get('payments-index', 'SummeryReportController@indexPayments')->name('payments-report.index');
	Route::post('payments-show', 'SummeryReportController@showPayments')->name('payments-report.show');

	// PaymentsReportController End

	// SuppliersReportController Start

	Route::get('suppliers-index', 'SummeryReportController@indexSuppliers')->name('suppliers-report.index');
	Route::post('suppliers-show', 'SummeryReportController@showSuppliers')->name('suppliers-report.show');

	// SuppliersReportController End

	// TaxesReportController Start

	//Route::resource('taxes_report','Summary_Reports\TaxesReportController');

	Route::get('tax-index', 'SummeryReportController@indexTaxes')->name('taxes-report.index');
	Route::post('tax-show', 'SummeryReportController@showTaxes')->name('taxes-report.show');

	


	// TaxesReportController End

	// TransactionsReportController Start

	Route::resource('transactions_report','Summary_Reports\TransactionsReportController');

	Route::get('transactions-index', 'SummeryReportController@indexTransactions')->name('transactions-report.index');
	Route::post('show_transactions', 'SummeryReportController@showTransactions')->name('Showtransactions');

	// TransactionsReportController End

	Route::post('sales-check/{id}/update', 'Receivings\ReceivingsCheckController@salesUpdate')->name('sales-check.update');
	// Summary Report End

	###################### Graphical Report Start ##############################

	// CategoriesReportController Start

	//Route::resource('graph_categories','Graphical_Reports\CategoriesReportController');
	Route::get('category-graph', 'GraphicalReportController@indexCategory')->name('category-graph');
	Route::post('category-graph', 'GraphicalReportController@showCategory')->name('category-graph.show');

	// CustomersReportController Start

	//Route::resource('graph_customers','Graphical_Reports\CustomersReportController');
	Route::get('customers-graph', 'GraphicalReportController@indexCustomer')->name('customers-graph');
	Route::post('customers-graph', 'GraphicalReportController@showCustomer')->name('customers-graph.show');

	// DiscountsReportController Start

	//Route::resource('graph_discounts','Graphical_Reports\DiscountsReportController');

	Route::get('discount-graph', 'GraphicalReportController@indexDiscount')->name('discount-graph');
	Route::post('discount-graph', 'GraphicalReportController@showDiscount')->name('discount-graph.show');

	// Employees Graph

	Route::get('employee-graph', 'GraphicalReportController@indexEmployee')->name('employee-graph');
	Route::post('employee-graph', 'GraphicalReportController@showEmployee')->name('employee-graph.show');

	// Expenses Graph

	Route::get('expense-graph', 'GraphicalReportController@indexExpense')->name('expense-graph');
	Route::post('expense-graph', 'GraphicalReportController@showExpense')->name('expense-graph.show');

	// ItemsReportController Start

	//Route::resource('graph_items','Graphical_Reports\ItemsReportController');

	Route::get('ItemGraphReport', 'GraphicalReportController@indexItemRepo')->name('ItemGraphReport');
	Route::post('ItemGraphReportShow', 'GraphicalReportController@showItemRepo')->name('ItemGraphReportShow');
	//Route::resource('graph_employees','Graphical_Reports\EmployeesReportController');


	// PaymentsReportController Start

	//Route::resource('graph_payments','Graphical_Reports\PaymentsReportController');

	Route::get('PaymentGraphReport', 'GraphicalReportController@indexPaymentRepo')->name('PaymentGraphReport');
	Route::post('PaymentGraphReportShow', 'GraphicalReportController@showPaymentRepo')->name('PaymentGraphReportShow');

	// TransactionsReportController Start

	//Route::resource('graph_transacions','Graphical_Reports\TransactionsReportController');

	Route::get('transGraphReport', 'GraphicalReportController@indexTransactionsRepo')->name('transGraphReport');
	Route::post('transGraphReportShow', 'GraphicalReportController@showTransactionsRepo')->name('transGraphReportShow');

	// SuppliersReportController Start

	Route::resource('graph_suppliers','Graphical_Reports\SuppliersReportController');

	Route::get('supplier-graph', 'GraphicalReportController@indexSupplier')->name('supplier-graph');
	Route::post('supplier-graph', 'GraphicalReportController@showSupplier')->name('supplier-graph.show');

	// SuppliersReportController End

	// taxesReportController Start

	//Route::resource('graph_taxes','Graphical_Reports\taxesReportController');

	Route::get('taxGraphReport', 'GraphicalReportController@indexTax')->name('taxGraphReport');
	Route::post('taxGraphReportShow', 'GraphicalReportController@showTax')->name('taxGraphReportShow');

	// taxesReportController End


// Graphical Report End

	########### Inventory Reports ############

	//Inventory Low

	Route::get('inventory-low', 'InventoryReportsController@indexLowInventory')->name('inventory-low-index');
	Route::post('inventory-low', 'InventoryReportsController@showLowInventory')->name('inventory-low-show');
	
	//Inventory Summery

	Route::get('inventory-summery-index', 'InventoryReportsController@indexInventorySummery')->name('inventory-summery-index');

	Route::post('inventory-summery-show', 'InventoryReportsController@showInventorySummery')->name('inventory-summery-show');

	//Inventory Age
	
	Route::get('inventory-age', 'InventoryReportsController@indexInventoryAge')->name('inventory-age-index');
	Route::post('inventory-age', 'InventoryReportsController@showInventoryAge')->name('inventory-age-show');

	###########################


# Detailed Reports Starts

//Transaction
	
	Route::get('detailed-transactions-index', 'DetailController@indexTransactions')->name('detailed-transactions-index');
	Route::post('detailed-transactions-show', 'DetailController@showTransactions')->name('detailed-transactions-show');

//receivings

	Route::get('detailed-receivings-index', 'DetailController@indexReceiving')->name('detailed-receivings-index');
	Route::post('detailed-receivings-show', 'DetailController@showReceiving')->name('detailed-receivings-show');

//Customers
	
	Route::get('detailed-customers-index', 'DetailController@indexCustomers')->name('detailed-customers-index');
	Route::post('detailed-customers-show', 'DetailController@showCustomers')->name('detailed-customers-show');

//Discounts
	
	Route::get('detailed-discounts-index', 'DetailController@indexDiscount')->name('detailed-discounts-index');
	Route::post('detailed-discounts-show', 'DetailController@showDiscount')->name('detailed-discounts-show');

//Employees
	
	Route::get('detailed-employees-index', 'DetailController@indexEmployee')->name('detailed-employees-index');
	Route::post('detailed-employees-show', 'DetailController@showEmployee')->name('detailed-employees-show');




//testing route for graphical report of taxes

	/*Route::get('taxGraphReport', 'DetailController@indexTax')->name('taxGraphReport');
	Route::post('taxGraphReportShow', 'DetailController@showTax')->name('taxGraphReportShow');

	Route::get('transGraphReport', 'DetailController@indexTransactionsRepo')->name('transGraphReport');
	Route::post('ajay', 'DetailController@showTransactionsRepo')->name('ajay');

	Route::get('PaymentGraphReport', 'DetailController@indexPaymentRepo')->name('PaymentGraphReport');
	Route::post('PaymentGraphReportShow', 'DetailController@showPaymentRepo')->name('PaymentGraphReportShow');

	Route::get('ItemGraphReport', 'DetailController@indexItemRepo')->name('ItemGraphReport');
	Route::post('ItemGraphReportShow', 'DetailController@showItemRepo')->name('ItemGraphReportShow');*/

# Detailed Reports End

#Start Repair Routes

Route::get('/repair', 'Repair\RepairController@index')->name('repair.index');
Route::post('/repair/store', 'Repair\RepairController@store')->name('repair.store');
Route::patch('/repair/update/{id}', 'Repair\RepairController@update')->name('repair.update');
Route::get('/repair/complete_work', 'Repair\RepairController@CompleteWork')->name('complete_work');
Route::get('/repair/work_item_detail/{id}', 'Repair\RepairController@WorkItemDetail')->name('WorkItemDetail');

#End Repair Routes
#___________ Account Repair Items _______________

Route::get('account/repair-items', 'Repair\RepairController@accountsRepairItem')->name('account.repair-items');
Route::post('account/repair-items/store', 'Repair\RepairController@accountsRepairStore')->name('account.repair-store');
Route::get('account/repair-items/challan/{id}', 'Repair\RepairController@accountsRepairChallan')->name('account.repair-challan');
Route::get('account/repair-items/history', 'Repair\RepairController@accountsRepairHistory')->name('account.repair-history');
Route::post('repaied-item-histoty', 'Repair\RepairController@getRepairedItem')->name('account.repaied-item-histoty');

