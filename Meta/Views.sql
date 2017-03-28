
CREATE VIEW `thinkopenat_gnucash_domain_model_account` AS select `to_gnucash`.`accounts`.`guid` AS `persistence_object_identifier`,`to_gnucash`.`accounts`.`name` AS `name`,`to_gnucash`.`accounts`.`account_type` AS `account_type`,`to_gnucash`.`accounts`.`commodity_guid` AS `commodity`,`to_gnucash`.`accounts`.`commodity_scu` AS `commodity_scu`,`to_gnucash`.`accounts`.`non_std_scu` AS `non_std_scu`,`to_gnucash`.`accounts`.`parent_guid` AS `parent`,`to_gnucash`.`accounts`.`code` AS `code`,`to_gnucash`.`accounts`.`description` AS `description`,`to_gnucash`.`accounts`.`hidden` AS `hidden`,`to_gnucash`.`accounts`.`placeholder` AS `placeholder` from `to_gnucash`.`accounts`;


CREATE VIEW `thinkopenat_gnucash_domain_model_invoice` AS select `to_gnucash`.`invoices`.`guid` AS `persistence_object_identifier`,`to_gnucash`.`invoices`.`id` AS `id`,`to_gnucash`.`invoices`.`date_opened` AS `opened`,`to_gnucash`.`invoices`.`date_posted` AS `posted`,`to_gnucash`.`invoices`.`notes` AS `notes`,`to_gnucash`.`invoices`.`active` AS `active`,`to_gnucash`.`invoices`.`currency` AS `currency`,`to_gnucash`.`invoices`.`owner_type` AS `ownerType`,`to_gnucash`.`invoices`.`owner_guid` AS `owner`,`to_gnucash`.`invoices`.`terms` AS `terms`,`to_gnucash`.`invoices`.`billing_id` AS `billingId`,`to_gnucash`.`invoices`.`post_txn` AS `transaction`,`to_gnucash`.`invoices`.`post_lot` AS `lot`,`to_gnucash`.`invoices`.`post_acc` AS `account`,`to_gnucash`.`invoices`.`billto_type` AS `billtoType`,`to_gnucash`.`invoices`.`billto_guid` AS `billto`,`to_gnucash`.`invoices`.`charge_amt_num` AS `charge_amount_num`,`to_gnucash`.`invoices`.`charge_amt_denom` AS `charge_amount_denom` from `to_gnucash`.`invoices`;


CREATE VIEW `thinkopenat_gnucash_domain_model_split` AS select `to_gnucash`.`splits`.`guid` AS `persistence_object_identifier`,`to_gnucash`.`splits`.`tx_guid` AS `transaction`,`to_gnucash`.`splits`.`account_guid` AS `account`,`to_gnucash`.`splits`.`memo` AS `memo`,`to_gnucash`.`splits`.`action` AS `action`,`to_gnucash`.`splits`.`reconcile_state` AS `reconcile_state`,`to_gnucash`.`splits`.`reconcile_date` AS `reconcile_date`,`to_gnucash`.`splits`.`value_num` AS `value_num`,`to_gnucash`.`splits`.`value_denom` AS `value_denom`,`to_gnucash`.`splits`.`quantity_num` AS `quantity_num`,`to_gnucash`.`splits`.`quantity_denom` AS `quantity_denom`, lot_guid AS lot from `to_gnucash`.`splits`



CREATE VIEW
    thinkopenat_gnucash_domain_model_customer
AS SELECT
    guid AS persistence_object_identifier,
    name, id, notes, active, discount_num, discount_denom, credit_num, credit_denom,
    currency, tax_override AS taxOverride,
    addr_name AS addressName, addr_addr1 AS addressLine1, addr_addr2 AS addressLine2,
    addr_addr3 AS addressLine3, addr_addr4 AS addressLine4, addr_phone AS addressPhone,
    addr_fax AS addressFax, addr_email AS addressEmail,
    shipaddr_name AS shippingAddressName, shipaddr_addr1 AS shippingAddressLine1,
    shipaddr_addr2 AS shippingAddressLine2, shipaddr_addr3 AS shippingAddressLine3,
    shipaddr_addr4 AS shippingAddressLine4, shipaddr_phone AS shippingAddressPhone,
    shipaddr_fax AS shippingAddressFax, shipaddr_email AS shippingAddressEmail,
    terms, tax_included AS taxIncluded, taxtable AS taxTable
FROM to_gnucash.customers;

CREATE VIEW
    thinkopenat_gnucash_domain_model_currency
AS SELECT
    guid AS persistence_object_identifier,
    namespace, mnemonic, fullname, cusip, fraction, quote_flag AS quoteFlag,
    quote_source AS quoteSource, quote_tz AS quoteTz
FROM to_gnucash.commodities;

CREATE VIEW
    thinkopenat_gnucash_domain_model_tax_table
AS SELECT
    guid AS persistence_object_identifier,
    name, refcount, invisible, parent
FROM to_gnucash.taxtables;


DROP VIEW thinkopenat_gnucash_domain_model_invoice_entry;
CREATE VIEW
    thinkopenat_gnucash_domain_model_invoice_entry
AS SELECT
    guid AS persistence_object_identifier,
    date, date_entered AS entered, description,
    action, notes, quantity_num, quantity_denom,
    i_acct AS account, i_price_num AS price_num, i_price_denom AS price_denom,
    i_discount_num AS discount_num, i_discount_denom AS discount_denom,
    invoice, i_disc_type AS discountType, i_disc_how AS discountOrder,
    i_taxable AS taxable, i_taxincluded AS taxIncluded, i_taxtable AS taxTable
FROM to_gnucash.entries;


