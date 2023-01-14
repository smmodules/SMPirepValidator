<div>
    <h3>Pilot Data Log from <strong><?= $pilotdatalog->network ?></strong> network</h3>
    <table style="margin-bottom: 4px; padding: 3px; margin-top: 4px;" width="100%">
        <tr>
            <td align="left"><strong>Flight#:</strong> <?= $pilotdatalog->callsign ?></td>
            <td align="left"><strong>Departure:</strong> <?= $pilotdatalog->depairport ?></td>
            <td align="left"><strong>Arrival:</strong> <?= $pilotdatalog->arrairport ?></td>
            <td align="left"><strong>Alternative:</strong> <?= $pilotdatalog->alternative ?></td>
        </tr>
        <tr style="border-bottom-style: dotted; border-bottom-color: #8f8b8b;">
            <td align="left"><strong>User ID:</strong> <?= $pilotdatalog->userId ?></td>
            <td align="left"><strong>Server:</strong> <?= $pilotdatalog->serverId ?></td>
            <td align="left"><strong>Software:</strong> <?= $pilotdatalog->softwareTypeId.' / '.$pilotdatalog->softwareVersion ?></td>
            <?php
            $sessioncreatedAt = date_create_from_format('Ymdhis', $pilotdatalog->sessioncreatedAt);
            ?>
            <td align="left"><strong>Date:</strong> <?=  date_format($sessioncreatedAt, 'Y-m-d H:i:s'); ?></td>
        </tr>
        <tr>
            <td colspan="4" align="left"><strong>Route:</strong> <?= $pilotdatalog->route ?></td>
        </tr>
        <tr style="border-bottom-style: dotted; border-bottom-color: #8f8b8b;">
            <td colspan="4" align="left"><strong>Remarks:</strong> <?= $pilotdatalog->remarks ?></td>
        </tr>
        <tr>
            <td colspan="1" align="left"><strong>Simulator:</strong> <?= $pilotdatalog->simulatorId ?></td>
            <td colspan="2" align="left"><strong>Aircraft:</strong> <?= $pilotdatalog->acftIcao.' ('.$pilotdatalog->acftModel.')' ?></td>
            <td colspan="1" align="left"><strong>Level:</strong> <?= $pilotdatalog->level ?></td>
        </tr>
        <tr>
            <td align="left"><strong>Flight Rules:</strong> <?= $pilotdatalog->flightRules ?></td>
            <td align="left"><strong>EET:</strong> <?= $pilotdatalog->eet ?></td>
            <td align="left"><strong>Endurance:</strong> <?= $pilotdatalog->endurance ?></td>
            <td align="left"><strong>POB:</strong> <?= $pilotdatalog->peopleOnBoard ?></td>
        </tr>
    </table>
</div>
