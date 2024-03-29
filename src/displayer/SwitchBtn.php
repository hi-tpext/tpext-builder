<?php

namespace tpext\builder\displayer;

class SwitchBtn extends Field
{
    protected $view = 'switchbtn';

    protected $checked = '';

    protected $pair = ['on' => 1, 'off' => 0];

    protected $required = false;

    /**
     * Undocumented function
     * @example 1 (1, 0) / ('yes', 'no') / ('on', 'off') etc...
     * @param array $val
     * @return $this
     */
    public function pair($on = 1, $off = 0)
    {
        $this->pair = ['on' => $on, 'off' => $off];;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getPair()
    {
        return $this->pair;
    }

    /**
     * SwitchBtn 不需要设置 required
     *
     * @param boolean $val
     * @return $this
     */
    public function required($val = true)
    {
        $this->required = false;
        return $this;
    }

    protected function boxScript()
    {
        $inputId = $this->getId();

        $script = <<<EOT

        $('#{$inputId}').next('label').find('input').on('change', function(){
            $('#{$inputId}').val($(this).is(':checked') ? "{$this->pair['on']}" : "{$this->pair['off']}");
        });

        $('#{$inputId}').val($('#{$inputId}').next('label').find('input').is(':checked') ? "{$this->pair['on']}" : "{$this->pair['off']}");

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function render()
    {
        $vars = $this->commonVars();

        if (!($this->value === '' || $this->value === null)) {
            $this->checked = $this->value;
        } else {
            $this->checked = $this->default;
        }

        $vars = array_merge($vars, [
            'checked' => $this->checked,
            'pair' => $this->pair,
        ]);

        $viewshow = $this->getViewInstance();

        return $viewshow->assign($vars)->getContent();
    }

    public function beforRender()
    {
        $this->boxScript();

        return parent::beforRender();
    }
}
