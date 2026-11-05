<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MCalendar extends CI_Model
{

    public function MCalendar()
    {
        parent::__construct();
    }

    public function getEvents($time, $user)
    {

        $today = date("Y/n/j", time());
        $current_month = date("n", $time);
        $current_year = date("Y", $time);
        $current_month_text = date("F Y", $time);
        $total_days_of_current_month = date("t", $time);

        $events = array();

        $query = $this->db->query("
          SELECT DATE_FORMAT(eventDate,'%d') AS day,`to`,share,
          eventContent,eventTitle,id,user,user_id,privacy
          FROM eventcal
          WHERE eventDate BETWEEN  '$current_year/$current_month/01'
          AND '$current_year/$current_month/$total_days_of_current_month' AND (user_id='" . $user . "' OR privacy = 'public') ");

        foreach ($query->result() as $row_event) {
            $events[intval($row_event->day)][] = $row_event;
        }
        $query->free_result();
        return $events;
    }
    public function getempname()
    {
        $query = "SELECT CONCAT(emp_first_name,emp_last_name) as empname from hr_user_profile";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function getDayEvents($day)
    {

        $query = $this->db->get_where('eventcal', array('eventDate' => $day));
        foreach ($query->result_array() as $row_event) {
            $events[] = $row_event;
        }
        $query->free_result();
        return $events;

    }

    public function getMyEvents($time, $user_id = 0)
    {

        $today = date("Y/n/j", time());
        $current_month = date("n", $time);
        $current_year = date("Y", $time);
        $current_month_text = date("F Y", $time);
        $total_days_of_current_month = date("t", $time);

        $events = array();

        $query = $this->db->query("
          SELECT DATE_FORMAT(eventDate,'%d') AS day,
          eventContent,
          eventTitle,id,user,user_id
          FROM eventcal
          WHERE  eventDate BETWEEN  '$current_year/$current_month/01'
          AND '$current_year/$current_month/$total_days_of_current_month'
          AND user_id = '$user_id' ");
        foreach ($query->result() as $row_event) {
            $events[intval($row_event->day)][] = $row_event;
        }
        $query->free_result();
        return $events;
    }

    public function getEventsById($id)
    {

        $this->db->where('id', $id);
        $query = $this->db->get('eventcal');
        foreach ($query->result_array() as $event) {
            $data[] = $event;
        }
        $query->free_result();
        return $data;
    }
    public function getshowevents($username)
    {
        $query = "select * from eventcal where user = '" . $username . "' or privacy = 'public'";
        $result = $this->db->query($query);
        foreach ($result->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function addEvents($user, $user_id)
    {

        if ($user_id != "") {
            $user_id = $user_id;
        } else {
            $user_id = "0";
        }
        if ($user == 'admin') {
            $privacy = 'public';
        } else {
            $privacy = 'private';
        }
        $query = "INSERT INTO eventcal
        (user,user_id,eventDate,eventTitle,eventContent,privacy,share,`to`)
        VALUES('$user','$user_id','" . $_POST['date'] . "','" . addslashes($_POST['eventTitle']) . "','" . addslashes($_POST['eventContent']) . "','" . addslashes($privacy) . "','" . addslashes($_POST['share']) . "','" . addslashes($_POST['to']) . "')";
        $result = $this->db->query($query);

        //check if the insertion is ok
        if ($result) {
            $alert = "New Event successfully added";
        } else {
            $alert = "Something is wrong. Try Again.";
        }

    }

    public function updateEvent()
    {

        $data = array(
            'eventDate' => $_POST['date'],
            'eventTitle' => $_POST['eventTitle'],
            'eventContent' => $_POST['eventContent'],
        );
        $this->db->where('id', $_POST['id']);
        $this->db->update('eventcal', $data);
    }

    public function deleteEvent($id)
    {
        $this->db->delete('eventcal', array('id' => $id));
    }

// end of Model/MCalendar.php
}
