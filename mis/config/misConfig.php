<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//site Name

$config['site_name'] = 'Management Information System';



//date format

$config['mysqlDate'] = "Y-m-d H:i:s";

$config['displayDate'] = "d-m-Y";

//master settings

$config['masterType'] = array(
    'source_type' => 'Source Type',
    'program_type' => 'Program Type',
    'incubation_cycle' => 'Incubation Cycle',
    'assessment_criteria' => 'Assessment Criteria',
    'activity_type' => 'Activity Type',
    'grading_category' => 'Grading Category',
    'document_checklist' => 'Document Checklist',
    'onhold_reasons' => 'Onhold Reasons',
    'resume_reasons' => 'Resume Reasons',
    'follow_reasons' => 'Follow Reasons',
    'area' => 'Area/Origin',
    'agreement' => 'Agreement',
    'nature_source' => 'Nature Source',
    'board_documents' => 'Board Formation Documents',
    'invester_document' => 'Invester Document'
);

$config['protoType'] = array(
    'designation' => 'Designation',
    'partnership_type' => 'Non TAP',
    'units' => 'Units',
    'donor' => 'Donor',
    'service' => 'TAP',
    'company_target' => 'Sector Target'
);

