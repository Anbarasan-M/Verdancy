<!DOCTYPE html>
<html>
<head>
    <title>Leave Request Notification</title>
</head>
<body>
    <p>Dear Admin,</p>
    <p>A new leave request has been created by {{ $serviceProviderName }} for {{ $leaveDate }}.</p>
    <p>Reason: {{ $leaveReason }}</p>
    <p>Please review the leave request.</p>
</body>
</html>
