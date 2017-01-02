<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Note.php
 * Date: 2017/1/2
 * Time: 21:45
 */

namespace app\api\controller;

use think\Validate;

use app\library\Base as BaseController;
use app\api\model\Note as NoteModel;
use app\library\Error;

class Note extends BaseController {
    
    private $noteModel;

    public function __construct()
    {
        parent::__construct();
        $this->noteModel = new NoteModel();
    }

    public function addNote()
    {
        if (!$this->check($this->param)) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $ret = $this->noteModel->addNote($this->param);
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        }
        return $this->getRes();
    }

    public function getNoteList()
    {
        if (empty($this->param['cir_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $ret = $this->noteModel->getNoteList($this->param['cir_id']);
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        }
        $this->data = $ret;
        return $this->getRes();
    }

    public function getNote()
    {
        if (empty($this->param['note_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $ret = $this->noteModel->getNote($this->param['note_id']);
        if (false === $ret) {
            return $this->getRes(Error::ERR_SYS);
        }
        $this->data = $ret[0];
        return $this->getRes();
    }

    /**
     * @param $param
     * @return array|bool
     * @DESC 验证接口字段
     */
    public function check($param)
    {
        $rule = [
            'category_id' => 'require',
            'cir_id'      => 'require',
            'title'       => 'require|min:4',
            'content'     => 'require',
        ];
        $msg = [
            'category_id.require' => '帖子所属哪个圈子分类',
            'cir_id.require'      => '帖子所属哪个圈子',
            'title.require'       => '帖子标题不能为空',
            'title.min'           => '帖子标题不得少于4个字符',
            'content.require'     => '帖子内容不能为空',
        ];
        
        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            return $validate->getError();
        }
        return $result;
    }
    
}
