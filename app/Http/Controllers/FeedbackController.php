<?php

namespace App\Http\Controllers;

use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function action_main($post)
    {
        // валідація
        if ($post->name == '' || mb_strlen($post->name) > 64)
            res(400, 'Введите имя в правильном формате!');

        if (preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}-/', $post->phone))
            res(400, 'Введите телефон в правильном формате!');

        // збереження в бд
        $feedback = new Feedback;
        $feedback->name = $post->name;
        $feedback->phone = $post->phone;
        $feedback->message = $post->message;
        $feedback->created_at = date('Y-m-d H:i:s');
        $feedback->updated_at = date('Y-m-d H:i:s');
        $feedback->accepted = 0;
        $feedback->save();

        // смска
        $address = uri("f/{$feedback->id}");
        send_sms(settings('sms.number'), 'New feedback ' . $address);

        // екранування символів і надсилання на Емейл сповіщення
        $post->name = htmlspecialchars($post->name);
        $post->message = htmlspecialchars($post->message);
        $text = "Новый <b>feedback</b> на сайте <b>shar.kiev.ua</b><br> \r\n";
        $text .= "Клиент: <b>{$post->name}</b><br> \r\n";
        $text .= "Телефон: <b>{$post->phone}</b><br> \r\n";
        if ($post->message != '') $text .= "Сообщение: <b>{$post->message}</b> \r\n";
        send_email(settings('feedback.email_from'), settings('feedback.email_to'), $text);

        // відповідь від сервера
        res(200, 'ok');
    }
}
