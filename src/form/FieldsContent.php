<?php

namespace tpext\builder\form;

use think\Model;
use tpext\builder\common\Form;
use tpext\builder\common\Search;
use tpext\builder\search\SRow;
use tpext\builder\common\Module;
use tpext\builder\displayer\Field;
use tpext\builder\inface\Renderable;
use tpext\think\View;

class FieldsContent extends FWrapper implements Renderable
{
    protected $view = 'fieldscontent';

    protected $rows = [];

    protected $data = [];

    protected $readonly = false;

    protected $hasWrapper = true;

    /**
     * Undocumented variable
     *
     * @var Form|Search
     */
    protected $form;

    /**
     * Undocumented function
     * 
     * @param mixed $val
     * @return $this
     */
    public function hasWrapper($val = true)
    {
        $this->hasWrapper = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function beforRender()
    {
        foreach ($this->rows as $row) {
            $row->fill($this->data);
            if (!($row instanceof FRow)) {
                $row->beforRender();
                continue;
            }

            $displayer = $row->getDisplayer();

            if ($displayer->isRequired()) {
                $this->form->addJqValidatorRule($displayer->getName(), 'required', true);
            }

            $row->beforRender();
        }
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param FRow|SRow|Field|Fillable $row
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
     * @param Form|Search $val
     * @return $this
     */
    public function setForm($val)
    {
        $this->form = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return Form|Search
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Undocumented function
     *
     * @param mixed ...$fields
     * @return $this
     */
    public function with(...$fields)
    {
        if (count($fields) && $fields[0] instanceof \Closure) {
            $fields[0]($this->form);
        }

        $this->form->fieldsEnd();
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array|Model|\ArrayAccess $data
     * @return $this
     */
    public function fill($data = [])
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param boolean $val
     * @return $this
     */
    public function readonly($val = true)
    {
        foreach ($this->rows as $row) {
            $row->getDisplayer()->readonly($val);
        }
        $this->readonly = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $val
     * @return $this
     */
    public function extKey($val)
    {
        foreach ($this->rows as $row) {
            if (!($row instanceof FRow)) {
                continue;
            }

            $row->getDisplayer()->extKey($val);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return $this
     */
    public function clearScript()
    {
        foreach ($this->rows as $row) {
            if (!($row instanceof FRow)) {
                continue;
            }

            $row->getDisplayer()->clearScript();
        }
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array|Model
     */
    public function getData()
    {
        return $this->data;
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

    public function render()
    {
        $template = Module::getInstance()->getViewsPath() . 'form' . DIRECTORY_SEPARATOR . $this->view . '.html';

        $viewshow = new View($template);

        $vars = [
            'rows' => $this->rows,
            'hasWrapper' => $this->hasWrapper,
        ];

        $customVars = $this->customVars();

        if (!empty($customVars)) {
            $vars = array_merge($vars, $customVars);
        }

        return $viewshow->assign($vars)->getContent();
    }

    public function __call($name, $arguments)
    {
        $count = count($arguments);

        if ($count > 0 && static::isDisplayer($name)) {

            $row = FRow::make($arguments[0], $count > 1 ? $arguments[1] : '', $count > 2 ? $arguments[2] : ($name == 'button' ? 1 : 12));

            $this->rows[] = $row;

            return $row->$name($arguments[0], $row->getLabel());
        }

        throw new \InvalidArgumentException(__blang('bilder_invalid_argument_exception') . ' : ' . $name);
    }

    public function destroy()
    {
        $this->rows = null;
    }
}
