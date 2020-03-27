<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function section_main()
    {
        $data = [
            'title' => 'Feedback',
            'feedback' => Feedback::orderBy('accepted', 'asc')->orderBy('id', 'desc')->paginate(config('app.items')),
            'breadcrumb' => [['name' => 'Feedback']],
            'components' => ['sweetalert']
        ];

        return view('admin.feedback.main', $data);
    }

    public function section_view($id)
    {
        $feedback = Feedback::find($id);

        if ($feedback === null)
            $this->display_404();

        $data = [
            'title' => 'Feedback',
            'feedback' => $feedback,
            'breadcrumb' => [
                ['name' => 'Feedback', 'url' => uri('admin/feedback')],
                ['name' => '№' . $id]
            ]
        ];

        return view('admin.feedback.view', $data);
    }

    public function action_delete($post)
    {
        Feedback::find($post->id)->delete();

        res(200, 'Запись успешно удалено!');
    }

    public function action_accepted($post)
    {
        $feedback = Feedback::find($post->id);

        $feedback->accepted = user()->id;

        $feedback->save();

        res(200, 'Вы успешно приняли feedback!');
    }
}