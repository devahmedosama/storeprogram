 <!-- Favicon -->
 <link rel="shortcut icon" href="{{ URL::to('assets/site/images/logo4.png') }}">

<!-- page css -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Core css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<link href="{{ URL::to('assets/admin') }}/css/app.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ URL::to('assets/admin/css/style.css') }}">
@if($lang == 'ar')
<link rel="stylesheet" type="text/css" href="{{ URL::to('assets/admin/css/style_ar.css') }}">
@endif