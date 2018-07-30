<!DOCTYPE html>
<html lang="en">
<head>
    <title>Colo Shop</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Colo Shop Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend_css/bootstrap4/bootstrap.min.css') }}">
    <link href="{{ asset('plugins/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/OwlCarousel2-2.2.1/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend_css/main_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend_css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend_css/categories_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend_css/categories_responsive.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('css/frontend_css/karan/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend_css/karan/easy-responsive-tabs.css') }}">
    <link rel="stylesheet" type="text/css" media="screen" property="" href="{{ asset('css/frontend_css/karan/shop.css') }}">
    <link rel="stylesheet" type="text/css" media="screen"  href="{{ asset('css/frontend_css/karan/flexslider.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('css/frontend_css/karan/style.css') }}">

</head>

<body>

<div class="super_container">

    <!-- Header -->
    @include('layouts.frontLayout.front_header')

    @yield('content')

    <!-- Footer -->
    @include('layouts.frontLayout.front_footer')

</div>
<script src="{{ asset('js/frontend_js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('css/frontend_css/bootstrap4/popper.js') }}"></script>
<script src="{{ asset('css/frontend_css//bootstrap4/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/Isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
<script src="{{ asset('plugins/easing/easing.js') }}"></script>
<script src="{{ asset('js/frontend_js/custom.js') }}"></script>
<script src="{{ asset('js/frontend_js/categories_custom.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('js/frontend_js/karan/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('js/frontend_js/karan/imagezoom.js') }}"></script>
<script src="{{ asset('js/frontend_js/karan/easy-responsive-tabs.js') }}"></script>
<script src="{{ asset('js/frontend_js/karan/jquery.flexslider.js') }}"></script>



<!--Angular-->
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>


<script>
    angular.module('checksys',[],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });
    angular.module('checksys').controller("checkboxCtrl",function ($scope) {
        $scope.showall=true;
        var cats=JSON.parse('<?php if (isset($subcats)){echo $subcats;}?>');
        $scope.catgs=[];
        angular.forEach(cats,function (value,key) {
            var temp={ id:value.id, name:value.name};
            $scope.catgs.push(temp);
        });
        //console.log($scope.catgs);
        $scope.selected=[];
        $scope.exist=function (item) {
            return $scope.selected.indexOf(item) > -1;
        }
        $scope.toggleSelection=function (item) {
            var idx=$scope.selected.indexOf(item);
            if (idx > -1)
            {
                $scope.selected.splice(idx, 1);
            }
            else {
                $scope.selected.push(item);
            }
        }

        $scope.checkAll=function () {
            if ($scope.selectAll){
                angular.forEach($scope.catgs,function (item) {
                    idx=$scope.selected.indexOf(item);
                    if (idx>=0){
                        return true;
                    }
                    else {
                        $scope.selected.push(item);
                    }

                })
            }
            else {
                //Yaha changw
                $scope.selected=[];
            }
        }
    })
</script>








<!--Karan-->
<script>
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            activate: function (event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });
</script>
<script type="text/javascript">
    function incrementValue()
    {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        if(value<10){
            value++;
            document.getElementById('number').value = value;
        }
    }
    function decrementValue()
    {
        var value = parseInt(document.getElementById('number').value, 10);
        value = isNaN(value) ? 0 : value;
        if(value>1){
            value--;
            document.getElementById('number').value = value;
        }

    }
</script>
<script>
    $(function () {
        $("input[name='radio']").click(function () {
            if ($("#chkYes").is(":checked")) {
                $("#dvRent").show();
            } else {
                $("#dvRent").hide();
            }
        });
    });
</script>
<script>
    // Can also be used with $(document).ready()
    $(window).load(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
</script>
</body>

</html>
