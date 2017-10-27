<?php
/**
 * 分类导航model.
 * User: Pengfan
 * Date: 2017/10/23
 * Time: 15:10
 */
namespace app\Home\model;
use think\Db;
use think\Model;

class Nave extends Model
{
    /**
     * 获取分类导航信息
     * @return array or null;
     */
    public function getNavListInfo(){
        $data =Db::table('e_nav_list')
            ->where(['status' => 1])
            ->order('nav_id desc')
            ->select();
        return $data ? $data : null;
    }

    /**
     * 添加导航分类
     * @param $nav_name分类名称 $status状态 $add_time添加时间;
     * @return true or false;
     */
    public function addNewNav($data){
        $res=Db::table('e_nav_list')->insert($data);
        return $res ? true : false;
    }

}