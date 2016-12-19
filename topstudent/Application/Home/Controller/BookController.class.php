<?php
namespace Home\Controller;
use Think\Controller;
class BookController extends Controller {
    public function index(){
    	$bookModel = M('books');
    	$condition['book_type'] = "语文";
    	$data = $bookModel->where($condition)->select();

    	$this->assign('list',$data);
        $this->display();
    }
}