<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class Room extends BaseService
{
    public function get($roomId)
    {
        $parameters = [
            ':room_id' => $roomId,
        ];
        return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
    }

    public function getCities()
    {
        // Get all cities
        $cities = [];
        try {
            $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
            foreach ($rows as $row) {
                $cities[] = $row['city'];
            }
        } catch (Exception $ex) {
            // Log error
        }

            return $cities;
    }

    public function getGuests()
    {
        // Get number of guests
        $guests = [];
        $rows = $this->fetchAll('SELECT DISTINCT count_of_guests FROM room');
        foreach ($rows as $row) {
            $guests[] = $row['count_of_guests'];
        }

            return $guests;
    }

    public function search($checkInDate, $checkOutDate, $city = '', $typeId = '', $minAmount = '', $maxAmount = '')
    {
        // Setup parameters
        $parameters = [
            ':check_in_date' => $checkInDate->format(DateTime::ATOM),
            ':check_out_date' => $checkOutDate->format(DateTime::ATOM),
        ];
        // if (!empty($guests)) {
        //     $parameters[':count_of_guests'] = $guests;
        // }
        if (!empty($city)) {
            $parameters[':city'] = $city;
        }
        if (!empty($typeId)) {
            $parameters[':type_id'] = $typeId;
        }
        if (!empty($minAmount)) {
            $parameters[':minAmount'] = $minAmount;
        }
        if (!empty($maxAmount)) {
            $parameters[':maxAmount'] = $maxAmount;
        }

        // Build query
        $sql = 'SELECT * FROM room WHERE ';
        // if (!empty($guests)) {
        //     $sql .= 'count_of_guests = :count_of_guests AND ';
        // }
        if (!empty($city)) {
            $sql .= 'city = :city AND ';
        }
        if (!empty($typeId)) {
            $sql .= 'type_id = :type_id AND ';
        }
        if (!empty($minAmount) && !empty($maxAmount)) {
            $sql .= 'price BETWEEN :minAmount AND :maxAmount AND ';
        }
        $sql .= 'room_id NOT IN (
            SELECT room_id
            FROM booking
            WHERE check_in_date <= :check_out_date AND check_out_date >= :check_in_date
            )';
        // Get results
        return $this->fetchAll($sql, $parameters);
    }

}
