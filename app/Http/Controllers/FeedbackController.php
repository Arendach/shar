<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create(Request $request)
    {
        // валідація
        if (!$request->name || mb_strlen($request->get('name')) > 64) {
            return response()->json([
                'message' => 'Введите имя в правильном формате!'
            ], 400);
        }

        if (preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}-/', $request->phone)) {
            return response()->json([
                'message' => 'Введите телефон в правильном формате!'
            ], 400);
        }

        $feedback = Feedback::create($request->only('name', 'phone', 'message'));

        // смска
        $address = url("f/{$feedback->id}");
        send_sms(settings('sms.number'), 'New feedback ' . $address);

        // todo: зробити сповіщення на пошту
       /* // екранування символів і надсилання на Емейл сповіщення
        $post->name = htmlspecialchars($post->name);
        $post->message = htmlspecialchars($post->message);
        $text = "Новый <b>feedback</b> на сайте <b>shar.kiev.ua</b><br> \r\n";
        $text .= "Клиент: <b>{$post->name}</b><br> \r\n";
        $text .= "Телефон: <b>{$post->phone}</b><br> \r\n";
        if ($post->message != '') $text .= "Сообщение: <b>{$post->message}</b> \r\n";
        send_email(settings('feedback.email_from'), settings('feedback.email_to'), $text);*/

        // відповідь від сервера
        return response()->json([
            'message' => 'Заявка принята! Ожидайте звонка менеджера'
        ], 200);
    }
}
