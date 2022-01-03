<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Reservation;
use App\Guest;

use App\Traits\ApiResponser;

class ReservationController extends Controller
{
    use ApiResponser;

    public function show($id)
    {
        $reservation = Reservation::with('guests.menu')->findOrFail($id);
        return $this->successResponse($reservation, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $rules = [
            'status' => 'required|max:256',
            'total_guests' => 'required',
        ];
        $this->validate($request, $rules);
        // also check if user has Reservation for that Restaurant for the same Date/time

        $reservation = Reservation::create($request->except('user_id'));
        if( $request->filled('user_id') )
        {
            $guest = Guest::create([
                'reservation_id' => $reservation->id,
                'guest_order' => 1,
                'guest_type' => 'OWNER',
                'user_id' => $request['user_id']
            ]);
        }
        // dd($reservation->toArray(), $guest->toArray());

        return $this->successResponse($reservation, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->fill($request->all());
        if($reservation->isClean())
        {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $reservation->save();
        return $this->successResponse($reservation);
    }

    public function all($user_id)
    {
        $user_created_reservations = Reservation::where('creator_id', $user_id)->get();
        $user_created_reservations_ids = $user_created_reservations->pluck('id')->toArray();

        $user_reservations = Guest::where('user_id', $user_id)->get();
        $user_guest_reservations_ids = $user_reservations->pluck('reservation_id')->toArray();
        $reservations_ids = (array_merge($user_created_reservations_ids, $user_guest_reservations_ids));
        
        $reservations = Reservation::find($reservations_ids)->toArray();
        // dd($reservations);

        return $this->successResponse($reservations);
    }

}
