<!DOCTYPE html>
<html>
<head>
    <title>Order Failed</title>
</head>
<body>
    <h1>Order Failed</h1>
    <p>Dear {{ auth()->user()->name }},</p>
    <p>We regret to inform you that your order could not be placed due to the following error:</p>
    <p>{{ $errorMessage }}</p>
    <p>Please try again or contact support.</p>
</body>
</html>
