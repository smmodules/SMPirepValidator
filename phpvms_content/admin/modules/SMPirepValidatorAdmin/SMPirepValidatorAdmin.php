<?php

class SMPirepValidatorAdmin extends CodonModule
{
    public function viewlog() {

        $this->set('pilotdatalog', SMPirepValidatorData::getPilotDataLog($this->get->logid));
        $this -> show('smpirepvalidatoradmin/viewpilotlog.tpl');

    }
}
