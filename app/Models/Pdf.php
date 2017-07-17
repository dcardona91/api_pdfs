<?php
namespace ThisApp\Models;

use \Fpdf\fpdf;
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
		$datosFinales = array('dp_pape' => isset($datos->dp_pape) ? $datos->dp_pape : "N/A", 
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
				'fa_atermina1' => isset($datos->fa_atermina1) ? $datos->fa_atermina1 : "N/A", 
				'fa_notprof1' => isset($datos->fa_notprof1) ? $datos->fa_notprof1 : "N/A", 
				'fa_modaca2' => isset($datos->fa_modaca2) ? $datos->fa_modaca2 : "N/A", 
				'fa_semapro2' => isset($datos->fa_semapro2) ? $datos->fa_semapro2 : "N/A", 
				'fa_gradua2' => isset($datos->fa_gradua2) ? $datos->fa_gradua2 : "N/A", 
				'fa_titulo2' => isset($datos->fa_titulo2) ? $datos->fa_titulo2 : "N/A", 
				'fa_mtermina2' => isset($datos->fa_mtermina2) ? $datos->fa_mtermina2 : "N/A", 
				'fa_atermina2' => isset($datos->fa_atermina2) ? $datos->fa_atermina2 : "N/A", 
				'fa_notprof2' => isset($datos->fa_notprof2) ? $datos->fa_notprof2 : "N/A", 
				'fa_modaca3' => isset($datos->fa_modaca3) ? $datos->fa_modaca3 : "N/A", 
				'fa_semapro3' => isset($datos->fa_semapro3) ? $datos->fa_semapro3 : "N/A", 
				'fa_gradua3' => isset($datos->fa_gradua3) ? $datos->fa_gradua3 : "N/A", 
				'fa_titulo3' => isset($datos->fa_titulo3) ? $datos->fa_titulo3 : "N/A", 
				'fa_mtermina3' => isset($datos->fa_mtermina3) ? $datos->fa_mtermina3 : "N/A", 
				'fa_atermina3' => isset($datos->fa_atermina3) ? $datos->fa_atermina3 : "N/A", 
				'fa_notprof3' => isset($datos->fa_notprof3) ? $datos->fa_notprof3 : "N/A", 
				'fa_modaca4' => isset($datos->fa_modaca4) ? $datos->fa_modaca4 : "N/A", 
				'fa_semapro4' => isset($datos->fa_semapro4) ? $datos->fa_semapro4 : "N/A", 
				'fa_gradua4' => isset($datos->fa_gradua4) ? $datos->fa_gradua4 : "N/A", 
				'fa_titulo4' => isset($datos->fa_titulo4) ? $datos->fa_titulo4 : "N/A", 
				'fa_mtermina4' => isset($datos->fa_mtermina4) ? $datos->fa_mtermina4 : "N/A", 
				'fa_atermina4' => isset($datos->fa_atermina4) ? $datos->fa_atermina4 : "N/A", 
				'fa_notprof4' => isset($datos->fa_notprof4) ? $datos->fa_notprof4 : "N/A", 
				'fa_modaca5' => isset($datos->fa_modaca5) ? $datos->fa_modaca5 : "N/A", 
				'fa_semapro5' => isset($datos->fa_semapro5) ? $datos->fa_semapro5 : "N/A", 
				'fa_gradua5' => isset($datos->fa_gradua5) ? $datos->fa_gradua5 : "N/A", 
				'fa_titulo5' => isset($datos->fa_titulo5) ? $datos->fa_titulo5 : "N/A", 
				'fa_mtermina5' => isset($datos->fa_mtermina5) ? $datos->fa_mtermina5 : "N/A", 
				'fa_atermina5' => isset($datos->fa_atermina5) ? $datos->fa_atermina5 : "N/A", 
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

		$pdf = new fpdf();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);

		$y = 10;
		$pdf->Cell(2,$y,'Ejemplo');


		foreach ($datosFinales as $key => $value) {
			$pdf->ln();
			$pdf->write(10, $key.":  ".$value);
		}
		$pdf->Output();
	}
}