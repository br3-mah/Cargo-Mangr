
<footer class="main-footer" @if($user_role == 4) style="margin-left: 12%; padding-left:10%" @endif >
    <strong>Copyright &copy; 2021 <a href="#">{{ \Str::title(get_general_setting('company_name', config('app.name'))) }}</a>.</strong>

    <div class="float-right d-sm-inline-block">
        <b>Version</b> {{ preg_replace('/[\\\@\;\" "]+/', '', get_general_setting('current_version')) }}
    </div>
</footer>