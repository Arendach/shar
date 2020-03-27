<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $section_main = 'section_main';

    public $action_main = 'action_main';

    public function post_handle($post)
    {
        $post = (object)$post;
        if (post('action')) {
            if (method_exists($this, 'action_' . $post->action)) {
                $action = $post->action;
                unset($post->action, $post->_token);
                return $this->{'action_' . $action}($post);
            } else {
                return $this->response_404();
            }
        } else {
            if (method_exists($this, $this->action_main)) {
                unset($post->action);
                return $this->{$this->action_main}($post);
            } else {
                return $this->response_404();
            }
        }
    }

    public function get_handle($get)
    {
        if (get('section')) {
            if (method_exists($this, 'section_' . $get->section)) {
                $section = $_GET['section'];
                unset($_GET['section']);
                return $this->{'section_' . $section}($get);
            } else {
                return $this->display_404();
            }
        } else {
            if (method_exists($this, $this->section_main)) {
                unset($_GET['section']);
                return $this->{$this->section_main}($get);
            } else {
                return $this->display_404();
            }
        }
    }

    protected function display_404()
    {
        abort(404);
    }

    protected function response_404($message = 'Страница не найдена!')
    {
        res(404, $message);
    }

    protected function display_403()
    {
        abort(403);
    }

    protected function response_403($message = 'Доступ запрещен!')
    {
        res(403, $message);
    }
}
