<?php
/*-
 * Masters Module Controller
 * This section for setting  purpose
 *
 * Master's Controller
 * @quadrupleindia.com
 * author - Prabakar
 */
class Incubationprogress extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->items_perpage = '15';
        $this->load->model('Mincubationprogress');
        $this->load->model('scouting/Minnovation');
        $this->load->helper('common_helper');
    }
    public function index()
    {
        redirect('incubationprogress/view_list/' . $innovationid);
    }
    public function form($mastertype = null, $mastername = null, $type = null, $subcategory = null, $frequency = null, $yearly = null, $monthly = null, $quarterly = null)
    {
        $data['mastertype'] = $this->Mincubationprogress->getmastertype();
        $data['type'] = array('data', 'activity');
        $data['frequency'] = array('weekly' => 1, 'monthly' => 2, 'quarterly' => 3, 'yearly' => 4);
        $data['yearly'] = array(date('Y') - 3, date('Y') - 2, date('Y') - 1, date('Y'), date('Y') + 1, date('Y') + 2, date('Y') + 3);
        $data['monthly'] = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        $data['quarterly'] = array('1', '2', '3', '4');
        $mastertype = urldecode($mastertype);
        $mastername = urldecode($mastername);
        $type = urldecode($type);
        $subcategory = urldecode($subcategory);
        if ($mastertype == null) {
            $mastertype = $data['mastertype'][0]['master_type'];
        }
        $data['defaultms'] = $mastertype;
        $data['submastertype'] = $this->Mincubationprogress->getsubmastertype($mastertype);
        if ($mastername == null) {
            $mastername = $data['submastertype'][0]['master_name'];
        }
        $data['defaultsubms'] = $mastername;
        if ($type == null) {
            $type = $data['type'][0];
        }
        $data['defaulttype'] = $type;
        if ($type == 'data') {
            $data['subcategory'] = $this->Mincubationprogress->getsubcategory($mastertype, $mastername, $type);
            if ($subcategory == null) {
                $subcategory = $data['subcategory'][0]['subcategory'];
            }
            $data['defaultsubcategory'] = $subcategory;
        }
        if ($frequency == null) {
            $frequency = $data['frequency']['weekly'];
        }
        $data['defaultfrequency'] = $frequency;
        if ($frequency != '4') {
            if ($yearly == null) {
                $yearly = date('Y');
            }
            $data['defaultyearly'] = $yearly;

            if ($monthly == null) {
                $monthly = date('m');
            }
            $data['defaultmonthly'] = $monthly;
            if ($quarterly == null) {
                $quarterly = $data['quarterly'][0];
            }
            $data['defaultquarterly'] = $quarterly;
        }
        if ($frequency == '1') {
            $data['weekreport'] = $this->Mincubationprogress->getweekreport($frequency, $subcategory);
            for ($i = 0; $i < count($data['monthly']); $i++) {
                $data['weekanswerreport'] = $this->Mincubationprogress->getweekanswerreport($frequency, $data['monthly'][$i], $subcategory);
            }
        }
        if ($frequency == '2') {
            $data['monthreport'] = $this->Mincubationprogress->getmonthreport($frequency, $subcategory);

            for ($i = 0; $i < count($data['monthly']); $i++) {
                $data['monthanswerreport' . $i] = $this->Mincubationprogress->getmonthanswerreport($frequency, $data['monthly'][$i], $subcategory, $yearly);
            }
        }
        if ($frequency == '3') {
            $data['quarterlyreport'] = $this->Mincubationprogress->getquarterlyreport($frequency, $subcategory);
            for ($i = 0; $i < count($data['quarterly']); $i++) {
                $data['quarterreport' . $i] = $this->Mincubationprogress->getquarterreport($frequency, $data['quarterly'][$i], $subcategory, $yearly);

            }
        } else {
            $data['yearreport'] = $this->Mincubationprogress->getyear_report($subcategory, $frequency);
            for ($i = 0; $i < count($data['yearly']); $i++) {
                $data['yearanswerreport' . $i] = $this->Mincubationprogress->getyearanswerreport($frequency, $data['yearly'][$i], $subcategory);
            }
        }

        $data['cpage'] = "form";
        $data['cpagetitle'] = "Incubation Progress";
        $this->load->view('../template', $data);

    }
    public function update()
    {echo "eerr";
        $post = $this->input->post('value');
        $this->Mincubationprogress->update_data($_POST['field'], $post, $_POST['rownum']);
    }
    public function edit()
    {
        $this->Mincubationprogress->update_data($_POST['field'], $_POST['data'], $_POST['rownum']);

    }

}
