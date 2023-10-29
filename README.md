# Docker-dentidesk Edgar Escorche

## Instalacion
### 1- Descargar el repositorio Docker-destidesk
  
    git clone https://github.com/edgarescor/Docker-dentidesk.git

### 2- Ejecutar el comando Docker-compose dentro de la carpeta Docker-dentidesk
 
    docker-compose up -d

### 3- Ubicarse en la carpeta Finanzasdocker
  
    cd ./Finanzasdocker

### 4- dentro de Finanzasdocker ejecutar el comando migrate
  
    php artisan migrate

### 5- ubicar en archivo .env dentro de la carpeta Finanzasdocker y comentar la conexion activa y sustituir por la siguiente conexion 

  conexion activa desde la descarga inicial : 
  
        DB_CONNECTION=mysql
        DB_HOST=localhost
        DB_PORT=33069
        DB_DATABASE=finanzas
        DB_USERNAME=root
        DB_PASSWORD=123456

  Sustituir por la siguiente conexion:

        DB_CONNECTION=mysql
        DB_HOST=173.21.100.9
        DB_PORT=3306
        DB_DATABASE=finanzas
        DB_USERNAME=root
        DB_PASSWORD=123456

  ### 7- Ejecutar en navegardor la siguiente ruta:

        localhost:8200

  de esta forma tendriamos el mini proyecto funcionando sin problemas.

## Rutas REST e indicaciones de Json
  ### 1- Calculo por mes :
  la ruta para esta accion es :
        
        localhost:8200/api/Transacciones/mes
  
  Metodo: 

          POST

  Header:

          "Content-Type": "application/json"
  Body:
  
        {
        	"mes":8, //mes que desea consultar NOTA: 0 para todos los meses y del 1 al 12 para el resto de meses
        	"agno":2023 // año de seleccion
        }
  Response:
  
        {
          "Ingresos": 0, //monto total de ingresos
          "Egresos": 0 //monto total de egresos
        }
  
  
### 2- Todos los Registros :
  la ruta para esta accion es :
        
        localhost:8200/api/Transacciones
  
  Metodo: 

          GET
  Response:

      [
          {
              "codigo": "2525", //Codigo Ingresado por el usuario
              "motivo": "pago de servicios", // motivo de la transaccion
              "monto": 6000, //Monto de la transaccion
              "fecha": "2023-10-28", // fecha de la transaccion
              "tipo": 2 //tipo de la transaccion 1 => Ingresos 2=> Egresos
          }
      ]

### 3- Ingresar Transaccion :
  la ruta para esta accion es :
        
        localhost:8200/api/Transacciones
  
  Metodo: 

          POST

  Header:

          "Content-Type": "application/json"
  Body:
  
        {
            "codigo":141412, // codigo indicador ingresado por el usuario
            "monto" : 1000, // monto de la transaccion
            "fecha"  :"2023-10-10", //fecha de la transaccion
            "motivo" : "Nuevo ingreso ", // motivo de la transaccion
            "tipo":1 //tipo de la transaccion 1 => Ingresos 2=> Egresos
        }
  Response:
  
        {
            "Mensaje": "Ingreso Exitoso", // mensaje de resultado
            "codigo": 141412, 
            "monto": 1000,
            "fecha": "2023-10-10",
            "motivo": "Nuevo ingreso ",
            "tipo": 1,
            "id_ingreso": 2 // identificador del registro en el sistema
        }
### 4- Actualizacion Transaccion :
  la ruta para esta accion es :
        
        localhost:8200/api/Transacciones
  
  Metodo: 

          PUT

  Header:

          "Content-Type": "application/json"
  Body:
  
        {
            "Mensaje": "Ingreso Exitoso", // mensaje de resultado
            "codigo": 141412, 
            "monto": 1000,
            "fecha": "2023-10-10",
            "motivo": "Nuevo ingreso ",
            "tipo": 1,
            "id_transaccion": 2 // identificador del registro en el sistema
        }
  Response:
  
        {
            "mensaje": "Actualización Exitosa"
        }
### 5- Eliminancion de Transaccion :
  la ruta para esta accion es :
        
        localhost:8200/api/Transacciones
  
  Metodo: 

          DELETE

  Header:

          "Content-Type": "application/json"
  Body:
  
        {
            "id_transaccion": 2 // identificador del registro en el sistema
        }
  Response:
  
        {
            "mensaje": "Eliminación Exitosa"
        }
  
          
           
  
  
