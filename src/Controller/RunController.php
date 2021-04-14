<?php
namespace App\Plugins\agpchat\src\Controller;

use App\Plugins\agpchat\src\Jobs\SendJobs;
use App\Plugins\agpchat\src\Models\Agpchat;

class RunController {

    /**
     * 接收到的数据
     *
     * @var object
     */
    public $data;

    /**
     * 插件信息
     *
     * @var array
     */
    public $value;

    /**
     * 插件注册
     *
     * @param object 接收到的数据 $data
     * @param array 插件信息 $value
     * @return void
     */
    public function register($data, $value)
    {
        $this->data = $data;
        $this->value = $value;
        $all = Agpchat::where('group',$data->group_id)->get();
        dispatch(new SendJobs($all,$this->data));
    }

}