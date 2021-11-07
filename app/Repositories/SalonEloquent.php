<?php

namespace App\Repositories;

use App\Http\Resources\requestResource;
use App\Http\Resources\salonResource;
use App\Http\Resources\salonSeatResource;
use App\Models\Request;
use App\Models\Salon;
use App\Models\SalonSeat;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

class SalonEloquent
{
    public function show($id = null)
    {
        if (isset($id)) {
            $salon = Salon::find($id);
            if (!isset($salon)) {
                return response_api(false, 422, 'Error', new \stdClass());
            }
            else{
                return response_api(true, 200, 'Success',new salonResource($salon) );

            }
        }
        else{
        $page_number = intval(\request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = Salon::count();
        $total_pages = ceil($total_records / $page_size);
        $salon = Salon::skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();
        return response_api(true, 200, 'Success', salonResource::collection($salon), $page_number, $total_pages, $total_records);
    }}


    public function requests()
    {
        $id=auth()->user()->id;
        $user=User::find($id);
        if ($user['type']=='owner') {
            $mysalon =Salon::where('user_id',$id)->first();
            $myrequest=Request::where('salon_id',$mysalon->id);
            $page_number = intval(\request()->get('page_number'));
            $page_size = \request()->get('page_size');
            $total_records = $myrequest->count();
            $total_pages = ceil($total_records / $page_size);
            $request = $myrequest->skip(($page_number - 1) * $page_size)
                ->take($page_size)->get();
            return response_api(true, 200, 'Success', requestResource::collection($request), $page_number, $total_pages, $total_records);
        }
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
        $salon->is_active = 0;
        $salon->is_online = $data['is_online'];
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
    public function addrequest(array $data)
    {
        $id=auth()->user()->id;
        $user=User::find($id);
        if ($user['type']=='customer'){
            $seat=SalonSeat::find($data['salon_seat_id']);
            $salon=Salon::find($data['salon_id']);
            if ($seat['status']=='available' & $salon != Null){
                $request = new Request();
                $request->user_id = $id;
                $request->salon_id = $data['salon_id'];
                $request->salon_seat_id = $data['salon_seat_id'];
                $request->status = "pending";
                $request->time = '00:10:00';
                $request->save();

                return response_api(true, 200, 'Successfully Added!', new requestResource($request));
            }
            else{
                return response_api(false, 422, 'the seat is not available or the salon not online','');
            }
        }
        else{
            return response_api(false, 422, 'You are not customer','');
        }


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
        if ($data['is_online'] != null) {
            $salon->is_online = $data['is_online'];
        }
        $salon->save();
        return response_api(true, 200, 'Successfully Updated!', new salonResource($salon));
    }

    public function editRequest(array $data)
    {
        $id=auth()->user()->id;
        $user=User::find($id);
        if ($user['type']=='owner') {
            $request=Request::find($data['request_id']);
            if ($data['status'] != null) {
                $request->status = $data['status'];
            }
            $request->save();
            return response_api(true, 200, 'Successfully Updated!', new requestResource($request));
        }
        if($user['type']=='customer'){
            $request=Request::find($data['request_id']);
            if ($data['status'] != null) {
                $request->status = 'cancel';
            }
            $request->save();
            return response_api(true, 200, 'Successfully Canceled!', new requestResource($request));
        }
        else{
            return response_api(false, 422, 'You are not owner','');
        }

    }

    public function search(array $data)
    {
        $salons=Salon::where('is_active',1);
        if (isset($data['name'])){

            $salons=$salons->where('name','Like','%'.$data['name'].'%');
        }
        if (isset($data['latitude'])&& isset( $data['longitude'])){
            $salons=$salons->select("salons.*"
                ,DB::raw("6371 * acos(cos(radians(" . $data['latitude'] . "))
                * cos(radians(salons.latitude))
                * cos(radians(salons.longitude) - radians(" . $data['longitude'] . "))
                + sin(radians(" .$data['latitude']. "))
                * sin(radians(salons.latitude))) AS distance"));

        }
        $page_number = intval(\request()->get('page_number'));
        $page_size = \request()->get('page_size');
        $total_records = $salons->count();
        $total_pages = ceil($total_records / $page_size);
        $data = $salons->skip(($page_number - 1) * $page_size)
            ->take($page_size)->get();

        return response_api(true, 200, 'Successfully !', salonResource::collection($data), $page_number, $total_pages, $total_records);


    }


}
