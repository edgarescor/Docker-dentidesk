<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Mantenedor Finanzas</title>
        @include('cdn.cdn')
        
   </head>
   <body>
    @include('layouts.menuTransparente')
    
   
   

    <div class="contenedor-formulario">
        
             <div class="col-md-12" style="padding-left: 100px; display: flex; align-items: flex-start;"  >
                <div class="Formulario">

                @if($errors->has('error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                    <form action="{{route('Add')}}" method="post">
                        <h5 class="titulo"> Registro de Ingresos </h5>
                        <div class="row">
                            
                                @csrf
                                <div class="col-md-2">
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;"> Código/Referencia</label>
                                    <input type="text" class='campo-formulario' name="codigo" id="codigo"  placeholder="Indique Código o Referencia" require>
                                    
                                    @error("codigo")
                                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;"> Tipo Transacción</label>
                                    <select class='campo-formulario' name="tipo" id="tipo">
                                        <option value="1">Ingreso</option>
                                        <option value="2">Egreso</option>
                                    </select>
                                </div>
                                
                                
                                <div class="col-md-2">
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;"> Concepto / Motivo Transacción</label>
                                    <input type="text" class='campo-formulario' name="motivo" id="motivo"  placeholder="Indique el Concepto del ingreso" require>
                                    @error("motivo")
                                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;"> Monto</label>
                                    <input type="number" class='campo-formulario' name="monto" id="monto" class="" placeholder="66666">
                                    @error("monto")
                                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;"> Fecha de Transacción</label>
                                    <input type="date" class='campo-formulario' name="fecha" id="fecha"  placeholder="Indique la fecha de ingreso">
                                    @error("fecha")
                                        <p style="font-size: 15px; padding-top: 10px;" class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-md-1" style="padding-top: 25px;">
                                    <button type="submit" class="btn  boton-registros" style="color: #012030; font-weight: 500;">Grabar</button>
                                </div>
                            
                        </div>
                    </form>

                    <hr>
                     <!-- grilla de ingresos reportados -->
                        @include('layouts.grilla_ingreso')
                </div>

                
            </div>

    </div>
  <script>
    function EliminarIngreso(cod){
        Swal.fire({
        icon: 'question',
        title: 'Estas Seguro de Eliminar Este Ingreso?',
        text: 'Al aceptar el ingreso se eliminara del sistema.',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "post",
                        url: '{{route("Eliminar")}}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            cod_ingreso : cod
                        },
                        success: function (resp) {
                            
                            var validacion = JSON.parse(resp);
                            if(validacion.respuesta==3){
                                    Swal.fire({
                                        icon: 'success',
                                        title: validacion.mensaje,
                                        })
                                        //recargar la pagina
                                        setTimeout(function() {
                                            location.reload(); 
                                        }, 3000)
                            }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: validacion.mensaje,
                                        })
                            }
                            
                        },
                        error: function (xhr, status, error) {
                            // Maneja los errores si ocurre alguno.
                            console.error(error);
                                    Swal.fire({
                                        icon: 'error',
                                        title: error,
                                        })
                        }
                    });
                        
                }
        })
    }

    function envio_form(id){
        var formulario = document.forms["form_"+id];
        formulario.submit();
    }
  </script>

</body>

</html>