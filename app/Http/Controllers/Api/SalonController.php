<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Salon\addRequest;
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

    public function show($id = null)
    {
        return $this->salon->show($id);
    }

    public function requests()
    {
        return $this->salon->requests();
    }

    public function salonSeat()
    {
        return $this->salon->salonSeat();
    }

    public function add(salonRequest $request)
    {
        return $this->salon->add($request->all());
    }

    public function addRequest(addRequest $request)
    {
        return $this->salon->addrequest($request->all());
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
