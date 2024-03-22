<?php
require_once 'fpdf.php';

class PDF extends FPDF
{
    public $fill = true; // Variable para alternar el color de fondo de las filas

    // Cabecera de página
    function Header()
    {
        // Establecer la imagen del logo y otros elementos de la cabecera
        $this->Image('../fpdf/logo.png', 2, 1, 25);
        $this->Ln(6);
        $this->Ln(6);
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
        date_default_timezone_set('America/Mexico_City'); // Establecer la zona horaria a la de tu ubicación
        $this->Cell(0, -30, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');

        // Cabecera de la tabla
        $this->Ln(55); // Añadir espacio
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(211, 211, 211); // Gris claro
        $this->Cell(18, 10, 'ID', 1, 0, 'C', $this->fill);
        $this->Cell(130, 10, 'Nombre del Rol', 1, 0, 'C', !$this->fill);
        $this->Cell(42, 10, 'Accion', 1, 1, 'C', $this->fill);
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
        $this->Image('../fpdf/logo.png', $x, $y, 100, 100, 'PNG');
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

// Consulta SQL para obtener los datos de los roles
$sql = "SELECT * FROM roles";

// Si se proporciona un parámetro de búsqueda, aplicar filtro por ID o nombre
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE IDrol LIKE '%$search%' OR NombreRol LIKE '%$search%'";
}

$stmt = $con->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($result) {
    // Iterar sobre los resultados y agregarlos al PDF
    foreach ($result as $row) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetDrawColor(163, 163, 163);
        // Alternar el color de fondo de las filas de la tabla
        $pdf->SetFillColor($pdf->fill ? 211 : 255, $pdf->fill ? 211 : 255, $pdf->fill ? 211 : 255);
        $pdf->Cell(18, 10, $row['IDrol'], 1, 0, 'C', true); // Color de fondo según la fila
        $pdf->Cell(130, 10, $row['NombreRol'], 1, 0, 'C', !$pdf->fill); // Color de fondo según la fila
        $pdf->Cell(42, 10, '', 1, 1, 'C', true); // Color de fondo según la fila
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, utf8_decode('No se encontraron registros.'), 1, 1, 'C');
}

// Cerrar la conexión a la base de datos
$con = null;

// Enviar encabezados HTTP para descargar el archivo PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Informe.pdf"');

// Salida del PDF generado
$pdf->Output();
?>