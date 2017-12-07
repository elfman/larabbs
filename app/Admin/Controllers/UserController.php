<?php

namespace App\Admin\Controllers;

use \App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
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
            $content->header('论坛用户');
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

            $content->header('论坛用户');
            $content->description('编辑');

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

            $content->header('论坛用户');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
//            $grid->avatar('头像')->image(48, 48);
            $grid->column('头像')->display(function () {
                $image = $this->avatar;
                if (!preg_match('/^http[^s]?/i', $image)) {
                    $image = config('app.url') . '/uploads/' . $image;
                }
                return $image;
            })->image(48, 48);
            $grid->name('名字');
            $grid->email('Email');
            $grid->introduction('简介');

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('name', '名字');
            $form->text('email', 'Email');
            $form->image('avatar', '头像')
                ->move(function($file) {
                    return 'images/avatar/' . date('Ym', time()) . '/' . date('d', time());
                })
                ->name(function ($file) use ($form) {
                    $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
                    $filename = $form->model()->id . '_' . time() . '_' . str_random(10) . '.' . $extension;
                    return $filename;
                })
                ->resize(240, 240);

            $form->text('introduction', '简介');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
