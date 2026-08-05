<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f9f6; color: #2e3b2e; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e1e8e1; }
        .header { background-color: #1a4d2e; padding: 40px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 700; }
        .content { padding: 40px 30px; line-height: 1.6; }
        .content h2 { color: #1a4d2e; font-size: 20px; margin-top: 0; }
        .details-card { background-color: #f9fbf9; border-left: 4px solid #1a4d2e; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .details-row { display: flex; margin-bottom: 10px; font-size: 15px; }
        .details-label { font-weight: bold; width: 120px; color: #7a8a7a; }
        .details-value { color: #2e3b2e; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-weight: bold; font-size: 14px; margin-bottom: 20px; }
        .status-booked { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .status-cancelled { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .status-completed { background-color: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }
        .footer { background-color: #f1f5f1; text-align: center; padding: 20px; font-size: 12px; color: #7a8a7a; border-top: 1px solid #e1e8e1; }
        .btn { display: inline-block; background-color: #1a4d2e; color: #ffffff !important; padding: 12px 30px; text-decoration: none; border-radius: 30px; font-weight: bold; margin-top: 20px; box-shadow: 0 4px 6px rgba(26,77,46,0.2); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ayurveda</h1>
        </div>
        <div class="content">
            <h2>Appointment Status Update</h2>
            <p>Dear {{ $booking->user->name }},</p>
            <p>Your appointment status has been updated by the doctor:</p>
            
            @if($booking->status == 'Booked')
                <div class="status-badge status-booked">Accepted &amp; Scheduled</div>
            @elseif($booking->status == 'Completed')
                <div class="status-badge status-completed">Completed</div>
            @else
                <div class="status-badge status-cancelled">Cancelled / Rejected</div>
            @endif

            <div class="details-card">
                <div class="details-row">
                    <span class="details-label">Doctor:</span>
                    <span class="details-value">Dr. {{ $booking->doctor->name }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Category:</span>
                    <span class="details-value">{{ $booking->doctor->specialization_category }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Date:</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, d M Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Time:</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                </div>
                @if($booking->consultation_type)
                <div class="details-row">
                    <span class="details-label">Type:</span>
                    <span class="details-value">{{ $booking->consultation_type }}</span>
                </div>
                @endif
                @php
                    $meetLink = $booking->google_meet_link ?: ($booking->doctor->google_meet_link ?? null);
                @endphp
                @if($booking->status == 'Booked' && $booking->consultation_type == 'Online' && !empty($meetLink))
                <div class="details-row">
                    <span class="details-label">Meeting:</span>
                    <span class="details-value"><a href="{{ $meetLink }}" style="color: #1a4d2e; font-weight: bold;">{{ $meetLink }}</a></span>
                </div>
                @endif
            </div>

            <p>If you have any questions, please contact the support team or visit your dashboard.</p>
            <center>
                <a href="{{ route('bookings.my') }}" class="btn">View Appointments</a>
            </center>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Ayurveda App. All rights reserved.
        </div>
    </div>
</body>
</html>
