<?php

namespace App\Http\Controllers;

use App\Models\AdminPower;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;

class AdminPowerController extends Controller
{
    public function admin_power_info($ids,Request $request){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_power", $admin_power_arr)){
            return redirect("/400");
        }

        $admin_power = new AdminPower();
        $data['ids'] = $ids;
        //只有单个用户的时候展示信息
        $is_power_arr = [];
        if(is_numeric($ids)){
            $power_list = $admin_power->AdminPowerList($ids);
            foreach($power_list as $k=>$v){
                $is_power_arr[] = $v->power_name_en;
            }
        }
        $data['is_power_arr'] = $is_power_arr;
        return view('admin-power',$data);
    }

    public function admin_power_add(Request $request){
        $admin_power = new AdminPower();
        $ids = $request->input('admin_ids');
        // 客户权限
        $is_customer_view = $request->input('customer_view') ? 1 : 0;
        $is_customer_add = $request->input('customer_add') ? 1 : 0;
        $is_customer_edit = $request->input('customer_edit') ? 1 : 0;
        $is_customer_delete = $request->input('customer_delete') ? 1 : 0;
        $is_customer_import = $request->input('customer_import') ? 1 : 0;
        $is_customer_export = $request->input('customer_export') ? 1 : 0;
        //  员工权限
        $is_admin_view = $request->input('admin_view') ? 1 : 0;
        $is_admin_add = $request->input('admin_add') ? 1 : 0;
        $is_admin_edit =  $request->input('admin_edit') ? 1 : 0;
        $is_admin_delete = $request->input('admin_delete') ? 1 : 0;
        $is_admin_import = $request->input('admin_import') ? 1 : 0;
        $is_admin_export = $request->input('admin_export') ? 1 : 0;
        $is_admin_power =  $request->input('admin_power') ? 1 : 0;

        $id_arr = explode(",",$ids);
        $power_data_arr = [];
        $time = Carbon::now()->toDateTimeString();
        
        foreach($id_arr as $id){
            if($id){
                $data=['admin_id'=>$id,'is_power'=>1,'created_by_id' => 0,'created_time'=>$time];
                
                // 客户管理
                if($is_customer_view){
                    $data['power_name'] = "浏览客户信息";
                    $data['power_name_en'] = "customer_view";
                    $power_data_arr[] = $data;
                }
                if($is_customer_add){
                    $data['power_name'] = "新增客户信息";
                    $data['power_name_en'] = "customer_add";
                    $power_data_arr[] = $data;
                }
                if($is_customer_edit){
                    $data['power_name'] = "编辑客户信息";
                    $data['power_name_en'] = "customer_edit";
                    $power_data_arr[] = $data;
                }
                if($is_customer_delete){
                    $data['power_name'] = "删除客户信息";
                    $data['power_name_en'] = "customer_delete";
                    $power_data_arr[] = $data;
                }
                if($is_customer_import){
                    $data['power_name'] = "导入客户信息";
                    $data['power_name_en'] = "customer_import";
                    $power_data_arr[] = $data;
                }
                if($is_customer_export){
                    $data['power_name'] = "导出客户信息";
                    $data['power_name_en'] = "customer_export";
                    $power_data_arr[] = $data;
                }
                // 员工管理
                if($is_admin_view){
                    $data['power_name'] = "浏览员工信息";
                    $data['power_name_en'] = "admin_view";
                    $power_data_arr[] = $data;
                }
                if($is_admin_add){
                    $data['power_name'] = "新增员工信息";
                    $data['power_name_en'] = "admin_add";
                    $power_data_arr[] = $data;
                }
                if($is_admin_edit){
                    $data['power_name'] = "编辑员工信息";
                    $data['power_name_en'] = "admin_edit";
                    $power_data_arr[] = $data;
                }
                if($is_admin_delete){
                    $data['power_name'] = "删除员工信息";
                    $data['power_name_en'] = "admin_delete";
                    $power_data_arr[] = $data;
                }
                if($is_admin_import){
                    $data['power_name'] = "导入员工信息";
                    $data['power_name_en'] = "admin_import";
                    $power_data_arr[] = $data;
                }
                if($is_admin_export){
                    $data['power_name'] = "导出员工信息";
                    $data['power_name_en'] = "admin_export";
                    $power_data_arr[] = $data;
                }
                if($is_admin_power){
                    $data['power_name'] = "员工权限";
                    $data['power_name_en'] = "admin_power";
                    $power_data_arr[] = $data;
                }
                

                // 先删掉他以前的权限
                $admin_power->AdmindPowerDelete($id);
                //批量插入新的权限
                $admin_power->AdminPowerAdd($power_data_arr);
            }
        }
        return back()->with(['message'=>'数据已经更改成功，请您耐心等待！', 'url' =>'/admin/list']);
    }
}
