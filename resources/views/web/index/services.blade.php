@extends('web.index')
@section('title')
    الخدمات
@endsection

@section('content')
    <section class="container-fluid" style="background:#00a8ff;color: white">
        <div class="container">
            <div class="text-center d-flex justify-content-center align-items-center" style="height:254px;">
                <div>
                    <h2 style="margin-bottom: 30px;">خدمات الشحرى</h2>
                    <h4>لا أحد يحب الألم بذاته، يسعى ورائه أو يبتغيه، ببساطة لأنه الألم...</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid">
        <div class="container">
            <div class="row" style="padding: 50px 0">
                <div class="col-lg-4 col-xl-4 float-right services-manu">
                    <div class="box-services-shadow" style="margin-bottom: 20px">
                        @foreach( service() as $service )
                        <h6 class="h6-services"><a data-services="services{{ $service->id }}" class="services-not-active {{ request()->is('services' . $service->id) ? "services-active" : "" }}" href="">{{ $service->title }}</a></h6>
                        @endforeach
                    </div>
                </div>
                @foreach( service() as $service)
                <div class="col-lg-8 col-xl-8 float-left services-block" style="margin: 0 auto 0 0;" id="services{{ $service->id }}">
                    <div class="box-services-info-shadow">
                        <div>
                            <img class="img-fluid w-100" src="{{asset('storage/'.$service->image)}}" alt="">
                        </div>
                        <div style="padding: 25px;">
                            <h6 style="font-size: 25px;margin-bottom: 20px;">{{ $service->title }}</h6>
                            <div class="text-justify">
                                <p>{{ $service->body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="container-fluid background5 float-right" id="special-service">
        <div class="container text-center language-arabic text-white">
            <div  class="d-flex justify-content-center align-items-center" style="height: 463px">
                <div>
                    <div class="d-block">
                        <h2 style="font-size: 40px;">الخدمة الخاصة : استئجار حافلة مع سائق</h2>
                    </div>
                    <div class="d-block mt-5">
                        <button class="text-white border-0 pt-2 pb-2 pr-5 pl-5" style="background: #487eb0">احجز الان</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid float-right" id="all-call-us" style="background: #ecf2f7">
        <div class="container language-arabic position-relative">
            <div class="col-md-7 float-right all-call-us">
                <div class="d-flex align-items-center" style="height: 463px;">
                    <div>
                        <div style="margin-bottom: 40px;">
                            <h6 style="color: #fbc531;">خط مساعدة دعم العملاء على مدار 24 ساعة طوال أيام الأسبوع</h6>
                        </div>
                        <div style="margin-bottom: 40px;">
                            <h2 id="call-us" class="language-english text-dark" style="font-size: 65px;">Tel. {{ setting()->phone }}</h2>
                        </div>
                        <div style="margin-bottom: 50px;">
                            <h6 class="text-dark" style="font-size: 20px;">خدمة الدعم متوفرة على مدار 24 ساعة في اليوم ، 7 أيام في الأسبوع لمساعدتك في شراء التذاكر الخاصة بك.</h6>
                        </div>
                        <div>
                            <a href="/contact"><button class="text-white border-0 pt-2 pb-2 pr-5 pl-5" style="background: #487eb0">اتصل بنا</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 float-right all-call-us">
                <div style="height: 463px;">
                    <img class="position-absolute" style="bottom: 0;left: 0;width: 100%" src="{{ url('/') }}/elshehry/images/image8.png" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="container-fluid float-right">
        <div class="container language-arabic">
            <div class="" style="height: 396px;">
                <div class="col-md-3 col-sm-12 col-md-12 col-lg-3 col-xl-3  float-right footer1" style="height: 396px;">
                    <div class="position-relative" style="height: inherit">
                        <div class="footer-transform">
                            <p class="">{{ setting()->contact_description }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 float-right footer2" style="height: 396px;">
                    <div class="position-relative" style="height: inherit">
                        <div class="footer-transform">
                            <div class="d-block">
                                {{ setting()->email }}<br>
                                {{ setting()->phone }}
                            </div>
                            <div class="d-block mt-4">
                                {{ setting()->addriss }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 float-right position-relative footer3" style="height: 396px;">
                    <div class="position-relative" style="height: inherit">
                        <div class="footer-transform">
                            <ul class="list-unstyled">
                                <li><a class="footer-link" href="/">الرئيسية</a></li>
                                <li><a class="footer-link" href="/about">عن الشركة</a></li>
                                <li><a class="footer-link" href="/services">خدماتنا</a></li>
                                <li><a class="footer-link" href="/#latest-news">اخر الاخبار</a></li>
                                <li><a class="footer-link" href="#special-service">خدمة خاصة</a></li>
                                <li><a class="footer-link" href="/contact">اتصل بنا</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 col-md-4 col-lg-3 col-xl-3 float-right footer4" style="height: 396px;">
                    <div class="position-relative" style="height: inherit">
                        <div class="footer-transform">
                            <div class="text-center">
                                <img class="img-fluid col-sm-7 col-7 col-md-auto" src="{{ url('/') }}/elshehry/images/sh1.png" alt="">
                            </div>
                            <div class="d-flex text-center mt-4" style="font-size: 30px;">
                                <a class="footer-link" href="{{ setting()->facebook }}"><i class="fab fa-facebook-f col-md-3"></i></a>
                                <a class="footer-link" href="{{ setting()->twitter }}"><i class="fab fa-twitter col-md-3"></i></a>
                                <a class="footer-link" href="{{ setting()->googel }}"><i class="fab fa-instagram col-md-3"></i></a>
                                <a class="footer-link" href="{{ setting()->linkedin }}"><i class="fab fa-linkedin-in col-md-3"></i></a>
                            </div>
                            <div class="text-center mt-4">
                                <h6>
                                    2002 - 2019 جميع الحقوق محفوظة لصالح شركة الاستشارية
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection