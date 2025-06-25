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
                <div class="latest-reviews business-listing">
                    <div class="row shadow-sm list-row border rounded">
                        <div class="col-lg-4 pe-0 img-col">
                            <a href="https://directory.smarteyeapps.com/view/124-st-al-farwaniya"><img class="rounded" src="/storage/business/resize/default.png" alt="" /></a>
                        </div>
                        <div class="col-lg-8 detail-col">
                            <a href="https://directory.smarteyeapps.com/view/124-st-al-farwaniya">
                                <div class="bofy-col">
                                    <h2 class="text-truncate">124 St Al Farwaniya</h2>
                                    <p class="text-truncate">Website: https://kw-service.com/ WhatsApp: Enter Whatsapp Nummber The whatsapp field is required. Address</p>
                                    <ul class="row ms-1">
                                        <li class="col-md-4"><i class="bi bi-telephone"></i> 0685125822</li>
                                        <li class="col-md-8"><i class="bi bi-envelope"></i> i.m.s.1995@hotmail.com</li>
                                    </ul>
                                    <ul class="row ms-1">
                                        <li class="col-md-4"><i class="bi bi-map"></i> Sydney</li>
                                        <li class="col-md-8">
                                            <p class="text-truncate"><i class="bi bi-geo-alt text-truncate"></i> 12 St Al Farwaniya Block 6318 apartment 3</p>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            <div class="footcover pe-0">
                                <ul>
                                    <li class="rev"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><small> (0 Reviews)</small></li>
                                    <li class="actionlist">
                                        <span>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i> Delete</button>
                                            <a href="https://directory.smarteyeapps.com/listing/29/edit">
                                                <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row shadow-sm list-row border rounded">
                        <div class="col-lg-4 pe-0 img-col">
                            <a href="https://directory.smarteyeapps.com/view/aaa"><img class="rounded" src="/storage/business/resize/default.png" alt="" /></a>
                        </div>
                        <div class="col-lg-8 detail-col">
                            <a href="https://directory.smarteyeapps.com/view/aaa">
                                <div class="bofy-col">
                                    <h2 class="text-truncate">AAA</h2>
                                    <p class="text-truncate">AAA gdfgfgdfgdf dfgdfgdfgfd dfgdfgdfgdfgdf fasdasdasd fasfsdfds vfsfdsfdsfds cfdsfdsfdsf c gfdsfdsf fdsfdsfdsf</p>
                                    <ul class="row ms-1">
                                        <li class="col-md-4"><i class="bi bi-telephone"></i> 01010115555</li>
                                        <li class="col-md-8"><i class="bi bi-envelope"></i> test1234@happ.com</li>
                                    </ul>
                                    <ul class="row ms-1">
                                        <li class="col-md-4"><i class="bi bi-map"></i> New York</li>
                                        <li class="col-md-8">
                                            <p class="text-truncate"><i class="bi bi-geo-alt text-truncate"></i> fdfdfdsfds</p>
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            <div class="footcover pe-0">
                                <ul>
                                    <li class="rev"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><small> (0 Reviews)</small></li>
                                    <li class="actionlist">
                                        <span>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i> Delete</button>
                                            <a href="https://directory.smarteyeapps.com/listing/27/edit">
                                                <button class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button>
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6 pt-2"></div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item disabled"><div class="page-link">« Previous</div></li>
                                        <li class="page-item active">
                                            <a class="page-link" href="https://directory.smarteyeapps.com/my-listing?page=1"><span>1</span></a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="https://directory.smarteyeapps.com/my-listing?page=2"><span>2</span></a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link" href="https://directory.smarteyeapps.com/my-listing?page=2"><span>Next »</span></a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection