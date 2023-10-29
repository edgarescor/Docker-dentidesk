@if($Ingresos_actuales->count()!=0)
    <div class="col-md-12 row">
        <div class="col-md-1">
            <p>#</p>
        </div>
        <div class="col-md-1">
            <p>Código</p>
        </div>
        <div class="col-md-1">
            <p>Tipo</p>
        </div>
        <div class="col-md-4" style="text-align: center;">
            <p>Concepto</p>
        </div>
        <div class="col-md-2" style="text-align: center;">
            <p>Monto</p>
        </div>
        <div class="col-md-1">
            <p>Fecha</p>
        </div>
        <div class="col-md-1" style="text-align: center;">
            <p></p>
        </div>
    </div>
    <hr>
    @php $i=0; @endphp
    @foreach($Ingresos_actuales as $ingreso)
        @php $i++; @endphp
            @if($errors->has('error_'.$ingreso->id))
                <div class="alert alert-danger">
                    {{ $errors->first('error_'.$ingreso->id) }}
                </div>
            @endif
            @if(session('success_'.$ingreso->id))
                <div class="alert alert-success">
                    {{ session('success_'.$ingreso->id) }}
                </div>
            @endif
        <form name="form_{{$ingreso->id}}" id="form_{{$ingreso->id}}" action="{{route('Modificar')}}" method="post"> 
            @csrf
            <div class="col-md-12 row">
                <div class="col-md-1">
                    <p>{{$i}}</p>
                    <input type="hidden" class='campo-formulario' name="id" id="id" value="{{$ingreso->id}}" require>
                </div>
                <div class="col-md-1">
                    
                    <input type="text" class='campo-formulario' name="codigo_{{$ingreso->id}}" id="codigo_{{$ingreso->id}}" value="{{$ingreso->codigo}}" require>
                    @error("codigo_".$ingreso->id)
                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-2">
                    
                    <select class='campo-formulario' name="tipo" id="tipo">
                        <option value="{{$ingreso->tipo}}">{{($ingreso->tipo==1)?"Ingreso":"Egreso"}} (Actual)</option>
                        <option value="1">Ingreso</option>
                        <option value="2">Egreso</option>
                    </select>
                </div>
                <div class="col-md-3" style="text-align: center;">
                    <input type="text" class='campo-formulario' name="motivo_{{$ingreso->id}}" id="motivo_{{$ingreso->id}}" value="{{$ingreso->motivo}}" require>
                    @error("motivo_".$ingreso->id)
                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-2" style="text-align: center;">
                    <input type="number" class='campo-formulario' name="monto_{{$ingreso->id}}" id="monto_{{$ingreso->id}}" value="{{$ingreso->monto}}" require>
                    @error("monto_".$ingreso->id)
                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-1">
                    <input type="date" class='campo-formulario' name="fecha_{{$ingreso->id}}" id="fecha_{{$ingreso->id}}" value="{{$ingreso->fecha}}" require>
                    @error("fecha_".$ingreso->id)
                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <p onclick="EliminarIngreso('{{$ingreso->id}}')" title="Eliminar Ingreso"><i class="fas fa-trash-alt"></i></p>
                </div>
                <div class="col-md-1" style="text-align: center;">
                    <p onclick="envio_form('{{$ingreso->id}}')" title="ModificarIngreso"> <i class="fas fa-pencil-alt"></i></p>
                </div>
            </div>
        </form>
        <hr>
    @endforeach
@else
    <div class="col-md-12" >
        <div class="Grilla">
            <p class="titulo" style="font-size: 20px;"> Sin Ingresos Reportados </p>
        </div>
    </div>
@endif