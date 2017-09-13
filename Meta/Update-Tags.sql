
# Use this queries to update the "account_tag" table. This is required after
# adding new tags in the "code" field of an account. This should somehow get
# automated. Maybe a view could help?
#
# This "could" be done using a view. Altough the view would have to get altered
# every time the number of tags in one code field gets increased.


SELECT md5(concat(thinkopenat_gnucash_domain_model_account.persistence_object_identifier, code)) AS persistence_object_identifier, thinkopenat_gnucash_domain_model_account.persistence_object_identifier AS account, code AS tag from thinkopenat_gnucash_domain_model_account where code!='' AND code not like '%|%'

UNION

SELECT md5(concat(thinkopenat_gnucash_domain_model_account.persistence_object_identifier, substring_index(substring_index(code, '|', 1), '|', -1))) AS persistence_object_identifier, thinkopenat_gnucash_domain_model_account.persistence_object_identifier AS account, substring_index(substring_index(code, '|', 1), '|', -1) AS tag from thinkopenat_gnucash_domain_model_account where code!='' AND code like '%|%'

UNION

SELECT md5(concat(thinkopenat_gnucash_domain_model_account.persistence_object_identifier, substring_index(substring_index(code, '|', 2), '|', -1))) AS persistence_object_identifier, thinkopenat_gnucash_domain_model_account.persistence_object_identifier AS account, substring_index(substring_index(code, '|', 2), '|', -1) AS tag from thinkopenat_gnucash_domain_model_account where code!='' AND code like '%|%'

UNION

SELECT md5(concat(thinkopenat_gnucash_domain_model_account.persistence_object_identifier, substring_index(substring_index(code, '|', 3), '|', -1))) AS persistence_object_identifier, thinkopenat_gnucash_domain_model_account.persistence_object_identifier AS account, substring_index(substring_index(code, '|', 2), '|', -1) AS tag from thinkopenat_gnucash_domain_model_account where code!='' AND code like '%|%|%'

UNION

SELECT md5(concat(thinkopenat_gnucash_domain_model_account.persistence_object_identifier, substring_index(substring_index(code, '|', 4), '|', -1))) AS persistence_object_identifier, thinkopenat_gnucash_domain_model_account.persistence_object_identifier AS account, substring_index(substring_index(code, '|', 2), '|', -1) AS tag from thinkopenat_gnucash_domain_model_account where code!='' AND code like '%|%|%|%'
;



INSERT INTO
	thinkopenat_gnucash_domain_model_account_tag
	(persistence_object_identifier, account, tag)
SELECT
	md5(concat(uuid(), persistence_object_identifier, FLOOR(RAND() * 1000000000))),
	persistence_object_identifier,
	code
FROM
	thinkopenat_gnucash_domain_model_account
WHERE
	code!='' AND
	code not like '%|%'
;



INSERT INTO
	thinkopenat_gnucash_domain_model_account_tag
	(persistence_object_identifier, account, tag)
SELECT
	md5(concat(uuid(), persistence_object_identifier, FLOOR(RAND() * 1000000000))),
	persistence_object_identifier,
	substring_index(substring_index(code, '|', 2), '|', -1)
FROM
	thinkopenat_gnucash_domain_model_account
WHERE
	code!='' AND
	code like '%|%'
;


INSERT INTO
	thinkopenat_gnucash_domain_model_account_tag
	(persistence_object_identifier, account, tag)
SELECT
	md5(concat(uuid(), persistence_object_identifier, FLOOR(RAND() * 1000000000))),
	persistence_object_identifier,
	substring_index(substring_index(code, '|', 3), '|', -1)
FROM
	thinkopenat_gnucash_domain_model_account
WHERE
	code!='' AND
	code like '%|%|%'
;


