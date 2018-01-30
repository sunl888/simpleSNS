<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <script src="{{asset('vendor/lib/pusher.min.js')}}"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('bef3f84fba66da26a514', {
            cluster: 'ap1',
            encrypted: true
        });

        var channel = pusher.subscribe('USER_ID_1');
        channel.bind('App\\Events\\PusherEvent', function (data) {
            console.log(data);
        });
    </script>
</head>
<body>

</body>
</html>