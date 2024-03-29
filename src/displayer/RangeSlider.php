<?php

namespace tpext\builder\displayer;

class RangeSlider extends Text
{
    protected $js = [
        '/assets/tpextbuilder/js/ion-rangeslider/ion.rangeSlider.min.js',
    ];

    protected $css = [
        '/assets/tpextbuilder/js/ion-rangeslider/ion.rangeSlider.min.css',
    ];

    protected $jsOptions = [
        'type' => 'single',
        'min' => 0,
        'max' => 100,
    ];

    protected $checked = [];

    protected function rangeScript()
    {
        $inputId = $this->getId();

        if (!empty($this->value)) {
            $this->checked = is_array($this->value) ? $this->value : explode(';', str_replace(',', ';', $this->value));
        } else if (!empty($this->default)) {
            $this->checked = is_array($this->default) ? $this->default : explode(';', str_replace(',', ';', $this->default));
        }

        if (count($this->checked) > 0) {
            $this->jsOptions['from'] = $this->checked[0];

            if (count($this->checked) > 1) {
                $this->jsOptions['to'] = $this->checked[1];
                $this->jsOptions['type'] = 'double';
            }
        }

        if ($this->disabled) {
            $this->jsOptions['disable'] = true;
        }

        $configs = json_encode($this->jsOptions);

        $script = <<<EOT

        $('#{$inputId}').ionRangeSlider({$configs});

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function beforRender()
    {
        $this->rangeScript();

        return parent::beforRender();
    }
}
