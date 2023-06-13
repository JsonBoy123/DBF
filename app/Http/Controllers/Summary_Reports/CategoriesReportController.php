<?php

namespace App\Http\Controllers\Summary_Reports;

use Illuminate\Http\Request;
use App\Models\Office\Shop\Shop;
use Illuminate\Support\Facades\DB;
use App\Models\Manager\MciCategory;
use App\Http\Controllers\Controller;


class CategoriesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = all_shopes();
        return MciCategory::with(['salescat'])->get();

        return view('Summary_Reports.categories_index',compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
        $result = $query->with(['specialities'=>function($query){
                        $query->with('specialization_catgs');
                        }])->with(['user_courts'=>function($query) use($courts_code){
                        $query->with('court_catg')->whereIn('user_courts.court_code',$courts_code->toArray());
                    }]);
    */
    public function store(Request $request)
    {
        $cats = MciCategory::with(['saleItems'])
                    ->has('saleItems.sale')
                    ->get();

        /*return MciCategory::with(['saleItems.sale' => function($query){
                                $query->where('sale_status', '=', '2');
                            }])
                            ->has('saleItems.sale')
                            ->get();*/
        // return $cats;
        return view('Summary_Reports.categories-table',compact('cats'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
