@extends('admin.layout.main')

@section('title') Agregar Saldo @endsection

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
                                    <label for="saldo">Saldo Actual</label>
                                    <h1>
                                        ${{ number_format($data->saldo,2)}}
                                    </h1>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="saldo">Agregar Saldo</label>
                                    <input type="number" id="saldo" name="saldo" placeholder="Ingresa el nuevo saldo" step="0.01" value="{{$data->saldo}}" class="form-control">
                                </div>
 
                            </div>
                            
                            @if ($data->saldo > 0)
                            <a href="javascript::void()" class="btn btn-warning" onclick="confirmAlert('{{ Asset($link.'resetWallet/'.$data->id) }}')">Restablecer Saldo</a>
                            @endif
                            <button type="submit" style="float:right;text-align:right;" class="btn btn-success">Actualizar Saldo</button>
                        </form>
                        
                    </div>
                </div>
            </div>
 
        </div>
    </div>
</section>

@endsection
