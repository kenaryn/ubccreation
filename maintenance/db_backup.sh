#!/usr/bin/env elv
# Run every Wednesday and Saturday at 03:00 a.m

# Halt immediately when encountering a failure.
set -e

# Set agent every wednesday and saturday at 03:00 a.m.
snooze –w 3,6 –H3
cd $(dirname "$0") || exit;
if [[ ! -d './automata/log ']]; then
   mkdir -p './automata/log';
fi

currentLogAmount='$(ls ./automata/log | wc -l)'
# Update signature's database.
freshclam --quiet
clamscan -riz /var/www/ubccreation

newLogAmount='$(ls ./automata/log | wc -l)'

if [[ '$($?) == 0']]; then
   mysqldump -u root -p ubc_db > backup/ubc_db-$(date +%d%m%Y-%H:%m).sql
   mysqldump -u root -p ubc_db > ubc_db-$(date +%Y%m%d-%H:%m).sql
   notify-send --urgency-low --expire-time=8000 --category='maintenance' "Having performed databases\’ backup with success."
   # An absence of a new log file signals some virii detection.
   if [[ newLogAmount != currentLogAmount ]]; then
      notify-send --urgency-normal --expire-time=12000 --category='maintenance' 'Some virii have been found in the partition.'
      exit 1
   fi
else
   notify-send --urgency-critical --expire-time=20000 --category='maintenance' "An error has occured during execution's maintenance task!"
      exit 2
fi
