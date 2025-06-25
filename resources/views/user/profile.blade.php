@extends('layouts.app')

@section('title', 'لوحة تحكم المستخدم')

@section('content')
<section class="nav-container user-page-nav container-fluid">
  <div class="container">

    {{-- breadcrumb --}}
    <div class="row">
      <ul class="path">
        <li><a href="{{route('user.dashboard')}}">الرئيسية <i class="bi bi-arrow-left-short"></i></a></li>
        <li> لوحة التحكم </li>
      </ul>
    </div>
    
  </div>
</section>
<div class="container-fluid user-container">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <x-user.navigation />
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-9 mx-auto">
                        <div class="card shadow mb-5">
                            <div class="card-header p-3">
                                <h4 class="fs-6 mb-0">الملف الشخصي للمستخدم</h4>
                            </div>
                            <div class="card-body">

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="profile-pic row">
                                    <div class="col-md-3">
                                        <img class="rounded shadow-sm" src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile-photos/default.webp') }}" alt="" />
                                    </div>
                                    <div class="col-md-8 align-items-center d-flex">
                                        <input type="file" name="profile_photo" form="profile-form" class="form-control">
                                    </div>
                                </div>

                                <div class="other-details mt-4">
                                    <form id="profile-form" method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row row">
                                            <div class="col-md-6">
                                                <label class="mb-1 pt-0">الاسم الكامل</label>
                                                <input type="text" name="name" class="form-control" placeholder="أدخل الاسم الكامل" value="{{ old('name', $user->name) }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-1 pt-0">البريد الإلكتروني</label>
                                                <input disabled class="form-control" placeholder="أدخل البريد الإلكتروني" value="{{ $user->email }}" />
                                            </div>
                                        </div>

                                        <div class="form-row row mt-3">
                                            <div class="col-md-6">
                                                <label class="mb-1 pt-0">رقم الجوال</label>
                                                <input type="text" name="phone" class="form-control" placeholder="أدخل رقم الجوال" value="{{ old('phone', $user->phone) }}" />
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-1 pt-0">نبذة عنك</label>
                                                <input type="text" name="bio" class="form-control" placeholder="أدخل نبذة مختصرة" value="{{ old('bio', $user->bio) }}" />
                                            </div>
                                        </div>

                                        <div class="form-row row mt-3">
                                            <div class="col-md-6 text-end">
                                                <button class="btn btn-primary">تحديث الملف الشخصي</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection