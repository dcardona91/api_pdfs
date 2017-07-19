<?php
namespace ThisApp\Models;

use \Setasign\fpdf\Fpdf;
use \Setasign\fpdi\Fpdi;
use \Exception;

class Pdf
{

	public function generate($pdf, $datos )
	{ 
		try {
			if (!method_exists($this, $pdf)) {
				throw new Exception("El documento no existe");				
			}else{
				call_user_func($this->$pdf($datos));
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}		
	}

	private function public_hv($datos)
	{	
		/*
		$datosFinales = $this->getQueryString();
		$pdf = new Fpdf();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$y = 10;
		$pdf->Cell(2,$y,'Ejemplo');
		foreach ($datosFinales as $key => $value) {
			$pdf->ln();
			$pdf->write(10, $key.":  ".$value);
		}
		$pdf->Output();
		*/
		//require_once('fpdf.php');
		//require_once('fpdi.php');
		$pdf = new Fpdi();

		$pageCount = $pdf->setSourceFile(__DIR__ .'/../../public/documents/public_hv.pdf');
		$templateId = $pdf->importPage(1);
		$size = $pdf->getTemplateSize($templateId);
		if ($size['w'] > $size['h']) {
        	$pdf->AddPage('L', array($size['w'], $size['h']));
	    } else {
	        $pdf->AddPage('P', array($size['w'], $size['h']));
	    }
	    $pdf->useTemplate($templateId);

		/*
		PAGINA 1
		*/
		$pdf->SetFont('Arial','',10);
		$datosFinales = $this->getQueryString();

		/*
		foreach ($datosFinales as $key => $value) {
			$ubicacion = explode("_", $key)[0];
			if ($ubicacion == "fa" or $ubicacion == "dp") {
				$pdf->ln();
				$pdf->write(10, $key.":  ".$value);
				unset($datosFinales[$key]);
			}					
		}
		*/
		$pdf->Text(22, 67, $datosFinales["dp_pape"]);
		$pdf->Text(80, 67, $datosFinales["dp_sape"]);
		$pdf->Text(140, 67, $datosFinales["dp_noms"]);
		switch ($datosFinales["dp_tdoc"]) {
			case 'pas':
				$pdf->Text(52, 77, 'X');
				break;
			case 'ce':
				$pdf->Text(40, 77, 'X');
				break;
			default:
				$pdf->Text(29.4, 77, 'X');
				break;
		}
		$pdf->Text(65, 77, $datosFinales["dp_ndoc"]);

		if ($datosFinales["dp_sexo"] == 'f')
			$pdf->Text(111.8, 77, 'X');
		else
			$pdf->Text(120.5, 77, 'X');

		if ($datosFinales["dp_col"]) {
			$pdf->Text(135.5, 76.8, 'X');
		}else{
			$pdf->Text(161, 76.87, 'X');
			$pdf->Text(167, 76.87, $datosFinales["dp_pais"]);
		}

		if ($datosFinales["dp_lmpc"])
			$pdf->Text(51.5, 87.5, 'X');
		else
			$pdf->Text(92.3, 87.5, 'X');

		$pdf->Text(118, 87.5, $datosFinales["dp_nlm"]);
		$pdf->Text(175, 87.5, $datosFinales["dp_dm"]);

		$pdf->Text(49, 100, $datosFinales["dp_dnace"]);
		$pdf->Text(66.5, 100, $datosFinales["dp_mnace"]);
		$pdf->Text(84, 100, $datosFinales["dp_anace"]);
		$pdf->Text(40.5, 107, $datosFinales["dp_pnace"]);
		$pdf->Text(40.5, 112.8, $datosFinales["dp_dptnace"]);
		$pdf->Text(40.5, 118.8, $datosFinales["dp_munace"]);

		$pdf->Text(103, 100, $datosFinales["dp_dir"]);
		$pdf->Text(112, 107, $datosFinales["dp_pais"]);
		$pdf->Text(166.5, 107, $datosFinales["dp_depto"]);
		$pdf->Text(121.5, 112.8, $datosFinales["dp_muni"]);
		$pdf->Text(121.5, 118.6, $datosFinales["dp_tel"]);
		$pdf->Text(166.5, 118.6, $datosFinales["dp_email"]);

		$pdf->Text(127.5, 156, $datosFinales["fa_titulo"]);

		switch ($datosFinales["fa_nescolar"]) {
				case '1':
					$pdf->Text(37, 166.5,'X');	
					break;
				case '2':
					$pdf->Text(43, 166.5,'X');
					break;
				case '3':
					$pdf->Text(49, 166.5,'X');
					break;
				case '4':
					$pdf->Text(55, 166.5,'X');
					break;
				case '5':
					$pdf->Text(61, 166.5,'X');
					break;
				case '6':
					$pdf->Text(67, 166.5,'X');
					break;
				case '7':
					$pdf->Text(73, 166.5,'X');
					break;
				case '8':
					$pdf->Text(79, 166.5,'X');
					break;
				case '9':
					$pdf->Text(85, 166.5,'X');
					break;
				case '10':
					$pdf->Text(91, 166.5,'X');
					break;				
				default:
					$pdf->Text(97, 166.5,'X');
					break;
			}	

		$pdf->Text(124.8, 166.5, $datosFinales["fa_mes"]);
		$pdf->Text(147, 166.5, $datosFinales["fa_ano"]);
		
		$pdf->Text(25, 209, $datosFinales["fa_modaca1"]);
		$pdf->Text(45, 209, $datosFinales["fa_semapro1"]);		
		if($datosFinales["fa_gradua1"])
			$pdf->Text(64.5, 209,'X');
		else
			$pdf->Text(73.5, 209,'X');
		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 209,$datosFinales["fa_titulo1"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 209,$datosFinales["fa_mtermina1"]);
		$partes = str_split($datosFinales["fa_atermina1"]);
		$pdf->Text(159, 209,$partes[0]);
		$pdf->Text(164, 209,$partes[1]);
		$pdf->Text(168, 209,$partes[2]);
		$pdf->Text(173, 209,$partes[3]);
		$pdf->Text(177.5, 209,$datosFinales["fa_notprof1"]);

//FORMACION ACADEMICA 2
		$pdf->Text(25, 215, $datosFinales["fa_modaca2"]);
		$pdf->Text(45, 215, $datosFinales["fa_semapro2"]);		
		if($datosFinales["fa_gradua2"])
			$pdf->Text(64.5, 215,'X');
		else
			$pdf->Text(73.5, 215,'X');
		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 215,$datosFinales["fa_titulo2"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 215,$datosFinales["fa_mtermina2"]);
		$partes = str_split($datosFinales["fa_atermina2"]);
		$pdf->Text(159, 215,$partes[0]);
		$pdf->Text(164, 215,$partes[1]);
		$pdf->Text(168, 215,$partes[2]);
		$pdf->Text(173, 215,$partes[3]);
		$pdf->Text(177.5, 215,$datosFinales["fa_notprof2"]);

//FORMACION ACADEMICA 3
		$pdf->Text(25, 221, $datosFinales["fa_modaca3"]);
		$pdf->Text(45, 221, $datosFinales["fa_semapro3"]);		
		if($datosFinales["fa_gradua3"])
			$pdf->Text(64.5, 221,'X');
		else
			$pdf->Text(73.5, 221,'X');
		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 221,$datosFinales["fa_titulo3"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 221,$datosFinales["fa_mtermina3"]);
		$partes = str_split($datosFinales["fa_atermina3"]);
		$pdf->Text(159, 221,$partes[0]);
		$pdf->Text(164, 221,$partes[1]);
		$pdf->Text(168, 221,$partes[2]);
		$pdf->Text(173, 221,$partes[3]);
		$pdf->Text(177.5, 221,$datosFinales["fa_notprof3"]);

//FORMACION ACADEMICA 4
		$pdf->Text(25, 227, $datosFinales["fa_modaca4"]);
		$pdf->Text(45, 227, $datosFinales["fa_semapro4"]);		
		if($datosFinales["fa_gradua4"])
			$pdf->Text(64.5, 227,'X');
		else
			$pdf->Text(73.5, 227,'X');
		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 227,$datosFinales["fa_titulo4"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 227,$datosFinales["fa_mtermina4"]);
		$partes = str_split($datosFinales["fa_atermina4"]);
		$pdf->Text(159, 227,$partes[0]);
		$pdf->Text(164, 227,$partes[1]);
		$pdf->Text(168, 227,$partes[2]);
		$pdf->Text(173, 227,$partes[3]);
		$pdf->Text(177.5, 227,$datosFinales["fa_notprof4"]);

//FORMACION ACADEMICA 5
		$pdf->Text(25, 233, $datosFinales["fa_modaca5"]);
		$pdf->Text(45, 233, $datosFinales["fa_semapro5"]);		
		if($datosFinales["fa_gradua5"])
			$pdf->Text(64.5, 233,'X');
		else
			$pdf->Text(73.5, 233,'X');
		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 233,$datosFinales["fa_titulo5"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 233,$datosFinales["fa_mtermina5"]);
		$partes = str_split($datosFinales["fa_atermina5"]);
		$pdf->Text(159, 233,$partes[0]);
		$pdf->Text(164, 233,$partes[1]);
		$pdf->Text(168, 233,$partes[2]);
		$pdf->Text(173, 233,$partes[3]);
		$pdf->Text(177.5, 233,$datosFinales["fa_notprof5"]);
		/*
		PAGINA 2
		*/
		$templateId = $pdf->importPage(2);
		$size = $pdf->getTemplateSize($templateId);
		if ($size['w'] > $size['h']) {
        	$pdf->AddPage('L', array($size['w'], $size['h']));
	    } else {
	        $pdf->AddPage('P', array($size['w'], $size['h']));
	    }
	    $pdf->useTemplate($templateId);

	    foreach ($datosFinales as $key => $value) {
			$ubicacion = explode("_", $key)[0];
			if ($ubicacion == "el" ) {
				$pdf->ln();
				$pdf->write(10, $key.":  ".$value);
				unset($datosFinales[$key]);
			}					
		}

		/*
		PAGINA 3
		*/
		$templateId = $pdf->importPage(3);
		$size = $pdf->getTemplateSize($templateId);
		if ($size['w'] > $size['h']) {
        	$pdf->AddPage('L', array($size['w'], $size['h']));
	    } else {
	        $pdf->AddPage('P', array($size['w'], $size['h']));
	    }
	    $pdf->useTemplate($templateId);

	    foreach ($datosFinales as $key => $value) {
				$pdf->ln();
				$pdf->write(10, $key.":  ".$value);		
		}
		$pdf->Output();
	}

	private function getQueryString(){
		return array('dp_pape' => isset($datos->dp_pape) ? $datos->dp_pape : "N/A", 
				'dp_sape' => isset($datos->dp_sape) ? $datos->dp_sape : "N/A", 
				'dp_noms' => isset($datos->dp_noms) ? $datos->dp_noms : "N/A", 
				'dp_tdoc' => isset($datos->dp_tdoc) ? $datos->dp_tdoc : "N/A", 
				'dp_ndoc' => isset($datos->dp_ndoc) ? $datos->dp_ndoc : "N/A", 
				'dp_sexo' => isset($datos->dp_sexo) ? $datos->dp_sexo : "N/A", 
				'dp_col' => isset($datos->dp_col) ? $datos->dp_col : "N/A", 
				'dp_pais' => isset($datos->dp_pais) ? $datos->dp_pais : "N/A", 
				'dp_lmpc' => isset($datos->dp_lmpc) ? $datos->dp_lmpc : "N/A", 
				'dp_nlm' => isset($datos->dp_nlm) ? $datos->dp_nlm : "N/A", 
				'dp_dm' => isset($datos->dp_dm) ? $datos->dp_dm : "N/A", 
				'dp_dnace' => isset($datos->dp_dnace) ? $datos->dp_dnace : "N/A", 
				'dp_mnace' => isset($datos->dp_mnace) ? $datos->dp_mnace : "N/A", 
				'dp_anace' => isset($datos->dp_anace) ? $datos->dp_anace : "N/A", 
				'dp_pnace' => isset($datos->dp_pnace) ? $datos->dp_pnace : "N/A", 
				'dp_dptnace' => isset($datos->dp_dptnace) ? $datos->dp_dptnace : "N/A", 
				'dp_munace' => isset($datos->dp_munace) ? $datos->dp_munace : "N/A", 
				'dp_dir' => isset($datos->dp_dir) ? $datos->dp_dir : "N/A", 
				'dp_pais' => isset($datos->dp_pais) ? $datos->dp_pais : "N/A", 
				'dp_depto' => isset($datos->dp_depto) ? $datos->dp_depto : "N/A", 
				'dp_muni' => isset($datos->dp_muni) ? $datos->dp_muni : "N/A", 
				'dp_tel' => isset($datos->dp_tel) ? $datos->dp_tel : "N/A", 
				'dp_email' => isset($datos->dp_email) ? $datos->dp_email : "N/A", 
				'fa_titulo' => isset($datos->fa_titulo) ? $datos->fa_titulo : "N/A", 
				'fa_nescolar' => isset($datos->fa_nescolar) ? $datos->fa_nescolar : "N/A", 
				'fa_mes' => isset($datos->fa_mes) ? $datos->fa_mes : "N/A", 
				'fa_ano' => isset($datos->fa_ano) ? $datos->fa_ano : "N/A", 
				'fa_modaca1' => isset($datos->fa_modaca1) ? $datos->fa_modaca1 : "N/A", 
				'fa_semapro1' => isset($datos->fa_semapro1) ? $datos->fa_semapro1 : "N/A", 
				'fa_gradua1' => isset($datos->fa_gradua1) ? $datos->fa_gradua1 : "N/A", 
				'fa_titulo1' => isset($datos->fa_titulo1) ? $datos->fa_titulo1 : "N/A", 
				'fa_mtermina1' => isset($datos->fa_mtermina1) ? $datos->fa_mtermina1 : "N/A", 
				'fa_atermina1' => isset($datos->fa_atermina1) ? $datos->fa_atermina1 : "1999", 
				'fa_notprof1' => isset($datos->fa_notprof1) ? $datos->fa_notprof1 : "N/A", 
				'fa_modaca2' => isset($datos->fa_modaca2) ? $datos->fa_modaca2 : "N/A", 
				'fa_semapro2' => isset($datos->fa_semapro2) ? $datos->fa_semapro2 : "N/A", 
				'fa_gradua2' => isset($datos->fa_gradua2) ? $datos->fa_gradua2 : "N/A", 
				'fa_titulo2' => isset($datos->fa_titulo2) ? $datos->fa_titulo2 : "N/A", 
				'fa_mtermina2' => isset($datos->fa_mtermina2) ? $datos->fa_mtermina2 : "N/A", 
				'fa_atermina2' => isset($datos->fa_atermina2) ? $datos->fa_atermina2 : "1999", 
				'fa_notprof2' => isset($datos->fa_notprof2) ? $datos->fa_notprof2 : "N/A", 
				'fa_modaca3' => isset($datos->fa_modaca3) ? $datos->fa_modaca3 : "N/A", 
				'fa_semapro3' => isset($datos->fa_semapro3) ? $datos->fa_semapro3 : "N/A", 
				'fa_gradua3' => isset($datos->fa_gradua3) ? $datos->fa_gradua3 : "N/A", 
				'fa_titulo3' => isset($datos->fa_titulo3) ? $datos->fa_titulo3 : "N/A", 
				'fa_mtermina3' => isset($datos->fa_mtermina3) ? $datos->fa_mtermina3 : "N/A", 
				'fa_atermina3' => isset($datos->fa_atermina3) ? $datos->fa_atermina3 : "1999", 
				'fa_notprof3' => isset($datos->fa_notprof3) ? $datos->fa_notprof3 : "N/A", 
				'fa_modaca4' => isset($datos->fa_modaca4) ? $datos->fa_modaca4 : "N/A", 
				'fa_semapro4' => isset($datos->fa_semapro4) ? $datos->fa_semapro4 : "N/A", 
				'fa_gradua4' => isset($datos->fa_gradua4) ? $datos->fa_gradua4 : "N/A", 
				'fa_titulo4' => isset($datos->fa_titulo4) ? $datos->fa_titulo4 : "N/A", 
				'fa_mtermina4' => isset($datos->fa_mtermina4) ? $datos->fa_mtermina4 : "N/A", 
				'fa_atermina4' => isset($datos->fa_atermina4) ? $datos->fa_atermina4 : "1999", 
				'fa_notprof4' => isset($datos->fa_notprof4) ? $datos->fa_notprof4 : "N/A", 
				'fa_modaca5' => isset($datos->fa_modaca5) ? $datos->fa_modaca5 : "N/A", 
				'fa_semapro5' => isset($datos->fa_semapro5) ? $datos->fa_semapro5 : "N/A", 
				'fa_gradua5' => isset($datos->fa_gradua5) ? $datos->fa_gradua5 : "N/A", 
				'fa_titulo5' => isset($datos->fa_titulo5) ? $datos->fa_titulo5 : "N/A", 
				'fa_mtermina5' => isset($datos->fa_mtermina5) ? $datos->fa_mtermina5 : "N/A", 
				'fa_atermina5' => isset($datos->fa_atermina5) ? $datos->fa_atermina5 : "1999", 
				'fa_notprof5' => isset($datos->fa_notprof5) ? $datos->fa_notprof5 : "N/A", 
				'fa_idioma1' => isset($datos->fa_idioma1) ? $datos->fa_idioma1 : "N/A", 
				'fa_habla1' => isset($datos->fa_habla1) ? $datos->fa_habla1 : "N/A", 
				'fa_lee1' => isset($datos->fa_lee1) ? $datos->fa_lee1 : "N/A", 
				'fa_escribe1' => isset($datos->fa_escribe1) ? $datos->fa_escribe1 : "N/A", 
				'fa_idioma2' => isset($datos->fa_idioma2) ? $datos->fa_idioma2 : "N/A", 
				'fa_habla2' => isset($datos->fa_habla2) ? $datos->fa_habla2 : "N/A", 
				'fa_lee2' => isset($datos->fa_lee2) ? $datos->fa_lee2 : "N/A", 
				'fa_escribe2' => isset($datos->fa_escribe2) ? $datos->fa_escribe2 : "N/A", 
				'el_empresa1' => isset($datos->el_empresa1) ? $datos->el_empresa1 : "N/A", 
				'el_publica1' => isset($datos->el_publica1) ? $datos->el_publica1 : "N/A", 
				'el_pais1' => isset($datos->el_pais1) ? $datos->el_pais1 : "N/A", 
				'el_depto1' => isset($datos->el_depto1) ? $datos->el_depto1 : "N/A", 
				'el_muni1' => isset($datos->el_muni1) ? $datos->el_muni1 : "N/A", 
				'el_correo1' => isset($datos->el_correo1) ? $datos->el_correo1 : "N/A", 
				'el_tel1' => isset($datos->el_tel1) ? $datos->el_tel1 : "N/A", 
				'el_dingresa1' => isset($datos->el_dingresa1) ? $datos->el_dingresa1 : "N/A", 
				'el_mingresa1' => isset($datos->el_mingresa1) ? $datos->el_mingresa1 : "N/A", 
				'el_aingresa1' => isset($datos->el_aingresa1) ? $datos->el_aingresa1 : "N/A", 
				'el_dretiro1' => isset($datos->el_dretiro1) ? $datos->el_dretiro1 : "N/A", 
				'el_mretiro1' => isset($datos->el_mretiro1) ? $datos->el_mretiro1 : "N/A", 
				'el_aretiro1' => isset($datos->el_aretiro1) ? $datos->el_aretiro1 : "N/A", 
				'el_cargo1' => isset($datos->el_cargo1) ? $datos->el_cargo1 : "N/A", 
				'el_depen1' => isset($datos->el_depen1) ? $datos->el_depen1 : "N/A", 
				'el_dir1' => isset($datos->el_dir1) ? $datos->el_dir1 : "N/A", 
				'el_empresa2' => isset($datos->el_empresa2) ? $datos->el_empresa2 : "N/A", 
				'el_publica2' => isset($datos->el_publica2) ? $datos->el_publica2 : "N/A", 
				'el_pais2' => isset($datos->el_pais2) ? $datos->el_pais2 : "N/A", 
				'el_depto2' => isset($datos->el_depto2) ? $datos->el_depto2 : "N/A", 
				'el_muni2' => isset($datos->el_muni2) ? $datos->el_muni2 : "N/A", 
				'el_correo2' => isset($datos->el_correo2) ? $datos->el_correo2 : "N/A", 
				'el_tel2' => isset($datos->el_tel2) ? $datos->el_tel2 : "N/A", 
				'el_dingresa2' => isset($datos->el_dingresa2) ? $datos->el_dingresa2 : "N/A", 
				'el_mingresa2' => isset($datos->el_mingresa2) ? $datos->el_mingresa2 : "N/A", 
				'el_aingresa2' => isset($datos->el_aingresa2) ? $datos->el_aingresa2 : "N/A", 
				'el_dretiro2' => isset($datos->el_dretiro2) ? $datos->el_dretiro2 : "N/A", 
				'el_mretiro2' => isset($datos->el_mretiro2) ? $datos->el_mretiro2 : "N/A", 
				'el_aretiro2' => isset($datos->el_aretiro2) ? $datos->el_aretiro2 : "N/A", 
				'el_cargo2' => isset($datos->el_cargo2) ? $datos->el_cargo2 : "N/A", 
				'el_depen2' => isset($datos->el_depen2) ? $datos->el_depen2 : "N/A", 
				'el_dir2' => isset($datos->el_dir2) ? $datos->el_dir2 : "N/A", 
				'el_empresa3' => isset($datos->el_empresa3) ? $datos->el_empresa3 : "N/A", 
				'el_publica3' => isset($datos->el_publica3) ? $datos->el_publica3 : "N/A", 
				'el_pais3' => isset($datos->el_pais3) ? $datos->el_pais3 : "N/A", 
				'el_depto3' => isset($datos->el_depto3) ? $datos->el_depto3 : "N/A", 
				'el_muni3' => isset($datos->el_muni3) ? $datos->el_muni3 : "N/A", 
				'el_correo3' => isset($datos->el_correo3) ? $datos->el_correo3 : "N/A", 
				'el_tel3' => isset($datos->el_tel3) ? $datos->el_tel3 : "N/A", 
				'el_dingresa3' => isset($datos->el_dingresa3) ? $datos->el_dingresa3 : "N/A", 
				'el_mingresa3' => isset($datos->el_mingresa3) ? $datos->el_mingresa3 : "N/A", 
				'el_aingresa3' => isset($datos->el_aingresa3) ? $datos->el_aingresa3 : "N/A", 
				'el_dretiro3' => isset($datos->el_dretiro3) ? $datos->el_dretiro3 : "N/A", 
				'el_mretiro3' => isset($datos->el_mretiro3) ? $datos->el_mretiro3 : "N/A", 
				'el_aretiro3' => isset($datos->el_aretiro3) ? $datos->el_aretiro3 : "N/A", 
				'el_cargo3' => isset($datos->el_cargo3) ? $datos->el_cargo3 : "N/A", 
				'el_depen3' => isset($datos->el_depen3) ? $datos->el_depen3 : "N/A", 
				'el_dir3' => isset($datos->el_dir3) ? $datos->el_dir3 : "N/A", 
				'el_empresa4' => isset($datos->el_empresa4) ? $datos->el_empresa4 : "N/A", 
				'el_publica4' => isset($datos->el_publica4) ? $datos->el_publica4 : "N/A", 
				'el_pais4' => isset($datos->el_pais4) ? $datos->el_pais4 : "N/A", 
				'el_depto4' => isset($datos->el_depto4) ? $datos->el_depto4 : "N/A", 
				'el_muni4' => isset($datos->el_muni4) ? $datos->el_muni4 : "N/A", 
				'el_correo4' => isset($datos->el_correo4) ? $datos->el_correo4 : "N/A", 
				'el_tel4' => isset($datos->el_tel4) ? $datos->el_tel4 : "N/A", 
				'el_dingresa4' => isset($datos->el_dingresa4) ? $datos->el_dingresa4 : "N/A", 
				'el_mingresa4' => isset($datos->el_mingresa4) ? $datos->el_mingresa4 : "N/A", 
				'el_aingresa4' => isset($datos->el_aingresa4) ? $datos->el_aingresa4 : "N/A", 
				'el_dretiro4' => isset($datos->el_dretiro4) ? $datos->el_dretiro4 : "N/A", 
				'el_mretiro4' => isset($datos->el_mretiro4) ? $datos->el_mretiro4 : "N/A", 
				'el_aretiro4' => isset($datos->el_aretiro4) ? $datos->el_aretiro4 : "N/A", 
				'el_cargo4' => isset($datos->el_cargo4) ? $datos->el_cargo4 : "N/A", 
				'el_depen4' => isset($datos->el_depen4) ? $datos->el_depen4 : "N/A", 
				'el_dir4' => isset($datos->el_dir4) ? $datos->el_dir4 : "N/A", 
				'tte_mserpubli' => isset($datos->tte_mserpubli) ? $datos->tte_mserpubli : "N/A", 
				'tte_mprivado' => isset($datos->tte_mprivado) ? $datos->tte_mprivado : "N/A", 
				'tte_mindep' => isset($datos->tte_mindep) ? $datos->tte_mindep : "N/A");
	}
}