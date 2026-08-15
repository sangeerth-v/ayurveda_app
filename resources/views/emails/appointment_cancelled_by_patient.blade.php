<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f7f9f6; color: #2e3b2e; margin: 0; padding: 40px 20px; }
        .container { max-width: 600px; background-color: #ffffff; margin: 0 auto; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e1e8e1; }
        .header { background-color: #c62828; padding: 40px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 700; }
        .content { padding: 40px 30px; line-height: 1.6; }
        .content h2 { color: #c62828; font-size: 20px; margin-top: 0; }
        .details-card { background-color: #f9fbf9; border-left: 4px solid #c62828; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .details-row { display: flex; margin-bottom: 10px; font-size: 15px; }
        .details-label { font-weight: bold; width: 140px; color: #7a8a7a; flex-shrink: 0; }
        .details-value { color: #2e3b2e; }
        .footer { background-color: #f1f5f1; text-align: center; padding: 20px; font-size: 12px; color: #7a8a7a; border-top: 1px solid #e1e8e1; }
        .btn { display: inline-block; background-color: #c62828; color: #ffffff !important; padding: 12px 30px; text-decoration: none; border-radius: 30px; font-weight: bold; margin-top: 20px; box-shadow: 0 4px 6px rgba(198,40,40,0.2); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Cancelled</h1>
        </div>
        <div class="content">
            <h2>Patient Cancelled Booking</h2>
            <p>Dear Dr. {{ $booking->doctor->name }},</p>
            <p>The patient has cancelled their scheduled appointment. Below are the details of the cancelled booking:</p>
            
            <div class="details-card">
                <div class="details-row">
                    <span class="details-label">Booking ID:</span>
                    <span class="details-value">#BK-{{ $booking->id }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Patient Name:</span>
                    <span class="details-value">{{ $booking->user->name }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Scheduled Date:</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, d M Y') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Scheduled Time:</span>
                    <span class="details-value">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">Consultation Type:</span>
                    <span class="details-value">{{ $booking->consultation_type }}</span>
                </div>
            </div>

            <p>This slot is now available for other bookings on your schedule.</p>
            <center>
                <a href="{{ route('doctor.dashboard') }}" class="btn">Go to Dashboard</a>
            </center>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Ayurveda App. All rights reserved.
        </div>
    </div>
</body>
</html>
