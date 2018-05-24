@extends('Admin.layouts.layout')
@section('css_bottom')
@endsection
@section('body')
    <div class="row col-md-12" align="center">
        <img src="data:image/png;base64, {!! base64_encode($png) !!} ">
    </div>
@endsection
@section('js_bottom')
<script src="{{asset('assets/global/plugins/orakuploader/orakuploader.js')}}"></script>
<script>

</script>
@endsection
