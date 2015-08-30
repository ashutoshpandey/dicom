<footer class="main-footer">
    <strong>Copyright &copy; 2014-2015 <a href="http://coursebooks.com">Course books</a>.</strong> All rights
    reserved.
</footer>

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>

<!-- Bootstrap 3.3.2 JS -->
{{HTML::script(asset("/public/js/bootstrap.min.js"))}}
<!-- daterangepicker -->
{{HTML::script(asset("/public/js/moment.js"))}}
{{HTML::script(asset("/public/js/daterangepicker/daterangepicker.js"))}}
<!-- datepicker -->
{{HTML::script(asset("/public/js/datepicker/bootstrap-datepicker.js"))}}
<span style="visibility: hidden" id='root' rel="{{$root}}"></span>