<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class ActualizarEstadoVendedorProcedure extends Migration
{
    public function up()
    {
        DB::unprepared('
            CREATE PROCEDURE actualizar_estado_vendedor(IN vendedor_id INT)
            BEGIN
                DECLARE total_avisos INT;
                DECLARE estado_actual VARCHAR(255);
                -- Obtener el número actual de avisos
                SELECT COALESCE(avisos, 0) INTO total_avisos FROM users WHERE id = vendedor_id;

                -- Obtener el estado actual del vendedor/a
                SELECT status INTO estado_actual FROM users WHERE id = vendedor_id;

                -- Incrementar el número de avisos
                SET total_avisos = total_avisos + 1;

                -- Actualizar el número de avisos
                UPDATE users SET avisos = total_avisos WHERE id = vendedor_id;

                -- Lógica para cambiar el estado según el número de avisos
                IF total_avisos > 3 AND estado_actual IS NULL THEN
                    UPDATE users SET status = "SOSPITOS" WHERE id = vendedor_id;
                ELSEIF total_avisos > 6 AND estado_actual = "SOSPITOS" THEN
                    UPDATE users SET status = "DOLENT" WHERE id = vendedor_id;
                END IF;
            END
        ');
    }

    public function down()
    {
        // Puedes agregar una lógica para revertir el procedimiento almacenado si es necesario
    }
}
