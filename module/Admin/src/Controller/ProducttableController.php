<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\BangSanpham;
use Admin\Model\BangNhomsanpham;
use Admin\Model\BangLoaisanpham;
class ProductTableController extends AbstractActionController {
    private $bangsanpham;
    private $bangnhomsanpham;
    private $bangloaisanpham;
    public $data;
    public function __construct(BangSanpham $bangsanpham,BangNhomsanpham $bangnhomsanpham, BangLoaisanpham $bangloaisanpham) {
        $this->bangsanpham = $bangsanpham;
        $this->bangnhomsanpham = $bangnhomsanpham;
        $this->bangloaisanpham = $bangloaisanpham;
    }
    public function setdata($row)
    {
        
    }

    public function indexAction() {
        $this->data = array();
        $result = $this->bangsanpham->Laytoanbo();
        foreach ($result as $row)
        {
            
            $sp = new \Admin\Model\Sanpham();
            $sp->Copydata($row);
            $dt = $sp->getarray();
            $nsp=$this->bangnhomsanpham->LaytheoId($row->id_nhomsanpham);
            $lsp = $this->bangloaisanpham->LaytheoId($nsp->id_loaisanpham);
            $dt['id_loaisanpham'] = $nsp->id_loaisanpham;
            $dt['tennhomsanpham'] = $nsp->tennhomsanpham;
            $dt['thongtinnhomsanpham'] = $nsp->thongtinnhomsanpham;
            $dt['tenloaisanpham'] = $lsp->tenloaisanpham;
            array_push($this->data,$dt);         
        }
        $_SESSION['name'] = 'Quân';
        $_SESSION['scriptfile'] = '<script type="text/javascript" src="http://localhost:8081/shop/public/js/plugins/tables/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="http://localhost:8081/shop/public/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="http://localhost:8081/shop/public/js/core/app.js"></script>
	<script type="text/javascript" src="http://localhost:8081/shop/public/js/pages/datatables_basic.js"></script>';
        $this->layout('layout/layout');
        return new ViewModel(array(
            'data' => $this->data,
        ));
    }
}
