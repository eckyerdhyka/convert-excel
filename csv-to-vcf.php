<?php

require_once __DIR__ . '/vendor/autoload.php';

use JeroenDesloovere\VCard\VCard;
use League\Csv\Reader;

/******* CONFIG *******/

$csv_file_name = "data-140218.csv";
$vcf_file_name = "data_070318.vcf";

/***** END CONFIG *****/

// Initialize CSV reader
$reader = Reader::createFromPath($csv_file_name);

$i = 0;

$contacts = [];
$str_contacts = "";

// Iterate over CSV contacts
foreach ($reader as $index => $column) {

	if ($i === 0) {
		$i++;
		continue;
	}

	// Initialize VCard
	$vcard = new VCard();

	// Define CSV file columns
	$name = strtolower($column[3]);
	$additional = 'db '.strtolower($column[0]);
	$prefix = '';
	$suffix = '';
	$birthday = '';
	$phone = $column[6];
	// END Define CSV file columns

	$vcard->addName($name, $additional, $prefix, $suffix);
	$vcard->addPhoneNumber($phone, 'PREF;WORK');
	$vcard->addBirthday($birthday);

	$contacts[] = $vcard->getOutput();

	$i++;
}

$str_contacts = implode("", $contacts);

file_put_contents($vcf_file_name, $str_contacts);
