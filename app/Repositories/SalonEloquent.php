<?php

namespace App\Repositories;

use App\Http\Resources\requestResource;
use App\Http\Resources\salonResource;
use App\Http\Resources\salonSeatResource;
use App\Models\Request;
use App\Models\Salon;
use App\Models\SalonSeat;

class SalonEloquent
{
    public function show()
    {
        $page_number = intval(\request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = Salon::count();
        $total_pages = ceil($total_records / $page_size);
        $salon = Salon::skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();
        return response_api(true, 200, 'Success', salonResource::collection($salon), $page_number, $total_pages, $total_records);
    }

    public function request()
    {
        $page_number = intval(\request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = Request::count();
        $total_pages = ceil($total_records / $page_size);
        $request = Request::skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();
        return response_api(true, 200, 'Success', requestResource::collection($request), $page_number, $total_pages, $total_records);

    }

    public function salonSeat()
    {
        $page_number = intval(\request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = SalonSeat::count();
        $total_pages = ceil($total_records / $page_size);
        $salon_seat = SalonSeat::skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();

        return response_api(true, 200, 'Success', salonSeatResource::collection($salon_seat), $page_number, $total_pages, $total_records);

    }

    public function add(array $data)
    {
        $salon = new Salon();
        $salon->name = $data['name'];
        $salon->address = $data['address'];
        $salon->latitude = $data['latitude'];
        $salon->longitude = $data['longitude'];
        $salon->seats_number = $data['seats_number'];
        $salon->isactive = 0;
        $salon->isonline = $data['isonline'];
        $salon->user_id = auth()->user()->id;
        $salon->save();
        for ($i = 1; $i <= $data['seats_number']; $i++) {
            $salon_seat = new SalonSeat();
            $salon_seat->seat_number = $i;
            $salon_seat->status = 'available';
            $salon_seat->salon_id = $salon->id;
            $salon_seat->save();
        }
        return response_api(true, 200, 'Successfully Added!', new salonResource($salon));

    }

    public function edit(array $data)
    {
        $id = auth()->user()->id;
        $salon = Salon::where("user_id", $id)->first();
        $salon->name = $data['name'];
        if ($data['address'] != null) {
            $salon->address = $data['address'];
        }
        if ($data['latitude'] != null) {
            $salon->latitude = $data['latitude'];
        }
        if ($data['longitude'] != null) {
            $salon->longitude = $data['longitude'];
        }
        if ($data['seats_number'] != null) {
            $salon->seats_number = $data['seats_number'];
        }
        if ($data['isonline'] != null) {
            $salon->isonline = $data['isonline'];
        }
        $salon->save();
        return response_api(true, 200, 'Successfully Updated!', new salonResource($salon));
    }

    public function editRequest(array $data)
    {
        $id = auth()->user()->id;
        $request = Request::where("user_id", $id)->first();
        if ($data['status'] != null) {
            $request->status = $data['status'];
        }
        $request->save();
        return response_api(true, 200, 'Successfully Updated!', new requestResource($request));
    }

    public function search(array $data)
    {
        $salon_name = $data['name'];
        $salon = Salon::where("name", "like", "%$salon_name%")->first();
        return response_api(true, 200, 'Success', new salonResource($salon));
    }

}
