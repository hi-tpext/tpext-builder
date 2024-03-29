<?php

namespace tpext\builder\displayer;

class Icon extends Text
{
    protected $view = 'icon';

    protected $js = [
        '/assets/tpextbuilder/js/fontIconPicker/jquery.fonticonpicker.min.js',
    ];

    protected $css = [
        '/assets/tpextbuilder/js/fontIconPicker/css/jquery.fonticonpicker.min.css',
        '/assets/tpextbuilder/js/fontIconPicker/themes/bootstrap-theme/jquery.fonticonpicker.bootstrap.min.css',
    ];

    protected $jsOptions = [
        'theme' => 'fip-bootstrap',
        'url' => '/assets/tpextbuilder/js/fontIconPicker/fontjson/materialdesignicons.json',
    ];

    protected function iconScript()
    {
        $inputId = $this->getId();

        $url = $this->jsOptions['url'];

        $str = preg_replace('/\W/', '', $this->name);

        $configs = json_encode($this->jsOptions);

        $configs = substr($configs, 1, strlen($configs) - 2);

        $script = <<<EOT

        var icon{$str} = $('#{$inputId}').fontIconPicker({
            {$configs}
        });

        $.ajax({
            url: '{$url}',
            type: 'GET',
            dataType: 'json'
        }).done(function(response) {
            var fontello_json_icons = [];
            $.each(response.glyphs, function(i, v) {
                fontello_json_icons.push( v.css );
            });

            icon{$str}.setIcons(fontello_json_icons);
        }).fail(function() {
            console.error('Icon font config loadig failed');
        });

        $('#{$inputId}').on('change',function(){
            $('#{$inputId}-selected').text($(this).val());
        });

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function beforRender()
    {
        $this->iconScript();

        return parent::beforRender();
    }
}
