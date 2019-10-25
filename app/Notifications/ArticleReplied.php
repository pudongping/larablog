<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Portal\Article\Reply;

class ArticleReplied extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reply;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
        return ['database', 'mail']; // 开启通知频道
    }

    /**
     * Get the mail representation of the notification.
     * 因为我们采用了 database 的途径开启了通知频道，因此这里的方法名必须为 「to + database」
     * 如果我们采用了 mail 邮件的途径开启了通知频道，因此这里的方法名为 「toMail」
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        $article = $this->reply->article;
        $link =  $article->link(['#reply' . $this->reply->id]);

        // 返回的数组将被转成 JSON 格式并存储到通知数据表的 data 字段中
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'article_link' => $link,
            'article_id' => $article->id,
            'article_title' => $article->title,
        ];
    }

    /**
     * 邮件通知
     *
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $url = $this->reply->article->link(['#reply' . $this->reply->id]);

        return (new MailMessage)
            ->subject(config('app.name', 'Alex的个人博客'))
            ->greeting('Hello!')
            ->line('您的文章有新回复！')
            ->action('查看回复', $url)
            ->line('感谢您使用我们的博客程序！');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
