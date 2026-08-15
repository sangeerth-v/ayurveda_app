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
        .details-label { font-weight: bold; width: 150px; color: #7a8a7a; flex-shrink: 0; }
        .details-value { color: #2e3b2e; }
        .badge-new { background-color: #e8f5e9; color: #2e7d32; font-weight: bold; padding: 2px 8px; border-radius: 4px; }
        .badge-old { background-color: #ffebee; color: #c62828; font-weight: bold; padding: 2px 8px; border-radius: 4px; text-decoration: line-through; }
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
            <h2>Appointment Rescheduled</h2>
            <p>Dear Dr. {{ $booking->doctor->name }},</p>
            <p>A patient has requested to reschedule their appointment. Below are the updated details:</p>
            
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
                    <span class="details-label">Patient Phone:</span>
                    <span class="details-value">{{ $booking->user->phone ?? 'N/A' }}</span>
                </div>
                <div class="details-row">
                    <span class="details-label">New Date:</span>
                    <span class="details-value"><span class="badge-new">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, d M Y') }}</span></span>
                </div>
                <div class="details-row">
                    <span class="details-label">New Time:</span>
                    <span class="details-value"><span class="badge-new">{{ \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') }}</span></span>
                </div>
                <div class="details-row">
                    <span class="details-label">Consultation Type:</span>
                    <span class="details-value"><span class="badge-new">{{ $booking->consultation_type }}</span></span>
                </div>

                @if($originalDate || $originalTime || $originalDoctorName)
                    <hr style="border: 0; border-top: 1px solid #e1e8e1; margin: 15px 0;">
                    <h4 style="margin: 0 0 10px 0; color: #7a8a7a;">Original Appointment Details:</h4>
                    @if($originalDoctorName && $originalDoctorName !== $booking->doctor->name)
                        <div class="details-row">
                            <span class="details-label">Original Doctor:</span>
                            <span class="details-value"><span class="badge-old">Dr. {{ $originalDoctorName }}</span></span>
                        </div>
                    @endif
                    @if($originalDate)
                        <div class="details-row">
                            <span class="details-label">Original Date:</span>
                            <span class="details-value"><span class="badge-old">{{ \Carbon\Carbon::parse($originalDate)->format('d M Y') }}</span></span>
                        </div>
                    @endif
                    @if($originalTime)
                        <div class="details-row">
                            <span class="details-label">Original Time:</span>
                            <span class="details-value"><span class="badge-old">{{ \Carbon\Carbon::parse($originalTime)->format('h:i A') }}</span></span>
                        </div>
                    @endif
                @endif
            </div>

            <p>Please log in to your doctor dashboard to review and approve this rescheduled appointment request.</p>
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
