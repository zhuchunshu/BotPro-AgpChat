<?php

namespace App\Plugins\agpchat\src\Controller;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use App\Plugins\agpchat\src\Models\Agpchat as ModelsAgpchat;
use App\Plugins\agpchat\src\Repositories\Agpchat;
use Illuminate\Http\Request;

class AgpchatController extends Controller
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Agpchat(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('group','群号');
            $grid->column('content','私信内容');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Agpchat(), function (Show $show) {
            $show->field('id');
            $show->field('group','群号');
            $show->field('content','私信内容');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Agpchat(), function (Form $form) {
            $form->display('id');
            $data = sendData([], "get_group_list");
            foreach ($data['data'] as $value) {
                $group[$value['group_id']]=$value['group_name'];
            }
            $form->listbox('group','选择群')
                ->options($group)
                ->saving(function ($value) {
                    // 转化成json字符串保存到数据库
                    return json_encode($value);
            })->required();
            $form->textarea('content','私信内容')->required();
        });
    }
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title;

    /**
     * Set description for following 4 action pages.
     *
     * @var array
     */
    protected $description = [
        //        'index'  => 'Index',
        //        'show'   => 'Show',
        //        'edit'   => 'Edit',
        //        'create' => 'Create',
    ];

    /**
     * Get content title.
     *
     * @return string
     */
    protected function title()
    {
        return $this->title ?: admin_trans_label();
    }

    /**
     * Get description for following 4 action pages.
     *
     * @return array
     */
    protected function description()
    {
        return $this->description;
    }

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['show'] ?? trans('admin.show'))
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['create'] ?? trans('admin.create'))
            ->body($this->form());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        return $this->form()->update($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        $group = array_diff($request->input('group'),[null]);
        if(!count($group)){
            return Json_Api(1,"选择了0个群",'error');
        }
        $content = $request->input('content');
        if(!$content){
            return Json_Api(1,"私信内容不能为空",'error');
        }
        foreach ($group as $value) {
            ModelsAgpchat::insert([
                'group' => $value,
                'content' => $content,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }
        return Json_Api(1,"搞定!",'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->form()->destroy($id);
    }
}
