<?php
    if (!$_POST) {
        header("Location:../form_login.php");
    }
    elseif ((!$_POST['rfc_cliente']) || (!$_POST['nombre_mascota']) || (!$_POST['rfc_medico']) || (!$_POST['fecha_seguimiento']) || (!$_POST['servicios'])) {
        header("Location:form_alta_control.php");
    }
    else {
        include("../conexion.php");

        $rfc_cliente = $_POST['rfc_cliente'];
        $nombre_mascota = $_POST['nombre_mascota'];
        $rfc_medico = $_POST['rfc_medico'];
        $fecha_seguimiento = $_POST['fecha_seguimiento'];
        $servicios = $_POST['servicios'];
        $fecha = date('Y-m-d');

        $buscar_mascota = mysqli_query($conexion, "SELECT id_mascota FROM mascota WHERE nombre_mascota='$nombre_mascota' AND rfc_cliente='$rfc_cliente'");
        $mascota = mysqli_fetch_assoc($buscar_mascota);

        $buscar_control = mysqli_query($conexion, "SELECT * FROM control_servicio WHERE id_mascota='$mascota[id_mascota]' AND fecha_control='$fecha'");
        if (mysqli_num_rows($buscar_control) > 0) {
            echo "<script>
                    alert('Consulta ya registrada');
                    window.history.go(-1);
                </script>";
            exit;
        }

        $crear_control = "INSERT INTO control_servicio(fecha_control, id_mascota, rfc_medico) VALUES ('$fecha', '$mascota[id_mascota]', '$rfc_medico')";
        $resultado_control = mysqli_query($conexion, $crear_control);
        
        $buscar_control = mysqli_query($conexion, "SELECT clave_control_servicio FROM control_servicio WHERE id_mascota='$mascota[id_mascota]' AND fecha_control='$fecha'");
        $control = mysqli_fetch_assoc($buscar_control);
        foreach ($servicios as $clave_servicio) {
            $crear_servicio = "INSERT INTO control_servicio_servicio VALUES ('$control[clave_control_servicio]', '$clave_servicio')";
            $resultado_servicio = mysqli_query($conexion, $crear_servicio);
        }
        
        $crear_historial = "INSERT INTO historial VALUES ('$mascota[id_mascota]', '$fecha_seguimiento', '$control[clave_control_servicio]')";
        $resultado_historial = mysqli_query($conexion, $crear_historial);

        $crear_cita = "INSERT INTO cita(fecha_cita, id_mascota) VALUES ('$fecha_seguimiento', '$mascota[id_mascota]')";
        $resultado_cita = mysqli_query($conexion, $crear_cita);

        echo "<script>alert('Consulta registrada con éxito.');</script>";
        header("Location:reporte_control.php");

        mysqli_close($conexion);
    }
?>