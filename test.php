<?php

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
    <!-- for Bootstrap -->
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <style>
body {
    background: #f2f2f2;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 95px 0;
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 200;
}

.row-no-gutter {
    margin-right: 0;
    margin-left: 0;
}

.row-no-gutter [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}


#card {
    background: #fff;
    position: relative;

    -webkit-box-shadow: 0px 1px 10px 0px rgba(207,207,207,1);
    -moz-box-shadow: 0px 1px 10px 0px rgba(207,207,207,1);
    box-shadow: 0px 1px 10px 0px rgba(207,207,207,1);

    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;  
}

.city-selected {
    position: relative;
    overflow: hidden;
    min-height: 200px;
    background: #3D6AA2;
}

article {
    position: relative;
    z-index: 2;
    color: #fff;
    padding: 20px;

    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-direction: row;
    -ms-flex-direction: row;
    flex-direction: row;
    -webkit-flex-wrap: wrap;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -webkit-align-content: flex-start;
    -ms-flex-line-pack: start;
    align-content: flex-start;
    -webkit-align-items: flex-start;
    -ms-flex-align: start;
    align-items: flex-start;
}

.info .city,
.night {
    font-size: 24px;
    font-weight: 200;
    position: relative;


    -webkit-order: 0;
    -ms-flex-order: 0;
    order: 0;
    -webkit-flex: 0 1 auto;
    -ms-flex: 0 1 auto;
    flex: 0 1 auto;
    -webkit-align-self: auto;
    -ms-flex-item-align: auto;
    align-self: auto;
}

.info .city:after {
    content: '';
    width: 15px;
    height: 2px;
    background: #fff;
    position: relative;
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
}

.city span {
    color: #fff;
    font-size: 13px;
    font-weight: bold;

    text-transform: lowercase;
    text-align: left;
}

.night {
    font-size: 15px;
    text-transform: uppercase;
}

.icon {
    width: 84px;
    height: 84px;
    -webkit-order: 0;
    -ms-flex-order: 0;
    order: 0;
    -webkit-flex: 0 0 auto;
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    -webkit-align-self: center;
    -ms-flex-item-align: center;
    align-self: center;

    overflow: visible;

}


.temp {
    font-size: 73px;
    display: block;
    position: relative;
    font-weight: bold;
}

svg {
    color: #fff;
    fill: currentColor;
}


.wind svg {
    width: 18px;
    height: 18px;
    margin-top: 20px;
    margin-right: 10px;
    vertical-align: bottom;
}

.wind span {
    font-size: 13px;
    text-transform: uppercase;
}

.city-selected:hover figure {
    opacity: 0.4;
}


figure {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    background-position: center;
    background-size: cover;
    opacity: 0.1;
    z-index: 1;

    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.days .row [class*="col-"]:nth-child(2) .day  {
    border-width: 0 1px 0 1px;
    border-style: solid;
    border-color: #eaeaea;
}

.days .row [class*="col-"] {
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -ms-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;  
}

.days .row [class*="col-"]:hover{
    background: #eaeaea;
}

.day {
    padding: 10px 0px;
    text-align: center;

}

.day h1 {
    font-size: 14px;
    text-transform: uppercase;
    margin-top: 10px;
}

.day svg {
    color: #000;
    width: 32px;
    height: 32px;
}
  </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div id="card" class="weater">
                    <div class="city-selected">
                        <article>

                            
                        </article>
                        
                        <figure style="background-image: url(http://136.243.1.253/~creolitic/bootsnipp/home.jpg)"></figure>
                    </div>

                    <div class="days">
                        <div class="row row-no-gutter">
                            <div class="col-md-6">
                                <div class="day">
                                    <h1>Tuesday</h1>
                                    <svg version="1.1" id="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59.077 59.077" style="enable-background:new 0 0 59.077 59.077;" xml:space="preserve">
                                        <g>
                                            <path d="M55.906,28.463c-0.235,0.129-0.469,0.258-0.711,0.379c-11.339,5.68-25.186,1.072-30.864-10.268
                                                C21.8,13.517,21.22,7.726,22.699,2.268L23.315,0l-2.061,1.129C9.807,7.402,5.107,21.605,10.554,33.464
                                                c0.231,0.501,0.826,0.722,1.326,0.491c0.502-0.23,0.723-0.824,0.492-1.326C7.684,22.424,11.164,10.333,20.253,4.09
                                                c-0.891,5.221-0.102,10.602,2.289,15.379c5.952,11.884,20.155,16.965,32.216,11.78c-2.045,5.346-6.026,9.775-11.183,12.357
                                                c-3.167,1.586-6.557,2.407-10.074,2.438c-0.638,0.007-1.285-0.016-1.917-0.063c-0.551-0.05-1.031,0.371-1.072,0.922
                                                c-0.041,0.551,0.371,1.031,0.922,1.072c0.617,0.046,1.244,0.07,1.867,0.07c0.073,0,0.146,0,0.218-0.001
                                                c3.825-0.034,7.51-0.926,10.952-2.65c6.357-3.183,11.071-8.95,12.935-15.822l0.562-2.239L55.906,28.463z"></path>
                                            <path d="M31.271,43.412c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.179,0.867-0.5c0.276-0.479,0.112-1.09-0.366-1.366
                                                l-2.83-1.634l2.83-1.634c0.479-0.276,0.643-0.888,0.366-1.366c-0.277-0.479-0.89-0.642-1.366-0.366l-2.83,1.634v-3.268
                                                c0-0.552-0.447-1-1-1s-1,0.448-1,1v3.268l-2.83-1.634c-0.478-0.276-1.09-0.113-1.366,0.366c-0.276,0.479-0.112,1.09,0.366,1.366
                                                l2.83,1.634l-2.83,1.634c-0.479,0.276-0.643,0.888-0.366,1.366c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134
                                                l2.83-1.634v3.268c0,0.552,0.447,1,1,1s1-0.448,1-1v-3.268L31.271,43.412z"></path>
                                            <path d="M11.637,37.046c-0.277-0.479-0.89-0.642-1.366-0.366l-2.83,1.634v-3.268c0-0.552-0.447-1-1-1s-1,0.448-1,1v3.268
                                                l-2.83-1.634c-0.478-0.276-1.09-0.113-1.366,0.366c-0.276,0.479-0.112,1.09,0.366,1.366l2.83,1.634l-2.83,1.634
                                                c-0.479,0.276-0.643,0.888-0.366,1.366c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134l2.83-1.634v3.268
                                                c0,0.552,0.447,1,1,1s1-0.448,1-1v-3.268l2.83,1.634c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.179,0.867-0.5
                                                c0.276-0.479,0.112-1.09-0.366-1.366l-2.83-1.634l2.83-1.634C11.749,38.136,11.913,37.524,11.637,37.046z"></path>
                                            <path d="M22.637,50.077c-0.277-0.479-0.89-0.642-1.366-0.366l-2.83,1.634v-3.268c0-0.552-0.447-1-1-1s-1,0.448-1,1v3.268
                                                l-2.83-1.634c-0.478-0.276-1.09-0.112-1.366,0.366s-0.112,1.09,0.366,1.366l2.83,1.634l-2.83,1.634
                                                c-0.479,0.276-0.643,0.888-0.366,1.366c0.186,0.321,0.521,0.5,0.867,0.5c0.17,0,0.342-0.043,0.499-0.134l2.83-1.634v3.268
                                                c0,0.552,0.447,1,1,1s1-0.448,1-1v-3.268l2.83,1.634c0.157,0.091,0.329,0.134,0.499,0.134c0.346,0,0.682-0.179,0.867-0.5
                                                c0.276-0.479,0.112-1.09-0.366-1.366l-2.83-1.634l2.83-1.634C22.749,51.167,22.913,50.556,22.637,50.077z"></path>
                                        </g>
                                    </svg>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="day">
                                    <svg version="1.1" id="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 59.077 59.077" style="enable-background:new 0 0 59.077 59.077;" xml:space="preserve">

                                    </svg>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="assets/js/jquery-3.1.1.js"></script>
<script src="assets/js/jquery-migrate-1.4.1.js"></script>



</body>
</html>