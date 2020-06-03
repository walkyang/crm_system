<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminViewSetting extends Model
{
    //指定表名
    protected $table = 'admin_view_setting';
    //指定主键,
    protected $primaryKey = 'view_id';
    //是否开启时间戳
    public $timestamps = false;
    //设置时间戳格式为Unix
    protected $dateFormat = 'U';
    //过滤字段，只有包含的字段才能被更新
    protected $fillable = ['admin_id','view_name','view_name_en','power_type_enum','hidden_attribute','created_time','updated_time'];
    //隐藏字段
    protected $hidden = [];

    //权限列表
    public function AdminViewSettingByView($admin_id,$view_name_en){
        return $this->where("admin_id","=",$admin_id)->where("view_name_en","=",$view_name_en)
            ->get(['hidden_attribute'])->first();
    }
    //添加
    public function AdminViewSettingAdd($view_setting_data){
        $view_id = $this->where("admin_id","=",$view_setting_data['admin_id'])->where("view_name_en","=",$view_setting_data['view_name_en'])
            ->get(['view_id'])->first()->view_id;
        if($view_id){
            $view_setting = $this->find($view_id);
            $view_setting->hidden_attribute = $view_setting_data['hidden_attribute'];
            $view_setting->updated_time = $view_setting_data['updated_time'];
            $view_setting->save();
        }else{
            $this->fill($view_setting_data);
            $this->save();
        }

    }
}
