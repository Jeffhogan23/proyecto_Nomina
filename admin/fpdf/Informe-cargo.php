<?php
require_once 'fpdf.php';

class PDF extends FPDF
{
    public $fill = true; // Variable para alternar el color de fondo de las filas

    // Cabecera de página
    function Header()
    {
        // Establecer la imagen del logo y otros elementos de la cabecera
        $this->Image('logo.png', 2, 1, 25);
        $this->Ln(6);
        $this->SetFont('Arial', 'B', 19);
        $this->Cell(45);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(100, 12, utf8_decode('CONTAX EMPLOYEE'), 1, 1, 'C', 0);
        $this->Ln(6); // Añadir espacio después de la cabecera de la empresa
        $this->SetTextColor(103);

        // Calcular la posición para la fecha (esquina superior derecha)
        $fechaX = $this->GetPageWidth() - $this->GetStringWidth('Fecha: ' . date('d/m/Y')) - 10;
        $fechaY = 22; // Altura igual al logo + 6 (espacio adicional) + 12 (altura de la celda de la empresa)

        // Mostrar la fecha en la esquina superior derecha
        $this->Ln(20); // Añadir espacio
        $this->SetXY($fechaX, $fechaY);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 10); // Reducir el tamaño de la fuente para la fecha
        date_default_timezone_set('UTC'); // Establecer temporalmente la zona horaria a UTC
        $this->Cell(0, -30, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');

        // Cabecera de la tabla
        $this->Ln(55); // Añadir espacio
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(211, 211, 211); // Gris claro
        $this->Cell(18, 10, 'ID', 1, 0, 'C', $this->fill);
        $this->Cell(130, 10, 'Nombre del Cargo', 1, 0, 'C', !$this->fill);
        $this->Cell(42, 10, 'Salario', 1, 1, 'C', $this->fill);
        $this->fill = !$this->fill; // Alternar el color de fondo
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Método para agregar la marca de agua
    function AddWatermark()
    {
        // Obtener las dimensiones de la página
        $pageWidth = $this->GetPageWidth();
        $pageHeight = $this->GetPageHeight();

        // Calcular la posición central de la página
        $x = ($pageWidth - 100) / 2;
        $y = ($pageHeight - 100) / 2;

        // Agregar la imagen del logo como marca de agua en el centro de la página con transparencia
        $this->Image('logo.png', $x, $y, 100, 100, 'PNG');
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();

// Agregar la marca de agua en cada página
$pdf->AddWatermark();

// Establecer la conexión a la base de datos
require '../../config/database.php';    
$db = new Database();
$con = $db->conectar();


// Inicializar la variable de consulta SQL
$sql = "SELECT * FROM cargo WHERE 1";

// Verificar si se proporcionó un parámetro de búsqueda
if (isset($_GET['search']) && !empty($_GET['search'])) {
    // Limpiar y escapar el parámetro de búsqueda para evitar inyección SQL
    $search = mysqli_real_escape_string($link, $_GET['search']);
    // Aplicar el filtro a la consulta SQL
    $sql .= " AND (IDcargo LIKE '%$search%' OR NombreCargo LIKE '%$search%' OR SalarioCargo LIKE '%$search%')";
}

if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        // Iterar sobre los resultados y agregarlos al PDF
        while ($row = mysqli_fetch_array($result)) {
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetDrawColor(163, 163, 163);
            // Alternar el color de fondo de las filas de la tabla
            $pdf->SetFillColor($pdf->fill ? 211 : 255, $pdf->fill ? 211 : 255, $pdf->fill ? 211 : 255);
            // Centrar verticalmente el contenido en la celda
            $pdf->Cell(18, 10, $row['IDcargo'], 1, 0, 'C', $pdf->fill);
            $pdf->Cell(130, 10, utf8_decode($row['NombreCargo']), 1, 0, 'C', !$pdf->fill);
            // Centrar horizontalmente el contenido en la celda
            $pdf->Cell(42, 10, '$' . $row['SalarioCargo'], 1, 1, 'C', $pdf->fill);
            $pdf->fill = !$pdf->fill; // Alternar el color de fondo
        }
        // Liberar el conjunto de resultados
        mysqli_free_result($result);
    } else {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'No se encontraron cargos.', 0, 1);
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Error al ejecutar la consulta: ' . mysqli_error($link), 0, 1);
}

// Cerrar la conexión a la base de datos
mysqli_close($link);

// Salida del PDF
$pdf->Output();
?>
