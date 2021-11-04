<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\editRequest;
use App\Http\Requests\Salon\salonRequest;
use App\Http\Requests\Salon\salonSeatsRequest;
use App\Http\Requests\Salon\SearchRequest;
use App\Repositories\SalonEloquent;

class SalonController extends Controller
{
    public function __construct(SalonEloquent $salonEloquent)
    {
        $this->salon = $salonEloquent;
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

    public function add(salonRequest $request)
    {
        return $this->salon->add($request->all());
    }

    public function edit(salonRequest $request)
    {
        return $this->salon->edit($request->all());
    }

    public function editRequest(editRequest $request)
    {
        return $this->salon->editRequest($request->all());
    }

    public function search(SearchRequest $request)
    {
        return $this->salon->search($request->all());
    }

}
