@if(session('success'))
    <script>
        toastr.success('{{ session('success') }}')
    </script>
@endif

@if(session('error'))
    <script>
        toastr.error('{{ session('error') }}')
    </script>
@endif

@if(session('warning'))
    <script>
        toastr.warning('{{ session('warning') }}')
    </script>
@endif

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

