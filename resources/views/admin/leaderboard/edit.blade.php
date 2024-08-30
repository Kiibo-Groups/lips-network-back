@extends('admin.layout.main')

@section('title') Editar Tabla de Clasificaciones @endsection

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
                                    <label for="score_min">Score Minimo para participar</label>
                                    <input type="number" id="score_min" name="score_min" placeholder="Ingresa el nuevo score" step="0.01" value="{{$data->score_min}}" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="reward">Recompensa</label>
                                    <input type="number" id="reward" name="reward" placeholder="Ingresa el nuevo score" step="0.01" value="{{$data->reward}}" class="form-control">
                                </div>

                                
                                <div class="form-group col-md-6">
                                    <label for="reward_div">Division de la recompensa <small>(% a dividir para cada posición)</small> </label>
                                    <input type="number" id="reward_div" name="reward_div" placeholder="Ingresa el nuevo score" step="0.01" value="{{$data->reward_div}}" class="form-control">
                                </div>
 
                                <div class="form-group col-md-6">
                                    <label for="date_end">Fecha de Finalizacion  </label>
                                    {!! Form::text('date_end',null,['class' => 'js-datepicker form-control','required' => 'required', 'min' => date("Y-m-d") ])!!}
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
