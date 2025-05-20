<?php
include "conexion.php";

// Establece las cabeceras para descargar un archivo XML
header("Content-Type: text/xml");
header("Content-Disposition: attachment; filename=productos.xml");

// Crea un nuevo documento XML con formato
$xml = new DOMDocument("1.0", "UTF-8");
$xml->formatOutput = true;


// Nodo raíz del documento <catalogo>
$root = $xml->createElement("catalogo");
$xml->appendChild($root);

// Consulta para obtener los productos
$stmt = $conn->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($productos as $producto) {
    // Crea un nodo <producto> por cada fila
    $productoElement = $xml->createElement("producto");

    // Añade los datos del producto como nodos hijos
    $referencia = $xml->createElement("referencia", htmlspecialchars($producto["referencia"]));
    $nombre = $xml->createElement("nombre", htmlspecialchars($producto["nombre"]));
    $precio = $xml->createElement("precio", number_format($producto["precio"], 2));

     // Anida los elementos dentro de <producto>
    $productoElement->appendChild($referencia);
    $productoElement->appendChild($nombre);
    $productoElement->appendChild($precio);

    // Añade <producto> al nodo raíz <catalogo>
    $root->appendChild($productoElement);
}

// Imprime el XML generado (que será descargado por el navegador)
echo $xml->saveXML();
?>