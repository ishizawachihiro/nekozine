#!/bin/bash
if (( `ps -ef|grep $0|grep -v grep | wc -l` > 2 ));then
  exit 1
fi
/usr/bin/php /opt/nekozine/batch/import_mention.php >> /home/nekozine/log/import_`date +%Y%m%d`.log
exit
