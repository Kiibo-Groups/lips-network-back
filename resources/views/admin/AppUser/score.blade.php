@extends('admin.layout.main')

@section('title') Agregar Score @endsection

@section('content')

<section class="pull-up">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto mt-2">
                <div class="card py-3 m-b-30">
                    <div class="card-body">
                        {!! Form::model($data, ['url' => [$form_url],'files' => true,'method' => 'PATCH'],['class' => 'col s12']) !!}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="saldo">Score Actual</label>
                                    <h1>
                                        {{$data->score}}
                                    </h1>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="score">Agregar Score</label>
                                    <input type="number" id="score" name="score" placeholder="Ingresa el nuevo score" step="0.01" value="{{$data->score}}" class="form-control">
                                </div>
 
                            </div>
                            
                            @if ($data->score > 0)
                            <a href="javascript::void()" class="btn btn-warning" onclick="confirmAlert('{{ Asset($link.'resetScore/'.$data->id) }}')">Restablecer Score</a>
                            @endif
                            <button type="submit" style="float:right;text-align:right;" class="btn btn-success">Actualizar Score</button>
                        </form>
                        
                    </div>
                </div>
            </div>
 
        </div>
    </div>
</section>

@endsection
