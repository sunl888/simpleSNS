<!DOCTYPE html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('a6263d75a70c21778735', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('USER_ID_' + 1);
        channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function (data) {
            alert(data.message);
        });
    </script>
</head>