@extends('store.layout.main')

@section('title') Edit Order @endsection

@section('icon') mdi-map-marker @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-12 mx-auto  mt-2">

{!! Form::open(['url' => [$form_url],'files' => true,'method' => 'POST'],['class' => 'col s12']) !!}

@include('store.order.form')

</form>
</div>
</div>
</div>
</div>
</div>
</section>

@endsection