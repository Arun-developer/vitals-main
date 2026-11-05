<?php
class Memail extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/Mmailtemplate');
    }

    //replace values in template
    public function parseContent($content, $template)
    {
        $data['subject'] = $this->_parseContent($template['0']['subject'], $content);
        $data['body'] = $this->_parseContent($template['0']['body'], $content);
        return $data;
    }

    public function _parseContent($main, $replace)
    {
        $main = str_replace(php72_array_keys($replace), php72_array_values($replace), $main);
        return $main;
    }

    //send mail
    public function _send($fromEmail, $toEmail, $content, $template, $attach = array())
    {
        $templateContent = $this->Mmailtemplate->getMailTemplate($template);
        if (php72_count($templateContent)) {
            $template = $this->Memail->parseContent($content, $templateContent);
            $this->Memail->send($fromEmail, $toEmail, $template['subject'], $template['body'], $attach);
        }
    }

    public function send($fromEmail, $toEmail, $messageSubject, $messageBody, $attach = array())
    {
        $toEmail = array();
        $toEmail[] = 'prabakaran@quadrupleindia.com';
        $toEmail[] = 'chakravarthy@villgro.org';
        $toEmail[] = 'animesh@quadrupleindia.com';
        $this->load->library('email');
        $this->email->clear(true);
        $this->email->set_newline("\r\n");
        $this->email->from($fromEmail, "Incubation Committee, test.villgroapps.org");
        $this->email->to($toEmail);
        if (php72_count($attach)) {
            foreach ($attach as $key => $value):
                $this->email->attach($value);
            endforeach;
        }
        $this->email->subject($messageSubject);
        $this->email->message($messageBody);
        $this->email->send();
    }

}
