<?php
// En billetera_historico/modelo.php

class BilleteraHistorico
{
    public function __construct() {}

    // --- FUNCIÓN 'getAll' CORREGIDA ---
    public function getAll()
    {
        $lista = [];
        try {
            $con = new Conexion();
            
            // --- CORRECCIÓN AQUÍ ---
            // La columna se llama 'tipo_id' en tu tabla, no 'billetera_registro_tipo_id'
            $query = "SELECT id, billetera_id, fecha, tipo_id, monto, partida_id, activo FROM billetera_historial;";

            $rs = mysqli_query($con->getConnection(), $query);
            if ($rs) {
                while ($registro = mysqli_fetch_assoc($rs)) {
                    $registro['activo'] = $registro['activo'] == 1 ? true : false;

                    array_push($lista, array(
                        'id' => intval($registro['id']),
                        'billetera_id' => intval($registro['billetera_id']),
                        'fecha' => $registro['fecha'],
                        
                        // --- CORRECCIÓN AQUÍ ---
                        'tipo_id' => intval($registro['tipo_id']), // Usamos el nombre correcto
                        
                        'monto' => intval($registro['monto']),
                        'partida_id' => $registro['partida_id'] ? intval($registro['partida_id']) : null,
                        'activo' => $registro['activo']
                    ));
                }
                mysqli_free_result($rs);
            }
            $con->closeConnection();
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return $lista;
        }
        return $lista;
    }

    // --- FUNCIÓN 'getById' CORREGIDA (EFICIENTE) ---
    public function getById($_id)
    {
        $registro = null;
        try {
            $con = new Conexion();
            $db = $con->getConnection(); 
            
            // --- CORRECCIÓN AQUÍ ---
            // La columna se llama 'tipo_id'
            $query = "SELECT id, billetera_id, fecha, tipo_id, monto, partida_id, activo FROM billetera_historial WHERE id = ?;";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "i", $_id); 
            
            mysqli_stmt_execute($stmt);
            $rs = mysqli_stmt_get_result($stmt);

            if ($rs) {
                $fila = mysqli_fetch_assoc($rs);
                if ($fila) {
                    $registro = array(
                        'id' => intval($fila['id']),
                        'billetera_id' => intval($fila['billetera_id']),
                        'fecha' => $fila['fecha'],
                        
                        // --- CORRECCIÓN AQUÍ ---
                        'tipo_id' => intval($fila['tipo_id']), // Usamos el nombre correcto
                        
                        'monto' => intval($fila['monto']),
                        'partida_id' => $fila['partida_id'] ? intval($fila['partida_id']) : null,
                        'activo' => $fila['activo'] == 1 ? true : false
                    );
                }
                mysqli_free_result($rs);
            }
            mysqli_stmt_close($stmt);
            $con->closeConnection();
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            return null;
        }
        return $registro; // Retorna el objeto encontrado o null
    }
}
?>