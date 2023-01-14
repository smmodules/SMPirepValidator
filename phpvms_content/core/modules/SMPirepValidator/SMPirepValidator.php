<?php
/**
 * Class SMPirepValidator
 * SMPirepValidator v.1.0 for phpVMS (tested under PHP 7.4 and phpVMS v5.5.2.72)
 * @description This module aims to validate if the pilot made his flights online on the IVAO and VATSIM networks
 *
 * SmartModules addon module for phpVMS virtual airline system
 * @link https://smartmodules.com.br
 *
 * SmartModules addon modules are licenced under the following license:
 * Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 * To view full license text visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Ton Nascoli (SmartModules)
 * @copyright Copyright (c) 2021, Ton Nascoli
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */
class SMPirepValidator extends CodonModule
{
    public function index()
    {
        $this->run_check();
    }

    public function run_check()
    {
        /** get IVAO and VATSIM file */

        // IVAO
        $jsonIvao = file_get_contents('https://api.ivao.aero/v2/tracker/whazzup');
        $dataIvao = json_decode($jsonIvao);

        // VATSIM
        $jsonVatsim = file_get_contents("https://data.vatsim.net/v3/vatsim-data.json");
        $dataVatsim = json_decode($jsonVatsim);

        //**********************************************************
        //                          IVAO
        //**********************************************************

        $foundflight=0;
        $airlines = OperationsData::getAllAirlines(true);
        if ($airlines) {
            foreach ($airlines as $airline){

                $airlinecode = $airline->code;

                foreach ($dataIvao->clients->pilots as $pilot) {

                    if (substr($pilot->callsign, 0, 3) === $airlinecode){

                        // General Data
                        $network = "IVAO";
                        $userId = $pilot -> userId;

                        $sessionId = $pilot -> id;
                        $callsign = $pilot -> callsign;
                        $serverId = $pilot->serverId;
                        $softwareTypeId = $pilot->softwareTypeId;
                        $softwareVersion = $pilot->softwareVersion;
                        $sessioncreatedAt = substr(self::clearField($pilot -> createdAt), 0,14);

                        // Flight Plan Data
                        $depairport = $pilot->flightPlan->departureId;
                        $arrairport = $pilot->flightPlan->arrivalId;
                        $alternative = $pilot->flightPlan->alternativeId;
                        $alternative2 = $pilot->flightPlan->alternative2Id;
                        $route = $pilot->flightPlan->route;
                        $remarks = $pilot->flightPlan->remarks;
                        $speed = $pilot->flightPlan->speed;
                        $level = $pilot->flightPlan->level;
                        $flightRules = $pilot->flightPlan->flightRules;
                        $eet = self::clearField(gmdate("H:i", $pilot->flightPlan->eet));
                        $endurance = self::clearField(gmdate("H:i", $pilot->flightPlan->endurance));
                        $peopleOnBoard = $pilot->flightPlan->peopleOnBoard;

                        // Aircraft Data
                        $acftIcao = $pilot->flightPlan->aircraft->icaoCode;
                        $acftmodel = $pilot->flightPlan->aircraft->model;

                        // Pilot Session Data
                        $simulatorId = $pilot->pilotSession->simulatorId;

                        $foundflight=1;
                        $checkexist = SMPirepValidatorData::CheckIvaoLogExist($network, $userId, $sessionId, $callsign, $sessioncreatedAt, $depairport, $arrairport, $peopleOnBoard);
                        if (!$checkexist){
                            SMPirepValidatorData::saveLog($network, $userId, $sessionId,
                                $callsign, $serverId, $softwareTypeId,
                                $softwareVersion, $sessioncreatedAt, $depairport,
                                $arrairport, $alternative, $alternative2, $route,
                                $remarks,$speed, $level, $flightRules, $eet,
                                $endurance, $peopleOnBoard, $acftIcao, $acftmodel,
                                $simulatorId);

                            echo 'Network: '.$network.' (SessionID: '.$sessionId.') | '.' VID: '.$userId.' | '.' Callsign: '.$callsign.' | '.' Departure: '.$depairport.' | '.' Arrival: '.$arrairport.' [STATUS: ** ADDED TO DATABASE **]<hr>';
                        } else {
                            echo 'Network: '.$network.' (SessionID: '.$sessionId.') | '.' VID: '.$userId.' | '.' Callsign: '.$callsign.' | '.' Departure: '.$depairport.' | '.' Arrival: '.$arrairport.' [STATUS: !! session already exists !!]<hr>';
                        }

                    }

                }
            }
        }

        if ($foundflight === 0){
            echo '<hr><h3>***** THERE ARE NO FLIGHTS ON IVAO AT THE MOMENT *****</h3><hr>';
        }

        echo '<br><br>';

        //**********************************************************
        //                          VATSIM
        //**********************************************************

        $foundflight=0;
        $airlines = OperationsData::getAllAirlines(true);

        if ($airlines) {
            foreach ($airlines as $airline){

                $airlinecode = $airline->code;


                foreach ($dataVatsim->pilots as $pilot) {

                    if (substr($pilot->callsign, 0, 3) === $airlinecode){

                        // General Data
                        $network = "VATSIM";
                        $userId = $pilot -> cid; // Vatsim CID

                        $sessionId = "";
                        $callsign = $pilot -> callsign;
                        $serverId = $pilot->server;
                        $softwareTypeId = "";
                        $softwareVersion = "";
                        $sessioncreatedAt = substr(self::clearField($pilot -> logon_time), 0,14);

                        // Flight Plan Data
                        $depairport = $pilot->flight_plan->departure;
                        $arrairport = $pilot->flight_plan->arrival;
                        $alternative = $pilot->flight_plan->alternate;
                        $alternative2 = "";
                        $route = $pilot->flight_plan->route;
                        $remarks = $pilot->flight_plan->remarks;
                        $speed = 'N'.str_pad($pilot->flight_plan->cruise_tas,4,0, STR_PAD_LEFT);
                        $level = $pilot->flight_plan->altitude;
                        $flightRules = $pilot->flight_plan->flight_rules;
                        $eet = $pilot->flight_plan->enroute_time;
                        $endurance = $pilot->flight_plan->fuel_time;
                        $peopleOnBoard = "";

                        // Aircraft Data
                        $acftIcao = $pilot->flightPlan->aircraft_short;
                        $acftmodel = $pilot->flightPlan->aircraft;

                        // Pilot Session Data
                        $simulatorId = "";

                        $foundflight=1;
                        $checkexist = SMPirepValidatorData::CheckVatsimLogExist($network, $userId, $callsign, $sessioncreatedAt, $depairport, $arrairport);
                        if (!$checkexist){
                            SMPirepValidatorData::saveLog($network, $userId, $sessionId,
                                $callsign, $serverId, $softwareTypeId,
                                $softwareVersion, $sessioncreatedAt, $depairport,
                                $arrairport, $alternative, $alternative2, $route,
                                $remarks,$speed, $level, $flightRules, $eet,
                                $endurance, $peopleOnBoard, $acftIcao, $acftmodel,
                                $simulatorId);

                            echo 'Network: '.$network.' | '.' CID: '.$userId.' | '.' Callsign: '.$callsign.' | '.' Departure: '.$depairport.' | '.' Arrival: '.$arrairport.' [STATUS: ** ADDED TO DATABASE **]<hr>';
                        } else {
                            echo 'Network: '.$network.' | '.' CID: '.$userId.' | '.' Callsign: '.$callsign.' | '.' Departure: '.$depairport.' | '.' Arrival: '.$arrairport.' [STATUS: !! session already exists !!]<hr>';
                        }

                    }

                }
            }
        }

        if ($foundflight === 0){
            echo '<hr><h3>***** THERE ARE NO FLIGHTS ON VATSIM AT THE MOMENT *****</h3><hr>';
        }

    }

    public static function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function clearField(?string $param)
    {
        if(empty($param)){
            return '';
        }

        return str_replace(['.', '-', '/', '(', ')', ':', 'T', 'Z', ' '], '', $param);
    }
}
