<?php

namespace App\Http\Controllers;

use Request;

class UploadController extends Controller
{
    //上传图片
    public function upload_images(){
        $img = Request::file('img');//图片
        $file_path = Request::post('path');//存储位置
        if($img){
            $rule = ['jpg', 'png', 'gif'];
            $code = 1; $path = '';$msg = '';
            $entension = $img->getClientOriginalExtension();
            if (!in_array($entension, $rule)) {
                $code = 0;
                $msg = '图片格式为jpg,png,gif';
            }else{
                // 使用 store 存储文件
                $path = $img->store($file_path.'/'.date('Ymd'));
                $msg = '上传成功';
            }
            return ["code"=> $code, "msg"=>$msg, "url"=>"img/".$path];
        }

    }

    //上传文件
    public function upload_file(){
        $file = Request::file('file');//文件
        $file_path = Request::post('path');//存储位置
        if($file){
            $rule = ['xls', 'xlsx'];
            $code = 1; $path = '';
            $entension = $file->getClientOriginalExtension();
            if (!in_array($entension, $rule)) {
                $code = 0;
                $msg = '文件只能是Excel';
            }else{
                // 使用 store 存储文件
                $path = $file->store($file_path.'/'.date('Ymd'));
                $msg = '上传成功';
            }
            return ["code"=> $code, "msg"=>$msg, "url"=>'/app/'.$path];
        }

    }
}
