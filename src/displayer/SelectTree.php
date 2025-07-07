<?php

namespace tpext\builder\displayer;

class SelectTree extends Tree
{
    protected $view = 'selecttree';

    protected $js = [
        '/assets/tpextbuilder/js/select2/select2.min.js',
        '/assets/tpextbuilder/js/zTree_v3/js/jquery.ztree.all.min.js',
        '/assets/tpextbuilder/js/zTree_v3/js/jquery.ztree.exhide.min.js',
        '/assets/tpextbuilder/js/s2ztree/jquery.ztree.fuzzysearch.js',
        '/assets/tpextbuilder/js/s2ztree/select2-ztree.js',
    ];

    protected $css = [
        '/assets/tpextbuilder/js/select2/select2.min.css',
        '/assets/tpextbuilder/js/zTree_v3/css/lyearStyle/lyearStyle.css'
    ];

    protected $attr = 'size="1"';

    protected $noCascaded = true;

    protected $jsOptions =  [
        'data' => [
            'simpleData' => [
                'enable' => true
            ]
        ],
    ];

    /**
     * 多选时，是否父子节点不级联
     * @param mixed $val
     * @param bool $val
     * @return $this
     */
    public function noCascaded($val = true)
    {
        $this->noCascaded = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    protected function ztreeScript()
    {
        if (!($this->value === '' || $this->value === null || $this->value === [])) {
            $this->checked = is_array($this->value) ? $this->value : explode(',', $this->value);
        } else if (!($this->default === '' || $this->default === null || $this->default === [])) {
            $this->checked = is_array($this->default) ? $this->default : explode(',', $this->default);
        }

        if ($this->disabledOptions && !is_array($this->disabledOptions)) {
            $this->disabledOptions = explode(',', $this->disabledOptions);
        }

        foreach ($this->options as &$d) {
            $d['chkDisabled'] = in_array($d['id'], $this->disabledOptions) || $this->isReadonly() || $this->isDisabled();
            $d['checked'] = in_array($d['id'], $this->checked);
            $d['open'] = $this->expandAll;
        }

        $script = '';
        $selectId = $this->getId();

        if (empty($this->jsOptions['placeholder'])) {
            $this->jsOptions['placeholder'] = '请选择' . $this->getlabel();
        }

        $key = preg_replace('/\W/', '', $selectId);

        $configs = json_encode($this->jsOptions);
        $zNodes = json_encode($this->options);
        $checked = json_encode($this->checked);

        $multiple = $this->multiple ? 1 : 0;
        $noCascaded = $this->noCascaded ? 1 : 0;

        $script = <<<EOT

        var setting{$key} = {$configs};

        var selectTree{$key} = $('#{$selectId}').select2ztree({
			textField : 'name',
			titleField : 'name',
			ztree : {
				setting : $.extend(true, {
					treeId : '{$selectId}',
                    check: {
                        chkStyle: '{$multiple}' == '1' ? 'checkbox' : 'radio',
                        radioType: 'all',
                        chkboxType: '{$noCascaded}' == '1' ? {"Y":"", "N":""} : {"Y":"s", "N":"s"},
                    },
				}, setting{$key}),
				zNodes : {$zNodes}
			}
		});

        selectTree{$key}.select2ztree('val', {$checked});

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function beforRender()
    {
        $this->ztreeScript();

        return parent::beforRender();
    }

    public function render()
    {
        $vars = $this->commonVars();

        $vars = array_merge($vars, [
            'multiple' => $this->multiple,
        ]);

        $viewshow = $this->getViewInstance();

        return $viewshow->assign($vars)->getContent();
    }
}
