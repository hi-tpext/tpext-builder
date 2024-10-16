<?php

namespace tpext\builder\common;

use tpext\think\View;
use tpext\builder\form\When;
use tpext\builder\form\FRow;
use tpext\builder\search\SRow;
use tpext\builder\common\Module;
use tpext\builder\form\Fillable;
use tpext\builder\traits\HasDom;
use tpext\builder\common\Builder;
use tpext\builder\displayer\Text;
use tpext\builder\search\TabLink;
use tpext\builder\displayer\Field;
use tpext\builder\search\SWrapper;
use tpext\builder\displayer\Button;
use tpext\builder\inface\Renderable;
use tpext\builder\form\FieldsContent;

/**
 * Search class
 */
class Search extends SWrapper implements Renderable
{
    use HasDom;

    protected $action = '';

    protected $id = 'search';

    protected $method = 'get';

    /**
     * Undocumented variable
     *
     * @var FRow[] 
     */
    protected $rows = [];

    protected $searchButtonsCalled = false;

    protected $ajax = true;

    protected $defaultDisplayerSize = [4, 8];

    protected $defaultDisplayerColSize = 2;

    protected $butonsSizeClass = 'btn-xs';

    protected $open = true;

    protected $tableId = '';

    protected $chooseColumns = ['*'];

    /**
     * Undocumented variable
     *
     * @var Row
     */
    protected $addTop;

    /**
     * Undocumented variable
     *
     * @var Row
     */
    protected $addBottom;

    /**
     * Undocumented variable
     *
     * @var TabLink
     */
    protected $tablink = null;

    /**
     * Undocumented variable
     *
     * @var FieldsContent
     */
    protected $__fields__ = null;

    /**
     * Undocumented variable
     *
     * @var When
     */
    protected $__when__ = null;

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function created()
    {
        $this->class = 'form-horizontal';

        $this->open = Module::config('search_open') == 1;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param SRow|Fillable $row
     * @return $this
     */
    public function addRow($row)
    {
        $this->rows[] = $row;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Undocumented function
     *
     * @return FieldsContent
     */
    public function createFields()
    {
        $this->__fields__ = new FieldsContent();
        $this->__fields__->setForm($this);
        return $this->__fields__;
    }

    /**
     * Undocumented function
     * @param Field $watchFor
     * @param string|int|array $cases
     * @return When
     */
    public function createWhen($watchFor, $cases)
    {
        $this->__when__ = new When();
        $this->__when__->watch($watchFor, $cases);
        $this->__when__->setForm($this);
        return $this->__when__;
    }


    /**
     * Undocumented function
     *
     * @return $this
     */
    public function fieldsEnd()
    {
        $this->__fields__ = null;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function whenEnd()
    {
        $this->__when__ = null;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $tableId
     * @return $this
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;
        $this->id = 'search-' . $this->tableId;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $val
     * @return $this
     */
    public function method($val)
    {
        $this->method = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param boolean $val
     * @return $this
     */
    public function open($val = true)
    {
        $this->open = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getFormId()
    {
        return $this->id;
    }

    /**
     * Undocumented function
     *
     * @param string $key trigger feild
     * @return TabLink
     */
    public function tabLink($key)
    {
        if (empty($this->tablink)) {
            $this->tablink = new TabLink();
            $this->tablink->key($key);
        }

        return $this->tablink;
    }

    /**
     * Undocumented function
     *
     * @return Row
     */
    public function addTop()
    {
        if (empty($this->addTop)) {
            $this->addTop = Row::make();
            $this->addTop->class('search-top');
        }

        return $this->addTop;
    }

    /**
     * Undocumented function
     *
     * @return Row
     */
    public function addBottom()
    {
        if (empty($this->addBottom)) {
            $this->addBottom = Row::make();
            $this->addBottom->class('search-bottom');
        }

        return $this->addBottom;
    }

    /**
     * Undocumented function
     * btn-lg btn-sm btn-xs
     * @param string $val
     * @return $this
     */
    public function butonsSizeClass($val)
    {
        $this->butonsSizeClass = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $label
     * @param integer $element
     * @return $this
     */
    public function defaultDisplayerSize($label = 4, $element = 8)
    {
        $this->defaultDisplayerSize = [$label, $element];
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $size
     * @return $this
     */
    public function defaultDisplayerColSize($size = 2)
    {
        $this->defaultDisplayerColSize = $size;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $val 默认显示的字段
     * @return $this
     */
    public function chooseColumns($val)
    {
        $this->chooseColumns = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function searchButtons($create = true)
    {
        if ($create) {
            $this->fieldsEnd();
            $this->fields('search_buttons', ' ', '3 col-lg-3 col-sm-12 col-xs-12 search-buttons')
                ->size('3 col-lg-4 col-sm-2 col-xs-12', '9 col-lg-8 col-sm-8 col-xs-12')
                ->with(
                    $this->button('submit', __blang('bilder_button_filter'), '6 col-lg-6 col-sm-6 col-xs-6')->class('btn-info ' . $this->butonsSizeClass),
                    $this->button('button', __blang('bilder_button_reset'), '6 col-lg-6 col-sm-6 col-xs-6')->class('btn-default ' . $this->butonsSizeClass)->attr('onclick="location.replace(location.href)"')
                );
        }

        $this->searchButtonsCalled = true;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $label
     * @param integer|string $size
     * @param string $class
     * @return $this
     */
    public function btnSubmit($label = '筛&nbsp;&nbsp;选', $size = '2 col-lg-2 col-sm-6 col-xs-12', $class = 'btn-info')
    {
        if ($label == '筛&nbsp;&nbsp;选') {
            $label = __blang('bilder_button_filter');
        }
        $this->fieldsEnd();
        $this->button('submit', $label, $size)->class($class . ' ' . $this->butonsSizeClass);
        $this->searchButtonsCalled = true;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $label
     * @param integer|string $size
     * @param string $class
     * @return $this
     */
    public function btnReset($label = '重&nbsp;&nbsp;置', $size = '2 col-lg-2 col-sm-6 col-xs-12', $class = 'btn-warning')
    {
        if ($label == '重&nbsp;&nbsp;置') {
            $label = __blang('bilder_button_reset');
        }
        $this->button('reset', $label, $size)->class($class . ' ' . $this->butonsSizeClass)->addAttr('onclick="location.replace(location.href)"');
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function beforRender()
    {
        if (!$this->open) {
            $this->addClass('hidden');
        }

        $empty = empty($this->rows);

        if (!$empty) {
            if (!$this->searchButtonsCalled) {
                $this->searchButtons();
            }
        } else {
            $this->addClass('form-empty');
            $this->button('submit', 'submit', '1')->getWrapper()->addClass('hidden');
        }

        $this->hidden('__page__')->value(1);
        $this->hidden('__pagesize__');
        $this->hidden('__search__')->value($this->getFormId());
        $this->hidden('__table__')->value($this->tableId);
        $this->hidden('__sort__');
        $this->hidden('__columns__')->value(implode(',', $this->chooseColumns));

        $this->addClass('search-form');
        $this->button('refresh', 'refresh', '1')->addClass('search-refresh')->getWrapper()->addClass('hidden');
        $this->searchScript();

        foreach ($this->rows as $row) {
            $row->beforRender();
        }

        if ($this->tablink) {
            $this->tablink->searchId($this->getFormId());
            $this->tablink->beforRender();
        }

        if (!in_array(strtolower($this->method), ['get', 'post'])) {
            $this->hidden('_method')->value($this->method);
            $this->method = 'post';
        }

        if ($this->addTop) {
            $this->addTop->beforRender();
        }

        if ($this->addBottom) {
            $this->addBottom->beforRender();
        }

        return $this;
    }

    protected function searchScript()
    {
        $form = $this->getFormId();

        $extKey = '-' . $this->tableId;

        $script = <<<EOT

        $(document).bind('keyup', function(event) {
            if (event.keyCode === 13) {
                if($('#{$form} form').hasClass('form-empty'))
                {
                    return false;
                }
                if($('form').size() > 1)
                {
                    return false;
                }
                window.__forms__['{$form}'].formSubmit();
                return false;
            }
            if (event.keyCode === 0x1B) {
                if($('#{$form} form').hasClass('form-empty'))
                {
                    return true;
                }
                var index = layer.msg(__blang.bilder_reset_filter_criteria, {
                    time: 2000,
                    btn: [__blang.bilder_button_ok, __blang.bilder_button_cancel],
                    yes: function (params) {
                        layer.close(index);
                        location.replace(location.href);
                    }
                });
                return false; //阻止系统默认esc事件
            }
        });

        $('body').on('click', '#{$this->tableId} ul.pagination li a:not(.goto-page)', function(){
            var page = $(this).attr('href').replace(/.*\?page=(\d+).*/,'$1');
            $('#{$form} form input[name="__page__"]').val(page);
            window.__forms__['{$form}'].formSubmit();
            return false;
        });

        $('body').on('click', '#{$this->tableId} ul.pagination .goto-page', function(){
            var last = $(this).data('last');
            layer.prompt({
                formType: 0,
                value: '',
                btn: [__blang.bilder_button_ok, __blang.bilder_button_cancel],
                title: __blang.bilder_please_enter_the_page_number + '(1~' + last + ')'
            }, function(value, index, elem){
                var page = parseInt(value);
                if(!page || page <1)
                {
                    layer.msg(__blang.bilder_page_number_input_error, {
                        time: 1500
                    });
                    return false;
                }
                else if(page > last)
                {
                    layer.msg(__blang.bilder_page_number_cannot_exceed + ' :' + last, {
                        time: 1500
                    });
                    return false;
                }
                $('#{$form} form input[name="__page__"]').val(page);
                window.__forms__['{$form}'].formSubmit();
            });
        });

        $('body').on('click', '#{$this->tableId} #dropdown-pagesize-div .dropdown-menu li a', function(){
            var pagesize = $(this).data('key');
            var oldsize = $('#{$form} form input[name="__pagesize__"]').val();
            if(pagesize == oldsize)
            {
                return;
            }
            if(pagesize > oldsize)
            {
                $('#{$form} form input[name="__page__"]').val(1);
            }
            $('#{$form} form input[name="__pagesize__"]').val(pagesize);
            $('#{$this->tableId} #dropdown-pagesize-div').find('.pagesize-text').text(pagesize);
            window.__forms__['{$form}'].formSubmit();
        });

        $('body').on('click', '#btn-refresh{$extKey},#form-refresh{$extKey}', function(){
            window.__forms__['{$form}'].formSubmit();
        });

        if(!$('#{$form} form').hasClass('form-empty'))
        {
            $('#btn-search{$extKey}').removeClass('hidden');
        }
        else
        {
            $('#{$form}').addClass('hidden');
        }

        $('body').on('click', '#btn-search{$extKey}', function(){
            if($('#{$form} form').hasClass('hidden'))
            {
                $('#{$form} form').removeClass('hidden');
            }
            else
            {
                $('#{$form} form').slideToggle(300);
            }
        });

        $('body').on('click', '#btn-export{$extKey}', function(){
            var url = $(this).data('export-url');
            window.__forms__['{$form}'].exportPost(url, '', 1);
        });

        $('body').on('click', '#dropdown-exports{$extKey}-div .dropdown-menu li a', function(){
            var url = $('#dropdown-exports{$extKey}').data('export-url');
            var fileType = $(this).data('key');
            window.__forms__['{$form}'].exportPost(url, fileType, 1);
        });

        $('body').on('click', '#dropdown-choose_columns{$extKey}-div .dropdown-menu', function(event){
            event.stopPropagation();
        });
        var columnsTimer = null;
        $('body').on('click', '#dropdown-choose_columns{$extKey}-div .dropdown-menu li a', function(event){
            var columns = [];
            if($(this).hasClass('checked')) {
                $(this).removeClass('checked');
                $(this).find('i').removeClass('mdi-checkbox-marked-outline').addClass('mdi-checkbox-blank-outline');
            } else {
                $(this).addClass('checked');
                $(this).find('i').removeClass('mdi-checkbox-blank-outline').addClass('mdi-checkbox-marked-outline');
            }
            $('#dropdown-choose_columns{$extKey}-div .dropdown-menu li a.checked').each(function(i, e){
                columns.push($(e).data('key'));
            });
            if(!columns.length) {
                lightyear.notify(__blang.bilder_show_at_least_one_field, 'warning');
                event.stopPropagation();
                return false;
            }
            if (columnsTimer) {
                clearTimeout(columnsTimer);
            }
            columnsTimer = setTimeout(function(){
                $('#$form form input[name="__columns__"]').val(columns.join(','));
                window.__forms__['{$form}'].formSubmit();
                columnsTimer = null;
            }, 1000);
            event.stopPropagation();
            return false;
        });

        $('body').on('click', '#form-submit{$extKey}', function(){
            $('#$form form input[name="__page__"]').val(1);
            return window.__forms__['{$form}'].formSubmit();
        });

        $('body').on('click', '.table .sortable', function(){
            var sort = '';
            if($(this).hasClass('mdi-sort-descending'))
            {
                sort = $(this).data('key') + ' asc';
                $(this).removeClass('mdi-sort-descending').addClass('mdi-sort-ascending');
            }
            else
            {
                sort = $(this).data('key') + ' desc';
                $('.sortable.mdi-sort-ascending').removeClass('mdi-sort-ascending').addClass('mdi-sort');
                $('.sortable.mdi-sort-descending').removeClass('mdi-sort-descending').addClass('mdi-sort');
                $(this).removeClass('mdi-sort').addClass('mdi-sort-descending');
            }

            $('#$form form input[name="__sort__"]').val(sort);
            window.__forms__['{$form}'].formSubmit();
        });

EOT;
        Builder::getInstance()->addScript($script);

        return $script;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function customVars()
    {
        return [];
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getViewTemplate()
    {
        $template = Module::getInstance()->getViewsPath() . 'table' . DIRECTORY_SEPARATOR . 'search.html';

        return $template;
    }

    /**
     * Undocumented function
     *
     * @return string|View
     */
    public function render()
    {
        $viewshow = new View($this->getViewTemplate());

        $vars = [
            'rows' => $this->rows,
            'action' => $this->action,
            'method' => strtoupper($this->method),
            'class' => $this->class,
            'attr' => $this->getAttrWithStyle(),
            'id' => $this->getFormId(),
            'ajax' => $this->ajax,
            'searchFor' => $this->tableId,
            'tablink' => $this->tablink,
            'addTop' => $this->addTop,
            'addBottom' => $this->addBottom,
        ];

        $customVars = $this->customVars();

        if (!empty($customVars)) {
            $vars = array_merge($vars, $customVars);
        }

        return $viewshow->assign($vars)->getContent();
    }

    public function __toString()
    {
        return $this->render();
    }

    public function __call($name, $arguments)
    {
        $count = count($arguments);

        if ($count > 0 && static::isDisplayer($name)) {

            $row = SRow::make($arguments[0], $count > 1 ? $arguments[1] : '', $count > 2 ? $arguments[2] : $this->defaultDisplayerColSize, $count > 3 ? $arguments[3] : '');

            if ($this->__fields__) {
                $this->__fields__->addRow($row);
            } else {
                $this->rows[] = $row;
            }

            $row->setForm($this);

            $displayer = $row->$name($arguments[0], $count > 1 ? $arguments[1] : '');

            $row->setLabel($displayer->getLabel());

            if ($this->__when__) {
                $this->__when__->toggle($displayer);
            }

            if ($this->defaultDisplayerSize) {
                $displayer->size($this->defaultDisplayerSize[0], $this->defaultDisplayerSize[1]);
            }

            $displayer->extKey('-' . $this->tableId);

            if ($displayer instanceof Text) {
                $displayer->befor('');
                $displayer->after('');
            } else if ($displayer instanceof Button) {
                $displayer->size(0, 12);
            }

            return $displayer;
        }

        throw new \InvalidArgumentException(__blang('bilder_invalid_argument_exception') . ' : ' . $name);
    }

    /**
     * 创建自身
     *
     * @param mixed $arguments
     * @return static
     */
    public static function make(...$arguments)
    {
        return Widget::makeWidget('Search', $arguments);
    }

    public function destroy()
    {
        $this->__fields__ = null;
        $this->__when__ = null;
        if ($this->addTop) {
            $this->addTop->destroy();
            $this->addTop = null;
        }
        if ($this->addBottom) {
            $this->addBottom->destroy();
            $this->addBottom = null;
        }
        $this->tablink = null;
        foreach ($this->rows as $row) {
            $row->destroy();
        }
        $this->rows = null;
    }
}
