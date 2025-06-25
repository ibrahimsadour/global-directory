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
                    <div class="col-md-8 mx-auto">
                        <div class="card side-card">
                            <div class="card-header">تغيير كلمة المرور</div>
                            <div class="card-body">
                                @if (session('status') === 'password-updated')
                                    <div class="alert alert-success mb-3">
                                        تم تحديث كلمة المرور بنجاح.
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('user.password.update') }}" class="p-4" id="catform">
                                    @csrf

                                    <div class="form-row row">
                                        <div class="col-sm-4"><label>كلمة المرور القديمة</label><span class="spcol">:</span></div>
                                        <div class="col-sm-8 sticky">
                                            <input type="password" name="oldpassword" class="form-control" placeholder="أدخل كلمة المرور القديمة" required />
                                            @error('oldpassword')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row row">
                                        <div class="col-sm-4"><label>كلمة المرور الجديدة</label><span class="spcol">:</span></div>
                                        <div class="col-sm-8 sticky">
                                            <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور الجديدة" required />
                                            @error('password')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row row">
                                        <div class="col-sm-4"><label>تأكيد كلمة المرور</label><span class="spcol">:</span></div>
                                        <div class="col-sm-8 sticky">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="أعد إدخال كلمة المرور" required />
                                        </div>
                                    </div>

                                    <div class="form-row row mb-0">
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-8 text-end">
                                            <button type="submit" class="btn btn-primary">تحديث كلمة المرور</button>
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


@endsection