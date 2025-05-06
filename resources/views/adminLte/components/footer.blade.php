
<footer class="main-footer" @if($user_role == 4) style="margin-left: 12%; padding-left:10%" @endif >
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">{{ \Str::title(get_general_setting('company_name', config('app.name'))) }}</a>.</strong>

 
</footer>
