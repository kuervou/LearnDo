<?php

namespace App\Controllers;

use App\Models\EstudianteModel;
use App\Models\CourseModel;

require_once __DIR__ . '\..\..\vendor\autoload.php';

class PdfController extends BaseController {
    public function generatePdf() {
        // Configura la biblioteca PDF según las necesidades específicas de tu proyecto
        $pdf = new \Mpdf\Mpdf();
        // Puedes configurar opciones adicionales del PDF según la documentación de mPDF

        //Traemos los parametros de la url
        $nick = $this->request->getGet('nick_estudiante');
        $id_curso = $this->request->getGet('id_curso');

        $EstudianteModel = new EstudianteModel();
        $estudiante = $EstudianteModel->obtenerEstudiante(['nick' => $nick]);

        $CourseModel = new CourseModel();
        $curso = $CourseModel->obtenerCurso(['id_curso' => $id_curso]);

        //Inicializamos la fecha de hoy
        $fecha_hoy = date('d/m/Y');

        // Genera el contenido del PDF
        $pdfContent = ' 
            <html>
            <head>
            <title>Certificado de Finalización</title>
            <meta charset="UTF-8">
            </head>
            <body>
            <div class="certificate">
                <img src="\LearnDo\public\assets\images\Logo.png" class="logo">
                <h2>Certificado de Finalización</h2>
                <p>Se otorga a:</p>
                <h3>'.$estudiante[0]['nombre'].' '.$estudiante[0]['apellido']. '</h3>
                <p>Por completar el curso:</p>
                <h4>'.$curso[0]['nombre']. '</h4>
                <p>Fecha de finalización:'.$fecha_hoy.'</p>
                <footer>
                <p>&copy; 2023 LearnDo. Todos los derechos reservados.</p>
                </footer>
            </div>
            </body>
            </html>

            
            <style>


html {
  min-height: 100%;
}

body {
    background-image: linear-gradient(135deg, rgb(17, 27, 34) 0%, rgb(20, 126, 159) 100%);
    font-family: Arial, sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
  }

.certificate {
  width: 50%;
  height: 80%;
  margin: auto;
  padding: 15px;
  background-color: rgb(255, 255, 255);
  border: 1px solid rgb(0, 0, 0);
  text-align: center;
  border-radius: 5%;
}

.logo {
    border-radius: 25%;
    top: 15px;
    right: 15px;
    max-width: 100px;
    height: auto;
    margin-top: 10%;
  }
  
  h2 {
    font-size: 24px;
    margin-bottom: 15px;
    color: rgb(16, 100, 116);
  }
  
  h3 {
    font-size: 20px;
    margin-top: 15px * 2;
    margin-bottom: 15px;
    color: rgb(17, 27, 34);
  }
  
  h4 {
    font-size: 18px;
    margin-top: 15px;
    margin-bottom: 15px;
    color: rgb(20, 126, 159);
  }
  
  p {
    font-size: 16px;
    margin-bottom: 15px;
    color: rgb(17, 27, 34);
  }

footer {
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: rgb(238, 238, 238);
  padding: 15px;
  text-align: center;
  font-size: 14px;
}
</style>
        ';
        // Crea el archivo PDF utilizando la biblioteca y el contenido generado
        $pdf->WriteHTML($pdfContent);

        // Descarga el archivo PDF
        $pdf->Output('certificado.pdf', 'D');
    }

}