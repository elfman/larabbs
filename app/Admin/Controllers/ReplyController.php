<?php

namespace App\Admin\Controllers;

use App\Models\Reply;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Request;

class ReplyController extends Controller
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
            $content->header('回复');
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

            $content->header('回复');
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

            $content->header('回复');
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
        return Admin::grid(Reply::class, function (Grid $grid) {
            $topic_id = Request::get('topic_id');
            if ($topic_id > 0) {
                $grid->model()->where('topic_id', $topic_id);
            }

            $grid->model()->orderBy('created_at', 'DESC');
            $grid->model()->with('topic');
            $grid->model()->with('user');
            $grid->id('ID')->sortable();

            $grid->column('topic.title', '帖子');
            $grid->column('user.name', '回复者');
            $grid->column('内容')->display(function () {
                return $this->content;
            });

            $grid->created_at('回复时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Reply::class, function (Form $form) {
            $form->model()->with('user')->with('topic');

            $form->display('id', 'ID');
            $form->display('topic.title', '帖子');
            $form->display('user.name', '回复者');

            $form->editor('content', '内容');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '最后更新');
        });
    }
}
