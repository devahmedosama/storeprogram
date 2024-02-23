@include('admin.content.header')
@include('admin.content.sidebar')
<div class="page-container">
	<div class="main-content">
	         	@if (session('yes'))
            <div class="alert alert-success">
                {{ session('yes') }}
            </div>
            @endif
            @if (session('no'))
            <div class="alert alert-danger">
                {{ session('no') }}
            </div>
            @endif

          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
        @yield('content')
    </div>
@include('admin.content.footer')