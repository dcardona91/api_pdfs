<?php
namespace ThisApp\Models;

use \Setasign\fpdf\Fpdf;
use \Setasign\fpdi\Fpdi;
use ThisApp\Aplication\Security\Hash;
use ThisApp\Aplication\System\Config;
use \Exception;

class Pdf
{

	public function generate($pdf, $datos)
	{ 
		try {
			if (!method_exists($this, $pdf)) {
				return -1;				
			}else{
				$fpdi = new Fpdi();
				$this->$pdf($fpdi, $datos);
				$nombre = 'hv_publica_'.uniqid().'.pdf';
				$userFolder = isset($datos->user) ? $datos->user : "000";
				$ruta = __DIR__ .'/../../public/documents/'. $userFolder ;
				if(!file_exists($ruta)){
					mkdir($ruta);
				}
				if($fpdi->Output("F",$ruta.'/'.$nombre,true) != ""){
					return -1;
				};
				return Config::get("site/name")."/documents/".$userFolder."/".$nombre;
			}
		} catch (Exception $e) {
			return $e;
		}		
	}

	private function public_hv($pdf, $datos)
	{		
		$pageCount = $pdf->setSourceFile(__DIR__ .'/../../public/documents/public_hv.pdf');
		$pdf->SetFont('Arial','',10);
		$datosFinales = $this->getQueryString($datos);
		$this->getFirstPage($pdf, $datosFinales);
		$this->getSecondPage($pdf, $datosFinales);
		$this->getThirdPage($pdf, $datosFinales);		
	}

	private function getFirstPage($pdf, $datosFinales ){
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
		$pdf->Text(22, 67, utf8_decode($datosFinales["dp_pape"]));
		$pdf->Text(80, 67, utf8_decode($datosFinales["dp_sape"]));
		$pdf->Text(140, 67, utf8_decode($datosFinales["dp_noms"]));
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
			$pdf->Text(167, 76.87, utf8_decode($datosFinales["dp_pais"]));
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
		$pdf->Text(40.5, 107, utf8_decode($datosFinales["dp_pnace"]));
		$pdf->Text(40.5, 112.8, utf8_decode($datosFinales["dp_dptnace"]));
		$pdf->Text(40.5, 118.8, utf8_decode($datosFinales["dp_munace"]));

		$pdf->Text(103, 100, $datosFinales["dp_dir"]);
		$pdf->Text(112, 107, utf8_decode($datosFinales["dp_pais"]));
		$pdf->Text(166.5, 107, utf8_decode($datosFinales["dp_depto"]));
		$pdf->Text(121.5, 112.8, utf8_decode($datosFinales["dp_muni"]));
		$pdf->Text(121.5, 118.6, $datosFinales["dp_tel"]);

		$pdf->SetFont('Arial','',8);
		$pdf->Text(166.5, 118.6, $datosFinales["dp_email"]);
		$pdf->SetFont('Arial','',10);

		$pdf->Text(127.5, 156, utf8_decode($datosFinales["fa_titulo"]));

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

//FORMACION ACADEMICA 1		
		$pdf->Text(25, 209, $datosFinales["fa_modaca1"]);
		$pdf->Text(45, 209, $datosFinales["fa_semapro1"]);		
		if($datosFinales["fa_gradua1"]){
			$pdf->Text(64.5, 209,'X');
		}else{
			if($datosFinales["fa_gradua1"] != "")
			$pdf->Text(73.5, 209,'X');
		}	

		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 209, utf8_decode($datosFinales["fa_titulo1"]));//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 209,$datosFinales["fa_mtermina1"]);
		$partes = str_split($datosFinales["fa_atermina1"]);
		$pdf->Text(159, 209,isset($partes[0]) ? $partes[0] : "");
		$pdf->Text(164, 209,isset($partes[1]) ? $partes[1] : "");
		$pdf->Text(168, 209,isset($partes[2]) ? $partes[2] : "");
		$pdf->Text(173, 209,isset($partes[3]) ? $partes[3] : "");
		$pdf->Text(177.5, 209,$datosFinales["fa_notprof1"]);

//FORMACION ACADEMICA 2
		$pdf->Text(25, 215, $datosFinales["fa_modaca2"]);
		$pdf->Text(45, 215, $datosFinales["fa_semapro2"]);		
		if($datosFinales["fa_gradua2"]){
			$pdf->Text(64.5, 215,'X');
		}else{
			if($datosFinales["fa_gradua2"] != "")
			$pdf->Text(73.5, 215,'X');
		}		

		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 215, utf8_decode($datosFinales["fa_titulo2"]));//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 215,$datosFinales["fa_mtermina2"]);
		$partes = str_split($datosFinales["fa_atermina2"]);

		$pdf->Text(159, 215,isset($partes[0]) ? $partes[0] : "");
		$pdf->Text(164, 215,isset($partes[1]) ? $partes[1] : "");
		$pdf->Text(168, 215,isset($partes[2]) ? $partes[2] : "");
		$pdf->Text(173, 215,isset($partes[3]) ? $partes[3] : "");

		$pdf->Text(177.5, 215,$datosFinales["fa_notprof2"]);

//FORMACION ACADEMICA 3
		$pdf->Text(25, 221, $datosFinales["fa_modaca3"]);
		$pdf->Text(45, 221, $datosFinales["fa_semapro3"]);		
		if($datosFinales["fa_gradua3"]){
			$pdf->Text(64.5, 221,'X');
		}else{
			if($datosFinales["fa_gradua3"] != "")
				$pdf->Text(73.5, 221,'X');
		}

		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 221,$datosFinales["fa_titulo3"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 221,$datosFinales["fa_mtermina3"]);
		$partes = str_split($datosFinales["fa_atermina3"]);
		$pdf->Text(159, 221,isset($partes[0]) ? $partes[0] : "");
		$pdf->Text(164, 221,isset($partes[1]) ? $partes[1] : "");
		$pdf->Text(168, 221,isset($partes[2]) ? $partes[2] : "");
		$pdf->Text(173, 221,isset($partes[3]) ? $partes[3] : "");
		$pdf->Text(177.5, 221,$datosFinales["fa_notprof3"]);

//FORMACION ACADEMICA 4
		$pdf->Text(25, 227, $datosFinales["fa_modaca4"]);
		$pdf->Text(45, 227, $datosFinales["fa_semapro4"]);		
		if($datosFinales["fa_gradua4"]){
			$pdf->Text(64.5, 227,'X');
		}else{
			if($datosFinales["fa_gradua4"] != "")
				$pdf->Text(73.5, 227,'X');
		}

		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 227,$datosFinales["fa_titulo4"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 227,$datosFinales["fa_mtermina4"]);
		$partes = str_split($datosFinales["fa_atermina4"]);
		$pdf->Text(159, 227,isset($partes[0]) ? $partes[0] : "");
		$pdf->Text(164, 227,isset($partes[1]) ? $partes[1] : "");
		$pdf->Text(168, 227,isset($partes[2]) ? $partes[2] : "");
		$pdf->Text(173, 227,isset($partes[3]) ? $partes[3] : "");
		$pdf->Text(177.5, 227,$datosFinales["fa_notprof4"]);

//FORMACION ACADEMICA 5
		$pdf->Text(25, 233, $datosFinales["fa_modaca5"]);
		$pdf->Text(45, 233, $datosFinales["fa_semapro5"]);		
		if($datosFinales["fa_gradua5"]){
			$pdf->Text(64.5, 233,'X');
		}else{
			if($datosFinales["fa_gradua5"] != "")
				$pdf->Text(73.5, 233,'X');
		}

		$pdf->SetFont('Arial','',8);
		$pdf->Text(79, 233,$datosFinales["fa_titulo5"]);//MAX 40 CHAR
		$pdf->SetFont('Arial','',10);
		$pdf->Text(150, 233,$datosFinales["fa_mtermina5"]);
		$partes = str_split($datosFinales["fa_atermina5"]);
		$pdf->Text(159, 233,isset($partes[0]) ? $partes[0] : "");
		$pdf->Text(164, 233,isset($partes[1]) ? $partes[1] : "");
		$pdf->Text(168, 233,isset($partes[2]) ? $partes[2] : "");
		$pdf->Text(173, 233,isset($partes[3]) ? $partes[3] : "");
		$pdf->Text(177.5, 233,$datosFinales["fa_notprof5"]);
		
		$pdf->Text(55, 254.5, utf8_decode($datosFinales["fa_idioma1"]));		
		
		switch ($datosFinales["fa_habla1"]) {
			case "R":
				$pdf->Text(107, 254.5,"X");
				break;
			case "B":
				$pdf->Text(113, 254.5,"X");
				break;			
			case "MB":
				$pdf->Text(119, 254.5,"X");
				break;
		}

		switch ($datosFinales["fa_lee1"]) {
			case "R":
				$pdf->Text(125, 254.5,"X");
				break;
			case "B":
				$pdf->Text(131, 254.5,"X");
				break;			
			case "MB":
				$pdf->Text(137, 254.5,"X");
				break;
		}

		switch ($datosFinales["fa_escribe1"]) {
			case "R":
				$pdf->Text(143, 254.5,"X");
				break;
			case "B":
				$pdf->Text(149, 254.5,"X");
				break;			
			case "MB":
				$pdf->Text(155, 254.5,"X");
				break;
		}

		$pdf->Text(55, 260, utf8_decode($datosFinales["fa_idioma2"]));

		switch ($datosFinales["fa_habla2"]) {
			case "R":
				$pdf->Text(107, 260,"X");
				break;
			case "B":
				$pdf->Text(113, 260,"X");
				break;			
			case "MB":
				$pdf->Text(119, 260,"X");
				break;
		}

		switch ($datosFinales["fa_lee2"]) {
			case "R":
				$pdf->Text(125, 260,"X");
				break;
			case "B":
				$pdf->Text(131, 260,"X");
				break;			
			case "MB":
				$pdf->Text(137, 260,"X");
				break;
		}

		switch ($datosFinales["fa_escribe2"]) {
			case "R":
				$pdf->Text(143, 260,"X");
				break;
			case "B":
				$pdf->Text(149, 260,"X");
				break;			
			case "MB":
				$pdf->Text(155, 260,"X");
				break;
		}
	}

	private function getSecondPage($pdf, $datosFinales ){

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



/*
*************************INICIO EXPERIENCIA 1 O ACTUAL 
*/
		//1ra linea
	    $pdf->Text(22, 85, utf8_decode($datosFinales["el_empresa1"]));
	    if ($datosFinales["el_publica1"] !== "") {
	    	if ($datosFinales["el_publica1"]) $pdf->Text(119, 85, 'X'); else $pdf->Text(138, 85, 'X');
	    }
		$pdf->Text(152, 85.5, utf8_decode($datosFinales["el_pais1"]));

		//2da linea
		$pdf->Text(22, 95, utf8_decode($datosFinales["el_depto1"]));
		$pdf->Text(85, 95, utf8_decode($datosFinales["el_muni1"]));
		$pdf->Text(147, 95.5, $datosFinales["el_correo1"]);

		//3ra linea
		$pdf->Text(22,105.5, $datosFinales["el_tel1"]);
		$pdf->Text(93,105.5, $datosFinales["el_dingresa1"]);
		$pdf->Text(110,105.5, $datosFinales["el_mingresa1"]);
		$pdf->Text(128,105.5, $datosFinales["el_aingresa1"]);
		$pdf->Text(151,105.5, $datosFinales["el_dretiro1"]);
		$pdf->Text(169,105.5, $datosFinales["el_mretiro1"]);
		$pdf->Text(187,105.5, $datosFinales["el_aretiro1"]);

		//4ta linea
		$pdf->Text(22,115.5, utf8_decode($datosFinales["el_cargo1"]));
		$pdf->Text(86,115.5, utf8_decode($datosFinales["el_depen1"]));
		$pdf->Text(145,115.5, utf8_decode($datosFinales["el_dir1"]));

/*
*************************INICIO EXPERIENCIA 2
*/
		//1ra linea
	    $pdf->Text(22,131.5, utf8_decode($datosFinales["el_empresa2"]));
	    if ($datosFinales["el_publica2"] !== "") {
	    	if ($datosFinales["el_publica2"]) $pdf->Text(119, 131.5, 'X'); else $pdf->Text(138, 131.5, 'X');
	    }
		$pdf->Text(152, 131.5, utf8_decode($datosFinales["el_pais2"]));

		//2da linea
		$pdf->Text(22,141.5, utf8_decode($datosFinales["el_depto2"]));
		$pdf->Text(85,141.5, utf8_decode($datosFinales["el_muni2"]));
		$pdf->Text(147,141.5, $datosFinales["el_correo2"]);

		//3ra linea
		$pdf->Text(22,151.5, $datosFinales["el_tel2"]);
		$pdf->Text(93,151.5, $datosFinales["el_dingresa2"]);
		$pdf->Text(110,151.5, $datosFinales["el_mingresa2"]);
		$pdf->Text(128,151.5, $datosFinales["el_aingresa2"]);
		$pdf->Text(151,151.5, $datosFinales["el_dretiro2"]);
		$pdf->Text(169,151.5, $datosFinales["el_mretiro2"]);
		$pdf->Text(187,151.5, $datosFinales["el_aretiro2"]);

		//4ta linea
		$pdf->Text(22,161.5, utf8_decode($datosFinales["el_cargo2"]));
		$pdf->Text(86,161.5, utf8_decode($datosFinales["el_depen2"]));
		$pdf->Text(145,161.5, utf8_decode($datosFinales["el_dir2"]));


/*
*************************INICIO EXPERIENCIA 3 
*/
		//1ra linea
	    $pdf->Text(22,177.5, utf8_decode($datosFinales["el_empresa3"]));
	    if ($datosFinales["el_publica3"] !== "") {
	    	if ($datosFinales["el_publica3"]) $pdf->Text(119, 177.5, 'X'); else $pdf->Text(138, 177.5, 'X');
	    }
		$pdf->Text(152, 177.5, utf8_decode($datosFinales["el_pais3"]));

		//2da linea
		$pdf->Text(22,187.5, utf8_decode($datosFinales["el_depto3"]));
		$pdf->Text(85,187.5, utf8_decode($datosFinales["el_muni3"]));
		$pdf->Text(147,187.5, $datosFinales["el_correo3"]);

		//3ra linea
		$pdf->Text(22,197.5, $datosFinales["el_tel3"]);
		$pdf->Text(93,197.5, $datosFinales["el_dingresa3"]);
		$pdf->Text(110,197.5, $datosFinales["el_mingresa3"]);
		$pdf->Text(128,197.5, $datosFinales["el_aingresa3"]);
		$pdf->Text(151,197.5, $datosFinales["el_dretiro3"]);
		$pdf->Text(169,197.5, $datosFinales["el_mretiro3"]);
		$pdf->Text(187,197.5, $datosFinales["el_aretiro3"]);

		//4ta linea
		$pdf->Text(22,207.5, utf8_decode($datosFinales["el_cargo3"]));
		$pdf->Text(86,207.5, utf8_decode($datosFinales["el_depen3"]));
		$pdf->Text(145,207.5, utf8_decode($datosFinales["el_dir3"]));


/*
*************************INICIO EXPERIENCIA 3 
*/
		//1ra linea
	    $pdf->Text(22,223.5, utf8_decode($datosFinales["el_empresa4"]));
	    if ($datosFinales["el_publica4"] !== "") {
	    	if ($datosFinales["el_publica4"]) $pdf->Text(119, 223.5, 'X'); else $pdf->Text(138, 223.5, 'X');
	    }
		$pdf->Text(152, 223.5, utf8_decode($datosFinales["el_pais4"]));

		//2da linea
		$pdf->Text(22,233.5, utf8_decode($datosFinales["el_depto4"]));
		$pdf->Text(85,233.5, utf8_decode($datosFinales["el_muni4"]));
		$pdf->Text(147,233.5, $datosFinales["el_correo4"]);

		//3ra linea
		$pdf->Text(22,243.5, $datosFinales["el_tel4"]);
		$pdf->Text(93,243.5, $datosFinales["el_dingresa4"]);
		$pdf->Text(110,243.5, $datosFinales["el_mingresa4"]);
		$pdf->Text(128,243.5, $datosFinales["el_aingresa4"]);
		$pdf->Text(151,243.5, $datosFinales["el_dretiro4"]);
		$pdf->Text(169,243.5, $datosFinales["el_mretiro4"]);
		$pdf->Text(187,243.5, $datosFinales["el_aretiro4"]);

		//4ta linea
		$pdf->Text(22,253.5, utf8_decode($datosFinales["el_cargo4"]));
		$pdf->Text(86,253.5, utf8_decode($datosFinales["el_depen4"]));
		$pdf->Text(145,253.5, utf8_decode($datosFinales["el_dir4"]));
	}

private function getThirdPage($pdf, $datosFinales ){

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

		$fullMonths = 0;
		$yearsPublic = 0;
		$monthsPublic = 0;
		$monthsPublic = 0;
		$yearsPriv = 0;
		$monthsPriv = 0;
		$yearsIndep = 0;
		$monthsIndep = 0;

	    if (is_numeric($datosFinales["tte_mserpubli"])){
	    	$fullMonths = intval($datosFinales["tte_mserpubli"]);
	    	$yearsPublic = floor($fullMonths / 12);
	    	$monthsPublic = $yearsPublic * 12;
	    	$monthsPublic = $fullMonths - $monthsPublic;
	    	$pdf->Text(136, 69, $yearsPublic == 0 ? "" : $yearsPublic);	    	
	    	$pdf->Text(162, 69, $monthsPublic == 0 ? "" : $monthsPublic);	    	
	    }

	    if (is_numeric($datosFinales["tte_mprivado"])){
	    	$fullMonths = intval($datosFinales["tte_mprivado"]);
	    	$yearsPriv = floor($fullMonths / 12);
	    	$monthsPriv = $yearsPriv * 12;
	    	$monthsPriv = $fullMonths - $monthsPriv;
	    	$pdf->Text(136, 79, $yearsPriv == 0 ? "" : $yearsPriv);	    	
	    	$pdf->Text(162, 79, $monthsPriv == 0 ? "" : $monthsPriv);	    	
	    }

		if (is_numeric($datosFinales["tte_mindep"])){
	    	$fullMonths = intval($datosFinales["tte_mindep"]);
	    	$yearsIndep = floor($fullMonths / 12);
	    	$monthsIndep = $yearsIndep * 12;
	    	$monthsIndep = $fullMonths - $monthsIndep;
	    	$pdf->Text(136, 89, $yearsIndep == 0 ? "" : $yearsIndep);	    	
	    	$pdf->Text(162, 89, $monthsIndep == 0 ? "" : $monthsIndep);	    	
	    }

	    $allMonths = $monthsPublic + $monthsPriv + $monthsIndep;
	    $allyears = $yearsPublic + $yearsPriv + $yearsIndep;
	    $allYearsProces = floor($allMonths / 12);
	    $allMonthsPorces = $allYearsProces * 12;
	    $finalMonths = $allMonths - $allMonthsPorces;
	    $allyears = $allyears + $allYearsProces;

		$pdf->Text(136, 99, $allyears == 0 ? "" : $allyears);	    	
	    $pdf->Text(162, 99, $finalMonths == 0 ? "" : $finalMonths);	    	


}

	private function getQueryString($datos){
		return array('dp_pape' => isset($datos->dp_pape) ? $datos->dp_pape : "", 
				'dp_sape' => isset($datos->dp_sape) ? $datos->dp_sape : "", 
				'dp_noms' => isset($datos->dp_noms) ? $datos->dp_noms : "", 
				'dp_tdoc' => isset($datos->dp_tdoc) ? $datos->dp_tdoc : "", 
				'dp_ndoc' => isset($datos->dp_ndoc) ? $datos->dp_ndoc : "", 
				'dp_sexo' => isset($datos->dp_sexo) ? $datos->dp_sexo : "", 
				'dp_col' => isset($datos->dp_col) ? $datos->dp_col : "", 
				'dp_pais' => isset($datos->dp_pais) ? $datos->dp_pais : "", 
				'dp_lmpc' => isset($datos->dp_lmpc) ? $datos->dp_lmpc : "", 
				'dp_nlm' => isset($datos->dp_nlm) ? $datos->dp_nlm : "", 
				'dp_dm' => isset($datos->dp_dm) ? $datos->dp_dm : "", 
				'dp_dnace' => isset($datos->dp_dnace) ? $datos->dp_dnace : "", 
				'dp_mnace' => isset($datos->dp_mnace) ? $datos->dp_mnace : "", 
				'dp_anace' => isset($datos->dp_anace) ? $datos->dp_anace : "", 
				'dp_pnace' => isset($datos->dp_pnace) ? $datos->dp_pnace : "", 
				'dp_dptnace' => isset($datos->dp_dptnace) ? $datos->dp_dptnace : "", 
				'dp_munace' => isset($datos->dp_munace) ? $datos->dp_munace : "", 
				'dp_dir' => isset($datos->dp_dir) ? $datos->dp_dir : "", 
				'dp_pais' => isset($datos->dp_pais) ? $datos->dp_pais : "", 
				'dp_depto' => isset($datos->dp_depto) ? $datos->dp_depto : "", 
				'dp_muni' => isset($datos->dp_muni) ? $datos->dp_muni : "", 
				'dp_tel' => isset($datos->dp_tel) ? $datos->dp_tel : "", 
				'dp_email' => isset($datos->dp_email) ? $datos->dp_email : "", 
				'fa_titulo' => isset($datos->fa_titulo) ? $datos->fa_titulo : "", 
				'fa_nescolar' => isset($datos->fa_nescolar) ? $datos->fa_nescolar : "", 
				'fa_mes' => isset($datos->fa_mes) ? $datos->fa_mes : "", 
				'fa_ano' => isset($datos->fa_ano) ? $datos->fa_ano : "", 
				'fa_modaca1' => isset($datos->fa_modaca1) ? $datos->fa_modaca1 : "", 
				'fa_semapro1' => isset($datos->fa_semapro1) ? $datos->fa_semapro1 : "", 
				'fa_gradua1' => isset($datos->fa_gradua1) ? $datos->fa_gradua1 : "", 
				'fa_titulo1' => isset($datos->fa_titulo1) ? $datos->fa_titulo1 : "", 
				'fa_mtermina1' => isset($datos->fa_mtermina1) ? $datos->fa_mtermina1 : "", 
				'fa_atermina1' => isset($datos->fa_atermina1) ? $datos->fa_atermina1 : "", 
				'fa_notprof1' => isset($datos->fa_notprof1) ? $datos->fa_notprof1 : "", 
				'fa_modaca2' => isset($datos->fa_modaca2) ? $datos->fa_modaca2 : "", 
				'fa_semapro2' => isset($datos->fa_semapro2) ? $datos->fa_semapro2 : "", 
				'fa_gradua2' => isset($datos->fa_gradua2) ? $datos->fa_gradua2 : "", 
				'fa_titulo2' => isset($datos->fa_titulo2) ? $datos->fa_titulo2 : "", 
				'fa_mtermina2' => isset($datos->fa_mtermina2) ? $datos->fa_mtermina2 : "", 
				'fa_atermina2' => isset($datos->fa_atermina2) ? $datos->fa_atermina2 : "", 
				'fa_notprof2' => isset($datos->fa_notprof2) ? $datos->fa_notprof2 : "", 
				'fa_modaca3' => isset($datos->fa_modaca3) ? $datos->fa_modaca3 : "", 
				'fa_semapro3' => isset($datos->fa_semapro3) ? $datos->fa_semapro3 : "", 
				'fa_gradua3' => isset($datos->fa_gradua3) ? $datos->fa_gradua3 : "", 
				'fa_titulo3' => isset($datos->fa_titulo3) ? $datos->fa_titulo3 : "", 
				'fa_mtermina3' => isset($datos->fa_mtermina3) ? $datos->fa_mtermina3 : "", 
				'fa_atermina3' => isset($datos->fa_atermina3) ? $datos->fa_atermina3 : "", 
				'fa_notprof3' => isset($datos->fa_notprof3) ? $datos->fa_notprof3 : "", 
				'fa_modaca4' => isset($datos->fa_modaca4) ? $datos->fa_modaca4 : "", 
				'fa_semapro4' => isset($datos->fa_semapro4) ? $datos->fa_semapro4 : "", 
				'fa_gradua4' => isset($datos->fa_gradua4) ? $datos->fa_gradua4 : "", 
				'fa_titulo4' => isset($datos->fa_titulo4) ? $datos->fa_titulo4 : "", 
				'fa_mtermina4' => isset($datos->fa_mtermina4) ? $datos->fa_mtermina4 : "", 
				'fa_atermina4' => isset($datos->fa_atermina4) ? $datos->fa_atermina4 : "", 
				'fa_notprof4' => isset($datos->fa_notprof4) ? $datos->fa_notprof4 : "", 
				'fa_modaca5' => isset($datos->fa_modaca5) ? $datos->fa_modaca5 : "", 
				'fa_semapro5' => isset($datos->fa_semapro5) ? $datos->fa_semapro5 : "", 
				'fa_gradua5' => isset($datos->fa_gradua5) ? $datos->fa_gradua5 : "", 
				'fa_titulo5' => isset($datos->fa_titulo5) ? $datos->fa_titulo5 : "", 
				'fa_mtermina5' => isset($datos->fa_mtermina5) ? $datos->fa_mtermina5 : "", 
				'fa_atermina5' => isset($datos->fa_atermina5) ? $datos->fa_atermina5 : "", 
				'fa_notprof5' => isset($datos->fa_notprof5) ? $datos->fa_notprof5 : "", 
				'fa_idioma1' => isset($datos->fa_idioma1) ? $datos->fa_idioma1 : "", 
				'fa_habla1' => isset($datos->fa_habla1) ? $datos->fa_habla1 : "", 
				'fa_lee1' => isset($datos->fa_lee1) ? $datos->fa_lee1 : "", 
				'fa_escribe1' => isset($datos->fa_escribe1) ? $datos->fa_escribe1 : "", 
				'fa_idioma2' => isset($datos->fa_idioma2) ? $datos->fa_idioma2 : "", 
				'fa_habla2' => isset($datos->fa_habla2) ? $datos->fa_habla2 : "", 
				'fa_lee2' => isset($datos->fa_lee2) ? $datos->fa_lee2 : "", 
				'fa_escribe2' => isset($datos->fa_escribe2) ? $datos->fa_escribe2 : "",
				'el_empresa1' => isset($datos->el_empresa1) ? $datos->el_empresa1 : "", 
				'el_publica1' => isset($datos->el_publica1) ? $datos->el_publica1 : "", 
				'el_pais1' => isset($datos->el_pais1) ? $datos->el_pais1 : "", 
				'el_depto1' => isset($datos->el_depto1) ? $datos->el_depto1 : "", 
				'el_muni1' => isset($datos->el_muni1) ? $datos->el_muni1 : "", 
				'el_correo1' => isset($datos->el_correo1) ? $datos->el_correo1 : "", 
				'el_tel1' => isset($datos->el_tel1) ? $datos->el_tel1 : "", 
				'el_dingresa1' => isset($datos->el_dingresa1) ? $datos->el_dingresa1 : "", 
				'el_mingresa1' => isset($datos->el_mingresa1) ? $datos->el_mingresa1 : "", 
				'el_aingresa1' => isset($datos->el_aingresa1) ? $datos->el_aingresa1 : "", 
				'el_dretiro1' => isset($datos->el_dretiro1) ? $datos->el_dretiro1 : "", 
				'el_mretiro1' => isset($datos->el_mretiro1) ? $datos->el_mretiro1 : "", 
				'el_aretiro1' => isset($datos->el_aretiro1) ? $datos->el_aretiro1 : "", 
				'el_cargo1' => isset($datos->el_cargo1) ? $datos->el_cargo1 : "", 
				'el_depen1' => isset($datos->el_depen1) ? $datos->el_depen1 : "", 
				'el_dir1' => isset($datos->el_dir1) ? $datos->el_dir1 : "", 
				'el_empresa2' => isset($datos->el_empresa2) ? $datos->el_empresa2 : "", 
				'el_publica2' => isset($datos->el_publica2) ? $datos->el_publica2 : "", 
				'el_pais2' => isset($datos->el_pais2) ? $datos->el_pais2 : "", 
				'el_depto2' => isset($datos->el_depto2) ? $datos->el_depto2 : "", 
				'el_muni2' => isset($datos->el_muni2) ? $datos->el_muni2 : "", 
				'el_correo2' => isset($datos->el_correo2) ? $datos->el_correo2 : "", 
				'el_tel2' => isset($datos->el_tel2) ? $datos->el_tel2 : "", 
				'el_dingresa2' => isset($datos->el_dingresa2) ? $datos->el_dingresa2 : "", 
				'el_mingresa2' => isset($datos->el_mingresa2) ? $datos->el_mingresa2 : "", 
				'el_aingresa2' => isset($datos->el_aingresa2) ? $datos->el_aingresa2 : "", 
				'el_dretiro2' => isset($datos->el_dretiro2) ? $datos->el_dretiro2 : "", 
				'el_mretiro2' => isset($datos->el_mretiro2) ? $datos->el_mretiro2 : "", 
				'el_aretiro2' => isset($datos->el_aretiro2) ? $datos->el_aretiro2 : "", 
				'el_cargo2' => isset($datos->el_cargo2) ? $datos->el_cargo2 : "", 
				'el_depen2' => isset($datos->el_depen2) ? $datos->el_depen2 : "", 
				'el_dir2' => isset($datos->el_dir2) ? $datos->el_dir2 : "", 
				'el_empresa3' => isset($datos->el_empresa3) ? $datos->el_empresa3 : "", 
				'el_publica3' => isset($datos->el_publica3) ? $datos->el_publica3 : "", 
				'el_pais3' => isset($datos->el_pais3) ? $datos->el_pais3 : "", 
				'el_depto3' => isset($datos->el_depto3) ? $datos->el_depto3 : "", 
				'el_muni3' => isset($datos->el_muni3) ? $datos->el_muni3 : "", 
				'el_correo3' => isset($datos->el_correo3) ? $datos->el_correo3 : "", 
				'el_tel3' => isset($datos->el_tel3) ? $datos->el_tel3 : "", 
				'el_dingresa3' => isset($datos->el_dingresa3) ? $datos->el_dingresa3 : "", 
				'el_mingresa3' => isset($datos->el_mingresa3) ? $datos->el_mingresa3 : "", 
				'el_aingresa3' => isset($datos->el_aingresa3) ? $datos->el_aingresa3 : "", 
				'el_dretiro3' => isset($datos->el_dretiro3) ? $datos->el_dretiro3 : "", 
				'el_mretiro3' => isset($datos->el_mretiro3) ? $datos->el_mretiro3 : "", 
				'el_aretiro3' => isset($datos->el_aretiro3) ? $datos->el_aretiro3 : "", 
				'el_cargo3' => isset($datos->el_cargo3) ? $datos->el_cargo3 : "", 
				'el_depen3' => isset($datos->el_depen3) ? $datos->el_depen3 : "", 
				'el_dir3' => isset($datos->el_dir3) ? $datos->el_dir3 : "", 
				'el_empresa4' => isset($datos->el_empresa4) ? $datos->el_empresa4 : "", 
				'el_publica4' => isset($datos->el_publica4) ? $datos->el_publica4 : "", 
				'el_pais4' => isset($datos->el_pais4) ? $datos->el_pais4 : "", 
				'el_depto4' => isset($datos->el_depto4) ? $datos->el_depto4 : "", 
				'el_muni4' => isset($datos->el_muni4) ? $datos->el_muni4 : "", 
				'el_correo4' => isset($datos->el_correo4) ? $datos->el_correo4 : "", 
				'el_tel4' => isset($datos->el_tel4) ? $datos->el_tel4 : "", 
				'el_dingresa4' => isset($datos->el_dingresa4) ? $datos->el_dingresa4 : "", 
				'el_mingresa4' => isset($datos->el_mingresa4) ? $datos->el_mingresa4 : "", 
				'el_aingresa4' => isset($datos->el_aingresa4) ? $datos->el_aingresa4 : "", 
				'el_dretiro4' => isset($datos->el_dretiro4) ? $datos->el_dretiro4 : "", 
				'el_mretiro4' => isset($datos->el_mretiro4) ? $datos->el_mretiro4 : "", 
				'el_aretiro4' => isset($datos->el_aretiro4) ? $datos->el_aretiro4 : "", 
				'el_cargo4' => isset($datos->el_cargo4) ? $datos->el_cargo4 : "", 
				'el_depen4' => isset($datos->el_depen4) ? $datos->el_depen4 : "", 
				'el_dir4' => isset($datos->el_dir4) ? $datos->el_dir4 : "", 
				'tte_mserpubli' => isset($datos->tte_mserpubli) ? $datos->tte_mserpubli : "", 
				'tte_mprivado' => isset($datos->tte_mprivado) ? $datos->tte_mprivado : "", 
				'tte_mindep' => isset($datos->tte_mindep) ? $datos->tte_mindep : "");
	}
}