@extends('store.layout.main')

@section('title') Edit Details @endsection

@section('icon') mdi-calendar @endsection


@section('content')

<section class="pull-up">
<div class="container">
<div class="row ">
<div class="col-lg-12 mx-auto  mt-2">
<div class="card py-3 m-b-30">
<div class="card-body">
{!! Form::model($data, ['url' => [$form_url],'files' => true,'method' => 'PATCH'],['class' => 'col s12']) !!}

@include('store.delivery.form')

</form>
</div>
</div>
</div>
</div>
</div>
</section>

@endsection