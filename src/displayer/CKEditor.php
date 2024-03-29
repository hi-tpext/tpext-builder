<?php

namespace tpext\builder\displayer;

use tpext\builder\traits\HasStorageDriver;
use tpext\builder\traits\HasImageDriver;

class CKEditor extends Field
{
    use HasStorageDriver;
    use HasImageDriver;

    protected $view = 'ckeditor';

    protected $minify = false;

    protected $js = [
        '/assets/builderckeditor/ckeditor.js',
    ];

    protected $jsOptions = [
        'language' => 'zh-cn',
        'uiColor' => '#eeeeee',
        'height' => 600,
        'image_previewText' => ' ',
    ];

    protected function editorScript()
    {
        if (!class_exists('\\tpext\\builder\\ckeditor\\common\\Resource')) {
            $this->js = [];
            $this->script[] = 'layer.alert("未安装ckeditor资源包！<pre>composer require ichynul/builder-ckeditor</pre>");';
            return;
        }
        // 配置可放在config.js中
        // 成功返回格式{"uploaded":1,"fileName":"图片名称","url":"图片访问路径"}
        // 失败返回格式{"uploaded":0,"error":{"message":"失败原因"}}

        if (!isset($this->jsOptions['filebrowserImageUploadUrl']) || empty($this->jsOptions['filebrowserImageUploadUrl'])) {

            $token = $this->getCsrfToken();

            $this->jsOptions['filebrowserImageUploadUrl'] = (string)url($this->getUploadUrl(), [
                'utype' => 'ckeditor',
                'token' => $token,
                'driver' => $this->getStorageDriver(),
                'is_rand_name' => $this->isRandName(),
                'image_driver' => $this->getImageDriver(),
                'image_commonds' => $this->getImageCommands()
            ]);
        }

        $configs = json_encode($this->jsOptions);

        // 配置可放在config.js中

        $script = <<<EOT

        CKEDITOR.replace('{$this->name}', {$configs});

EOT;
        $this->script[] = $script;

        return $script;
    }

    public function beforRender()
    {
        if (!$this->readonly) {
            $this->editorScript();
        }

        return parent::beforRender();
    }
}
