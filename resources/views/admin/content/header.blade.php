<!DOCTYPE html>
<?php 
        $lang =  App::getLocale();
        $setting  =  App\Models\Setting::first();
?>
<html lang="{{ $lang }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ (isset($title))?$title:$setting->title }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::to('assets/site/images/logo4.png') }}">

    <!-- page css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Core css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    @if($lang == 'ar')
    <link href="{{ URL::to('assets/admin') }}/css/app_ar.css" rel="stylesheet">
    @else
    <link href="{{ URL::to('assets/admin') }}/css/app.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" type="text/css" href="{{ URL::to('assets/admin/css/style.css') }}">
    
    @if($lang == 'ar')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('assets/admin/css/style_ar.css') }}">
    @endif
    <style>
        
    </style>
</head>

<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <div class="header">
                <div class="logo logo-dark" style="background: #3a89a7;">
                    <a href="{{ URL::to('admin') }}">
                        <img src="{{ URL::to($setting->logo) }}" alt="Logo" height="70">
                        <img class="logo-fold" src="{{ URL::to($setting->logo) }}" alt="Logo" height="70">
                    </a>
                </div>
                <div class="logo logo-white">
                    <a href="{{ URL::to('admin') }}">
                        <img src="{{ URL::to('assets/site/images/logo4.png') }}" alt="Logo">
                        <img class="logo-fold" src="{{ URL::to('assets/site/images/logo4.png') }}" alt="Logo">
                    </a>
                </div>
                <div class="nav-wrap">
                   <ul class="nav-left">
                      <li class="desktop-toggle">
                         <a href="javascript:void(0);">
                         <i class="anticon"></i>
                         </a>
                      </li>
                      <li class="mobile-toggle">
                         <a href="javascript:void(0);">
                         <i class="anticon"></i>
                         </a>
                      </li>
                      
                      </li>
                   </ul>
                   
                </div>
            </div>    
            <!-- Header END -->