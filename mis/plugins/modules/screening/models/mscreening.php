<?php

class Mscreening extends CI_Model
{

    public function __construct()
    {

        parent::__construct();

        $this->hris = $this->load->database('hris', true);

        $this->table = 'innovation_pool';

    }

    public function insert($form = array())
    {

        $criteria = $form['criteria'];

        unset($form['criteria']);

        $innovation = $form['innovation'];

        unset($form['innovation']);

        unset($form['txtSubmit']);

        foreach ($form as $field => $answer):

            if ($field == 'services') {
                $this->insertInnovationServices($innovation, $answer);
            } else {

                $answer = is_array($answer) ? implode(',', $answer) : $answer;

                $data = array('criteria' => $criteria,

                    'innovation' => $innovation,

                    'field' => $field,

                    'answer' => $answer);

                if ($this->checkDuplicate($innovation, $criteria, $field)) {

                    $this->db->insert('screening', $data);

                } else {

                    $this->db->where('criteria', $criteria);

                    $this->db->where('innovation', $innovation);

                    $this->db->where('field', $field);

                    $this->db->update('screening', $data);

                }

            }

        endforeach;

    }

    public function addic($options, $id)
    {

        $data = array('ic_status' => $options['decision'],

            'ic_description' => $options['description'],

            'ic_document' => $options['filename'],

        );

        $this->db->where('id', $id);

        $this->db->update('innovation_pool', $data);

        return true;

    }

    public function getReportsInfo($innovation)
    {

        $data = array();

        $this->db->select("people_meet.*");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get('people_meet');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

    public function insertIncubateeDetailsBYID($options = array(), $innovation)
    {

        $encrypted_password = md5($options['userPassword']);

        $data = array(

            'innovation' => $options['innovationID'],

            'user_name' => $options['username'],

            'user_password' => $encrypted_password,

            'incubatee_status' => '1',
            'partner_id' => $this->session->userdata('partner_id'),

        );

        if ($this->checkIncubateeAvailability($innovation)) {

            $this->db->insert('incubatee', $data);

        } else {

            $this->db->where('innovation', $innovation);

            $this->db->update('incubatee', $data);

        }

    }

    public function editassessdocument($innovation, $id, $options = array())
    {

        $data = array('master_type' => $options['mastertype'],

            'criteria' => $options['criteria'],

            'field' => $options['field'],

            'documents' => @$options['document'],

            'answer' => $options['document-description']);

        $this->db->where('id', $id);

        $this->db->where('innovation', $innovation);

        $this->db->update('document_to_produce', $data);

        return true;

    }

    public function checkIsApproved($innovation)
    {

        $this->db->select("innovation");

        $this->db->where_in("innovation", $innovation);

        $result = $this->db->get('pre_ic_mail');

        $data = $result->row_array();

        return $data;

    }

    public function checkIncubateeAvailability($innovation)
    {

        $this->db->select("id,user_name");

        $this->db->where_in("innovation", $innovation);

        $result = $this->db->get('incubatee');

        $data = $result->result_array();

        if ($result->num_rows() > 0) {

            return false;

        } else {

            return true;

        }

    }

    public function getEmpEMailID($id)
    {

        $this->hris->select("emp_firstname,emp_oth_email");

        $this->hris->where_in("emp_number", $id);

        $result = $this->hris->get('hs_hr_employee');

        $data = $result->result_array();

        return $data;

    }

    public function getIncubateeDetailsBY_Innovation($innovation)
    {

        $this->db->select('IP.name_of_entrepreneur,IP.email_id,IC.user_name');

        $this->db->where('IP.id', $innovation);

        $this->db->join('incubatee as IC', 'IC.innovation = IP.id');

        $query = $this->db->get('innovation_pool as IP');

        $data = $query->result_array();

        return $data;

    }

    public function insertSiteVisit($options = array(), $innovation)
    {
        foreach ($options['id'] as $key => $value) {

            if ($options['id'][$key] == '') {

                $data = array(

                    'innovation' => $innovation,

                    'criteria' => $options['criteria'][$key],

                    'subcriteria' => $options['subcriteria'][$key],

                    'category' => $options['category'][$key],

                    'place' => $options['place'][$key],

                    'date' => date2mysql($options['date'][$key]),

                    'created_date' => date("Y-m-d"),

                );

                $result = $this->db->insert('people_meet', $data);

            } else {

                $data1 = array(

                    'innovation' => $innovation,

                    'criteria' => $options['criteria'][$key],

                    'subcriteria' => $options['subcriteria'][$key],

                    'category' => $options['category'][$key],

                    'place' => $options['place'][$key],

                );

                $this->db->where('id', $options['id'][$key]);

                $result1 = $this->db->update('people_meet', $data1);

            }

        }

        return true;

    }

    public function externalDelete($id)
    {

        $this->db->where('id', $id);

        $this->db->db_debug = false;

        $result = $this->db->delete('people_meet');

        if (!$result) {

            $msg = $this->db->_error_message();

            $num = $this->db->_error_number();

            return $num;

        }

        return '';

    }

    public function insertDetails($innovation, $masterType, $criteria, $form = array())
    {
        unset($form['innovation']);

        unset($form['pid']);

        unset($form['criteria']);

        unset($form['txtSubmit']);

        foreach ($form as $key => $value) {

            for ($i = 0; $i < count($form['field']); $i++) {

                $data = array(

                    'innovation' => $innovation,

                    'master_type' => $masterType,

                    'criteria' => $criteria,

                    'field' => $form['field'][$i],

                    'answer' => $form['answer'][$i],

                    'documents' => $form['fileName'][$i],

                    'created_date' => date("Y-m-d"),

                );

                if ($this->checkDocsDuplicate($innovation, $masterType, $criteria, $form['field'][$i])) {

                    $this->db->insert('document_to_produce', $data);

                } else {

                    $this->db->where('field', $form['field'][$i]);

                    $this->db->update('document_to_produce', $data);

                }

            }

        }

        return true;

    }

    public function checkDocsDuplicate($innovation, $masterId, $criteria, $fieldID = array())
    {

        $this->db->select("id,answer,documents");

        $this->db->where_in("field", $fieldID);

        $result = $this->db->get('document_to_produce');

        $data = $result->result_array();

        if ($result->num_rows() > 0) {

            return false;

        } else {

            return true;

        }

    }

    public function getAnswerListBYID($id, $innovation)
    {

        $this->db->select("id,field,answer,documents");

        $this->db->where("field", $id);

        $this->db->where('innovation', $innovation);

        $result = $this->db->get("document_to_produce");

        $data = $result->result_array();

        return $data;

    }

    public function insertproducedDocs($innovation, $masterId, $criteria, $form = array())
    {

        $data = array(

            'innovation' => $innovation,

            'master_type' => $masterId,

            'criteria' => $criteria,

            'answer' => $form['document-description'],

            'documents' => $form['docToProduce'],

            'created_date' => date("Y-m-d"),

        );

        $this->db->insert('document_to_produce', $data);

        return true;

    }

    public function checkProduceDocsDuplicate($innovation, $masterId, $criteria)
    {

        $this->db->select("documents");

        $this->db->where("innovation", $innovation);

        $this->db->where("master_type", $masterId);

        $this->db->where("criteria", $criteria);

        $result = $this->db->get('document_to_produce');

        if ($result->num_rows() > 0) {

            return false;

        } else {

            return true;

        }

    }

    public function checkDuplicate($innovation, $criteria, $field = '')
    {

        $this->db->select('id');

        $this->db->where('criteria', $criteria);

        $this->db->where('innovation', $innovation);

        if ($field != '') {
            $this->db->where('field', $field);
        }

        $result = $this->db->get('screening');

        if ($result->num_rows() > 0) {

            return false;

        } else {

            return true;

        }

    }

    public function insertProfileDocsDetails($innovation, $files)
    {
        $data = array(
            "profile_pics" => $files['uploadProfilePics']['name'],
        );

        $this->db->where("id", $innovation);

        $this->db->update("innovation_pool", $data);

    }

    public function getSubCriteriaDetails()
    {

        $this->db->select("subcriteria_id,subcriteria");
        $this->db->order_by('subcriteria');
        $query = $this->db->get("assesment_master");

        $data = $query->result_array();

        return $data;

    }

    public function getInnovatorInfoBYID($innovation)
    {

        $this->db->where("id", $innovation);

        $query = $this->db->get("innovation_pool");

        $data = $query->result_array();

        return $data;

    }

    public function updateAssessmentStatus($innovation, $status)
    {

        $data = array(

            'innovation' => $innovation,

            'status' => $status,

            'created_date' => date("Y-m-d"),

        );

        if ($this->checkAssessmentDuplicateBy_Innovation($innovation)) {

            $result = $this->db->insert("screening_assessment_complete", $data);

        } else {

            $this->db->where("innovation", $innovation);

            $result = $this->db->update("screening_assessment_complete", $data);

        }

    }

    public function checkAssessmentDuplicateBy_Innovation($innovation)
    {

        $this->db->select('id,status');

        $this->db->where("innovation", $innovation);

        $result = $this->db->get('screening_assessment_complete');

        if ($result->num_rows() > 0) {

            return false;

        } else {
            return true;
        }

    }

    public function getAssessmentStatusByInnovation($innovation)
    {

        $this->db->select("status");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("screening_assessment_complete");

        $data = $query->result_array();

        return $data;

    }

    public function getDocumentsByInnovation($innovation)
    {
        $this->db->select('SD.id,SD.innovation,SD.checklist,SD.documents,CM.document_description');

        $this->db->where('SD.innovation', $innovation);

        $this->db->join('checklist_master as CM', 'CM.id = SD.checklist');

        $query = $this->db->get('screening_documents as SD');

        $data = $query->result_array();

        return $data;

    }

    public function getAssessmentListBYCriteria($criteria)
    {

        $this->db->select("label,id,pid,input_type");

        $this->db->where("criteria", $criteria);

        $this->db->where('pid !=', '');

        $this->db->where('input_type', 'textarea');

        $this->db->where('parent_value', null);

        $query = $this->db->get("screening_master");

        $data = $query->result_array();

        return $data;

    }

    public function getDocsByCriteria($innovation, $criteria, $pid = '0', $subfield = null)
    {

        $this->db->select('SA.id,SA.innovation,SM.label,SA.answer');

        $this->db->where('SA.innovation', $innovation);

        $this->db->where('SM.criteria', $criteria);

        $this->db->where('SM.input_type', "file");

        $this->db->join('screening as SA', 'SM.id = SA.field');

        $query = $this->db->get('screening_master as SM');

        $data = $query->result_array();

        $query->free_result();

        return $data;

    }

    public function insertSiteVisitDocs($options)
    {

        $data = array(

            'document' => $options['uploaddocs'],

        );

        $this->db->where("id", $options['editID']);

        $this->db->update("people_meet", $data);

    }

    public function insertdocsVerificationComments($id, $innovation, $ajaxComments, $userName)
    {

        $data = array(

            'document_id' => $id,

            'innovation' => $innovation,

            'comments' => $ajaxComments,

            'comments_by' => $userName,

            'created_date' => date('Y-m-d'),

        );

        if ($this->checkDuplicateDocComments($id, $innovation)) {

            $result = $this->db->insert("document_verify_comments", $data);

        } else {

            $this->db->where("document_id", $id);

            $result = $this->db->update("document_verify_comments", $data);

        }

        return $result;

    }

    public function checkDuplicateDocComments($id, $innovation)
    {

        $this->db->select('id');

        $this->db->where('document_id', $id);

        $this->db->where('innovation', $innovation);

        $result = $this->db->get('document_verify_comments');

        if ($result->num_rows() > 0) {

            return false;

        } else {
            return true;
        }

    }

    public function insertComments($innovation, $masterType, $criteria, $subcriteria, $comments, $userName)
    {

        if ($masterType == "m1") {$master = "Document to Produce";}

        if ($masterType == "m2") {$master = "Document to Verify";}

        if ($masterType == "m3") {$master = "People to Meet";}

        $data = array(

            'innovation' => $innovation,

            'master_type' => $master,

            'criteria' => $criteria,

            'subcriteria' => $subcriteria,

            'comments' => $comments,

            'comments_by' => $userName,

            'cretaed_date' => date('Y-m-d'),

        );

        $result = $this->db->insert("screening_assesment_comments", $data);

        return $data;

    }

    public function updateStatusIncubatee($name, $status)
    {

        $data = array(

            'enterprenur_name' => $name,

            'status' => $status,

            'created_date' => date('Y-m-d'),

        );

        $this->db->insert('incubatee_completed_status', $data);

        return true;

    }

    public function getData($name)
    {

        $this->db->select("enterprenur_name,status");

        $this->db->where("enterprenur_name", $name);

        $query = $this->db->get("incubatee_completed_status");

        $result = $query->result_array();

        return $result;

    }

    public function getCommentsData($innovation, $master, $criteria, $subcriteria = null)
    {

        $this->db->select("comments,comments_by");

        $this->db->where("innovation", $innovation);

        $this->db->where("master_type", $master);

        $this->db->where("criteria", $criteria);

        if ($subcriteria != null) {

            $this->db->where("subcriteria", $subcriteria);

        }

        $this->db->order_by('id', 'desc');

        $query = $this->db->get("screening_assesment_comments");

        $data = $query->result_array();

        return $data;

    }

    public function getEditTemplateData($innovation, $id = null)
    {

        $this->db->select("body");

        $this->db->where("innovation", $innovation);

        if ($id != null) {

            $this->db->where("id", $id);

        }

        $query = $this->db->get("nda_doc_edit");

        $data = $query->result_array();

        return $data;

    }

    public function checkDuplicateTemplateByInnovation($innovation)
    {

        $data = array();

        $this->db->select('id');

        $this->db->where('innovation', $innovation);

        $result = $this->db->get('nda_doc_edit');

        $data = $result->result_array();

        return $data;

    }

    public function insertDocsTemplate($innovation, $options)
    {

        $data = array(

            'innovation' => $innovation,

            'body' => $options['body'],

            'created_date' => date('Y-m-d'),

        );

        if ($this->checkDuplicateTemplate($innovation)) {

            $this->db->insert('nda_doc_edit', $data);

        } else {

            $this->db->where("innovation", $innovation);

            $this->db->update("nda_doc_edit", $data);

        }

        $this->db->select("id");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("nda_doc_edit");

        $insert_ID = $query->result_array();

        return $insert_ID;

    }

    #Menu Rearrangement

    public function getNdaListByInnovation($innovation)
    {

        $this->db->select("innovation,copy1,copy2");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("nda_document");

        $data = $query->result_array();

        return $data;

    }

    public function getCheckListByInnovation($innovation)
    {

        $this->db->select("innovation,checklist");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("checklist_innovation");

        $data = $query->result_array();

        return $data;

    }

    public function getDueDelligenceByInnovation($innovation)
    {

        $this->db->select("innovation,invite_code,invite_code,subject,description,status");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("invite_prescreen");

        $data = $query->result_array();

        return $data;

    }

    public function getDocsProduceByInnovation($innovation)
    {

        $this->db->select("innovation,master_type,criteria,field,answer,comments,documents");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("document_to_produce");

        $data = $query->result_array();

        return $data;

    }

    public function getAssessmentsDetails($innovation)
    {

        $this->db->select("innovation,criteria,subcriteria,category,place");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("people_meet");

        $data = $query->result_array();

        return $data;

    }

    public function getInnovationPeopleByStatus($innovation)
    {

        $data = array();

        $this->db->select('innovation,criteria');

        $this->db->where("innovation", $innovation);

        $query = $this->db->get('people_meet');

        $data = $query->result_array();

        $query->free_result();

        return $data;

    }

    public function getGradingFeedbackByInnovation($innovation)
    {

        $this->db->select("innovation,master_type,criteria,field,answer,comments,documents");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("document_to_produce");

        $data = $query->result_array();

        return $data;

    }

    public function getpre_ic_ByInnovation($innovation)
    {

        $this->db->select("innovation,email,subject,body");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("pre_ic_mail");

        $data = $query->result_array();

        return $data;

    }

    #End Menu Rearrangement

    public function checkDuplicateTemplate($innovation)
    {

        $this->db->select('id');

        $this->db->where('innovation', $innovation);

        $result = $this->db->get('nda_doc_edit');

        if ($result->num_rows() > 0) {

            return false;

        } else {
            return true;
        }

    }

    public function loadCriteriaDetails($id)
    {

        $this->db->select("subcriteria_id,subcriteria");

        $this->db->where("criteria", $id);
        $this->db->order_by('subcriteria');
        $query = $this->db->get("assesment_master");

        $data = $query->result_array();

        return $data;

    }

    public function getTemplateData()
    {

        $this->db->select("body");

        $query = $this->db->get("nda_doc_template");

        $data = $query->result_array();

        return $data;

    }

    public function editTemplateData($innovation = null)
    {

        $this->db->select("body");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("nda_doc_edit");

        $data = $query->result_array();

        return $data;

    }

    public function getConnectingPeopleDetails($innovation, $criteria, $field)
    {

        $data = array();

        $this->db->select("*");

        if (isset($options['num']) && isset($options['offset'])) {
            $this->db->limit($options['num'], $options['offset']);
        }

        $this->db->order_by('id', 'asc');

        if (!empty($options['orderby']) && !empty($options['ordertype'])) {
            $this->db->order_by($options['orderby'], $options['ordertype']);
        }

        $this->db->where("innovation", $innovation);

        $this->db->where("criteria", $criteria);

        $this->db->where("subcriteria", $field);

        $query = $this->db->get('people_meet');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

    public function insertPeopleConnection($innovation, $postdata)
    {

        $data = array(

            'innovation' => $innovation,

            'criteria' => $postdata['master_type'],

            'subcriteria' => $postdata['subcriteria'],

            'category' => $postdata['txtIndividual'],

            'place' => $postdata['label'],

            'date' => $postdata['date'],

            'created_date' => date('Y-m-d'),

        );

        $result = $this->db->insert('people_meet', $data);

        return $result;

    }

    public function updatePeopleConnection($innovation, $postdata, $id)
    {

        $data = array(

            'innovation' => $innovation,

            'criteria' => $postdata['master_type'],

            'subcriteria' => $postdata['subcriteria'],

            'category' => $postdata['txtIndividual'],

            'place' => $postdata['label'],

            'date' => $postdata['date'],

            'created_date' => date('Y-m-d'),

        );

        $this->db->where("id", $id);

        $result = $this->db->update('people_meet', $data);

        return $result;

    }

    /**

     * Function : changeStatus method is used for Make active inactive.

     * $options - values

     *     staus

     *    vendor_id

     *

     * @param array $options

     *

     */

    public function changeStatus($options = array())
    {

        $data = array('status' => $options['status']);

        $this->db->where('id', $options['id']);

        $this->db->update('people_meet', $data);

        return true;

    }

    /**

     * Function : delete method is used for delete records by changing status to -1.

     *

     * @param int $vendor_id

     *

     */

    public function delete($id)
    {

        $this->db->where('id', $id);

        $this->db->db_debug = false;

        $result = $this->db->delete('people_meet');

        if (!$result) {

            $msg = $this->db->_error_message();

            $num = $this->db->_error_number();

            return $num;

        }

        return '';

    }

    public function getTemplateType($innovation)
    {

        $data = array();

        $this->db->select("id,listing_type,innovation,label,input_type");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get('screening_master');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data[] = $row;

            }

        }

        return $data;

    }

    public function getPeopleByInnovation($innovation)
    {

        $data = array();

        $buildqry = "SELECT PM.category,PM.criteria,PM.place,PM.date,PM.status,CM.answer,CM.comments,CM.documents FROM people_meet as PM LEFT Join (Select DP.field,DP.answer,DP.comments,DP.documents,DP.innovation from `document_to_produce` as DP  where DP.innovation = '$innovation') as CM on (PM.innovation = CM.innovation) Where PM.innovation = '$innovation' Group by PM.category ";

        $value = $this->db->query($buildqry);

        $data = $value->result_array();

        return $data;

    }

    public function getCommentsByInnovation($innovation)
    {

        $this->db->select("comments,criteria,comments_by,cretaed_date");

        $this->db->where("innovation", $innovation);

        $query = $this->db->get("screening_assesment_comments");

        $data = $query->result_array();

        return $data;

    }

    public function getFiledsByPerticularIncubatee($innovation, $criteria, $pid = '0', $subfield = null)
    {

        $data = array();

        $this->db->select("SM.*");

        $this->db->select("(select answer from screening where screening.innovation='" . $innovation . "' and screening.criteria = '" . $criteria . "' and SM.id = screening.field) as answer");

        $this->db->select("(select count(id) from screening_master SF where SF.pid=SM.id and SF.parent_value = '') as assess_field");

        $this->db->select("(select count(id) from screening_master SF1 where SF1.pid=SM.id and SF1.parent_value != '') as sub_field");

        $this->db->where('SM.status', '1');

        $this->db->where('SM.criteria', $criteria);

        //Last Added

        $this->db->where('SM.innovation', $innovation);

        $this->db->where('SM.listing_type', "showPersonal");

        $this->db->where('SM.pid', $pid);

        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->order_by('SM.order', 'asc');

        $query = $this->db->get('screening_master SM');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $row['value'] = unserialize($row['value']);

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

    //Updation in assessment Started

    public function getDocsFieldsAnswerList($innovation, $criteria, $pid = '0', $subfield = null)
    {

        $data = array();

        $this->db->select("SM.*");

        $this->db->select("(select answer from document_to_produce where document_to_produce.innovation='" . $innovation . "' and document_to_produce.criteria = '" . $criteria . "' and SM.id = document_to_produce.field) as answer");

        $this->db->select("(select count(id) from screening_master SF where SF.pid=SM.id and SF.parent_value = '') as assess_field");

        $this->db->select("(select count(id) from screening_master SF1 where SF1.pid=SM.id and SF1.parent_value != '') as sub_field");

        $this->db->where('SM.status', '1');

        $this->db->where_in('SM.criteria', $criteria);

        $this->db->where('SM.pid', $pid);

        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->order_by('SM.order', 'asc');

        $query = $this->db->get('screening_master SM');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $row['value'] = unserialize($row['value']);

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

    // Updation in assessment end

    //Updation End

    public function getFiledsAnswerList($innovation, $criteria, $pid = '0', $subfield = null)
    {

        $data = array();

        $this->db->select("SM.*");

        $this->db->select("(select answer from screening where screening.innovation='" . $innovation . "' and screening.criteria = '" . $criteria . "' and SM.id = screening.field) as answer");

        $this->db->select("(select count(id) from screening_master SF where SF.pid=SM.id and SF.parent_value = '') as assess_field");

        $this->db->select("(select count(id) from screening_master SF1 where SF1.pid=SM.id and SF1.parent_value != '') as sub_field");

        $this->db->where('SM.status', '1');

        $this->db->where('SM.criteria', $criteria);

        //Last Added

        $this->db->where('SM.pid', $pid);

        if ($subfield == null and $pid != '0') {
            $this->db->where('parent_value', '');
        } elseif ($subfield != null) {
            $this->db->where('parent_value', $subfield);
        }

        $this->db->order_by('SM.order', 'asc');

        $query = $this->db->get('screening_master SM');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $row['value'] = unserialize($row['value']);

                $data[] = $row;

            }

        }

        $query->free_result();

        return $data;

    }

    public function ajaxForm($innovation, $criteria, $pid, $parent_value, $option = '')
    {

        if ($this->Mscreening->checkDuplicate($innovation, $criteria)) {
            $data['fieldsList'] = $this->Mscreening_master->getFiledsList($criteria, $pid, $parent_value);
        } else {
            $data['fieldsList'] = $this->Mscreening->getFiledsAnswerList($innovation, $criteria, $pid, $parent_value);
        }

        $data['innovation'] = $innovation;

        $data['criteria'] = $criteria;

        $data['option'] = $option;

        $this->load->vars($data);

        if (count($data['fieldsList'])) {

            if ($option == 'view') {
                $page = 'ajax_view';
            } else {
                $page = 'ajax_form';
            }

            echo $content = $this->load->view($page, true);

        }

    }

    #services

    public function insertInnovationServices($innovation, $services)
    {

        $data = array('innovation' => $innovation,

            'services' => implode(",", $services));

        if ($this->checkDuplicateService($innovation)) {

            $this->db->insert('innovation_services', $data);

        } else {

            $this->db->where('innovation', $innovation);

            $this->db->update('innovation_services', $data);

        }

    }

    public function checkDuplicateService($innovation)
    {

        $this->db->select('id');

        $this->db->where('innovation', $innovation);

        $result = $this->db->get('innovation_services');

        if ($result->num_rows() > 0) {

            return false;

        } else {
            return true;
        }

    }

    public function isCompleted($innovation)
    {

        $this->db->select("id,accept_status");

        $this->db->where("id", $innovation);

        $query = $this->db->get("innovation_pool");

        $data = $query->result_array();

        return $data;

    }

    public function getInnovationService($innovation)
    {

        $data = array();

        $this->db->select('services');

        $this->db->where('innovation', $innovation);

        $query = $this->db->get('innovation_services');

        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $data = explode(',', $row['services']);

            }

        }

        return $data;

    }

    public function getassessdocument($innovation, $id = null)
    {

        if ($id != null) {

            $wherequery = "DP.id = '" . $id . "'";

        } else {

            $wherequery = "1=1";

        }

        $query = "SELECT DP.*,MS.master_name,SM.label FROM document_to_produce as DP LEFT JOIN screening_master SM ON(SM.id = DP.field) JOIN master_settings as MS ON (MS.id = DP.criteria) where DP.innovation = '" . $innovation . "' AND $wherequery";

        $result = $this->db->query($query);

        return $result->result_array();

    }

    #agreement

}
