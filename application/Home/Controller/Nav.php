<?php
/**
 * 分类导航controller.
 * User: Pengfan
 * Date: 2017/10/23
 * Time: 14:46
 */
namespace app\Home\controller;
use app\Home\model\Nave;
use think\Controller;
use think\Db;
use think\Request;

class Nav extends Controller
{


    /**
     * 分类导航信息
     */
    public function Index(){
        $nav_model = new Nave();
        $navInfo = $nav_model->getNavListInfo();
        return $this->fetch('', [
            'navInfo' => $navInfo,
        ]);
    }

    /**
     * 新增导航信息
     */
    public function addNav()
    {
        $param = Request::instance()->post();
        if(Request::instance()->isPost()){
            $data['nav_name'] = $param['nav_name'];
            $data['status'] = $param['status'];
            $data['add_time'] = time();
            $nav_model = new Nave();
            $addNewNav = $nav_model->addNewNav($data);
            if($addNewNav){
                $this->success('新增成功', 'nav/index');
            }else{
                $this->error('新增失败','nav/addNav');
            }
        }
        return $this->fetch('addNav');
    }



    /**
     * 修改导航信息
     */
    public function editNav($id)
    {
        $param = Request::instance()->post();
        if(Request::instance()->isPost()){
            $id=$param['nav_id'];
            $data['nav_name'] = $param['nav_name'];
            $data['status'] = $param['status'];
           $navEdit=Db::table('e_nav_list')->where('nav_id = '.$id)->update($data);
            if($navEdit){
                $this->success('修改成功', 'nav/index');
            }else{
                $this->error('您未做任何修改');
            }
        }
        $navInfo=Db::table('e_nav_list')->where('nav_id = '.$id)->find();
        $this->assign('navInfo',$navInfo);
        return $this->fetch('editNav');
    }

    /**
     * 删除导航信息
     */
    public function delNav($id)
    {
       $delNav=Db::table('e_nav_list')->where('nav_id = '.$id)->update(array('status'=>'2'));
       if($delNav){
           $this->success('删除成功', 'nav/index');
       }else{
           $this->error('删除失败');
       }
    }
}