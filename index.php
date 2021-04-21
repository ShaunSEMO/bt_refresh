<?php
    include 'includes/class_login.php';
    include 'includes/function_signin-validation.php';
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Biz Tweak</title>
		<!-- Meta tags -->
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!-- //Meta tags -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.css"><!-- font-awesome-icons -->
        <style media="screen">
        @import url('https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap');
        body{
            font-family: 'Kumbh Sans', sans-serif;
        }
        section{
            padding: 60px 0;
        }
        </style>
</head>

<body>
        <section style="background: #54cdd2;" class="pt-0">
            <div class="container-fluid bg-white">
                <div class="row">
                    <div class="col-12 text-center mt-3">
                        <img src="images/logo2.png" class="img-fluid" alt="" style="height: 120px;">
                    </div>
                </div>
            </div>
            <div class="container">
            <div class="row">
                </div>
                <div class="col-12 text-center py-5">
                    <h1 class="mb-5 mt-5">We believe that entrepreneurship can be easier.</h1>
                    <p class="lead mb-4">Being an entrepreneur is a hard and interesting journey for sure, and starting a business can be even harder, especially when you don’t know what you don’t know about your business or business idea. Not knowing the right information at the right time has caused failure in many businesses, BizTweak aims to change that.</p>
                    <a href="login.php" class="btn btn-primary btn-lg">USE BIZTWEAK NOW</a>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>How it Works</h1>
                </div>
                <div class="col-md-6 mt-5 text-center">
                    <h1>1</h1>
                    <img class="img-fluid" src="images/step1.png" alt="">
                </div>
                <div class="col-md-6 mt-5 text-center">
                    <h1>2</h1>
                    <img class="img-fluid" src="images/step2.png" alt="">
                </div>
                <div class="col-md-6 mt-5 text-center">
                    <h1>3</h1>
                    <img class="img-fluid" src="images/step3.png" alt="">
                </div>
                <div class="col-md-6 mt-5 text-center">
                    <h1>4</h1>
                    <img class="img-fluid" src="images/step4.png" alt="">
                </div>
                <div class="col-12 mt-4 text-center">
                    <a href="login.php" class="btn btn-primary btn-lg">USE BIZTWEAK NOW</a>
                </div>
            </div>
        </div>
    </section>
    <section style="background: #54cdd2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h1>Impact</h1>
                </div>
                <div class="col-md-8 mb-5 text-center">
                    <p class="lead">
                        After completing the assessment you will get a business health report that will give you recommendations on
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 text-center">
                    <h4>Market Viability</h4>
                    <div class="row justify-content-center">
                        <p class="col-md-8">The goal is to determine a realistic estimate of future revenues and whether it’s big enough.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 text-center">
                    <h4>Business Idea Validation</h4>
                    <div class="row justify-content-center">
                        <p class="col-md-8">The goal is to test and validate if your idea is viable prior to launching your product, service or website.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 text-center">
                    <h4>Customers & Revenue</h4>
                    <div class="row justify-content-center">
                        <p class="col-md-8">The goal is to help entrepreneurs locate where their customers could be, and how much revenue could be generated from them.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 text-center">
                    <h4>Investor Readiness</h4>
                    <div class="row justify-content-center">
                        <p class="col-md-8">The goal is to provide a 360 assessment of a business, and provide a roadmap on how to get investor ready.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 text-center">
                    <h4>Employee Quality</h4>
                    <div class="row justify-content-center">
                        <p class="col-md-8">The goal is to provide information on how you can improve the performance of employees and your relationship with them.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4 text-center">
                    <h4>Business Scalability</h4>
                    <div class="row justify-content-center">
                        <p class="col-md-8">The goal is to test if the current business has the elements it requires to scale into a bigger business</p>
                    </div>
                </div>
                <div class="col-12 mt-3 text-center">
                    <a href="login.php" class="btn btn-primary btn-lg">USE BIZTWEAK NOW</a>
                </div>
            </div>
        </div>
    </section>
    <footer class="container-fluid" style="background: #54cdd2">
        <div class="row">
            <div class="col-12 text-center">
                <p class="lead">&copy; 2020 Biz Tweak. All rights reserved</p>
            </div>
        </div>
    </footer>
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script>
        $('section').css('min-height',$(window).height());
    </script>
</body>
</html>
