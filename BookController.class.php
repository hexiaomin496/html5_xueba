<?php
namespace Home\Controller;
use Think\Controller;
class BookController extends Controller {
	public function index(){
		$condition1['book_type'] = '语文';
		$condition1['book_grade'] = '一年级';
		$bookModel = M('books');
		$chinese = $bookModel->where($condition1)->select();
		$this->assign('chinese',$chinese);
		$this->assign('chineses',$chinese);

		$condition2['book_type'] = '数学';
		$condition2['book_grade'] = '一年级';
		$bookModel = M('books');
		$math = $bookModel->where($condition2)->select();
		$this->assign('math',$math);
		$this->assign('maths',$math);

		$condition3['book_type'] = '英语';
		$condition3['book_grade'] = '一年级';
		$bookModel = M('books');
		$english = $bookModel->where($condition3)->select();
		$this->assign('english',$english);
		$this->assign('englishs',$english);

		$this->display();
	}

	//二年级
	public function gradeTwo(){
		$condition1['book_type'] = '语文';
		$condition1['book_grade'] = '二年级';
		$bookModel = M('books');
		$chinese = $bookModel->where($condition1)->select();
		$this->assign('chinese',$chinese);
		$this->assign('chineses',$chinese);

		$condition2['book_type'] = '数学';
		$condition2['book_grade'] = '二年级';
		$bookModel = M('books');
		$math = $bookModel->where($condition2)->select();
		$this->assign('math',$math);
		$this->assign('maths',$math);

		$condition3['book_type'] = '英语';
		$condition3['book_grade'] = '二年级';
		$bookModel = M('books');
		$english = $bookModel->where($condition3)->select();
		$this->assign('english',$english);
		$this->assign('englishs',$english);

		$this->display();
	}

	//三年级
	public function gradeThree(){
		$condition1['book_type'] = '语文';
		$condition1['book_grade'] = '三年级';
		$bookModel = M('books');
		$chinese = $bookModel->where($condition1)->select();
		$this->assign('chinese',$chinese);
		$this->assign('chineses',$chinese);

		$condition2['book_type'] = '数学';
		$condition2['book_grade'] = '三年级';
		$bookModel = M('books');
		$math = $bookModel->where($condition2)->select();
		$this->assign('math',$math);
		$this->assign('maths',$math);

		$condition3['book_type'] = '英语';
		$condition3['book_grade'] = '三年级';
		$bookModel = M('books');
		$english = $bookModel->where($condition3)->select();
		$this->assign('english',$english);
		$this->assign('englishs',$english);

		$this->display();
	}

	//四年级
	public function gradeFour(){
		$condition1['book_type'] = '语文';
		$condition1['book_grade'] = '四年级';
		$bookModel = M('books');
		$chinese = $bookModel->where($condition1)->select();
		$this->assign('chinese',$chinese);
		$this->assign('chineses',$chinese);

		$condition2['book_type'] = '数学';
		$condition2['book_grade'] = '四年级';
		$bookModel = M('books');
		$math = $bookModel->where($condition2)->select();
		$this->assign('math',$math);
		$this->assign('maths',$math);

		$condition3['book_type'] = '英语';
		$condition3['book_grade'] = '四年级';
		$bookModel = M('books');
		$english = $bookModel->where($condition3)->select();
		$this->assign('english',$english);
		$this->assign('englishs',$english);

		$this->display();
	}

	//五年级
	public function gradeFive(){
		$condition1['book_type'] = '语文';
		$condition1['book_grade'] = '五年级';
		$bookModel = M('books');
		$chinese = $bookModel->where($condition1)->select();
		$this->assign('chinese',$chinese);
		$this->assign('chineses',$chinese);

		$condition2['book_type'] = '数学';
		$condition2['book_grade'] = '五年级';
		$bookModel = M('books');
		$math = $bookModel->where($condition2)->select();
		$this->assign('math',$math);
		$this->assign('maths',$math);

		$condition3['book_type'] = '英语';
		$condition3['book_grade'] = '五年级';
		$bookModel = M('books');
		$english = $bookModel->where($condition3)->select();
		$this->assign('english',$english);
		$this->assign('englishs',$english);

		$this->display();
	}

	//六年级
	public function gradeSix(){
		$condition1['book_type'] = '语文';
		$condition1['book_grade'] = '六年级';
		$bookModel = M('books');
		$chinese = $bookModel->where($condition1)->select();
		$this->assign('chinese',$chinese);
		$this->assign('chineses',$chinese);

		$condition2['book_type'] = '数学';
		$condition2['book_grade'] = '六年级';
		$bookModel = M('books');
		$math = $bookModel->where($condition2)->select();
		$this->assign('math',$math);
		$this->assign('maths',$math);

		$condition3['book_type'] = '英语';
		$condition3['book_grade'] = '六年级';
		$bookModel = M('books');
		$english = $bookModel->where($condition3)->select();
		$this->assign('english',$english);
		$this->assign('englishs',$english);

		$this->display();
	}

	public function detail(){
		$condition['book_id'] = I('id');
		$bookModel = M('books');
		$book = $bookModel->where($condition)->find();
		$array = explode(',', $book['book_img']);//将路径用','分割成数组
		for($i=0;$i<count($array);$i++){//删除数组中的空值
			if($array[$i] == ''){
				unset($array[$i]);
			}
		}
		$count = count($array);
		$this->assign('count',$count);
		$this->assign('book',$book);
		$this->display();
	}
}