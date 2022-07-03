<?php

namespace tpext\builder\traits\actions;

use think\facade\Session;
use tpext\builder\common\Form;
use tpext\builder\common\Builder;

/**
 * 基础
 */

trait HasBase
{
    /**
     * 数据模型
     *
     * @var \think\Model
     */
    protected $dataModel;

    /**
     * Undocumented variable
     *
     * @var Form
     */
    protected $form;

    /**
     * 页面标题
     *
     * @var string
     */
    protected $pageTitle = 'Page';
    protected $addText = '添加';
    protected $editText = '编辑';
    protected $viewText = '查看';
    protected $enableField = 'enable';
    protected $pk = 'id';

    /**
     * 表单是否为编辑模式
     * 0:add,1:edit,2:view
     * @var boolean
     */
    protected $isEdit = false;

    /**
     * Undocumented function
     *
     * @param boolean|int $isEdit 0:add,1:edit,2:view
     * @param array $data
     * @return void
     */
    protected function buildForm($isEdit, &$data = [])
    {
        $form = $this->form;
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @param boolean $isExporting
     * @return void
     */
    protected function buildTable(&$data = [], $isExporting = false)
    {
        $table = $this->table;
    }

    /**
     * 构建搜索 范例
     *
     * @return void
     */
    protected function buildSearch()
    {
        $search = $this->search;
    }

    /**
     * 保存数据 范例
     *
     * @param integer $id
     * @return mixed
     */
    protected function save($id = 0)
    {
        $data = request()->post();

        return $this->doSave($data, $id);
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @param integer $id
     * @return mixed
     */
    protected function doSave($data, $id = 0)
    {
        $res = 0;

        if ($id) {
            $res = $this->dataModel->allowField(true)->isUpdate(true, [$this->getPk() => $id])->save($data);
        } else {
            $res = $this->dataModel->allowField(true)->isUpdate(false)->save($data);
        }

        if (!$res) {
            $this->error('保存失败');
        }

        return $this->builder()->layer()->closeRefresh(1, '保存成功');
    }

    /**
     * Undocumented function
     *
     * @param string $title
     * @param string $desc
     * @param string $type index/add/edit/view
     * @return Builder
     */
    protected function builder($title = '', $desc = '', $type = '')
    {
        $builder = Builder::getInstance($title, $desc);

        $this->creating($builder, $type);

        return $builder;
    }

    /**
     * Undocumented function
     *
     * @param Builder $builder
     * @param string $type index/add/edit/view
     * @return void
     */
    protected function creating($builder, $type = '')
    {
        //其他用户自定义初始化
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function getPk()
    {
        if (empty($this->pk)) {
            if ($this->dataModel) {
                $this->pk = $this->dataModel->getPk();
                $this->pk = !empty($this->pk) && is_string($this->pk) ? $this->pk : 'id';
            } else {
                $this->pk = 'id';
            }
        }

        return $this->pk;
    }

    protected function checkToken()
    {
        $token = Session::get('_csrf_token_');

        if (empty($token) || $token != input('__token__')) {
            $this->error('token错误');
        }
    }
}
