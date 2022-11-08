<!DOCTYPE html>
<html>
<head>
    <title>XGuard BI</title>
    <link href="{{ secure_asset(mix("app.css", 'vendor/xguard-bi')) }}?v={{config('bi.version')}}"
          rel="stylesheet" type="text/css">
</head>
<body>
<div id="app"></div>
<script
    src="{{ secure_asset(mix('app.js', 'vendor/xguard-bi')) }}?v={{config('bi.version')}}"></script>
</body>
</html>
