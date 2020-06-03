<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //指定表名
    protected $table = 'admin';
    //指定主键,
    protected $primaryKey = 'admin_id';
    //是否开启时间戳
    public $timestamps = false;
    //设置时间戳格式为Unix
    protected $dateFormat = 'U';
    //过滤字段，只有包含的字段才能被更新
    protected $fillable = ['admin_name','admin_pwd','real_name','admin_sex','admin_mobile','admin_address',
    'is_quit','quit_time','created_by_id','created_time','updated_by_id','updated_time'];
    //隐藏字段
    protected $hidden = [];
    //页码
    protected $pagesize = 10;

    //登录
    public function AdminLogin($admin_name,$admin_pwd){
        $admin = $this->where([['admin_name','=',$admin_name],['admin_pwd','=',$admin_pwd],['is_quit','=','0']])
                ->first(['admin_id','admin_name','admin_pwd','real_name']);
        return $admin;
    }
    public function AdminList($page,$where_arr){
        $select = new Admin();
        foreach($where_arr as $k=>$v){
            $select = $select->where($k,'=',$v);
        }
        return $select->offset(($page-1)*$this->pagesize)->limit($this->pagesize)
         ->get(['admin_id','admin_name','real_name','admin_pwd','created_time','is_quit','quit_time','admin_sex','admin_mobile','admin_address']);
    }
    public function AdminCnt($where_arr){
        $select = new Admin();
        foreach($where_arr as $k=>$v){
            $select = $select->where($k,'=',$v);
        }
        return $select->count();
    }
    public function AdminGetByID($admin_id){
        return $this->find($admin_id);
    }
    public function AdminAdd($admin_data){
        $this->fill($admin_data);
        $this->save();
    }
    public function AdminAddByBatch($admin_data_arr){
        $this->insert($admin_data_arr);
    }
    public function AdminUpdate($admin_id,$admin_data){
        $rows_cnt = $this->where('admin_id','=',$admin_id)->update($admin_data);
        return $rows_cnt;
    }
}
