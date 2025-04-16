<!DOCTYPE html>
<html>
<head>
    <title>Your Leave Request</title>
</head>
<body>
    <h1>Leave Request Submitted</h1>
    <p>Dear {{ auth()->user()->name }},</p>
    <p>Your leave request for the following date has been successfully submitted:</p>
    <ul>
        <li><strong>Date:</strong> {{ $leaveDate }}</li>
        <li><strong>Reason:</strong> {{ $leaveReason }}</li>
    </ul>
    <p>Thank you.</p>
</body>
</html>
