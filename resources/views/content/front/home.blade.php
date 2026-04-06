@extends('layouts.front.layout')

@section('title', __('Home'))

@section('content')
<!--===== WELCOME STARTS =======-->
    <div class="slider-carousel-area owl-carousel">
        <div class="welcome6-section-area">
            <img src="{{ asset('front/assets/img/images/homepage6-bg.png') }}" alt="" class="homepage6-bg">
            <div class="lawer-images">
                <img src="{{ asset('front/assets/img/icons/law-img7.png') }}" alt="" class="law">
                <img src="{{ asset('front/assets/img/bacground/Polygon1.png') }}" alt="" class="Polygon1">
                <img src="{{ asset('front/assets/img/bacground/Polygon2.png') }}" alt="" class="Polygon2">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="welcome6-header-area">
                            <span data-aos="fade-left" data-aos-duration="800">Dedicated Personal Injury Representation</span>
                            <h1 data-aos="fade-left" data-aos-duration="900">Injury Compensation Starts Here: Proven Legal Representation</h1>
                            <p data-aos="fade-left" data-aos-duration="1000">Our team of dedicated & experienced attorneys is committed to guiding you through this difficult time, we believe in empowering our clients.</p>
                          <div class="div" data-aos="fade-left" data-aos-duration="1200">
                            <a href="{{ route('login') }}" class="welcome6-btn">{{ __('Login') }} <i class="fa-light fa-arrow-right"></i></a>
                            <a href="{{ route('register') }}" class="welcome7-btn">{{ __('Register') }} <i class="fa-light fa-arrow-right"></i></a>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4" >
                        <div class="welcome6-elements-area">
                            <div class="polygon-author aniamtion-key-1" style="background-image: url({{ asset('front/assets/img/elements/elementor33.svg') }}); background-position: center; background-repeat: no-repeat; background-size: cover; display: inline-block;">
                                <div class="polygon-arrow">
                                    <span><a href="contact1.html"><i class="fa-regular fa-arrow-right"></i></a></span>
                                <a href="contact1.html">Free Case Review</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--===== WELCOME ENDS =======-->

<!--===== ABOUT STARTS =======-->
    <div class="about6-section-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about6-header">
                        <span data-aos="fade-right" data-aos-duration="800">About Us</span>
                        <h2 data-aos="fade-right" data-aos-duration="1000">Your Recovery: Personalized & Support for Injury Cases</h2>
                        <p data-aos="fade-right" data-aos-duration="1200">Our team of dedicated & experienced attorneys is committed to guiding you through this difficult time, we believe in empowering our clients.</p>
                        {{-- <div class="about6-tabs" data-aos="fade-right" data-aos-duration="1200">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Expertise</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Client-Centric Approach</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                  <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Successful Case</button>
                                </li>
                              </ul>
                              <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                    <div class="tabs-author-area2">
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Investigate & Evidence Gathering</a></li>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Transparent Communication</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Advocacy and Negotiation</a></li>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Maximized Compensation</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                    <div class="tabs-author-area2">
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Investigate & Evidence Gathering</a></li>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Transparent Communication</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Advocacy and Negotiation</a></li>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Maximized Compensation</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                    <div class="tabs-author-area2">
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Investigate & Evidence Gathering</a></li>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Transparent Communication</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Advocacy and Negotiation</a></li>
                                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check8.svg') }}" alt="">Maximized Compensation</a></li>
                                        </ul>
                                    </div>
                                </div>
                              </div>
                        </div> --}}
                        <p data-aos="fade-right" data-aos-duration="1000">Strong advocacy on your behalf, including negotiation with insurance companies or opposing parties to achieve a fair settlement.</p>
                        <div class="div" data-aos="fade-right" data-aos-duration="1200">
                            <a href="about.html" class="about7-btn">Talk to an Attorney <i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about6-images-area" data-aos="zoom-out" data-aos-duration="1000">
                        <img src="{{ asset('front/assets/img/elements/elementor34.png') }}" alt="" class="elementor34 keyframe5">
                        <img src="{{ asset('front/assets/img/images/about6-img1.png') }}" alt="" class="about6-img1">
                        <img src="{{ asset('front/assets/img/images/about6-img2.png') }}" alt="" class="about6-img2 aniamtion-key-1">
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--===== ABOUT ENDS =======-->

<!--===== SERVICES STARTS =======-->
    <div class="service6-section-area sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 m-auto">
                    <div class="service6-header text-center">
                        <span data-aos="fade-up" data-aos-duration="800">Practice Areas</span>
                        <h2 data-aos="fade-up" data-aos-duration="1000">Our Practice Areas</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="800">
                    <div class="service6-boxarea">
                        <div class="service6-img">
                            <img src="{{ asset('front/assets/img/images/service6-img1.png') }}" alt="">
                        </div>
                        <div class="service-arrow-btn text-center">
                            <a href="#"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                        <div class="service-content text-center">
                            <a href="service-single.html">Auto Accidents</a>
                            <div class="readmore">
                                <a href="service-single.html">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                    <div class="service6-boxarea">
                        <div class="service6-img">
                            <img src="{{ asset('front/assets/img/images/service6-img2.png') }}" alt="">
                        </div>
                        <div class="service-arrow-btn text-center">
                            <a href="#"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                        <div class="service-content text-center">
                            <a href="service-single.html">Workplace Injuries</a>
                            <div class="readmore">
                                <a href="service-single.html">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1200">
                    <div class="service6-boxarea">
                        <div class="service6-img">
                            <img src="{{ asset('front/assets/img/images/service6-img3.png') }}" alt="">
                        </div>
                        <div class="service-arrow-btn text-center">
                            <a href="#"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                        <div class="service-content text-center">
                            <a href="service-single.html">Medical Malpractice</a>
                            <div class="readmore">
                                <a href="service-single.html">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1000">
                    <div class="service6-boxarea">
                        <div class="service6-img">
                            <img src="{{ asset('front/assets/img/images/service6-img4.png') }}" alt="">
                        </div>
                        <div class="service-arrow-btn text-center">
                            <a href="#"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                        <div class="service-content text-center">
                            <a href="service-single.html">Slip and Fall Accidents</a>
                            <div class="readmore">
                                <a href="service-single.html">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1200">
                    <div class="service6-boxarea">
                        <div class="service6-img">
                            <img src="{{ asset('front/assets/img/images/service6-img5.png') }}" alt="">
                        </div>
                        <div class="service-arrow-btn text-center">
                            <a href="#"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                        <div class="service-content text-center">
                            <a href="service-single.html">Product Liability</a>
                            <div class="readmore">
                                <a href="service-single.html">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="1400">
                    <div class="service6-boxarea">
                        <div class="service6-img">
                            <img src="{{ asset('front/assets/img/images/service6-img6.png') }}" alt="">
                        </div>
                        <div class="service-arrow-btn text-center">
                            <a href="#"><i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                        <div class="service-content text-center">
                            <a href="service-single.html">Wrongful Death</a>
                            <div class="readmore">
                                <a href="service-single.html">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-12 m-auto" data-aos="fade-up" data-aos-duration="1200">
                    <div class="div text-center">
                        <a href="service1.html" class="about7-btn">View More Practice Areas <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--===== SERVICES ENDS =======-->

<!--===== SERVICES-2 STARTS =======-->
{{-- <div class="service-2-section-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="services-all-images">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="service-img1" data-aos="zoom-in" data-aos-duration="1000">
                                <img src="{{ asset('front/assets/img/images/service6-img7.png') }}" alt="">
                                <img src="{{ asset('front/assets/img/elements/elementor34.png') }}" alt="" class="elementor34 keyframe5">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="second-service-img">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="images" data-aos="zoom-in" data-aos-duration="1200">
                                            <img src="{{ asset('front/assets/img/images/service6-img8.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="space20"></div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="images" data-aos="zoom-in" data-aos-duration="1400">
                                            <img src="{{ asset('front/assets/img/images/service6-img9.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="service-2-header-area">
                    <span data-aos="fade-left" data-aos-duration="600">Service Benefits</span>
                    <h2 data-aos="fade-left" data-aos-duration="800">Our Firm Distinct Practice Areas And Injury Claims</h2>
                    <p class="pera-header" data-aos="fade-left" data-aos-duration="1000">“In the face of adversity, resilience is our armor, fortifying us against life's storms. It's the unwavering belief that within every challenge lies an opportunity for growth.”</p>
                    <div class="list-area" data-aos="fade-left" data-aos-duration="1200">
                        <ul>
                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check-img6.svg') }}" alt="">Legal Expertise</a></li>
                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check-img6.svg') }}" alt="">Focus on Recovery</a></li>
                        </ul>
                        <ul>
                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check-img6.svg') }}" alt="">Legal Expertise</a></li>
                            <li><a href="#"><img src="{{ asset('front/assets/img/icons/check-img6.svg') }}" alt="">Focus on Recovery</a></li>
                        </ul>
                    </div>
                    <p data-aos="fade-left" data-aos-duration="1400">Conducting detailed investigations and gathering evidence to build a strong case, ensuring no stone is left upturned in pursuit of justice.</p>
                    <div class="div" data-aos="fade-left" data-aos-duration="1200">
                        <a href="service2.html" class="about7-btn">Talk to an Attorney <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!--===== SEVICES-2 ENDS =======-->

<!--===== OTERS STARTS =======-->
<div class="others6-section-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-headlines" >
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Workplace Injuries  <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Medical Malpractice <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Product Liability <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>
                    <div class="text-headlines__item" >Auto Accidents <img src="{{ asset('front/assets/img/icons/start-icon.svg') }}" alt=""></div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--===== OTHERS ENDS =======-->

<!--===== TEAM STARTS =======-->
<div class="team6-section-area sp3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="team6-header text-center">
                    <span data-aos="fade-up" data-aos-duration="800">Our Team</span>
                    <h2 data-aos="fade-up" data-aos-duration="1000">Our Legal Support Team</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="800">
                <div class="team6-main-boxarea">
                    <div class="team6-boxarea">
                        <div class="team6-img">
                            <img src="{{ asset('front/assets/img/images/team6-img1.png') }}" alt="">
                        </div>
                        <div class="team6-images">
                            <img src="{{ asset('front/assets/img/bacground/polygon3.png') }}" alt="" class="polygon3">
                            <img src="{{ asset('front/assets/img/bacground/polygon4.png') }}" alt="" class="polygon4">
                        </div>
                        <div class="social-links">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="team-content text-center">
                        <a href="team1.html">Jofra Archer</a>
                        <p>Founder Partner</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="1000">
                <div class="team6-main-boxarea">
                    <div class="team6-boxarea">
                        <div class="team6-img">
                            <img src="{{ asset('front/assets/img/images/team6-img2.png') }}" alt="">
                        </div>
                        <div class="team6-images">
                            <img src="{{ asset('front/assets/img/bacground/polygon3.png') }}" alt="" class="polygon3">
                            <img src="{{ asset('front/assets/img/bacground/polygon4.png') }}" alt="" class="polygon4">
                        </div>
                        <div class="social-links">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="team-content text-center">
                        <a href="team1.html">Mitchel Starc</a>
                        <p>Senior Attorneys</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="1200">
                <div class="team6-main-boxarea">
                    <div class="team6-boxarea">
                        <div class="team6-img">
                            <img src="{{ asset('front/assets/img/images/team6-img1.png') }}" alt="">
                        </div>
                        <div class="team6-images">
                            <img src="{{ asset('front/assets/img/bacground/polygon3.png') }}" alt="" class="polygon3">
                            <img src="{{ asset('front/assets/img/bacground/polygon4.png') }}" alt="" class="polygon4">
                        </div>
                        <div class="social-links">
                            <ul>
                                <li><a href="#"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="team-content text-center">
                        <a href="team1.html">MD. Saifuddin</a>
                        <p>Personal Injury Law</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--===== TEAM ENDS =======-->

<!--===== TESTIMONIAL STARTS =======-->
<div class="testimonial-main-setion-area sp1">
   <div class="container">
    <div class="row">
        <div class="col-lg-4 m-auto">
            <div class="testimonial6-header text-center">
                <span data-aos="fade-up" data-aos-duration="800">Testimonials</span>
                <h2 data-aos="fade-up" data-aos-duration="1000">See What Clients Say About Our Lawyer</h2>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-lg-5">
            <div class="testimonial6-imges" data-aos="zoom-out" data-aos-duration="1000">
                <img src="{{ asset('front/assets/img/images/testimonial6-img1.png') }}" alt="">
            </div>
        </div>
        <div class="col-lg-7">
            <div class="testimonial-auhtor-main-area owl-carousel">
                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial6-auhtor-boxarea">
                    <div class="quitop-img">
                        <img src="{{ asset('front/assets/img/icons/quito9.svg') }}" alt="">
                    </div>
                    <div class="testimonial6-content">
                        <p>“I should be incapable of drawing a single stroke at the present moment; and yet I feel that I never was a best greater artist than now. The lovely valley teems with vapor around me, & the meridian sun strikes.</p>
                        <div class="testimonial-man">
                            <div class="img">
                                <img src="{{ asset('front/assets/img/images/testimonial6-img2.png') }}" alt="">
                            </div>
                            <div class="content">
                                <a href="team1.html">Shakib Mahmud</a>
                                <p>Operating Officer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>
<!--===== TESTIMONIAL ENDS =======-->

<!--===== BLOG STARTS =======-->
<div class="blog-6-section-area sp1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="blog6-header">
                    <span data-aos="fade-up" data-aos-duration="800">Our Recent Blog Post</span>
                    <h2 data-aos="fade-up" data-aos-duration="1000">Our Latest News & Blog</h2>
                    <p data-aos="fade-up" data-aos-duration="1100">Legal matters can be daunting, but understanding your rights <br> and options is key to navigating the complexities of the law.</p>
                    <div class="div" data-aos="fade-up" data-aos-duration="1200">
                        <a href="blog1.html" class="about7-btn">Read More Blogs <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="blo6-author-area" data-aos="fade-up" data-aos-duration="1000">
                    <div class="row align-items-center">
                        <div class="col-lg-6" data-aos="">
                            <div class="blog-img1">
                                <img src="{{ asset('front/assets/img/images/blog6-img1.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="blog-content1">
                                <a href="blog-single.html">Clearing the Fog Around Our Best Common Legal Issues</a>
                                <p>We believe that every individual deserves accessible & reliable legal best counsel.</p>
                                <a href="blog-single.html" class="readmore">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space24"></div>
                <div class="blo6-author-area" data-aos="fade-up" data-aos-duration="1200">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="blog-img1">
                                <img src="{{ asset('front/assets/img/images/blog6-img2.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="blog-content1">
                                <a href="blog-single.html">Clearing the Fog Around Our Best Common Legal Issues</a>
                                <p>We believe that every individual deserves accessible & reliable legal best counsel.</p>
                                <a href="blog-single.html" class="readmore">Read More <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== BLOG ENDS =======-->

<!--===== CONTACT STARTS =======-->
<div class="contact6-section-area sp1">
  <div class="container">
    <div class="row">
        <div class="col-lg-5 m-auto">
            <div class="contact6-header text-center">
                <span data-aos="fade-up" data-aos-duration="800">Contact Us</span>
                <h2 data-aos="fade-up" data-aos-duration="1000">Connect with Our Lawsy Lawyer Legal Team Today</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="contact-main-area" data-aos="zoom-in" data-aos-duration="1000">
                <h3>Send Us A Message</h3>
                <p>Our response time is within 30 minutes during business hours</p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-placeholder">
                            <input type="text" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-placeholder">
                            <input type="text" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="contact-placeholder">
                            <input type="text" placeholder="Phone Number">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-placeholder">
                            <input type="text" placeholder="Email Adderss">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-placeholder">
                            <input type="text" placeholder="Subject Name">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-placeholder">
                            <textarea placeholder="Message" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-placeholder">
                            <button type="submit">Free Case Evulation <i class="fa-regular fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
        {{-- <div class="col-lg-6">
            <div class="contact-google-maps" data-aos="zoom-in" data-aos-duration="1200">
                <div class="mapouter">
                    <div class="gmap_canvas">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4506257.120552435!2d88.67021924228865!3d21.954385721237916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1704088968016!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    </div>
            </div>
        </div> --}}
    </div>
</div>
</div>
<!--===== CONTACT ENDS =======-->

<!--===== CTA STARTS =======-->
<div class="cta6-section-area sp4" style="background-image: url({{ asset('front/assets/img/images/cta-bg1.png') }}); background-position: center; background-size: cover; background-repeat: no-repeat;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="cta6-header-area">
          <h2 data-aos="fade-up" data-aos-duration="800">Contact Us Insightful Advice</h2>
          <P data-aos="fade-up" data-aos-duration="1000">We prioritize understanding your unique situation & offer tailored strategies <br> that align with your goals, don't navigate the legal maze alone – schedule.</P>
          <div class="div" data-aos="fade-up" data-aos-duration="1200">
            <a href="contact1.html" class="welcome6-btn">Book Case Evaluation <i class="fa-light fa-arrow-right"></i></a>
            <a href="contact2.html" class="welcome7-btn">Contact Us <i class="fa-light fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
       <div class="cta-contact-area">
        <div class="row">
          <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-duration="800">
            <div class="cta5-author-area">
              <div class="cta5-icons">
                <img src="{{ asset('front/assets/img/icons/call-img3.svg') }}" alt="">
              </div>
              <div class="cta5-content">
                <p>Call Us 24/7</p>
                <a href="tel:+1234567890">+123 456 7890</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6" data-aos="zoom-in" data-aos-duration="1000">
            <div class="cta5-author-area">
              <div class="cta5-icons">
                <img src="{{ asset('front/assets/img/icons/email-img1.svg') }}" alt="">
              </div>
              <div class="cta5-content">
                <p>Mail Us Anytime</p>
                <a href="mailto:Lawsy@gmail.com">Lawsy@gmail.com</a>
              </div>
            </div>
          </div>

        </div>
       </div>
      </div>
    </div>
  </div>
</div>
<!--===== CTA ENDS =======-->
@endsection
