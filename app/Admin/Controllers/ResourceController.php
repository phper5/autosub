<?php

namespace App\Admin\Controllers;

use App\Resource;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ResourceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Resource';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Resource());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('bucket', __('Bucket'));
        $grid->column('object', __('Object'));
        $grid->column('type', __('Type'));
        $grid->column('size', __('Size'));
        $grid->column('user_id', __('User id'));
        $grid->column('attrs', __('Attrs'));
        $grid->column('created_at', __('Created at'))->date('Y-m-d H:i:s');
        $grid->column('updated_at', __('Updated at'))->date('Y-m-d H:i:s');
        $grid->column('filename', __('Filename'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Resource::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('bucket', __('Bucket'));
        $show->field('object', __('Object'));
        $show->field('type', __('Type'));
        $show->field('size', __('Size'));
        $show->field('user_id', __('User id'));
        $show->field('attrs', __('Attrs'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('filename', __('Filename'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Resource());

        $form->text('bucket', __('Bucket'));
        $form->text('object', __('Object'));
        $form->text('type', __('Type'))->default('image');
        $form->number('size', __('Size'));
        $form->text('user_id', __('User id'));
        $form->textarea('attrs', __('Attrs'));
        $form->text('filename', __('Filename'));

        return $form;
    }
}
