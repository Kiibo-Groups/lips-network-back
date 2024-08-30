@extends('admin.layout.main')

@section('title') Ticket @endsection

@section('content')

<section class="pull-up">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 mt-2">
                <div class="card py-3 m-b-30">
                    <div class="card-body">
                        {!! Form::model($data, ['url' => [$form_url],'files' => true,'method' => 'PATCH'],['class' => 'col s12']) !!}
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="valor">Valor del ticket</label>
                                    <input type="number" id="valor" name="valor" placeholder="Ingresa el valor del ticket" step="0.01" value="{{$data->valor}}" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="score">Score del ticket</label>
                                    <input type="number" id="score" name="score" placeholder="Ingresa el score del ticket" step="0.01" value="{{$data->score}}" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" @if($data->status == 1) selected @endif>Aprobado</option>
                                        <option value="2" @if($data->status == 2) selected @endif>Denegado</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="categorystore_id">Asignar Categoria <small>(Opcional)</small> </label>
                                    <select name="categorystore_id" id="categorystore_id" class="form-control">
                                        <option value="0" @if($data->categorystore_id == 0) selected @endif >Selecciona una categoria</option>
                                       @foreach ($categorys as $cat)
                                       <option value="{{$cat->id}}" @if($data->categorystore_id == $cat->id) selected @endif>{{$cat->name}}</option>
                                       @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">Descripción</label>
                                    <textarea name="description" id="description" cols="15" rows="5" class="form-control">{!! $data->description !!}</textarea>
                                </div>
                            </div>
                            
                            <button type="submit" style="float:right;text-align:right;" class="btn btn-success">Actualizar ticket</button>
                        </form>
                        
                    </div>
                </div>
            </div>


            <div class="col-lg-3 mt-2">
                <div class="card py-3 m-b-30">
                    <div class="card-body">
                        <div class="col-s-12">
                            <div class="form-row">
                                 
                                <div class="form-group col-md-12">
                                    <label for="description">"Ticket"</label>
                                    
                                    <a href="{{ $data->imagen }}" target="_blank">
                                        <img src="{{ $data->imagen }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
