<?php

namespace App\Listeners\Portal;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailVerified
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        // 将认证成功后的消息提醒写入会话闪存中
        session()->flash('success', '恭喜您，邮箱认证成功~~~^_^~~~');
    }
}
