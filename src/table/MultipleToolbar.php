<?php

namespace tpext\builder\table;

use tpext\builder\common\Toolbar;

class MultipleToolbar extends Toolbar
{
    protected $useLayer = true;

    protected $hasSearch = false;

    protected $btnSearch = null;

    /**
     * Undocumented function
     *
     * @param boolean $val
     * @return $this
     */
    public function useLayer($val)
    {
        $this->useLayer = $val;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param boolean $val
     * @return $this
     */
    public function hasSearch($val)
    {
        $this->hasSearch = $val;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function beforRender()
    {
        if (empty($this->elms)) {
            $this->buttons();
        }

        if ($this->hasSearch && !$this->btnSearch) {
            $this->btnToggleSearch();
        }

        foreach ($this->elms as $elm) {

            if (!$this->useLayer) {
                $elm->useLayer(false);
            }
        }

        return parent::beforRender();
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function buttons()
    {
        $this->btnAdd();
        $this->btnDelete();
        $this->btnRefresh();

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @return $this
     */
    public function btnAdd($url = '', $label = '添加', $class = 'btn-primary', $icon = 'mdi-plus', $attr = '')
    {
        if (empty($url)) {
            $url = url('add');
        }
        $this->linkBtn('add', $label)->href($url)->icon($icon)->addClass($class)->addAttr($attr);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $postUrl
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @param boolean|string $confirm
     * @return $this
     */
    public function btnDelete($postUrl = '', $label = '删除', $class = 'btn-danger', $icon = 'mdi-delete', $attr = '', $confirm = true)
    {
        if (empty($postUrl)) {
            $postUrl = url('delete');
        }
        $this->linkBtn('delete', $label)->postChecked($postUrl, $confirm)->addClass($class)->icon($icon)->addAttr($attr);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $postUrl
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @param boolean|string $confirm
     * @return $this
     */
    public function btnDisable($postUrl = '', $label = '禁用', $class = 'btn-warning', $icon = 'mdi-block-helper', $attr = '', $confirm = true)
    {
        if (empty($postUrl)) {
            $postUrl = url('enable', ['state' => 0]);
        }
        $this->linkBtn('disable', $label)->postChecked($postUrl, $confirm)->addClass($class)->icon($icon)->addAttr($attr);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $postUrl
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @param boolean|string $confirm
     * @return $this
     */
    public function btnEnable($postUrl = '', $label = '启用', $class = 'btn-success', $icon = 'mdi-check', $attr = '', $confirm = true)
    {
        if (empty($postUrl)) {
            $postUrl = url('enable', ['state' => 1]);
        }
        $this->linkBtn('enable', $label)->postChecked($postUrl, $confirm)->addClass($class)->icon($icon)->addAttr($attr);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $enableTitle
     * @param string $disableTitle
     * @return $this
     */
    public function btnEnableAndDisable($enableTitle = '启用', $disableTitle = '禁用')
    {
        $this->btnEnable()->getCurrent()->addAttr('title="' . $enableTitle . '"')->label($enableTitle);
        $this->btnDisable()->getCurrent()->addAttr('title="' . $disableTitle . '"')->label($disableTitle);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @return $this
     */
    public function btnRefresh($label = '', $class = 'btn-cyan', $icon = 'mdi-refresh', $attr = 'title="刷新"')
    {
        $this->linkBtn('refresh', $label)->addClass($class)->icon($icon)->addAttr($attr);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @return $this
     */
    public function btnToggleSearch($label = '', $class = 'btn-secondary', $icon = 'mdi-magnify', $attr = 'title="搜索"')
    {
        $this->linkBtn('search', $label)->addClass($class)->icon($icon)->addClass('hidden')->addAttr($attr);

        $this->btnSearch = true;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $afterSuccessUrl
     * @param string|array acceptedExts
     * @param array layerSize
     * @param int fileSize MB
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @return $this
     */
    public function btnImport($afterSuccessUrl = '', $acceptedExts = "rar,zip,doc,docx,xls,xlsx,ppt,pptx,pdf", $layerSize = ['800px', '550px'], $fileSize = '20', $label = '导入', $class = 'btn-pink', $icon = 'mdi-cloud-upload', $attr = 'title="上传文件"')
    {
        if (empty($afterSuccessUrl)) {
            $afterSuccessUrl = url('/tpextbuilder/admin/import/afterSuccess');
        }

        if (is_array($acceptedExts)) {
            $acceptedExts = implode(',', $acceptedExts);
        }

        $afterSuccessUrl = urlencode($afterSuccessUrl);

        $afterSuccessUrl = preg_replace('/(.+?)(\.html)?$/', '$1', $afterSuccessUrl);

        $importpagetoken = session('importpagetoken') ? session('importpagetoken') : md5('importpagetoken' . time() . uniqid());

        session('importpagetoken', $importpagetoken);

        $pagetoken = md5($importpagetoken . $acceptedExts . $fileSize);

        $url = url('/tpextbuilder/admin/import/page') . '?successUrl=' . $afterSuccessUrl . '&acceptedExts=' . $acceptedExts . '&fileSize=' . $fileSize . '&pageToken=' . $pagetoken;

        $this->linkBtn('import', $label)->useLayer(true, $layerSize)->href($url)->icon($icon)->addClass($class)->addAttr($attr);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $postUrl
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @return $this
     */
    public function btnExport($postUrl = '', $label = '导出', $class = 'btn-pink', $icon = 'mdi-export', $attr = 'title="导出"')
    {
        if (empty($postUrl)) {
            $postUrl = url('export');
        }

        $this->linkBtn('export', $label)->addClass($class)->icon($icon)->addAttr($attr . ' data-export-url="' . $postUrl . '"');
        return $this;
    }

    public function btnExports($items, $postUrl = '', $label = '导出', $class = 'btn-secondary', $icon = 'mdi-export', $attr = 'title="导出"')
    {
        if (empty($postUrl)) {
            $postUrl = url('export');
        }

        $this->dropdownBtns('exports', $label)->items($items)->addClass($class)->icon($icon)
            ->addAttr($attr . ' data-export-url="' . $postUrl . '"')->addGroupClass('pull-right m-r-10');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @return $this
     */
    public function btnLink($url, $label = '', $class = 'btn-secondary', $icon = 'mdi-checkbox-marked-outline', $attr = '')
    {
        $action = preg_replace('/.+?\/(\w+)(\.\w+)?$/', '$1', $url, -1, $count);

        if (!$count) {
            $action = mt_rand(10, 99);
        }

        $this->linkBtn($action, $label)->href($url)->icon($icon)->addClass($class)->addAttr($attr);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $label
     * @param string $class
     * @param string $icon
     * @param string $attr
     * @param boolean|string $confirm
     * @return $this
     *
     */
    public function btnPostChecked($url, $label = '', $class = 'btn-secondary', $icon = 'mdi-checkbox-marked-outline', $attr = '', $confirm = true)
    {
        $action = preg_replace('/.+?\/(\w+)(\.\w+)?$/', '$1', $url, -1, $count);

        if (!$count) {
            $action = mt_rand(10, 99);
        }

        $this->linkBtn($action, $label)->postChecked($url, $confirm)->addClass($class)->icon($icon)->addAttr($attr);

        return $this;
    }
}
