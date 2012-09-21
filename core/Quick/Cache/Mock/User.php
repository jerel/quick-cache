<?php namespace Quick\Cache\Mock;

class User
{
    public function get_by_email($email)
    {
        return array('first' => 'Billy', 'last' => 'the Kid');
    }

    public function get()
    {
        return 'jimbobjones';
    }
}
