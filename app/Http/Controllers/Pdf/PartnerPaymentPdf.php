<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Helpers\Numbers;
use App\Http\Controllers\Pdf\PdfHelper;
use fpdf;
require(__DIR__.'/../fpdf/fpdf.php');

class PartnerPaymentPdf extends fpdf {

	function __construct($model) {
		parent::__construct();
		$this->SetAutoPageBreak(true, 1);
		$this->b = 0;
		$this->line_height = 7;
		
		$this->model = $model;

		$this->AddPage();
		$this->printPago();
		$this->observations();
		PdfHelper::firma($this);
		$this->pesos();
        $this->Output();
        exit;
	}

	function getFields() {
		return [
			'Nombre' 	=> 60,
			'Saldo' 	=> 30,
			'Localidad' => 30,
			'Direccion' => 60,
			'Obs' 		=> 20,
		];
	}

	function getModelProps() {
		return [
			[
				'text' 	=> 'Socio',
				'key'	=> 'name',
			],
			[
				'text' 	=> 'N° Documento',
				'key'	=> 'doc_number',
			],
		];
	}

	function Header() {
		$data = [
			'num' 				=> $this->model->num,
			'date'				=> $this->model->created_at,
			'title' 			=> 'Recibo de Pago',
			'model_info'		=> $this->model->partner,
			'model_props' 		=> $this->getModelProps(),
			// 'fields' 			=> $this->getFields(),
		];
		PdfHelper::header($this, $data);
	}

	function printPago() {
		$this->x = 5;
		$this->SetFont('Arial', 'B', 11);
		$this->Cell(200, 7, 'Recibimos de '.$this->model->partner->name, $this->b, 1, 'L');
		$this->x = 5;
		$this->Cell(200, 7, 'la cantidad de '.Numbers::price($this->model->amount).' (pesos)', $this->b, 1, 'L');
	}

	function observations() {
		if (!is_null($this->model->observations)) {
			$this->x = 5;
			$this->SetFont('Arial', '', 11);
			$this->Cell(200, 7, 'Aclaraciones: '.$this->model->observations, $this->b, 1, 'L');
		}
	}

	function pesos() {
		$this->x = 155;
		$this->y -= 5;
		$this->SetFont('Arial', '', 11);
		$this->Cell(50, 7, 'Son '.Numbers::price($this->model->amount), 1, 1, 'L');
	}

	function Footer() {
		PdfHelper::appInfo($this, $this->y);
	}

}