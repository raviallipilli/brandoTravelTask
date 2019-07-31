<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrandoTravel extends CI_Controller
{

    public function index()
    {
        if ($this->input->post('type') == 2) {
            $this->load->database();

            $start = $this->input->get('start');
            $destination = $this->input->get('destination');

            $startDate = trim($this->input->post('startDate'));
            $startDateArray = explode('/',$startDate);
            $mysqlStartDate = $startDateArray[2]."-".$startDateArray[1]."-".$startDateArray[0];
            $startDate = $mysqlStartDate;

            $startTime = $this->input->post('startTime');
            $endTime = $this->input->post('endTime');
            $duration = $this->input->post('duration');
            $description = $this->input->post('description');

            $query = "insert into journey (start,destination,startDate,startTime,endTime,duration,description) values ('" . $start . "','" . $destination . "','" . $startDate . "','" . $startTime . "','" . $endTime . "','" . $duration . "','" . $description . "')";
            $this->db->query($query);

            echo "Records Saved Successfully";

        }
        else if ($this->input->get('type') == 1) {

            $curl = curl_init();
            $start = rawurlencode($this->input->get('start'));
            $destination = rawurlencode($this->input->get('destination'));
            $appKey = '3952d46b22e214e3afaa313ea48b1eea';
            $appId = '86125f62';
            $requestUrl = "https://api.tfl.gov.uk/Journey/JourneyResults/$start/to/$destination?app_id=$appId&app_key=$appKey&nationalSearch=true";
            curl_setopt_array($curl, array(
                CURLOPT_URL => $requestUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $res = json_decode($response);

                $data = $res->journeys;
               // echo "<pre>";
               // print_r($data);
                $dateString = $data[0]->startDateTime;
                $dateArr = explode("T", $dateString);

                // start date
                $startDate = date('d/m/Y', strtotime($dateArr[0]));

                // start time
                $startTime = date('H:i', strtotime($dateArr[0] . ' ' . $dateArr[1]));

                $timeString = $data[0]->arrivalDateTime;
                $timeArr = explode("T", $timeString);

                // end time
                $endTime = date('H:i', strtotime($timeArr[0] . ' ' . $timeArr[1]));

                // duration
                $duration = $data[0]->duration." mins";

                // description
                $descArr = $data[0]->legs[0]->instruction->steps;
                $description = "<ul>";
                foreach ($descArr as $desc) {
                    $description .="<br>";
                    $description .= "<li>" . ucfirst($desc->description) . "</li>";

                    if ($desc->descriptionHeading) {
                        $description .="<br>";
                        $description .= "<li>" . ucfirst($desc->descriptionHeading) . "</li>";
                    }
                }
                $description .="<br>";
                $description .= "<li>You have now arrived</li>";
                $description .= "</ul>";

                echo json_encode(array(
                    'startDate' => $startDate,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'duration' => $duration,
                    'description' => $description,
                ));
                exit;
            }
        } else {
            $this->load->view('index');
        }
    }

}
