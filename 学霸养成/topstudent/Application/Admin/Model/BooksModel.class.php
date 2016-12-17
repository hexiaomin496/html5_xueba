<?php
   namespace Admin\Model;
   use Think\Model;

   class BooksModel extends Model{
   	 public $_validate=array(
   	    array('book_title',"require","课本标题不能为空"),
		array("book_content","require","课本内容不能为空"),
		array("book_type","require","课本类型不能为空"),
		// array("publisher","require","图书出版社不能为空"),
		// array("publishdate","require","图书出版时间不能为空"),
		// array("ISBN","require","图书ISBN不能为空"),
		// array("summary","require","图书内容不能为空")
   	 	);
   }
?>