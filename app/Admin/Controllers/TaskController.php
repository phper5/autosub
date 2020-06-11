<?php

namespace App\Admin\Controllers;

use App\Resource;
use App\Task;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Task';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Task());
        $grid->model()->orderBy('created_at', 'desc');
        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('service', __('Service'));
        //        $grid->column('source_file', __('Source file'));
        $grid->column('source_file')->display(function ($source_file) {
            if ($resource = Resource::find($source_file)) {
                $large = $resource->getUrl();
                return '<a href="'.$large.'" target="_blank">  <img  src="'.$resource->getUrl(150).'"></a>';
            }
            else{
                return $source_file;
            }

        });
        $grid->column('target_file')->display(function ($target_file) {

            if (($target_file = json_decode($target_file,true))  && ($resource = Resource::find($target_file[0]))) {
                $large = $resource->getUrl();
                return '<a href="'.$large.'" target="_blank">  <img  src="'.$resource->getUrl(150).'"></a>';
            }
            else{
                return $target_file;
            }

        });
        $grid->column('status', __('Status'));
        $grid->column('progress', __('Progress'));
//        $grid->column('target_file', __('Target file'));
        $grid->column('created_at', __('Created at'))->date('Y-m-d H:i:s')->sortable();
        $grid->column('updated_at', __('Updated at'))->date('Y-m-d H:i:s');


//        $grid->column('args', __('Args'));

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
        $show = new Show(Task::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('service', __('Service'));
        $show->field('status', __('Status'));
        $show->field('progress', __('Progress'));
        $show->field('target_file', __('Target file'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('source_file', __('Source file'));
        $show->field('args', __('Args'));
        $show->source_file()->unescape()->as(function ($source_file) {
            if ($resource = Resource::find($source_file)) {
                $large = $resource->getUrl();
                return '<a href="'.$large.'" target="_blank">  <img  src="'.$resource->getUrl(150).'"></a>';
            }
            else{
                return $source_file;
            }
        });
        $show->args()->unescape()->as(function ($args_str) {
            $args = json_decode($args_str,true);
            if (isset($args['mask'])) {
                $binary = base64_decode(explode(',', $args['mask'])[1]);

                $image_info = getimagesizefromstring($binary);
                //print_r($data);
                if ($resource = Resource::find($this->source_file)) {
                    $large = $resource->getUrl();
                    $background = $large;
                }
                return '<div style="background-size:'.$image_info[0].'px;background-repeat: no-repeat;background-image: url('.$background.')">  <img  src="'.$args['mask'].'"></div>';
            }
            else{
                return $args_str;
            }
        });
        $show->target_file()->unescape()->as(function ($target_file) {
            if (($target_file = json_decode($target_file,true))  && ($resource = Resource::find($target_file[0]))) {
                $large = $resource->getUrl();
                return '<a href="'.$large.'" target="_blank">  <img  src="'.$resource->getUrl(150).'"></a>';
            }
            else{
                return $target_file;
            }
        });
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Task());

        $form->text('user_id', __('User id'));
        $form->text('service', __('Service'));
        $form->number('status', __('Status'));
        $form->number('progress', __('Progress'));
        $form->text('target_file', __('Target file'));
        $form->text('source_file', __('Source file'));
        $form->textarea('args', __('Args'));

        return $form;
    }
}
