<!DOCTYPE html>
<html>
<head>
   <title>Hotel Room Reservation</title>
   <!-- Bootstrap 5 -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
       body {
           font-family: 'Inter', sans-serif;
           background: #f4f6f9;
           padding: 30px;
           color: #2c3e50;
       }
       .app-card {
           background: #fff;
           border-radius: 16px;
           box-shadow: 0 6px 20px rgba(0,0,0,0.08);
           padding: 25px;
           margin-bottom: 25px;
       }
       h2 {
           font-weight: 700;
           margin-bottom: 25px;
       }
       .room {
           display: inline-flex;
           justify-content: center;
           align-items: center;
           width: 70px;
           height: 70px;
           margin: 6px;
           border-radius: 12px;
           font-weight: 600;
           font-size: 14px;
           transition: all 0.3s ease;
       }
       .room.available {
           background: linear-gradient(135deg, #4CAF50, #2e7d32);
           color: #fff;
       }
       .room.booked {
           background: linear-gradient(135deg, #e74c3c, #c0392b);
           color: #fff;
       }
       .room:hover {
           transform: scale(1.1);
           box-shadow: 0 4px 14px rgba(0,0,0,0.15);
           cursor: pointer;
       }
       .floor-title {
           margin: 15px 0 10px;
           font-weight: 600;
           font-size: 18px;
           color: #34495e;
       }
       .btn-custom {
           border-radius: 10px;
           padding: 0.6rem 1.4rem;
           font-weight: 500;
           transition: 0.3s;
       }
       .btn-custom:hover {
           transform: translateY(-2px);
           box-shadow: 0 5px 12px rgba(0,0,0,0.15);
       }
       .status-badge {
           display: inline-block;
           padding: 5px 12px;
           border-radius: 20px;
           font-size: 13px;
           font-weight: 500;
       }
       .status-available { background: #d4edda; color: #155724; }
       .status-booked { background: #f8d7da; color: #721c24; }
   </style>
</head>
<body>


<div class="container">
   <h2 class="text-center"> Hotel Room Reservation System</h2>
   <p class="text-center text-muted mb-4">Check the floors below and pick your rooms easily.</p>


   <!-- Messages -->
   @if(session('success'))
       <div class="alert alert-success shadow-sm">
               {{ session('success') }}
       </div>
   @endif
   @if(session('error'))
       <div class="alert alert-danger shadow-sm">
            {{ session('error') }}
       </div>
   @endif


   <!-- Booking Controls -->
   <div class="app-card">
       <form method="POST" action="{{ route('rooms.book') }}" class="row g-3 align-items-center mb-3">
           @csrf
           <div class="col-auto">
               <label class="form-label">How many rooms would you like to book? (1–5)</label>
           </div>
           <div class="col-auto">
               <input type="number" name="count" min="1" max="5" class="form-control" required>
           </div>
           <div class="col-auto">
               <button type="submit" class="btn btn-primary btn-custom">Reserve Now</button>
           </div>
       </form>


       <div class="d-flex gap-2">
           <form method="POST" action="{{ route('rooms.randomize') }}">
               @csrf
               <button type="submit" class="btn btn-warning btn-custom">Shuffle Rooms</button>
           </form>


           <form method="POST" action="{{ route('rooms.reset') }}">
               @csrf
               <button type="submit" class="btn btn-danger btn-custom">Clear All Bookings</button>
           </form>
       </div>
   </div>


   <!-- Room Layout -->
   <div class="app-card">
       <div class="mb-3">
           <span class="status-badge status-available"> Available</span>
           <span class="status-badge status-booked ms-2"> Booked</span>
       </div>


       @foreach($rooms as $key => $floorRooms)
           <div>
               <div class="floor-title">Floor {{ $key }}</div>
               <div>
                   @foreach($floorRooms as $room)
                       <div class="room {{ $room->is_available ? 'available' : 'booked' }}">
                           {{ $room->room_number }}
                       </div>
                   @endforeach
               </div>
           </div>
       @endforeach
   </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>