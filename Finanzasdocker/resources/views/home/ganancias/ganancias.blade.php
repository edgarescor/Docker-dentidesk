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

                        <h5 class="titulo"> Buscador de Ganancias mensuales </h5>
                        <div class="row" style="text-align: center; padding-left: 10%;">
                            
                                @csrf
                                <div class="col-md-3" >
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;">Año</label>
                                    
                                    
                                    <select class='campo-formulario' name="mes" id="mes">
                                       @php 
                                            $meses = array(
                                                0 => 'Todos los meses',
                                                1 => 'Enero',
                                                2 => 'Febrero',
                                                3 => 'Marzo',
                                                4 => 'Abril',
                                                5 => 'Mayo',
                                                6 => 'Junio',
                                                7 => 'Julio',
                                                8 => 'Agosto',
                                                9 => 'Septiembre',
                                                10 => 'Octubre',
                                                11 => 'Noviembre',
                                                12 => 'Diciembre'
                                                
                                            );

                                            foreach ($meses as $numeroMes => $nombreMes) {
                                                echo '<option value="' . $numeroMes . '">' . $nombreMes . '</option>';
                                            }
                                        @endphp
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="texto-label" style="font-weight: 700; line-height: normal;"> Tipo Transacción</label>
                                    <select class='campo-formulario' name="agno" id="agno">
                                        
                                        @php 
                                        $agnoActual = date("Y"); 
                                        $agnoMinimo = $agnoActual - 1;
                                        $agnoMaximo = $agnoActual + 5;
                                            
                                            for ($agno = $agnoMinimo; $agno <= $agnoMaximo; $agno++) {
                                                    echo "<option value='$agno'>$agno</option>";
                                                }
                                        @endphp
                                        
                                    </select>
                                </div>
                                
                                <div class="col-md-3" style="padding-top: 25px;">
                                    <button onclick="buscarTransaccion()" class="btn  boton-registros" style="color: #012030; font-weight: 500;">Buscar</button>
                                </div>
                            
                        </div>

                    <hr>

                    <figure class="highcharts-figure" >
                        <div id="container" style="display: none"></div>
                    </figure>
                    
                </div>

                
            </div>

    </div> 
<script>
    function buscarTransaccion(){
        var mes = $("#mes").val();
        var agno = $("#agno").val();

        $.ajax({
            type: "post",
            url: '{{route("BuscarTransacciones")}}',
            headers: {
                    "Content-Type": "application/json"
                },
            data: JSON.stringify({
                "mes":mes,
                "agno":agno
            }),
            success: function (resp) {
                console.log(resp);
                var respuesta = JSON.parse(resp);
                
               var egreso = parseInt(respuesta["Egresos"],10);
               var ingreso = parseInt(respuesta["Ingresos"],10);
              
               $("#container").empty();
               Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Ingresos y Egresos del mes'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'category',
                        labels: {
                            autoRotation: [-45, -90],
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Dinero '
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        pointFormat: ''
                    },
                    series: [{
                        name: 'Dinero',
                        colors: [
                            '#2B80C6', '#C43131'
                        ],
                        colorByPoint: true,
                        groupPadding: 0,
                        data: [
                            ['Ingresos', ingreso],
                            ['Egresos', egreso],
                            
                        ],
                        dataLabels: {
                            enabled: true,
                            rotation: 0,
                            color: '#FFFFFF',
                            align: 'center',
                            format: '$ {point.y:.0f}', // one decimal
                            y: 10, // 10 pixels down from the top
                            style: {
                                fontSize: '13px',
                                fontFamily: 'Verdana, sans-serif'
                            }
                        }
                    }]
                });

                    $("#container").show(3);

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


  
</script>


</body>

</html>