
UPDATE transactions SET post_date=DATE_ADD(post_date, INTERVAL 12 HOUR) WHERE HOUR(post_date)=0 AND MINUTE(post_date)=0 AND SECOND(post_date)=0;
UPDATE transactions SET post_date=DATE_ADD(post_date, INTERVAL 13 HOUR) WHERE HOUR(post_date)=23 AND MINUTE(post_date)=0 AND SECOND(post_date)=0;
UPDATE transactions SET post_date=DATE_ADD(post_date, INTERVAL 14 HOUR) WHERE HOUR(post_date)=22 AND MINUTE(post_date)=0 AND SECOND(post_date)=0;


