@extends('layouts.app')

@section('title', 'Home')

@section('content')

@if(Auth::user()->hasRole('developer') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('administrator') || Auth::user()->hasRole('manager'))
<section class="content-header">
    <h1 style="font-family:Titillium Web, sans-serif">
    Welcome To MarketPlace Blog Dashboard
  </h1>
</section>
@endif

<!-- Main content -->
<section class="content">
    <div class="row">

        @if(Auth::user()->hasRole('developer') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('administrator') || Auth::user()->hasRole('manager'))
        <div class="col-lg-4">
            <a href="#">
            <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-light-blue"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number">{{ $usersCount[0]->usersCount }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
          </a>
        </div>
     @endif

        @if(Auth::user()->hasRole('developer') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('administrator') || Auth::user()->hasRole('manager'))
        <div class="col-lg-4">
            <a href="#">
            <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-light-blue"><i class="fa fa-square"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Posts</span>
              <span class="info-box-number">{{ $postsCount[0]->postsCount }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
         </a>
        </div>

        <div class="col-lg-4">
            <a href="#">
            <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-indent"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Categories</span>
              <span class="info-box-number">{{ $categoriesCount[0]->categoriesCount }}</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
           </a>
        </div>
     @endif


     @if(Auth::user()->hasRole('developer') || Auth::user()->hasRole('staff') || Auth::user()->hasRole('administrator') || Auth::user()->hasRole('manager'))
     <div class="col-lg-4">
         <a href="#">
         <div class="info-box">
         <!-- Apply any bg-* class to to the icon to color it -->
         <span class="info-box-icon bg-light-blue"><i class="fa fa-user-plus"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Subscribers</span>
           <span class="info-box-number">{{ $subscribersCount[0]->subscribersCount }}</span>
         </div><!-- /.info-box-content -->
       </div><!-- /.info-box -->
      </a>
     </div>

      <div class="col-lg-4">
         <a href="#">
         <div class="info-box">
         <!-- Apply any bg-* class to to the icon to color it -->
         <span class="info-box-icon bg-blue"><i class="fa fa-comment"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Comments</span>
           <span class="info-box-number">{{ $commentsCount[0]->commentsCount }}</span>
         </div><!-- /.info-box-content -->
       </div><!-- /.info-box -->
        </a>
     </div>


    {{--<div class="col-lg-4">
    <a href="{{ url('/request-customer') }}">
            <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-registered"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Request</span>
              <span class="info-box-number">9</span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
           </a>
    </div> --}}
    @endif

</section>

@endsection
