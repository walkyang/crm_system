<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPower extends Model
{
    //指定表名
    protected $table = 'admin_power';
    //指定主键,
    protected $primaryKey = 'power_id';
    //是否开启时间戳
    public $timestamps = false;
    //设置时间戳格式为Unix
    protected $dateFormat = 'U';
    //过滤字段，只有包含的字段才能被更新
    protected $fillable = ['admin_id','power_name','power_name_en','power_type_enum','is_power','created_by_id','created_time'];
    //隐藏字段
    protected $hidden = [];

    //权限列表
    public function AdminPowerList($admin_id){
        return $this->where("admin_id","=",$admin_id)->where("is_power","=",1)
            ->get(['power_name_en']);
    }
    //添加
    public function AdminPowerAdd($power_data_arr){
        //return $this->create($power_data);
        // $this->fill($power_data);
        // $this->save();
        $this->insert($power_data_arr);

    }
    //删除
    public function AdmindPowerDelete($admin_id){
        $this->where('admin_id',$admin_id)->delete();
    }
}
