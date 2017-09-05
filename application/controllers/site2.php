<?php
class Site extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->load->model('site_model');
        $data['records'] = $this->site_model->getAll();
        $this->load->view('header');
        $this->load->view('home', $data);
    }
    
    public function IDnumberFill()
    {
        $IDnumber      = $this->input->post('typeID');
        $IDpayments    = $this->input->post('paymentsID');
        $IDcustody     = $this->input->post('custodyID');
        $IDcorporate   = $this->input->post('corporateActionID');
        $IDsettlements = $this->input->post('settlementsID');
        
        $this->load->model('site_model');
        $records                    = $this->site_model->getIDs($IDnumber);
        $IDpaymentsfromModel        = $this->site_model->getIDs($IDpayments);
        $IDcustodyfromModel         = $this->site_model->getIDs($IDcustody);
        $IDcorporateActionfromModel = $this->site_model->getIDs($IDcorporate);
        $IDsettlementsfromModel     = $this->site_model->getIDs($IDsettlements);
        
        function sendBackIDs($IDNumbers, $stageName)
        {
            $sendBack = ' ';
            $sendBack .= '<div class="stage"><span>' . $stageName . '</span><ul>';
            foreach ($IDNumbers as $row):
                $sendBack .= '<a class="tradeIDs" href="#' . $row->TradeID . '"> ' . $row->TradeID . ' </a>';
            endforeach;
            $sendBack .= '</ul></div>';
            echo $sendBack;
            
        }
        
        sendBackIDs($records, 'Trade Support');
        sendBackIDs($IDpaymentsfromModel, 'Payments');
        sendBackIDs($IDcustodyfromModel, 'Custody');
        sendBackIDs($IDcorporateActionfromModel, 'Corporate Action');
        sendBackIDs($IDsettlementsfromModel, 'Settlements');
        
    }
    
    public function IDnumberAJAX()
    {
        $IDnumber = $this->input->post('type');
        $this->load->model('site_model');
        $records = $this->site_model->getRecordByID($IDnumber);
        
        $sendBack = ' ';
        foreach ($records as $row):
            $sendBack .= '<h2 class="sub-header">Trade Break Information ID #' . $row->TFL_tradeID . '</h2>';
            $sendBack .= '<div class="table-responsive">';
            $sendBack .= '<table class="table">';
            $sendBack .= '<thead>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Criteria</th>';
            $sendBack .= '<th>Details</th>';
            $sendBack .= '</tr>';
            $sendBack .= '</thead>';
            $sendBack .= '<tbody>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Settle Date</th>';
            $sendBack .= '<td>' . $row->settleDate . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>TradeDate</th>';
            $sendBack .= '<td>' . $row->tradeDate . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Account</th>';
            $sendBack .= '<td>' . $row->accountName . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Quantity</th>';
            $sendBack .= '<td>' . $row->quantity . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Item Type</th>';
            $sendBack .= '<td>' . $row->itemType . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Amount Value</th>';
            $sendBack .= '<td>' . $row->amountValue . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Security Description</th>';
            $sendBack .= '<td>' . $row->securityDescription . '</td>';
            $sendBack .= '</tr>';
            $sendBack .= '<tr>';
            $sendBack .= '<th>Trader Name</th>';
            $sendBack .= '<td>' . $row->traderName . '</td>';
            $sendBack .= '</tr>';
            
            $sendBack .= '</tbody>';
            $sendBack .= '</table>';
            $sendBack .= '</div>';
        endforeach;
        echo $sendBack;
    }
    
    public function createRecord()
    {
        $data = array(
            'title' => $this->input->post('title'),
            'content' => $this->input->post('title')
        );
        
        $this->site_model->add_record($data);
    }
    
    public function options()
    {
        $this->output->set_header('Access-Control-Allow-Origin: * ');
        $this->output->set_header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization, X-Requested-With');
        
        if (isset($_POST['id']) && $_POST['id'] != '') {
            $_SESSION['id'] = $_POST['id'];
        }
        $data = array(
            'TFL_tradeID' => $this->input->post('tfl_tradeID'),
            'BankID' => $this->input->post('tfl_appid'),
            'TFL_dt' => $this->input->post('tfl_dt'),
            'traderName' => $this->input->post('tfl_uid'),
            'amountValue' => $this->input->post('tfl_payload'),
            'settleDate' => $this->input->post('tfl_settleDate'),
            'tradeDate' => $this->input->post('tfl_tradeDate'),
            'accountName' => $this->input->post('tfl_accountName'),
            'quantity' => $this->input->post('tfl_quantity'),
            'itemtype' => $this->input->post('tfl_itemtype'),
            'securityDescription' => $this->input->post('tfl_securityDescription')
        );
        
        $this->load->model('site_model');
        $record = $this->site_model->insertJSONdata($data);
        
        $stage       = $this->input->post('tfl_sysid');
        $TFL_tradeID = $this->input->post('tfl_tradeID');
        $TFL_dt      = $this->input->post('tfl_dt');
        
        $dataSys = array();
        
        $dataSys['TradeID'] = $TFL_tradeID;
        if ($stage == 'stage1Support') {
            $dataSys['tradeSupportStage'] = $TFL_dt;
        }
        if ($stage == 'stage2Payments') {
            $dataSys['paymentsStage'] = $TFL_dt;
        }
        
        $this->site_model->insertStage($dataSys);
        
    }
    
    
}