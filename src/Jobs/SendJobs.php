<?php
namespace App\Plugins\agpchat\src\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendJobs implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 590;

    public $all;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($all,$data)
    {
        $this->all = $all;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->all as $value) {
            sendMsg([
                'group_id' => $this->data->group_id,
                'user_id' => $this->data->user_id,
                'message' => $value->content
            ], "send_private_msg");
            sleep(3);
        }
    }

}