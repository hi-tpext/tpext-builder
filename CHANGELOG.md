# CHANGELOG

---

## [未发布]

1.新增 `inface\ReleaseAble` 接口与 `traits\HasDestroyOnce` 幂等标记，统一组件销毁契约：容器与组件类实现 ReleaseAble，`destroy()` 入口检查 `__destroyed__` 防止同一组件经多条归属路径被重复销毁，`parent::destroy()` 覆写链在末尾置位。

2.销毁流程补漏：Form 补销毁 tab/step；Table 补销毁 toolbar/actionbar（原来只置空引用，Bar 全泄漏）；Tab/Step 补销毁 rows['content'] 并清理 labels/`__fields__`；Toolbar 补销毁 elms；Fields/Items/table FieldsContent 新增 `destroy()`；FRow/TColumn/SRow 对 displayer 判空保幂等；JSTree/ZTree 同步契约。

3.数组属性销毁后复位为空数组（保持类型恒定），对象引用置 null。

---

## [1.9.169 / 3.9.154]

1.添加图片轮播组件`swiper()`，支持多种图片展示方式。

2.优化 `hasWhen` 的渲染逻辑，支持多层嵌套。

3.优化 `hasWhen` [只读] 模式显示。

4.其他细节优化。

```php
//swiper示例

$list = CmsBanner::where('position_id', $id)->field('title,image')->select();// title,image两个字段
// $list = ['path1.jpg', 'path2.jpg'];或者图片路径数组
$builder = $this->builder('轮播');
$builder->swiper()->images($list);
return $builder;
```

---

## [1.9.121 / 3.9.105]

1.导出性能优化，真正支持`cursor()`查询返回的生成器。 

2.支持全局设置[只导出已选列]只导出用户前端页面选择的列，也可在控制器中`$this->exportOnlyChoosedColumns=true|false`单独控制

---

## [1.9.120 / 3.9.104]

### 列表页可排除某些字段

```php
class Cmscontent extends Controller
{
    protected function initialize()
    {
            //其他初始化
          $this->indexFieldsExcept = 'content';//排除某字段，优化查询速度
    }
}
```

---

## [1.9.119 / 3.9.103]

### 修复：when 里面的 switchBtn 问题

---

## [1.9.114 / 3.8.7]

### 取消上传文件分块的超时限制

---

## [1.9.110 / 3.8.3]

### HasOptions 的 optionsData 方法 textField 支持变量

### 列表页 checkbox 样式调整

---

## [1.9.107 / 3.8.1]

### form 的 tab 可以把按钮位置设置为左侧竖排（默认在顶部）。

```php
$from->getTab()->vertical();//设置竖排

$form->tab('基本信息');
//...其他字段
$form->tab('扩展信息');
//...其他字段
```

## 1.9.106/3.7.9

### 文件上传支持[占位图]，没有不论是否有文件，表单页面的布局都一样。

通过[占位图]里面的按钮操作[上传新文件]或[选择已上传文件]。

新增`showUploadBtn(bool)`方法，是否显示[上传新文件]，配合`showChooseBtn(bool)`可控制两个按钮。

新增`disableButtons()`方法，同时禁用[上传新文件]或[选择已上传文件]两个底部控制按钮。

可使用`cover('img_path')`设置占位图:

```php
$form->file('file','文件')->cover('/static/images/myupload.png')//默认会有一个占位图，可以设置自定义图片。
    ->disableButtons()->showInput(false);//同时禁用控制按钮和地址输入框，仅通过占位图控制
```

---
