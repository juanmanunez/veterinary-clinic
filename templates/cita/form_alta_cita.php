<?php 
    session_start();
    if (!$_SESSION || $_SESSION['tipo'] != 2) {
        header("Location:../form_login.php");
    }
 
    include("../conexion.php");

    $buscar_mascotas = "SELECT id_mascota, nombre_mascota FROM mascota WHERE rfc_cliente = '$_SESSION[nombre]'";
    $resultado_mascotas = mysqli_query($conexion, $buscar_mascotas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
    <link rel="stylesheet" href="../../css/animate.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/fonts/styles.css">
</head>
<body>
    <header>
        <div class="header--menu">
            <input type="button" value="Menú" onclick="Mostrar_Slider()" class="header--menu__button">
            <div class="header--menu__slider" id="slider" style="left: -300px;">
                <?php if ($_SESSION['tipo'] != 2) { ?>
                    <ul>
                        <li class="categoria">
                            <input type="button" class="header--menu__link" onclick="Mostrar_Clientes()" value="Clientes">
                            <ul id="funciones_clientes" style="height: 0px">
                                <li><a href="..cliente/form_alta_cliente.php" class="header--menu__link">Registrar cliente</a></li>
                                <li><a href="..cliente/reporte_clientes.php" class="header--menu__link">Reporte clientes</a></li>
                            </ul>
                        </li>
                        <li class="categoria">
                            <input type="button" class="header--menu__link" onclick="Mostrar_Consultas()" value="Consultas">
                            <ul id="funciones_consultas" style="height: 0px">
                                <li><a href="../control_servicio/form_alta_control.php" class="header--menu__link">Registrar consulta</a></li>
                                <li><a href="../control_servicio/reporte_control.php" class="header--menu__link">Reporte consultas</a></li>
                            </ul>
                        </li>
                        <li class="categoria">
                            <input type="button" class="header--menu__link" onclick="Mostrar_Facturas()" value="Facturas">
                            <ul id="funciones_facturas" style="height: 0px">
                                <li><a href="../factura/form_alta_factura.php" class="header--menu__link">Registrar factura</a></li>
                                <li><a href="../factura/reporte_facturas.php" class="header--menu__link">Reporte facturas</a></li>
                            </ul>
                        </li>
                        <li class="categoria">
                            <input type="button" class="header--menu__link" onclick="Mostrar_Mascotas()" value="Mascotas">
                            <ul id="funciones_mascotas" style="height: 0px">
                                <li><a href="../mascota/form_alta_mascota.php" class="header--menu__link">Registrar mascota</a></li>
                            </ul>
                        </li>
                        <li class="categoria">
                            <input type="button" class="header--menu__link" onclick="Mostrar_Medicos()" value="Médicos">
                            <ul id="funciones_medicos" style="height: 0px">
                                <li><a href="../medico/form_alta_medico.php" class="header--menu__link">Registrar médico</a></li>
                                <li><a href="../medico/reporte_medicos.php" class="header--menu__link">Reporte medicos</a></li>
                            </ul>
                        </li>
                        <li class="categoria">
                            <input type="button" class="header--menu__link" onclick="Mostrar_Servicios()" value="Servicios">
                            <ul id="funciones_servicios" style="height: 0px">
                                <li><a href="../servicio/form_alta_servicio.php" class="header--menu__link">Registrar servicio</a></li>
                                <li><a href="../servicio/reporte_servicios.php" class="header--menu__link">Reporte servicios</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } else {?>
                <ul>
                    <li class="categoria">
                        <a href="../mascota/reporte_mascotas.php?cliente=<?php echo $_SESSION['nombre']; ?>" class="header--menu__link">Consultar mascotas</a>
                    </li>
                    <li class="categoria">
                        <a href="form_alta_cita.php" class="header--menu__link">Agendar cita</a>
                        <a href="reporte_citas.php" class="header--menu__link">Consultar citas</a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
        <div class="header--title">
            <a href="../bienvenida.php" class="header--title__name">Veterinaria</a>
        </div>
        <div class="header--nav">
           <a href="../logout.php" class="header--nav__link"><i class="icon-logout"></i></a>
        </div>
    </header>
    <section class="wrap" id="wrap">
        <form action="alta_cita.php" method="post" class="animated bounceInRight">
            <h1 class="form__title">Agendar Cita</h1>
            <select required class="form__input" name="id_mascota">
                <option>Seleccione una mascota</option>
                <?php while($mascota = mysqli_fetch_assoc($resultado_mascotas)): ?>
                    <option value="<?php echo $mascota['id_mascota'] ?>"><?php echo $mascota['nombre_mascota'] ?></option>
                <?php endwhile; ?>
            </select>
            <div class="date">
                <label for="fecha" class="date__label">Fecha</label>
                <input type="date" name="fecha_cita" id="fecha" required class="date__input">
            </div><br>
            <input type="submit" value="Agendar" class="form__button">
        </form>
    </section>
    <footer>
        <div class="copy">
            <a href="../innovasoft.html">&copy Innovasoft 2017</a>
        </div>
    </footer>
    
    <script src="../../js/funciones.js"></script>
    <script>
        var fecha = document.getElementById('fecha');
        fecha.addEventListener('change', ValidarAnterior);
        
        function ValidarAnterior(){
            var fecha_hoy = new Date();
            var fecha_array = fecha.value.split('-');
            var fecha_formateada = new Date(fecha_array[0], fecha_array[1] - 1, fecha_array[2]);
            if (fecha_formateada < fecha_hoy) {
                alert("No puedes seleccionar una fecha anterior al día de hoy");
                fecha.onfocus();
                return false;
            }
        }
    </script>
</body>
</html>