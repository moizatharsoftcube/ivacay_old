

<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/wow.js')}}"></script>
<script src="{{asset('slick/slick.js')}}"></script>
<script src="{{asset('slick/slick.min.js')}}"></script>
<script src="{{asset('js/jquery.slicknav.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/aos.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('js/core.js')}}"></script>
<script src="{{asset('js/maps.js')}}"></script>
<script src="{{asset('js/worldLow.js')}}"></script>

<!-- For stripe -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<!-- Toaster JS-->
<script src="{{asset('build/toastr.min.js')}}"></script>
<script>
    // customize your toaster link https://www.jqueryscript.net/demo/Highly-Customizable-jQuery-Toast-Message-Plugin-Toastr/
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-full-width",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $(document).ready(function () {
        @if(Session::has('success'))
            toastr["success"](' {{ Session::get('success') }}');
        @endif
            @if(Session::has('added'))
            toastr["success"](' {{ Session::get('added') }}');
        @endif
            @if(Session::has('failed'))
            toastr["error"]('{{ Session::get('failed') }}');
        @endif
            @if(Session::has('out_of_stock'))
            toastr["error"]('{{ Session::get('out_of_stock') }}');
        @endif
            @if(Session::has('already_exist'))
            toastr["error"]('{{ Session::get('already_exist') }}');
        @endif
            @if(Session::has('checkFalse'))
            toastr["error"]('{{ Session::get('checkFalse') }}');
        @endif
            @if(Session::has('checkUserRole'))
            toastr["error"]('{{ Session::get('checkUserRole') }}');
        @endif
            @if(Session::has('error'))
            toastr["error"]('{{ Session::get('error') }}');
        @endif
    });



    // // Block
    // document.addEventListener('keydown', function() {
    //     if (event.keyCode == 123) {
    //         return false;
    //     } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
    //         event.preventDefault();
    //         return false;
    //     } else if (event.ctrlKey && event.keyCode == 85) {
    //         return false;
    //     } else if(event.ctrlKey && (event.key === "I" || event.key === "i")) {
    //         event.preventDefault();
    //         return false;
    //     } else if(event.ctrlKey && (event.key === "U" || event.key === "u")) {
    //         event.preventDefault();
    //         return false;
    //     }
    //     // if(event.ctrlKey && (event.key === "S" || event.key === "s")) {
    //     //     event.preventDefault();
    //     // }
    //     //
    //     // if(event.ctrlKey && (event.key === "C")) {
    //     //     event.preventDefault();
    //     // }
    //     // if(event.ctrlKey && (event.key === "E" || event.key === "e")) {
    //     //     event.preventDefault();
    //     // }
    //
    //     // if(event.ctrlKey && (event.key === "K" || event.key === "k")) {
    //     //     event.preventDefault();
    //     // }
    // }, false);

    // document.onkeydown = function (e) {
    //     if (event.keyCode == 123) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
    //         return false;
    //     }
    //     if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
    //         return false;
    //     }
    // }
    // if (document.addEventListener) {
    //     document.addEventListener('contextmenu', function (e) {
    //         e.preventDefault();
    //     }, false);
    // } else {
    //     document.attachEvent('oncontextmenu', function () {
    //         window.event.returnValue = false;
    //     });
    // }
    //Block End

</script>
@stack('js')
