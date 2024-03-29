<?php

namespace tpext\builder\displayer;

class Tags extends Field
{
    protected $view = 'tags';

    protected $js = [
        '/assets/tpextbuilder/js/jquery-tags-input/jquery.tagsinput.min.js',
    ];

    protected $css = [
        '/assets/tpextbuilder/js/jquery-tags-input/jquery.tagsinput.min.css',
    ];

    protected $placeholder = '';

    protected $jsOptions = [
        'height' => '33px',
        'width' => '100%',
        'defaultText' => '',
        'removeWithBackspace' => true,
        'delimiter' => [','],
    ];

    /**
     * Undocumented function
     *
     * @param string $val
     * @return $this
     */
    public function placeholder($val)
    {
        $this->placeholder = $val;
        return $this;
    }

    protected function tagsScript()
    {
        $inputId = $this->getId();

        $this->jsOptions['defaultText'] = empty($this->placeholder) ? $this->label : $this->placeholder;

        $configs = json_encode($this->jsOptions);

        $configs = substr($configs, 1, strlen($configs) - 2);

        $script = <<<EOT
        $('#{$inputId}').tagsInput({
			{$configs}
		});

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function beforRender()
    {
        if(!$this->readonly)
        {
            $this->tagsScript();
        }

        return parent::beforRender();
    }

    public function customVars()
    {
        return [
            'placeholder' => $this->placeholder ?: __blang('bilder_please_enter') . $this->label
        ];
    }
}
