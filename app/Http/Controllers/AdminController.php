<?php

namespace App\Http\Controllers;

use App\Exports\DataExport;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Admin;
use App\Models\AdminViewSetting;
use App\Models\AdminPower;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cookie;

class AdminController extends Controller
{
    private $pagesize = 10;

    public function admin_login(Request $request){
        $rules = ['admin_name' => 'required','admin_pwd' => 'required'];
        $messages = ['admin_name.required' => '请填写用户名 ´◡` ','admin_pwd.required' => '请填写密码 ´◡` '];
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $admin = new Admin();
        $admin_name = $request->input('admin_name');
        $admin_pwd = $request->input('admin_pwd');
        $admin_info = $admin->AdminLogin($admin_name,$admin_pwd);
        if($admin_info) {
            //保存数据, cookie
            Cookie::queue('admin_id', $admin_info->admin_id, 24 * 3600);
            Cookie::queue('admin_name', $admin_info->admin_name, 24 * 3600);
            Cookie::queue('real_name', $admin_info->real_name, 24 * 3600);
            //把权限写入redis
            $admin_power = new AdminPower();
            $power_list = $admin_power->AdminPowerList($admin_info->admin_id);
            $str_power = "";
            foreach($power_list as $k=>$v){
                $str_power .= $v->power_name_en.",";
            }
            //Redis::set('my_crm_redis','ha哈哈'); //dd(Redis::get('my_crm_redis'));//Redis::del('my_crm_redis');
            Redis::set('admin_power_'.$admin_info->admin_id,$str_power); 

            return back()->with(['message'=>'登录成功，请您耐心等待！', 'url' =>'/home']);
        }else{
            return back()->withErrors(['用户名或密码错误´◡`']);
        }
    }

    public function admin_list($page=1,Request $request){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_view", $admin_power_arr)){
            return redirect("/400");
        }

        $data = [];
        $_surl = '';
        $admin_name = $request->input('admin_name','');
        $real_name= $request->input('real_name','');
        $admin = new Admin();
        $s_where = [];
        if($admin_name){
            $s_where['admin_name'] = $admin_name;
        }
        if($real_name){
            $s_where['real_name'] = $real_name;
        }
        $admin_list = $admin->AdminList($page,$s_where);
        $admin_cnt = $admin->AdminCnt($s_where);

        $_surl = $_surl ? '?'.ltrim($_surl,'&') : '';
        $start = ($page - 1) * $this->pagesize;
        $total = $admin_cnt;

        $data['admin_list'] = $admin_list;
        $data['pagestr'] = multi($total, $this->pagesize, $page, '/admin/list/', $_surl);
        $data['admin_power_arr'] = $admin_power_arr;
        return view('admin-list',$data);
    }

    public function admin_info($id=0,Request $request){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_view", $admin_power_arr)){
            return redirect("/400");
        }

        $data = [];
        $data['admin_info'] = null;
        if($id){
            $admin = new Admin();
            $admin_info = $admin->AdminGetByID($id);
            $data['admin_info'] = $admin_info;
        }

        $data['hidden_attribute_arr'] = [];
        if($admin_id){
            $admin_view_setting = new AdminViewSetting();
            $view_name_en = "admin_info";
            $admin_view_setting =  $admin_view_setting->AdminViewSettingByView($admin_id,$view_name_en); 
            $data['hidden_attribute_arr'] = explode(',',$admin_view_setting->hidden_attribute);
        }
        $data['admin_id'] = $id;
        return view('admin-info',$data);
    }

    // add or update
    public function admin_add(Request $request){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_add", $admin_power_arr)){
            return redirect("/400");
        }

        $admin_id = $request->input('admin_id');
        $admin_name = $request->input('admin_name');
        $real_name = $request->input('real_name');
        $admin_pwd = $request->input('admin_pwd');
        $admin_sex = $request->input('admin_sex');
        $admin_mobile = $request->input('admin_mobile');
        $admin_address = $request->input('admin_address');
        $check_quit = $request->input('is_quit');
        $is_quit = $check_quit ? 1 : 0;
        $admin_id = $request->cookie('admin_id',0);

        $admin = new Admin();
        $time = Carbon::now()->toDateTimeString();
        $rules = ['admin_name' => 'required','real_name' => 'required'];
        $messages = ['admin_name.required' => '请填写用户名 ´◡` ','real_name.required' => '请填写真实姓名 ´◡` '];
        if($admin_id){
            //update
            $admin_data=['admin_name'=>$admin_name,'real_name'=>$real_name,'is_quit'=>$is_quit,
            'admin_sex'=>$admin_sex,'admin_mobile'=>$admin_mobile,'admin_address'=>$admin_address,
            'updated_by_id'=>$admin_id,'updated_time'=>$time];
            if($admin_pwd){
                $admin_data['admin_pwd'] = $admin_pwd;
            }
        }else{
            $rules['admin_pwd'] = 'required';
            $messages['admin_pwd.required'] = '请填写密码 ´◡`';
            //add
            $admin_data=['admin_name'=>$admin_name,'real_name'=>$real_name,'admin_pwd'=>$admin_pwd,
            'admin_sex'=>$admin_sex,'admin_mobile'=>$admin_mobile,'admin_address'=>$admin_address,
            'is_quit'=>$is_quit,'created_by_id'=>$admin_id,'created_time'=>$time];
        }
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if($admin_id){
            $admin->AdminUpdate($admin_id,$admin_data);
        }else{
            $admin->AdminAdd($admin_data);
        }
        //suucess...
        return back()->with(['message'=>'数据已经更改成功，请您耐心等待！', 'url' =>'/admin/list']);
        
    }

    public function admin_delete($ids){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_delete", $admin_power_arr)){
            return redirect("/400");
        }

        $admin = new Admin();
        $id_arr = explode(",",$ids);
        foreach($id_arr as $id) {
            if ($id) {
                $admin_data["is_quit"] = 1;
                $admin->AdminUpdate($id,$admin_data);
            }
        }
        //suucess...
        return back()->with(['message'=>'数据已经更改成功，请您耐心等待！', 'url' =>'/admin/list']);
    }

    //导出用户
    public function admin_export(Request $request){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_export", $admin_power_arr)){
            return redirect("/400");
        }

        $cellData = [['用户名','姓名','密码','创建时间','性别','电话','地址','是否离职','离职日期']];
        $admin = new Admin();
        # 目前这里是所有数据
        $admin_list = $admin->AdminList(1,[]);
        foreach($admin_list as $k=>$v){
            $data = [$v->admin_name,$v->real_name,$v->admin_pwd,$v->created_time,$v->admin_sex,
            $v->admin_mobile,$v->admin_address,$v->is_quit,$v->quit_time];
            $cellData[] = $data;
        }
        $timestamp = Carbon::now()->timestamp;
        return Excel::download(new DataExport($cellData),'员工信息_'.$timestamp.'.xlsx');
    }
    //导入用户
    public function admin_import(Request $request){
        $admin_id = $request->cookie('admin_id',0);
        $admin_power = Redis::get('admin_power_'.$admin_id);
        $admin_power_arr = explode(",",$admin_power);
        if(!in_array("admin_import", $admin_power_arr)){
            return redirect("/400");
        }

        $file_url = $request->input('file_url');//文件
        $now_cnt = $request->input('now_cnt');
        $time = Carbon::now()->toDateTimeString();

        $admin = new Admin();
        $data_arr = [];
        if($file_url) {
            $array = Excel::toArray(new DataImport, storage_path($file_url));
            $total_cnt = count($array[0]);
            $max_cnt = 100;# 每次循环处理的条数
            if($total_cnt-$now_cnt < $max_cnt){
                $max_cnt = $total_cnt;
            }
            for ($i=$now_cnt; $i<$max_cnt; $i++) {
               //这里批量插入
               $admin_data=['admin_name'=>$array[0][$i][0],'real_name'=>$array[0][$i][1],
               'admin_pwd'=>$array[0][$i][2],'created_time'=>$array[0][$i][3],
               'admin_sex'=>$array[0][$i][4],'admin_mobile'=>$array[0][$i][5],'admin_address'=>$array[0][$i][6],
               'is_quit'=>$array[0][$i][7],'created_by_id'=>$admin_id];
               $data_arr[] = $admin_data;
            }
            if(count($data_arr) > 0){
                $admin->AdminAddByBatch($data_arr);
            }
            $now_cnt = $max_cnt+$now_cnt;
            if($now_cnt >= $total_cnt){
                $code = 1; $msg= "导入成功";
            }else{
                $code = 2; $msg= "导入中...";
            }
            return ["code"=> $code, "msg"=>$msg,"total_cnt"=>$total_cnt,"now_cnt"=>$now_cnt,"max_cnt"=>$max_cnt];
        }

    }

}
