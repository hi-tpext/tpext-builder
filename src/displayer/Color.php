<?php

namespace tpext\builder\displayer;

class Color extends Text
{
    protected $view = 'color';

    protected $js = [
        '/assets/tpextbuilder/js/bootstrap-colorpicker/bootstrap-colorpicker.min.js',
    ];

    protected $css = [
        '/assets/tpextbuilder/js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
    ];

    protected $befor = '<span class="input-group-addon"><i style="background-color: blue;"></i></span>';

    protected $jsOptions = [
        'format' => 'hex',
        'inline' => false,
    ];

    /**
     * Undocumented function
     * rgb|rgba|hsl|hsla|hex
     * @param string $val
     * @return $this
     */
    public function format($val)
    {
        $this->jsOptions['format'] = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function rgb()
    {
        $this->format('rgb');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function rgba()
    {
        $this->format('rgba');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function hsl()
    {
        $this->format('hsl');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function hsla()
    {
        $this->format('hsla');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function hex()
    {
        $this->format('hex');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param boolean $val
     * @return $this
     */
    public function inline($val = true)
    {
        $this->jsOptions['inline'] = $val;
        return $this;
    }

    protected function colorScript()
    {
        $inputId = $this->getId();
        
        $configs = json_encode($this->jsOptions);

        $configs = substr($configs, 1, strlen($configs) - 2);

        $script = <<<EOT

        $('#{$inputId}').parent('div.input-group').colorpicker({
            {$configs}
        });

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function beforRender()
    {
        $this->colorScript();

        return parent::beforRender();
    }
}
