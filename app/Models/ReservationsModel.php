<?php

namespace App\Models;

class ReservationsModel extends Model
{
    public int|null $days = null;
    public string|null $start_date = null;
    public int|null $room_id = null;
    public int|null $guest_id = null;
    protected static $table = 'reservations';

    public function __construct(?int $room_id = null, ?int $guest_id = null, ?int $days = null, ?string $start_date = null) 
    {
        parent::__construct();
        if ($room_id) $this->room_id = $room_id;
        if ($guest_id) $this->guest_id = $guest_id;
        if ($days) $this->days = $days;
        if ($start_date) $this->start_date = $start_date;  
    }
public function getRoomStatus($room_id, $days, $start_date, ?int $exclude_id = null): string {
    $sql = "SELECT COUNT(*) as overlap_count
            FROM reservations
            WHERE room_id = :room_id
            AND (
                (:start_date1 BETWEEN start_date AND DATE_ADD(start_date, INTERVAL (days - 1) DAY))
                OR (DATE_ADD(:start_date2, INTERVAL (:days1 - 1) DAY) BETWEEN start_date AND DATE_ADD(start_date, INTERVAL (days - 1) DAY))
                OR (start_date BETWEEN :start_date3 AND DATE_ADD(:start_date4, INTERVAL (:days2 - 1) DAY))
            )";

    if ($exclude_id !== null) {
        $sql .= " AND id != :exclude_id";
    }

    $params = [
        'room_id' => $room_id,
        'start_date1' => $start_date,
        'start_date2' => $start_date,
        'start_date3' => $start_date,
        'start_date4' => $start_date,
        'days1' => $days,
        'days2' => $days,
    ];

    if ($exclude_id !== null) {
        $params['exclude_id'] = $exclude_id;
    }

    $result = $this->db->execSql($sql, $params);

    if (!$result || !isset($result[0])) {
        return 'available';
    }

    return ($result[0]['overlap_count'] > 0) ? 'occupied' : 'available';
}



}