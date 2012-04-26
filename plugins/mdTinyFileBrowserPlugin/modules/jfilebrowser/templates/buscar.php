<?php
//variables
$seccion = $_REQUEST['seccion'];
$id = $_REQUEST['id'];
$cat = $_REQUEST['cat'];
$set_cook = $_REQUEST['set_c'];
$busqueda = $_REQUEST['busqueda'];
$fecha_act = date('Y-m-d H:i:s');

///////////ruta donde estan los archivos
$ruta_completa_ar = str_replace('filebrowser.php', '', $_SERVER['PHP_SELF']).'archivos/';

$js_opt['admin_area'] = TRUE;

// cookie para las vistas de los archivos
$cookie_vbrw = $_COOKIE['jfilebrowser'];

if(!isset($cookie_vbrw) || $set_cook == 1) {
	//setear el cookie
	setcookie('jfilebrowser','1', time()+(60*60*24*365));
	//refrescar la pagina
	if(isset($_REQUEST['busqueda'])) header('Location: filebrowser.php?seccion=1&busqueda='.$busqueda);
	elseif(isset($_REQUEST['id'])) header('Location: filebrowser.php?seccion=1&id='.$id);
}
elseif($set_cook == 2) {
	//setear el cookie
	setcookie('jfilebrowser','2', time()+(60*60*24*365));
	//refrescar la pagina
	if(isset($_REQUEST['busqueda'])) header('Location: filebrowser.php?seccion=1&busqueda='.$busqueda);
	elseif(isset($_REQUEST['id']))  header('Location: filebrowser.php?seccion=1&id='.$id);
}

include("../include/config.inc.php");

//incluir la pagina de validacion solo cuando es necesario
if(isset($_POST['validacion']) && !empty($_POST['validacion'])) {
	include('../include/validacion.inc.php');
}

?>


<?php

///////Archivos
//Si hya una busqueda
if(isset($_GET['busqueda'])) {
    if(empty($busqueda)) $archiv_bus = -1;

    elseif(isset($busqueda)) {
        $archiv_bus = (get_magic_quotes_gpc()) ? $busqueda : addslashes($busqueda);
    }else $archiv_bus = -1;

    $query_img  = "SELECT * FROM archivos WHERE nombre_archivos LIKE '%$archiv_bus%' ORDER BY fecha_archivos DESC";
    $busq_act = true;

} else { //Mostrar todos

    if (isset($id)) {
        $id_cat = (get_magic_quotes_gpc()) ? $id : addslashes($id);
    }else $id_cat = -1;

    $query_img  = "SELECT * FROM archivos WHERE categoria_archivos = $id_cat ORDER BY fecha_archivos DESC";

}

//configuracion de la paginacion
$paging = new PHPPaging;
$paging->agregarConsulta($query_img);
if($cookie_vbrw == 1)$paging->porPagina(12);
else $paging->porPagina(10);

$paging->ejecutar();
$num_paginas = $paging->numTotalPaginas();
$total_registros = $paging->numTotalRegistros();

?>

<div class="contain_men_cat">
    <ul class="menu_cat">
        <li><a href="filebrowser.php?seccion=1&amp;<?php if($busq_act) echo "busqueda=$busqueda"; else echo "id=$id" ?>&amp;set_c=1" class="thumbnail_a<?php if($cookie_vbrw == 1) echo '_activo' ?>">Thumbnals</a></li>
        <li><a href="filebrowser.php?seccion=1&amp;<?php if($busq_act) echo "busqueda=$busqueda"; else echo "id=$id" ?>&amp;set_c=2" class="lista_a<?php if($cookie_vbrw == 2) echo '_activo' ?>">Lista</a></li>

        <?php if(!$busq_act){ ?>
        <li><a href="filebrowser.php?seccion=2&amp;cat=<?php echo $id_cat ?>" class="subir_img_a" title="Subir imagen en este directorio">Subir</a></li>
        <?php }?>
    </ul>
    <div class="clear"></div>
</div>

<?php

//enlaces de la navegacion
if($num_paginas > 1) echo '<div class="paginacion">'.$paging->fetchNavegacion().'</div>';
$cuenta_form = 2;

//si esxisten achivos
if($total_registros > 0){?>
<ul class="imag_list_ul<?php if($cookie_vbrw == 2) echo '_lista' ?>">

    <?php
    //loop de la navegacion
    while($result_categorias_img = $paging->fetchResultado()){
        //swith para las clases de los tipo de archivos
        switch($result_categorias_img['extension_archivos']){
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
                $mime_t = 'imagen';
            break;
            case 'pdf':
                $mime_t = 'pdf2';
            break;
            case 'doc':
            case 'docx':
                $mime_t = 'doc2';
            break;
            case 'xls':
            case 'xlsx':
                $mime_t = 'xls2';
            break;
            case 'ppt':
            case 'pptx':
                $mime_t = 'ppt2';
            break;
            default: $mime_t = 'gen2';
        }

        //si la vista es thumnails
        if($cookie_vbrw == 1){?>
        <li>
            <?php if($mime_t == 'imagen') {?>
            
                <a href="filebrowser.php?seccion=4&amp;id=<?php echo $result_categorias_img['id_archivos'] ?>" title="<?php echo $result_categorias_img['nombre_archivos'] ?>"><img src="img.php?file=<?php echo $ruta ?>archivos/<?php echo $result_categorias_img['archivo_archivos'] ?>&amp;ancho=75&amp;alto=75&amp;cut" width="75" height="75" alt="" /></a>

            <?php } else { ?>

            <div class="archivos_list_dv">
            <a href="filebrowser.php?seccion=4&amp;id=<?php echo $result_categorias_img['id_archivos'] ?>" title="<?php echo $result_categorias_img['nombre_archivos'] ?>"><img src="img/<?php echo $mime_t ?>.png" alt=""  width="75" height="75" /></a>            </div>

            <?php } ?>

            <form id="form_submit" method="post" action="" class="centrar_2" onsubmit="jFileBrowserDialog.confirmar('estas seguro que quieres borrar esta imagen', <?php echo $cuenta_form ?>);return false">
                <input type="image" name="borrar_cat_bt" id="borrar_cat_bt" src="img/delete.png" />
                <input name="validacion" type="hidden" id="validacion2" value="4" />
                <input name="id" type="hidden" id="id" value="<?php echo $result_categorias_img['id_archivos'] ?>" />
            </form>
        </li>
        <?php }

        //si la vista es lista
        elseif($cookie_vbrw == 2){ ?>
            <li>
                <div>
                    <form id="form_submit<?php if($cookie_vbrw == 2) echo '_lista' ?>" method="post" action="" class="centrar_2" onsubmit="jFileBrowserDialog.confirmar('estas seguro que quieres borrar esta imagen', <?php echo $cuenta_form ?>);return false">
                    <input type="image" name="borrar_cat_bt" id="borrar_cat_bt" src="img/delete.png" />
                    <input name="validacion" type="hidden" id="validacion2" value="4" />
                    <input name="id" type="hidden" id="id" value="<?php echo $result_categorias_img['id_archivos'] ?>" />
                    </form>
                    <a href="filebrowser.php?seccion=4&amp;id=<?php echo $result_categorias_img['id_archivos'] ?>" title="<?php echo $result_categorias_img['nombre_archivos'] ?>" class="archivos_mime_<?php echo $mime_t ?>"><?php echo $result_categorias_img['nombre_archivos'] ?></a>
                </div>
            </li>
        <?php } ?>

        <?php ++$cuenta_form;

    } ?>
</ul>
<?php } else echo 'no se encontr&oacute; ning&uacute;n archivo';
