<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SalonEloquent;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function __construct(SalonEloquent $salonEloquent)
    {
        $this->salon= $salonEloquent;
    }
    public function show()
    {
        return $this->salon->show();
    }
    public function request()
    {
        return $this->salon->request();
    }

    public function salonSeat()
    {
        return $this->salon->salonSeat();
    }

}
