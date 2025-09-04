<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        // Floors 1 to 9 → 10 rooms each
        for ($f = 1; $f <= 9; $f++) {
            for ($r = 1; $r <= 10; $r++) {
                Room::create([
                    'floor' => $f,
                    'room_number' => $f*100 + $r,
                ]);
            }
        }
 
 
        // Floor 10 → 7 rooms
        for ($r = 1; $r <= 7; $r++) {
            Room::create([
                'floor' => 10,
                'room_number' => 1000 + $r,
            ]);
        }
    }
 
}
