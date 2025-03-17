<header class="header-area">
    <div class="top-header">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <!-- Breaking News Area -->
                <x-frontend.header.breaking-news-area :breakingNews="$breakingNews"/>
                <!-- Stock News Area -->
                <div class="col-12 col-md-6">
                    <div class="stock-news-area">
                        <div id="stockNewsTicker" class="ticker">
                            <ul>
                                <li>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>eur/usd</span>
                                            <span>1.1862</span>
                                        </div>
                                        <div class="stock-index minus-index">
                                            <h4>0.18</h4>
                                        </div>
                                    </div>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>BTC/usd</span>
                                            <span>15.674.99</span>
                                        </div>
                                        <div class="stock-index plus-index">
                                            <h4>8.60</h4>
                                        </div>
                                    </div>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>ETH/usd</span>
                                            <span>674.99</span>
                                        </div>
                                        <div class="stock-index minus-index">
                                            <h4>13.60</h4>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>eur/usd</span>
                                            <span>1.1862</span>
                                        </div>
                                        <div class="stock-index minus-index">
                                            <h4>0.18</h4>
                                        </div>
                                    </div>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>BTC/usd</span>
                                            <span>15.674.99</span>
                                        </div>
                                        <div class="stock-index plus-index">
                                            <h4>8.60</h4>
                                        </div>
                                    </div>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>ETH/usd</span>
                                            <span>674.99</span>
                                        </div>
                                        <div class="stock-index minus-index">
                                            <h4>13.60</h4>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>eur/usd</span>
                                            <span>1.1862</span>
                                        </div>
                                        <div class="stock-index minus-index">
                                            <h4>3.95</h4>
                                        </div>
                                    </div>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>BTC/usd</span>
                                            <span>15.674.99</span>
                                        </div>
                                        <div class="stock-index plus-index">
                                            <h4>4.78</h4>
                                        </div>
                                    </div>
                                    <div class="single-stock-report">
                                        <div class="stock-values">
                                            <span>ETH/usd</span>
                                            <span>674.99</span>
                                        </div>
                                        <div class="stock-index minus-index">
                                            <h4>11.37</h4>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Middle Header Area -->
    <div class="middle-header">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <!-- Logo Area -->
                <div class="col-12 col-md-4">
                    <div class="logo-area">
                        <a href="index.html"><img src="{{asset('assets/frontend/img/core-img/logo.png')}}" alt="logo"></a>
                    </div>
                </div>
                <!-- Header Advert Area -->
                <div class="col-12 col-md-8">
                    <div class="header-advert-area">
                        <a href="#"><img src="{{asset('assets/frontend/img/bg-img/top-advert.png')}}" alt="header-add"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Header Area -->
   <x-frontend.header.navigation :categories="$categories"/>
</header>
