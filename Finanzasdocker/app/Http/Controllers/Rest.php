<?php

namespace App\Http\Controllers;

use App\Models\transaccionesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Rest extends Controller
{
    //
    public function BuscarTransacciones(Request $request){
        $data =  json_decode($request->getContent());
        $mes = $data->mes;
        $agno = $data->agno;
        $array_mes= array(0,1,2,3,4,5,6,7,8,9,10,11,12);
        try {
            if(in_array($mes,$array_mes)){
                if($mes!=0){
                    $buscar_montos =DB::table('transacciones')
                                ->selectRaw('SUM(IF(tipo = 1, monto, 0)) AS ingresos, SUM(IF(tipo = 2, monto, 0)) AS egreso')
                                ->where('estado',1)
                                ->whereMonth('fecha',$mes)
                                ->whereYear('fecha',$agno)
                                ->get();
                }else{
                    $buscar_montos =DB::table('transacciones')
                                ->selectRaw('SUM(IF(tipo = 1, monto, 0)) AS ingresos, SUM(IF(tipo = 2, monto, 0)) AS egreso')
                                ->where('estado',1)
                                ->whereYear('fecha',$agno)
                                ->get();
                }
                $respuesta = [
                    "Ingresos"=>($buscar_montos[0]->ingresos == null)?0:$buscar_montos[0]->ingresos,
                    "Egresos"=>($buscar_montos[0]->egreso == null)?0:$buscar_montos[0]->egreso,
                ];
                
                return json_encode($respuesta);
            }else{
                return response()->json(['Mensaje' => 'El mes indicado no es valido'],423);
            }
        
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'El servicio de búsqueda fallo'],423);
        }
        
    }

    public function IngresoTransaccion(Request $request){
        try {
            $data =  json_decode($request->getContent());
            $codigo = $data->codigo;
            $monto = $data->monto;
            $fecha = $data->fecha;
            $motivo = $data->motivo;
            $tipo   = $data->tipo;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Algunos campo no fueron indicado'],423);
        }
        
        try {
            $buscar_existencia = transaccionesModel::where('codigo',$codigo)
                                                    ->where('tipo',$tipo)
                                                    ->where('estado',1);
            if($buscar_existencia->count() == 0){
                $ingreso = transaccionesModel::create([
                    "codigo"=>$codigo,
                    "motivo"=>$motivo,
                    "monto"=>$monto,
                    "fecha"=>$fecha,
                    "tipo"=>$tipo,
                    "fecha_registro" => Carbon::now()->format('Y-m-d')
                ]);

                $respuesta = [
                    "Mensaje" => "Ingreso Exitoso",
                    "codigo" => $ingreso->codigo,
                    "monto" => $ingreso->monto,
                    "fecha" => $ingreso->fecha,
                    "motivo" => $ingreso->motivo,
                    "tipo" => $ingreso->tipo,
                    "id_ingreso" => $ingreso->id
                ];
                return response()->json($respuesta,200);
            }else{
                return response()->json(['Mensaje' => 'El codigo indicado ya se encuentra registrado'],423);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Fallo el ingreso '],423);
        }   
    }

    public function ActualizacionTransaccion(Request $request){
        try {
            $data =  json_decode($request->getContent());
            $codigo = $data->codigo;
            $monto = $data->monto;
            $fecha = $data->fecha;
            $motivo = $data->motivo;
            $tipo   = $data->tipo;
            $id_transaccion = $data->id_transaccion;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Algunos campo no fueron indicado'],423);
        }
        
      
        try {
            $transaccion = transaccionesModel::where('id',$id_transaccion)->first();
            if($transaccion!=null){
                $buscar_existencia = transaccionesModel::where('codigo',$codigo)
                                                        ->where('tipo',$tipo)
                                                        ->where('id','<>',$id_transaccion)
                                                        ->where('estado',1);
                if($buscar_existencia->count() == 0){
                $transaccion = transaccionesModel::where('id',$id_transaccion)->first();
                $transaccion->update([
                        "codigo"=>$codigo,
                        "motivo"=>$motivo,
                        "monto"=>$monto,
                        "fecha"=>$fecha,
                        "tipo"=>$tipo,
                        ]);
                $respuesta = [
                    "mensaje" => "Actualización Exitosa",
                    ];
                    return response()->json($respuesta,200);
                }else{
                    return response()->json(['Mensaje' => 'El codigo indicado ya se encuentra registrado'],423);
                }
            }else{
                return response()->json(['Mensaje' => 'el identificador indicado no fue encontrado'],423);
            }
            
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Fallo el proceso de actualización'],423);
        }
    }
    public function EliminacionTransaccion(Request $request){
        try {
            $data =  json_decode($request->getContent());
            
            $id_transaccion = $data->id_transaccion;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Algunos campo no fueron indicado'],423);
        }

        try {
            $transaccion = transaccionesModel::where('id',$id_transaccion)->first();
            if($transaccion!=null){
                $transaccion->update([
                        "estado"=>0,
                        "fecha_eliminacion"=>Carbon::now()->format('Y-m-d')
                        ]);

                        $respuesta = [
                            "mensaje" => "Eliminación Exitosa",
                        ];
                        return response()->json($respuesta,200);
            }else{
                return response()->json(['Mensaje' => 'No encontramos el identificador indicado'],423);
            }

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Fallo el proceso de eliminación'],423);
        }
    }

    public function TodasTransacciones(Request $request){
        try {
            $transacciones = transaccionesModel::where('estado',1);

            if($transacciones->count()>0){
                $datos_transacciones = $transacciones->get();
                $respuesta=array();
                $i=0;
                foreach ($datos_transacciones as $transaccion) {
                    $respuesta[$i] = [
                        "codigo"=>$transaccion->codigo,
                        "motivo"=>$transaccion->motivo,
                        "monto"=>$transaccion->monto,
                        "fecha"=>$transaccion->fecha,
                        "tipo"=>$transaccion->tipo,
                    ];
                    $i++;
                }
                
                return response()->json($respuesta,200);

            }else{
                return response()->json(['Mensaje' => 'No hay registros para mostrar'],423);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['Mensaje' => 'Fallo el proceso de búsqueda '],423);
        }
        
    }

}
