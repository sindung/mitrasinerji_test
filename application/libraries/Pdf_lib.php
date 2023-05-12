<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_lib extends TCPDF {

    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
    }

    //Page header
    public function Header() {
        // Set font
        $fontname = TCPDF_FONTS::addTTFfont(base_url('assets/font/FutuLt.ttf'), 'TrueTypeUnicode', '', 96);
        $this->SetFont($fontname, 'I', 8);
        // Position at 15 mm from bottom
        //$this->SetY(-15);
        // Page number
        $this->SetXY(5, 0);
        //$this->setCellPaddings($left = '20', $top = '40', $right = '20', $bottom = '20');
        $this->Cell(0, 20, 'Dicetak pada : ' . date('d/m/Y H:i:s'), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        //$this->SetXY(0, 0);
        $this->Cell(0, 20, 'Hlm. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    //Page footer
    public function Footer() {
        
    }

}

/*Author:Tutsway.com */
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */