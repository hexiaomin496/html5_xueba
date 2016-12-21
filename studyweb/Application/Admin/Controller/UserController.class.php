<?php
namespace Admin\Controller;
use Think\Controller;

class UserController extends Controller
{
	public function index()
	{
		import('Org.Util.Page');
		$userModel = M('usertab');
		$count = $userModel->count();

		$page = new\Think\Page($count,3);
        $nowPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page->setConfig('first','第一页');
        $page->setConfig('prev','前一页');
        $page->setConfig('next','后一页');
        
        $user = $userModel->page($nowPage.',3')->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('user',$user);

        $this->display();
	}
    
    //教师管理
	public function teacher()
	{
		import('Org.Util.Page');

		$teacherModel = M('teachertab');
		$count = $teacherModel->count();

		$page = new\Think\Page($count,2);
        $nowPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page->setConfig('first','第一页');
        $page->setConfig('prev','前一页');
        $page->setConfig('next','后一页');

        $teacher = $teacherModel->page($nowPage.',2')->select();
        $show = $page->show();
        $this->assign('page',$show);
	    $this->assign('teachertab',$teacher);

		$this->display();
	}

    //查看
    public function detail()
    {
    	//获取id
    	$id = I('id');

    	//answer-usertab表关联查询 查询出当前id回答的所有问题
    	$userAnsModel = M('answer');
    	$condition['answer.user_id'] = $id;
    	$userAns = $userAnsModel->join('RIGHT JOIN usertab ON answer.user_id = usertab.user_id ')->where($condition)->select();

    	//question-usertab表关联查询 查询出当前id提问的所有问题
    	unset($condition);//销毁查询条件
        $userQueModel = M('question');
        $condition['question.user_id'] = $id;
    	$userQue = $userQueModel->join('RIGHT JOIN usertab ON question.user_id = usertab.user_id')->where($condition)->select();

        //新建数组 
    	$user = array();
    	//计算长度
    	$lenAns = count($userAns);
    	$lenQue = count($userQue);
    	$lenSum = $lenAns + $lenQue;
    	//将当前id所有提问和回答的数据写入新数组
    	for ($i=0; $i < $lenAns; $i++) {
    		$user[$i] = $userAns[$i];
    	}
    	for($i = $lenAns,$j = 0; $i < $lenSum; $i++,$j++) {
    		$user[$i] = $userQue[$j];
    	}
        
    	//分页
     	// import('Org.Util.Page');
     	// unset($condition);
     	// $condition['question.user_id'] = $id;
     	// $userList = M('question')->join('usertab ON question.user_id = usertab.user_id')->join('answer ON usertab.user_id = answer.user_id')->where($condition)->select();
      //   //$count = $userList->count();
      //   dump((array)$userList);
      //   exit();

		// $page = new\Think\Page($lenSum,1);
  //       $nowPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
  //       $page->setConfig('first','第一页');
  //       $page->setConfig('prev','前一页');
  //       $page->setConfig('next','后一页');

  //       $user = $objectUser->page($nowPage.',1')->select();
  //       $show = $page->show();
  //       $this->assign('page',$show);
        $this->assign('user',$user);
        $this->display();
    }

    //删除
    public function delete()
    {
    	$condition['ans_id'] =  I('id');
    	$userAns = M('answer');
    	if($userAns->where($condition)->delete()){
    		$this->success('删除成功');
    	}else{
    		$this->error('删除失败');
    	}
    }

    //批量删除
    public function deleteAll()
    {
    	$queModel = M('question');
        $ansModel = M('answer');
        $condition['user_id'] = $_POST['test'][0];

        $queList = $queModel->where($condition)->delete();
        $ansList = $ansModel->where($condition)->delete();

        if($queList || $ansList) {
            $this->success('成功删除',U('index'));
        }else{
            $this->error('删除失败');
        }
    }

    //搜索用户---输入单字会乱码，输入的不是数字筛选出的有错
    public function searchUser()
    {
        import('Org.Util.Page');
        $username = $_POST['user_name'];
        $userModel = M('usertab');
        $condition['user_username'] = array('like','%'.$username.'%');
        $count = $userModel->where($condition)->count();//数据总数

        $page = new\Think\Page($count,2);
        $nowPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page->setConfig('first','第一页');
        $page->setConfig('prev','前一页');
        $page->setConfig('next','后一页');

        $user= $userModel->where($condition)->page($nowPage.',2')->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('user',$user);

        $this->display();
    }

	//搜索老师
	public function searchTea()
	{
		import('Org.Util.Page');
        $teachername = $_POST['user_name'];
        $teacherModel = M('teachertab');
        $condition['user_name'] = array('like','%'.$teachername.'%');
        //$teacher = $teacherModel->where($condition)->select();
        $count = $teacherModel->where($condition)->count();//数据总数

        $page = new\Think\Page($count,2);
        $nowPage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page->setConfig('first','第一页');
        $page->setConfig('prev','前一页');
        $page->setConfig('next','后一页');

        $teacher= $teacherModel->where($condition)->page($nowPage.',2')->select();
        $show = $page->show();
        $this->assign('page',$show);
        $this->assign('teacher',$teacher);

        $this->display();
	}

       //detail页里的搜索
       public function searchDetail()
       {
           $condition['usertab.user_id'] = $_SESSION['userID'];
           $content = I('post.content');
           $condition['content'] = array('like','%{$content}%');

           // dump($condition);
           // exit();
           $userAnsModel = M('answer');
           $userAns = $userAnsModel->join('RIGHT JOIN usertab ON answer.user_id = usertab.user_id ')->where($condition)->select();

           //question-usertab表关联查询 查询出当前id提问的所有问题
           $userQueModel = M('question');
           $userQue = $userQueModel->join('RIGHT JOIN usertab ON question.user_id = usertab.user_id')->where($condition)->select();

           //新建数组
           $user = array();
           //计算长度
           $lenAns = count($userAns);
           $lenQue = count($userQue);
           $lenSum = $lenAns + $lenQue;
           //将当前id所有提问和回答的数据写入新数组
           for ($i=0; $i < $lenAns; $i++) {
           $user[$i] = $userAns[$i];
           }
           for($i = $lenAns,$j = 0; $i < $lenSum; $i++,$j++) {
               $user[$i] = $userQue[$j];
           }

           $this->assign('user',$user);
           $this->display();
       }

   	//查询
   	public function query()
   	{
           $condition['usertab.user_id'] = $_SESSION['userID'];
   		$startTime1 = I('post.date1');
   		$endTime1 = I('post.date2');

   		$startTime2 = strtotime($startTime1);
   		$endTime2 = strtotime($endTime1);

   		$startTime = date('Y-m-d H:i:s',$startTime2);
   		$endTime = date('Y-m-d H:i:s',$endTime2);

   		$condition['publish'] = array('between', array($startTime,$endTime));

   		//answer-usertab表关联查询 查询出当前id回答的所有问题
       	$userAnsModel = M('answer');
       	$userAns = $userAnsModel->join('RIGHT JOIN usertab ON answer.user_id = usertab.user_id ')->where($condition)->select();

       	//question-usertab表关联查询 查询出当前id提问的所有问题
           $userQueModel = M('question');
       	$userQue = $userQueModel->join('RIGHT JOIN usertab ON question.user_id = usertab.user_id')->where($condition)->select();

           //新建数组
       	$user = array();
       	//计算长度
       	$lenAns = count($userAns);
       	$lenQue = count($userQue);
       	$lenSum = $lenAns + $lenQue;
       	//将当前id所有提问和回答的数据写入新数组
       	for ($i=0; $i < $lenAns; $i++) {
       	$user[$i] = $userAns[$i];
       	}
       	for($i = $lenAns,$j = 0; $i < $lenSum; $i++,$j++) {
       	 	$user[$i] = $userQue[$j];
       	}

           $this->assign('user',$user);
           $this->display();

   	}

	//封禁
	public function closure()
	{

	}

    //批量封禁
    public function closureAll()
    {

    }

	//认证查看---- 不能正常显示数据
	public function credit()
	{
		$condition['tea_id'] = I('id');
		$teacherModel = M('teachertab');
		$teacher = $teacherModel->where($condition)->select();
		// dump($teacher);
		// exit();
		$this->assign('teacher',$teacher);
		$this->display();
	}
	public function doCredit(){
                $condition['user_id'] = I('id');
                $teacherModel = M('teachertab');
                $teacher = $teacherModel->where($condition)->find();
                $teacher['tea_credit'] = '成功';
                $teacher = $teacherModel->where($condition)->save($teacher);
                //$this->success('认证成功',U('admin/user/teacher'));
                $this->redirect('admin/user/teacher', '', 0, '认证成功');
          }

    //撤职
    public function fire()
    {
        $condition['tea_id'] = I('id');
        $teacherModel = M('teachertab');
        if($teacherModel->where($condition)->delete())
        {
           $this->success('成功撤职',U('index')); 
        }else{
            $this->error('撤职失败');
        }

    }

	//批量撤职
	public function fireAll()
	{
		$teacherModel = M('teachertab');
    	$id = $_POST['test'];
    	$idResult=array_pop($id);//删除数组的最后一个元素

    	$i = 0;
    	foreach($id as $key => $value) {
    		$condition = 'tea_id='.$value;
    		$list[$i] = $teacherModel->where($condition)->delete();
    		$i++;
    	};

    	if($list) {
    		$this->success('成功撤职'.$i.'条',U('index'));
    	}else{
    		$this->error('撤职失败');
    	}
    }
}