<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\AdminViewSetting;

class AdminViewSettingController extends Controller
{
    public function admin_view_info($id,Request $request){
        $admin_view_setting = new AdminViewSetting();
        $data['n_admin_id'] = $id;
        $admin_id = $request->cookie('admin_id',0);
        $view_name_en = "admin_info";
        $data['hidden_attribute_arr'] = [];
        if($admin_id){
            $admin_view_setting =  $admin_view_setting->AdminViewSettingByView($admin_id,$view_name_en); 
            $data['hidden_attribute_arr'] = explode(',',$admin_view_setting->hidden_attribute);
        }
        return view('admin-view-info',$data);
    }

    public function admin_view_add(Request $request){
        $n_admin_id = $request->input('n_admin_id',0);
        // 客户权限
        $is_admin_sex = $request->input('admin_sex') ? 1 : 0;
        $is_admin_mobile = $request->input('admin_mobile') ? 1 : 0;
        $is_admin_address = $request->input('admin_address') ? 1 : 0;
        $admin_id = $request->cookie('admin_id',0);
        $time = Carbon::now()->toDateTimeString();
        
        $admin_view_setting = new AdminViewSetting();
        $data = ['admin_id'=>$admin_id,'view_name'=>'员工信息','view_name_en'=>'admin_info','created_time'=>$time,'updated_time'=>$time];
        $str_hidden_attribute = '';
        // 客户管理
        if($is_admin_sex){
            $str_hidden_attribute .= "admin_sex,";
        }
        if($is_admin_mobile){
            $str_hidden_attribute .= "admin_mobile,";
        }
        if($is_admin_address){
            $str_hidden_attribute .= "admin_address,";
        }
        $data['hidden_attribute'] = $str_hidden_attribute;
        
        //批量插入新的权限
        $admin_view_setting->AdminViewSettingAdd($data);
        
        return back()->with(['message'=>'数据已经更改成功，请您耐心等待！', 'url' =>'/admin/info/'.$n_admin_id]);
    }
}
