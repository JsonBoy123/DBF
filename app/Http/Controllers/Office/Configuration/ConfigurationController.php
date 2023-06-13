<?php

namespace App\Http\Controllers\Office\Configuration;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Configuration\Configuration;
use File;

class ConfigurationController extends Controller
{
    public function index()
    {
    	$data = Configuration::first();

    	// dd($data->company_logo);

    	return view("office.configuration.index",compact('data'));
    }

    public function update(Request $request, $id)
    {

    	$data = $request->validate([ 
    								'company_name'  => 'required',
                                    'company_logo'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10000', 
    								'address'       => 'required',
                                    'website'       => 'nullable',
                                    'email'         => 'nullable',
                                    'phone'         => 'required',
                                    'fax'         	=> 'nullable',
                                    'return_policy' => 'nullable',
                                     ]);
        
         	
         	if(empty($request->hasFile('company_logo')) && !empty($id)){


		           $old_data = Configuration::where('id',$id)->first();

		            if($request->image == null) {
		                $data['company_logo'] = $old_data->company_logo;    
		            }

		        Configuration::where('id',$id)->update($data);

	             return redirect('configuration');

		       }

		    if($request->hasFile('company_logo')) {


	         	$filename 			= $request->file('company_logo')->getClientOriginalName();
	            $extension 			= $request->file('company_logo')->getClientOriginalExtension();
	            $fileNameToStore 	= $request->company_name.'_'.$filename;

	            $chk_path 			= storage_path('app/public/logo');
	               
	            if(! File::exists($chk_path)){
	                File::makeDirectory($chk_path, 0777, true, true);
	            }

	            $path = $request->file('company_logo')->storeAs('public/logo', $fileNameToStore);
	            $data['company_logo'] = $fileNameToStore;    

	            Configuration::where('id',$id)->update($data);

	             return redirect('configuration');
            }
    }
}
