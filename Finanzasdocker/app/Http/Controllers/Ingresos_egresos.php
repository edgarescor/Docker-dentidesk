<?php

namespace App\Http\Controllers;


use App\Models\transaccionesModel;
use App\Rules\Codigo;
use App\Rules\Monto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Ingresos_egresos extends Controller
{
    //

    public function Formulario(Request $request){
        $ingresos_actuales = transaccionesModel::where('estado',1)->orderBy('id','DESC')->get();
        return view('home.ingreso.ingreso',[
            'Ingresos_actuales'=>$ingresos_actuales
        ]);
    }

    public function Add(Request $request) {
        //validación del formulario
        $request->validate([
                    'codigo' => new Codigo,
                    'monto' => new Monto,
                    'fecha' => 'required|date',
                    'motivo' => 'required|string'
                ]);

            try {
                //se busca la existencia del codigo del ingreso en la base de datos
                $buscar_existencia = transaccionesModel::where('codigo',$request->codigo)->where('estado',1)->where('tipo',$request->tipo)->count();
                if($buscar_existencia==0){
                    //insert mediante model
                    transaccionesModel::create([
                        "codigo"=>$request->codigo,
                        "motivo"=>$request->motivo,
                        "monto"=>$request->monto,
                        "fecha"=>$request->fecha,
                        "tipo"=>$request->tipo,
                        "fecha_registro" => Carbon::now()->format('Y-m-d')
                    ]);

                    //retornar a la vista el exito del insert
                    return redirect()->back()->with('success', 'El ingreso fue cargado con éxito.');
                }else{
                    return redirect()->back()->withErrors(['error' => "Disculpe el codigo indicado ya fue ingresado en el sistema"]);
                }
                
                
            } catch (\Throwable $error) {
                //throw $th;
                    $errorMessage = "Fallo el almacenamiento del ingreso.";
                    return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
    }

    public function Modificar(Request $request){
      
        $request->validate([
            'codigo_'.$request->id => new Codigo,
            'monto_'.$request->id => new Monto,
            'fecha_'.$request->id => 'required|date',
            'motivo_'.$request->id => 'required|string'
        ]);
        $codigo = $request->input("codigo_" . $request->id);
        $monto = $request->input("monto_" . $request->id);
        $motivo = $request->input("motivo_" . $request->id);
        $fecha = $request->input("fecha_" . $request->id);
            try {
                //se busca la existencia del codigo del ingreso en la base de datos
                $buscar_existencia = transaccionesModel::where('codigo',$codigo)->where('estado','<>','0')->where('id','<>',$request->id)->where('tipo',$request->tipo);
                if($buscar_existencia->count()==0){
                        $Ingreso_modificable = transaccionesModel::where('id',$request->id)->first();
                        $Ingreso_modificable->update([
                            "codigo"=>$codigo,
                            "motivo"=>$motivo,
                            "monto"=>$monto,
                            "tipo"=>$request->tipo,
                            "fecha"=>$fecha,
                        ]);
                        return redirect()->back()->with('success_'.$request->id, 'El ingreso fue cargado con éxito.');
                }else{
                    return redirect()->back()->withErrors(['error_'.$request->id => "Disculpe el codigo indicado ya fue ingresado en el sistema"]);
                }
            } catch (\Throwable $th) {
                //throw $th;
                $errorMessage = "Fallo la Actualizacion.";
                    return redirect()->back()->withErrors(['error_'.$request->id => $errorMessage]);
            }
    }
    public function Eliminar(Request $request){
       
        /**
         * definición de retornos
         * 0 -> se detecta un fallo en la función
         * 1 -> fallo en la validación de CSRF token
         * 2 -> no se encontró el ingreso
         * 3 -> eliminación exitosa
         */
        try {
            if($request->_token!=null){
                $buscar_ingreso = transaccionesModel::where('id',$request->cod_ingreso)->first();
                if($buscar_ingreso!=null){
                    $buscar_ingreso->update(["estado"=>0]);
                    $resultado = array(
                        "respuesta"=>3,
                        "mensaje"=>"Eliminación Exitosa"
                    );
                }else{
                    $resultado = array(
                        "respuesta"=>2,
                        "mensaje"=>"No se encontró el identificador"
                    );
                }
            }else{
                $resultado = array(
                    "respuesta"=>1,
                    "mensaje"=>"fallo la validación del token"
                );
            }
            return json_encode($resultado);
        } catch (\Throwable $th) {
            //throw $th;
            $resultado = array(
                "respuesta"=>0,
                "mensaje"=>"La función no se encuentra disponible (error de proceso)"
            );
            return json_encode($resultado);
        }
    }
}
