<?php

namespace App\Admin\Controllers;

use App\Models\Domain;
use App\Models\Record;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class RecordController extends Controller
{
    use HasResourceActions;

    protected $recordTypes = [
        'a' => 'A',
        'aaaa' => 'AAAA',
        'cname' => 'CNAME',
        'txt' => 'TXT',
    ];

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Record);

        $grid->id('Id');
        $grid->domain_id('Domain')->display(function($domainId) {
            return Domain::find($domainId)->domain;
        });
        $grid->type('Type');
        $grid->record('Record');
        $grid->content('Content');
        $grid->remark('Remark');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Record::findOrFail($id));

        $show->id('Id');
        $show->domain_id('Domain id');
        $show->type('Type');
        $show->record('Record');
        $show->content('Content');
        $show->remark('Remark');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Record);

        $domains = Domain::all(['id', 'domain'])->pluck('domain', 'id')->toArray();
        $form->select('domain_id', 'Domain')
            ->options($domains)
            ->default(array_first(array_keys($domains)));
        $form->radio('type', 'Type')
            ->options($this->recordTypes)
            ->default(array_first(array_keys($this->recordTypes)));
        $form->text('record', 'Record');
        $form->text('content', 'Content');
        $form->text('remark', 'Remark');

        return $form;
    }
}
