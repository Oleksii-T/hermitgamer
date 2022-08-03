@extends('layouts.app')

@section('content')
    <div class="wrapper_main">
        <main class="content">
            <section class="offer">
                <div class="container">
                    <h1>
                        Practice day trading the market, without risking a single penny
                    </h1>
                    <span>
                        Use TradingSim to test strategies, boost confidence, and increase your profitability.
                    </span>
                    <a href="#" class="btn btn-standart btn-blue" style="margin-top: 40px">Sign Up</a>
                </div>
                {{-- <div class="offer-image">
                    <img src="https://www.tradingreps.com/assets/website/img/graf.svg">
                </div> --}}
            </section>
            {{-- <section class="tracker">
                <div class="container">
                    <div class="tracker-image">
                        <img src="https://www.tradingreps.com/assets/website/img/tracker.png" alt="tracker">
                    </div>
                </div>
            </section> --}}
            <section class="features pd-100">
                <div class="container">
                    <h2>Our Features</h2>
                    <span>Boost up your work with advance and flexible features</span>

                    <div class="feature-items">
                        <div class="feature-item">
                            <img src="{{asset('img/food-8.svg')}}">
                            <h3>Load Simulation</h3>
                            <p>Load and simulate personal charts with different data</p>
                        </div>
                        <div class="feature-item">
                            <img src="{{asset('img/food-12.svg')}}">
                            <h3>Charts</h3>
                            <p>Set up different type of charts on your dashboard</p>
                        </div>
                        <div class="feature-item">
                            <img src="{{asset('img/food-10.svg')}}">
                            <h3>Market Scanner</h3>
                            <p>Personal market scanner to make your simulation</p>
                        </div>
                        <div class="feature-item">
                            <img src="{{asset('img/food-11.svg')}}">
                            <h3>Analytics</h3>
                            <p>Best analytic tools for simulated charts</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="about-us pd-100">
                <div class="container">
                    <h2>About Us</h2>
                    <span>Some information about our company</span>
                    <div class="about-us-items">
                        <div class="about-us-item">
                            <div class="image">
                                <img src="{{asset('img/food-1.png')}}">
                            </div>
                            <div class="text --right">
                                <h3>What we believe</h3>
                                <p>At Company we believe that traders are made not born. We feel that regardless of your background or financial situation you can achieve consistency in trading.</p>
                                <p>We do not subscribe to the idea you can follow someone else's trades or alerts to profits. We think that trading is more than money and is the ultimate test of oneself.</p>
                                <p>We are learning from our customers everyday and will not rest until everyone has a fair shot at building sustainable financial freedom.</p>
                            </div>
                        </div>
                        <div class="about-us-item">
                            <div class="text --left">
                                <h3>We don't create charts, we create freedom</h3>
                                <p>At Company we believe that traders are made not born. We feel that regardless of your background or financial situation you can achieve consistency in trading.</p>
                                <p>We do not subscribe to the idea you can follow someone else's trades or alerts to profits. We think that trading is more than money and is the ultimate test of oneself.</p>
                                <p>We are learning from our customers everyday and will not rest until everyone has a fair shot at building sustainable financial freedom.</p>
                            </div>
                            <div class="image">
                                <img src="{{asset('img/food-7.png')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-footer />
    </div>
@endsection
