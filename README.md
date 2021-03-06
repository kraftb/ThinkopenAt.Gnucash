# ThinkopenAt.Gnucash

TYPO3 Flow package implementing an interface to the Gnucash book
keeping application.

## About this application framework

This application has been developed by me, a programmer which is
interested in book keeping. But as I have neither studied finance
nor have even visited a course or similar don't expect every
financial term to be correct!! Sorry for this :)

A bunch of database domain models and repositories has been created which
allows to interface with the mysql based Gnucash storage backend.
Currently the implemented application allows to summarize transactions
for outgoing and incoming invoices/bills. The generated report can
be used to deliver the quarterly (or monthly) company VAT tax statement
as required by the Austrian fiscal authorities. The German (Austrian) term is
"Umsatzsteuervoranmeldung".

Next to a printable HTML report an XML file can get generated which
allows direct import into the Austrian finance office web application
"finanzonline.at".

The new version also contains a rudimental attempt to export the
GnuCash accounts to a format which can get imported into the
BMD book keeping software which is used by many tax consultants.

The export can get configured from within a PHP array - so it should be
possible to adopt the application/export-settings to your GnuCash setup.
It can get assumed, that not all companies or freelancers which use GnuCash
have the same account setup.

It is most probably a question of taste whether one should adopt the
book keeping account setup to make your exports match the requirements
of your tax consultants. Or do it the other way round and alter the
export configuration.

## Intentions

So the application is currently rather focused on Austrian fiscal law
but could get easily adopted to other countries. As Gnucash is mostly
used by small companies and freelancers its intention is also rather
focused on those companies and businesses. For large companies there
are quite a lot of commercial professional business solutions while
this application is inteded to be affordable for small firms.

The idea behind it is to make book keeping more attractive to the owners
and employees of a small company instead of outsourcing every piece of
financial stuff to official book keeping agencies. Thus you have more
overview over your financial situation (or disaster) and can react better
upon short-term problems or opportunities. May they be good or bad.

## Future goals

The application should get split up into a framework supplying the
interface between Gnucash and TYPO3 Flow. Then a basic, non-regionaly
bound report/interface application should get create. Finally
regional sub-applications should/could get created which fit into
the existing application.

Those sub-packages will then match the requirements for different
regions/countries/planets and financial or governmental authorities :)

Have I noted that Gnucash supports a wide range of world wide used
currencies??

## Usage

To get everything to work you should have a little bit experience on
how to get a working TYPO3 Flow instance. Then you should know about
how to use Gnucash and how to get your Gnucash to save its data into
a mysql backend. In Linux you have to install some additional libraries
and there are tutorials on how to use Gnucash+mysql in Windows (Just
search the web).

## Database setup

To create a connection between the database GnuCash is using and your
TYPO3 Flow database there are a bunch of SQL VIEWs which have to get
created. You can create those VIEWs by executing the statements in
Meta/Views.sql of the GnuCash application.

The VIEWs described in there are creating a read/write relation between
your TYPO3 Flow and GnuCash database. Not only the table names are
mapped to table names which TYPO3 Flow uses natively but also some
column names are aliased.

Of course the TYPO3 Flow database user need access privileges to the
GnuCash database.

## Configuration of the application

Append the following configuration at the end of your
TYPO3 Flow Configuration/Settings.yaml file:

    ThinkopenAt:
     Gnucash:
        Setup:
          CompanyName: 'Your company name'
          TaxId: '12 345/9876'
          Currency: 'EUR'
          CustomerIdLength: 3
          VatRate: 20
 

## Configuration for VAT statement export

To get the VAT statement (Umsatzsteuervoranmeldung) operational
there are just a few things you have to change in your GnuCash accounts.

The account codes used here are cohering to the currently Austrian account
code model (Einheitskontenrahmen) as explained here:

http://www.steuerverein.at/buchhaltung/kontenplan_1.htm

http://www.steuerverein.at/buchhaltung/kontenplan_2.htm

Put all your income accounts (account code 400 "Brutto Umsatzerlöse") where
you book your outgoing bills to into a container parent account. Create
different container parent accounts for in-country income accounts. So for
you customers in Austria. Another container parent for european union customers
and another third one for world wide customers.

Then set the following values in the "CODE" field of the account. You can
do so by editing the account (right click) and filling the "CODE" field
from within the gnucash interface as shown in the screenshot.

![Account schema in GnuCash](/Documentation/Images/AccountSchema.png?raw=true "GnuCash account schema")

The important CODEs for your VAT declaration are as described here:

Those accounts get used to book your outgoing bills. The net amount (excluding
VAT) is booked to those accounts while the due VAT is book to the "VAT-AT"
account.

  **VAT:INCOME-AT**
  
  **VAT:INCOME-EU**
  
  **VAT:INCOME-WW**

The VAT which is due to get delivered to the fiscal office for every outgoing
bill you send to a customer has to get booked to an account with this code.
You will usually not have to charge any VAT to your customers in the EU as
those are falling within the reverse charge regulation.

  **VAT:AT**

When you make purchases or other companie send you a bill you have to book the
bill to the appropriate 7-class accounts (Abschreibungen) probably using an
3-class account for registering the incoming invoice. The VAT charged
to you usually has to get booked to 25-class account. Depending on 10% or 20%
different codes should get set for those VAT accounts:

  **VAT:RETURN-20**
  
  **VAT:RETURN-10**

For purchases or sevices in the EU you will usually get a bill without any
VAT and a notice about reverse charge regulations. You have to book the purchases
to an account labeled with the following code. The sum of purchases made in
the EU is used as basis for assesment (Bemessungsgrundlage).

  **VAT:PURCHASE-EU**

Finally you can (?) book (and counter-book) a VAT for purchases made in the EU
to an account with the following code.

So to create a virtual "Umsatzsteuer" and "Vorsteuer" account for reverse
charge purchases.

I am not sure about whether this is correct or usual this way. The values
from there are usually not required in the VAT declaration form so this is
obligatory.

  **VAT:RETURN-EU**

> **WARNING**: Take care. The code parts have changed from only hyphenated
> like "VAT-PURCHASE-EU" to a prefix "VAT" (code-key) separated from a value
> by a semicolon. So in the new version "VAT:PURCHASE-EU" and "VAT:AT" is
> required.

## Exporting an VAT statement

Open the TYPO3 Flow application at

http://yourflowsite.org/ThinkopenAt.Gnucash/

Then use the three supplied links:

* Umsatzsteuer Voranmeldung - PDF für Archiv
* XML für Umsatzsteuer Voranmeldung
* XML für Zusammenfassende Meldung 

For creating the reports required for your quarterly financial report.

NOTICE: It is currently not supported to dynamically fill in the year/quarter
which to export. I know. This would be really important.

So right now you have to set the year/quarter which you are going to export
in the following file on line 112:

Packages/Application/ThinkopenAt.Gnucash/Classes/ThinkopenAt/Gnucash/Controller/StandardController.php


