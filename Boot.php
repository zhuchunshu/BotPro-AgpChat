<?php
namespace App\Plugins\agpchat;

use App\Plugins\agpchat\src\database\Createagpchattable;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Menu;
use Illuminate\Support\Facades\Route;

class Boot {

    public function handle(){
        $this->route();
        $this->menu();
        $this->SqlMigrate();
    }

    // 注册路由
    public function route(){
        Route::group([
            'prefix'     => config('admin.route.prefix')."/agpchat",
            'middleware' => config('admin.route.middleware'),
        ], function () {
            Route::get('/', [src\Controller\IndexController::class,'show']); // 插件信息
            Route::get('/ci', [src\Controller\AgpchatController::class,'index']);
            Route::get('/ci/create', [src\Controller\AgpchatController::class,'create']); // 新增
            Route::post('/ci', [src\Controller\AgpchatController::class,'store']); // 保存
            Route::get('/ci/{id}/edit', [src\Controller\AgpchatController::class,'edit']); // 编辑
            Route::get('/ci/{id}', [src\Controller\AgpchatController::class,'show']); // 显示
            Route::put('/ci/{id}', [src\Controller\AgpchatController::class,'update']); // 更新
            Route::delete('/ci/{id}', [src\Controller\AgpchatController::class,'destroy']); //删除
        });
    }

    // 注册菜单
    public function menu(){
        Admin::menu(function (Menu $menu) {
            $menu->add([
                [
                    'id'            => 100, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => '加群私聊',
                    'icon'          => 'feather icon-bell',
                    // 'uri'           => 'fuduji',
                    'parent_id'     => 0,
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ],
                [
                    'id'            => 101, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => '插件信息',
                    'icon'          => '',
                    'uri'           => 'agpchat',
                    'parent_id'     => 100,
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ],
                [
                    'id'            => 102, // 此id只要保证当前的数组中是唯一的即可
                    'title'         => '管理',
                    'icon'          => '',
                    'uri'           => 'agpchat/ci',
                    'parent_id'     => 100,
                    'permission_id' => 'administrator', // 与权限绑定
                    'roles'         => 'administrator', // 与角色绑定
                ]
            ]);
        });
    }

    // 数据库迁移
    public function SqlMigrate(){
        (new Createagpchattable())->up();
    }

}