<?php

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class RoomType extends BaseService
{
    public function getAllTypes()
    {
        // Get all room types
        return $this->fetchAll('SELECT * FROM room_type');
    }
}
