SMPirepValidator v.1.3:
========================

SMPirepValidator v.1.3 for phpVMS (tested under PHP 7.4 and phpVMS v5.5.2.72 @ProAvia)
@description This module aims to validate if the pilot made his flights online on the IVAO and VATSIM networks

SmartModules addon module for phpVMS virtual airline system
@link https://smartmodules.com.br

SmartModules addon modules are licenced under the following license:
Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
To view full license text visit http://creativecommons.org/licenses/by-nc-sa/3.0/

@author Ton Nascoli (SmartModules)
@copyright Copyright (c) 2021, Ton Nascoli
@license http://creativecommons.org/licenses/by-nc-sa/3.0/


#Install:
========================
1. Download the ZIP file in your computer
2. Extract the zip file into a folder of your choice
3. Go to the folder where you extracted the files and access the phpvms_content folder
4. Upload the ADMIN and CORE folders to your website by placing them in the phpvms root folder
5. If asked to replace files, click YES


Install sm_onlinelog.sql
========================
Just import the sm_onlinelog.sql file using your PhpMyAdmin


CRON JOB
========================
This is the commonly used command line. If in doubt, consult your host provider

/usr/bin/GET https://{your_website}/{your_phpvms_folder}/action.php/SMPirepValidator/run_check


How does work?
------------------------
After you enable CRON JOB, the module will add all the pilot's flight logs to the sm_onlinelog table.
When validating the PIREP, the system will show if the LOG was found and will enable the administrator
to see the LOG of the flight performed at IVAO/VATSIM.

ENJOY!!!!

Note:
========================
 
1. Tested under PHP 7.4 and phpVMS v5.5.2.72

2. We made a litle bit change to the original code of the pirep_list.php file to allow
the IVAO / VATSIM flight log to be presented when validating PIREP. Therefore, 
it is important that you back up your file. This file is in the admin/templates folder.
We have provided a backup of the original file in the bkp_original_file folder.

3. This module is designed to take IVAO and VATSIM logs every 15 minutes and add them to 
the sm_onlinelog table.
