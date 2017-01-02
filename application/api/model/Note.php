<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Note.php
 * Date: 2017/1/2
 * Time: 23:13
 */
namespace app\api\model;

use app\library\Flag;
use think\Model;
use think\Db;

class Note extends Model
{
    protected $table = 'note';

    protected $pk = 'id';

    /**
     * 发帖
     *
     */
    public function addNote($arrInput)
    {

        $arrInput['date']    = date('Ymd', time());
        $arrInput['creator'] = '大黄';

        $this->data($arrInput);
        $this->save();
        return $this->data[$this->pk];
    }

    /**
     * 获取帖子列表
     * @param $circle_id
     */
    public function getNoteList($circle_id)
    {
        $arrCond = [
            'cir_id'    => ['=', $circle_id],
            'is_delete' => ['=', Flag::CONST_NOTE_DELETE_NOT],
        ];
        $field= 'category_id,cir_id,title,content,date,creator,create_time';
        return Db::table($this->table)->where($arrCond)->field($field)->select();
    }

}
