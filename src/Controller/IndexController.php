<?php
namespace App\Plugins\agpchat\src\Controller;

use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Widgets\Markdown;

class IndexController {

    public function show(Content $content){
        $content->title('加群私聊插件');
        $content->header('加群私聊插件');
        $content->description('加群私聊插件信息');
        $content->body(Card::make(
            Markdown::make(read_file(plugin_path("agpchat/README.md")))
        ));
        return $content;
    }
}
