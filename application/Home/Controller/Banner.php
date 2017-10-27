<?php
/**
 * Banner管理控制器.
 * User: Administrator
 * Date: 2017/10/25 0025
 * Time: 下午 5:42
 */
namespace app\Home\controller;
use app\Home\model\Nave;
use think\Controller;
use think\Db;
use think\Request;

class Banner extends Controller
{


    /**
     * 分类导航bannerlist
     */
    public function bannerList()
    {
        $where=" 1 ";
        $param = Request::instance()->post();
        if(Request::instance()->isPost()){
            if($param['nav_id']){
                $navId=$param['nav_id'];
                $where.=" and a.nav_id = ".$navId;
                $this->assign('nav_id',$navId);
            }
            if($param['status']){
                $status=$param['status'];
                $where.=" and a.status = ".$status;
            }
        }
        $count=Db::table('e_nav_banner')
            ->alias('a')
            ->join('e_nav_list w','a.nav_id = w.nav_id')
            ->field('a.*,w.nav_name')
            ->where($where)
            ->count();
        $this->assign('count',json_encode($count));
        $bannerList=Db::table('e_nav_banner')
            ->alias('a')
            ->join('e_nav_list w','a.nav_id = w.nav_id')
            ->field('a.*,w.nav_name')
            ->where($where)
            ->select();
        $this->assign('bannerList',$bannerList);
        $nav_model = new Nave();
        $navInfo = $nav_model->getNavListInfo();
        $this->assign('navInfo',$navInfo);
        return $this->fetch('bannerList');
    }

    public function addBanner()
    {
        $param = Request::instance()->post();
        if(Request::instance()->isPost()){
            $data['nav_id'] = $param['nav_id'];
            $data['banner_img'] = $param['banner_img'];
            $data['Jump_url'] = $param['Jump_url'];
            $data['status'] = $param['status'];
            $data['add_time'] = time();
            $addBanner=Db::table('e_nav_banner')->insert($data);
            if($addBanner){
                $this->success('新增成功', 'banner/bannerList');
            }else{
                $this->error('新增失败','banner/addBanner');
            }
        }
        $nav_model = new Nave();
        $navInfo = $nav_model->getNavListInfo();
        $this->assign('navInfo',$navInfo);
        return $this->fetch('addBanner');
    }

    public function editBanner($id)
    {
        $param = Request::instance()->post();
        if(Request::instance()->isPost()){
            $id=$param['id'];
            $data['nav_id'] = $param['nav_id'];
            $data['Jump_url'] = $param['Jump_url'];
            $data['banner_img'] = $param['banner_img'];
            $data['status'] = $param['status'];
            $navEdit=Db::table('e_nav_banner')->where('id = '.$id)->update($data);
            if($navEdit){
                $this->success('修改成功', 'banner/bannerList');
            }else{
                $this->error('您未做任何修改');
            }
        }
        $banInfo=Db::table('e_nav_banner')->where('id = '.$id)->find();
        $this->assign('banInfo',$banInfo);
        $nav_model = new Nave();
        $navInfo = $nav_model->getNavListInfo();
        $this->assign('navInfo',$navInfo);
        return $this->fetch('editbanner');
    }

    public function delBanner($id)
    {
        $delBanner=Db::table('e_nav_banner')->where('id = '.$id)->update(array('status' => '2'));
        if($delBanner){
            $this->success('删除成功', 'banner/bannerList');
        }else{
            $this->error('删除失败');
        }

    }
}
