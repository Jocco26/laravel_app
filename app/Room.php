<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/*
desired query
SELECT r.id, r.name
FROM rooms as r
WHERE r.id NOT IN(
    SELECT b.room_id
    FROM reservation b
    WHERE NOT (
        b.date_out < '2017-01-02' OR
        b.date_in > '2017-01-03'
        )
    )
ORDER BY r.id
*/

class Room extends Model
{
    public function getAvailablerooms($start_date, $end_date)
    {
        $available_rooms = DB::table('rooms as r')
                                    ->select('r.id','r.name')
                                    ->whereRaw("
                                        r.id NOT IN(
                                            SELECT b.room_id FROM reservations b
                                            WHERE NOT(
                                                b.date_out < '{$start_date}' OR
                                                b.date_in > '{$end_date}'
                                            )
                                        )
                                        ")
                                        ->orderBy('r.id')
                                        ->get()
        ;
        return $available_rooms;
    }

    public function isRoomBooked($room_id, $start_date, $end_date)
    {
        $available_rooms = DB::Table('reservations')
                        ->whereRaw("
                            NOT(
                                date_out < '{$start_date}' OR
                                date_in > '{$end_date}'
                            )
                        ")
                        ->where('room_id', $room_id)
                        ->count()
        ;
        return $available_rooms;

    }

}
