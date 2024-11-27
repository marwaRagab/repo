<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Military_affairsRepositoryInterface
{
    public function index();
    public function convert( $id);
    public function get_settlment($type = null);
    public function all_military_affairs_count($type='');
}
