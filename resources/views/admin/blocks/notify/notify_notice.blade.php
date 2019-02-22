@if(Session::has('noticeMessage'))
    <script type="text/javascript">
        successMsg("{{ @session('noticeMessage') }}");
    </script>
@endif
