<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>simpleSNS</title>
    <style>
         @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(../../fonts/iconfont/MaterialIcons-Regular.eot); /* For IE6-8 */
            src: local('Material Icons'),
            local('MaterialIcons-Regular'),
            url(../../fonts/iconfont/MaterialIcons-Regular.woff2) format('woff2'),
            url(../../fonts/iconfont/MaterialIcons-Regular.woff) format('woff'),
            url(../../fonts/iconfont/MaterialIcons-Regular.ttf) format('truetype');
        }
        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px; /* Preferred icon size */
            display: inline-block;
            width: 1em;
            height: 1em;
            line-height: 1;
            text-transform: none;
            /* Support for all WebKit browsers. */
            -webkit-font-smoothing: antialiased;
            /* Support for Safari and Chrome. */
            text-rendering: optimizeLegibility;
            /* Support for Firefox. */
            -moz-osx-font-smoothing: grayscale;
            /* Support for IE. */
            font-feature-settings: 'liga';
        }
    </style>
</head>
<body>
<div id="app"></div>
<script>
    //
</script>
<script src="{{cdn(mix('js/app.js'))}}"></script>
</body>
</html>
