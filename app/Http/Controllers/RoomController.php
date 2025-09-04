<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all()->groupBy('floor');
        return view('rooms.index', compact('rooms'));
    }
 
 
    /**
     * Reset all rooms back to available
     */
    public function reset()
    {
        Room::query()->update(['is_available' => true]);
 
 
        return redirect()
            ->route('rooms.index')
            ->with('success', 'All rooms have been reset to available.');
    }
 
 
    /**
     * Randomize room occupancy
     */
    public function randomize()
    {
        $rooms = Room::all();
 
 
        foreach ($rooms as $room) {
            $room->update([
                'is_available' => (bool) rand(0, 1),
            ]);
        }
 
 
        return redirect()
            ->route('rooms.index')
            ->with('success', 'Room occupancy has been randomized.');
    }
 
 
    /**
     * Book N rooms (between 1 and 5)
     */
    public function book(Request $request)
    {
        $count = (int) $request->input('count');
 
 
        // Validate input
        if ($count < 1 || $count > 5) {
            return back()->with('error', 'Please select between 1 and 5 rooms.');
        }
 
 
        // Find available rooms
        $availableRooms = Room::where('is_available', true)
            ->take($count)
            ->get();
 
 
        if ($availableRooms->count() < $count) {
            return back()->with('error', 'Only ' . $availableRooms->count() . ' room(s) are available right now.');
        }
 
 
        // Mark them as booked
        foreach ($availableRooms as $room) {
            $room->update(['is_available' => false]);
        }
 
 
        return back()->with(
            'success',
            'Successfully booked room(s): ' . $availableRooms->pluck('room_number')->join(', ')
        );
    }
 
}
