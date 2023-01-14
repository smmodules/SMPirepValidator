<?php
/**
 * Class SMPirepValidatorData
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
class SMPirepValidatorData extends CodonModule
{
    public static function getAllLogs($orderby) {

        if (empty($orderby)) {
            $orderby='ASC';
        }

        $sql = "SELECT	* 
                FROM sm_onlinelog 
                ORDER BY sm_onlinelog.datelog '$orderby'";

        $result = DB::get_results($sql);
        return $result;
    }

    public static function CheckIvaoLogExist($network, $userId, $sessionId, $callsign, $sessioncreatedAt, $depairport, $arrairport, $peopleOnBoard)
    {

        $sql = "SELECT *	 
                FROM
	                sm_onlinelog 
                WHERE
                    sm_onlinelog.network = '$network'
                    AND sm_onlinelog.userId = '$userId'
                    AND sm_onlinelog.sessionId = '$sessionId'
                    AND sm_onlinelog.callsign = '$callsign'
	                AND sm_onlinelog.sessioncreatedAt = '$sessioncreatedAt'
                    AND sm_onlinelog.depairport = '$depairport'
                    AND sm_onlinelog.arrairport = '$arrairport'
	                AND sm_onlinelog.peopleOnBoard = '$peopleOnBoard'	                
	                LIMIT 1";

        return DB::get_row($sql);

    }

    public static function CheckVatsimLogExist($network, $userId, $callsign, $sessioncreatedAt, $depairport, $arrairport)
    {

        $sql = "SELECT *	 
                FROM
	                sm_onlinelog 
                WHERE
                    sm_onlinelog.network = '$network'
                    AND sm_onlinelog.userId = '$userId'
                    AND sm_onlinelog.callsign = '$callsign'
	                AND sm_onlinelog.sessioncreatedAt = '$sessioncreatedAt'
                    AND sm_onlinelog.depairport = '$depairport'
                    AND sm_onlinelog.arrairport = '$arrairport'	                
	                LIMIT 1";

        return DB::get_row($sql);

    }

    public static function findPilotDataLog($network, $userId, $callsign, $depairport, $arrairport)
    {
        $sql = "SELECT *	 
                FROM
	                sm_onlinelog 
                WHERE
                    sm_onlinelog.network = '$network'
                    AND sm_onlinelog.userId = '$userId'
                    AND sm_onlinelog.callsign = '$callsign'	                
                    AND sm_onlinelog.depairport = '$depairport'
                    AND sm_onlinelog.arrairport = '$arrairport'                                       	                
	                LIMIT 1";

        $result = DB::get_row($sql);
//        echo '<br>';
//        echo 'Network: '.$network.'<br>';
//        echo 'userID: '.$userId.'<br>';
//        echo 'Callsign: '.$callsign.'<br>';
//        echo 'Dep: '.$depairport.'<br>';
//        echo 'Arr: '.$arrairport.'<br>';
//        var_dump($result);
//        die();
        return  $result;
    }

    public static function getPilotDataLog($logid)
    {
        $sql = "SELECT *	 
                FROM
	                sm_onlinelog 
                WHERE
                    sm_onlinelog.id = '$logid'                   	                
	                LIMIT 1";

        return DB::get_row($sql);
    }

    public static function saveLog($network, $userId, $sessionId, $callsign, $serverId, $softwareTypeId,
        $softwareVersion, $sessioncreatedAt, $depairport, $arrairport, $alternative, $alternative2, $route, $remarks,
        $speed, $level, $flightRules, $eet, $endurance, $peopleOnBoard, $acftIcao, $acftModel, $simulatorId)
    {
        $sql="INSERT INTO sm_onlinelog (network, userId, sessionId, callsign, serverId, softwareTypeId, softwareVersion,
                          sessioncreatedAt, depairport, arrairport, alternative, alternative2, route, remarks, speed, 
                          level, flightRules, eet, endurance, peopleOnBoard, acftIcao, acftModel, simulatorId, created_at)

                    VALUES('$network', '$userId', '$sessionId', '$callsign', '$serverId', '$softwareTypeId',
                           '$softwareVersion', '$sessioncreatedAt', '$depairport', '$arrairport', '$alternative', 
                           '$alternative2', '$route', '$remarks', '$speed', '$level', '$flightRules', '$eet', '$endurance', 
                           '$peopleOnBoard', '$acftIcao', '$acftModel', '$simulatorId',now())";

        DB::query($sql);

        if (DB::errno() != 0) {
            echo '<hr><h1>'.DB::error().'</h1><hr>';
            return false;
        }
        return true;
    }
}
