<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Topic;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Log;

class TopicController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('帖子');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('帖子');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('帖子');
            $content->description('新建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Topic::class, function (Grid $grid) {

            $grid->model()->with('user')->with('category')->orderBy('updated_at', 'DESC');

            $grid->id('ID')->sortable();

            $grid->column('title', '标题')->display(function () {
                return "<a href='/topics/$this->id/$this->slug' target='_blank'>$this->title</a>";
            });
            $grid->column('user.name', '作者');
            $grid->column('category.name', '分类')->label();
            $grid->view_count('已读');
            $grid->column('回复数')->display(function () {
                return "<a href='/admin/replies?topic_id=$this->id'>$this->reply_count</a>";
            });

            $grid->created_at('创建时间');
            $grid->updated_at('最后更新');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Topic::class, function (Form $form) {
            $form->model()->with('user');


            $form->display('id', 'ID');
            $form->display('user.name', '作者');

            $form->text('title', '标题');

            $form->editor('body', '内容');
            $form->select('category_id', '类别')->options(Category::all()->pluck('name', 'id'));
            $form->text('slug', 'slug');
            $form->text('excerpt', '摘要');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '最后更新');
        });
    }
}
