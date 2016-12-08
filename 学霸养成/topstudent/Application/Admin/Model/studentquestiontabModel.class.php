<?php
namespace Home\Model;
use Think\Model\RelationModel;
class studentquestiontabModel extends RelationModel{
    protected $_link = array(
         'studentanswertab'  =>  array(
             'mapping_type' => self::HAS_MANY,
             'class_name' => 'studentanswertab',
             'foreign_key' => 'que_id',
             'mapping_name' => 'que_ans',

         ),
    );
}