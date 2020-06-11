<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Mydnic\Kustomer\Feedback;

class FeedbackController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mydnic\Kustomer\Feedback';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Feedback());

        $grid->column('id', __('Id'));
        $grid->column('type', __('Type'));
        $grid->column('message', __('Message'));
        $grid->column('user_info', __('User info'));
        $grid->column('reviewed', __('Reviewed'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Feedback::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'));
        $show->field('message', __('Message'));
        $show->field('user_info', __('User info'));
        $show->field('reviewed', __('Reviewed'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Feedback());

        $form->text('type', __('Type'));
        $form->textarea('message', __('Message'));
        $form->textarea('user_info', __('User info'));
        $form->switch('reviewed', __('Reviewed'));

        return $form;
    }
}
