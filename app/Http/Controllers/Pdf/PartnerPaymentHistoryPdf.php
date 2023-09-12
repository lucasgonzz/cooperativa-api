<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Helpers\Numbers;
use App\Http\Controllers\Pdf\PdfHelper;
use Carbon\Carbon;
use fpdf;
require(__DIR__.'/../fpdf/fpdf.php');

class PartnerPaymentHistoryPdf extends fpdf {

	function __construct($models, $model_id, $from_date, $until_date) {
		parent::__construct();
		$this->SetAutoPageBreak(true, 1);
		$this->b = 0;
		$this->line_height = 7;
		
		$this->models = $models;
		$this->model_id = $model_id;
		$this->from_date = $from_date;
		$this->until_date = $until_date;

		$this->AddPage();
		$this->print();
        $this->Output();
        exit;
	}

	function getFields() {
		if (is_null($this->model_id)) {
			return [
				'Fecha' 	=> 30,
				'Socio' 	=> 50,
				'Servicio' 	=> 40,
				'Importe'	=> 40,
				'Obs' 		=> 40,
			];
		} else {
			return [
				'Fecha' 	=> 30,
				'Servicio' 	=> 40,
				'Importe'	=> 40,
				'Obs' 		=> 90,
			];
		}
	}

	function getModelProps() {
		if (!is_null($this->model_id)) {
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
		} else {
			return [
				[
					'text' 	=> 'Desde',
					'key'	=> 'from_date',
				],
				[
					'text' 	=> 'Hasta',
					'key'	=> 'until_date',
				],
			];
		}
	}

	function Header() {
		if (is_null($this->model_id)) {
			$model_info = new \stdClass();
			$model_info->from_date = date_format(date_create($this->from_date), 'd/m/Y');
			$model_info->until_date = date_format(date_create($this->until_date), 'd/m/Y');
		} else {
			$model_info = $this->models[0]->partner;
		}
		$data = [
			'date_formated'		=> date('d/m/y'),
			'title' 			=> 'Historial de Pago',
			'model_info'		=> $model_info,
			'model_props' 		=> $this->getModelProps(),
			'fields' 			=> $this->getFields(),
		];
		PdfHelper::header($this, $data);
	}

	function print() {
		$this->SetFont('Arial', '', 9);
		foreach ($this->models as $model) {
			$this->x = 5;
			$this->Cell($this->getFields()['Fecha'], $this->line_height, date_format($model->created_at,'d/m/y'), $this->b, 0, 'L');
			if (is_null($this->model_id)) {
				$this->Cell($this->getFields()['Socio'], $this->line_height, $model->partner->num.' '.$model->partner->name, $this->b, 0, 'L');
			}
			$this->Cell($this->getFields()['Servicio'], $this->line_height, $model->service->name, $this->b, 0, 'L');
			$this->Cell($this->getFields()['Importe'], $this->line_height, Numbers::price($model->amount), $this->b, 0, 'L');
			$this->MultiCell($this->getFields()['Obs'], $this->line_height, $model->observations, $this->b, 'L', false);
			$this->Line(5, $this->y, 205, $this->y);
		}
	}

	function Footer() {
		PdfHelper::appInfo($this, $this->y);
	}

}