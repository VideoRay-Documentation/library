<?php

$accessoryNameIndex = 0;
$accessoryProjIndex = 1;
$accessoryCatIndex = 2;
$accessoryMfgIndex = 3;

$categoryNameIndex = 0;
$categoryHeadingIndex = 1;
$categoryHtmIndex = 2;

$manufacturerNameIndex = 0;
$manufacturerHeadingIndex = 1;
$manufacturerHtmIndex = 2;

$dataDir = "data/";
$htmDir = "htm/";

$accessoriesFile = $dataDir . "accessories.csv";
$categoriesFile = $dataDir . "categories.csv";
$manufacturersFile = $dataDir . "manufacturers.csv";

$catList = "";
$mfgList = "";

//open categories list file
$categoriesData = file($categoriesFile);
$categoriesFound = 0;
$categoriesHeader = explode("|",$categoriesData[0]);

//create categories section list
for ($categoriesCount = 1 ; $categoriesCount < sizeof($categoriesData) ; $categoriesCount++) {
  $categoriesRow = explode("	",$categoriesData[$categoriesCount]);
  if (substr($categoriesRow[$categoryNameIndex],0,1) != "#") {
    $catSection[$categoriesRow[$categoryNameIndex]] = trim($categoriesRow[$categoryHeadingIndex]) . "\n";
    $catSectionHtm[$categoriesRow[$categoryNameIndex]] = "  <li><b><a href=\"" . trim($categoriesRow[$categoryHtmIndex]) . ".html\">" . $categoriesRow[$categoryNameIndex] . "</a></b></li>\n  <ul>\n";
    $catSubsectionHtm[$categoriesRow[$categoryNameIndex]] = "<h3>" . $categoriesRow[$categoryNameIndex] . " Accessories</h3>\n\n<ul>\n";
    }
  }

//open manufacturers list file
$manufacturersData = file($manufacturersFile);
$manufacturersFound = 0;
$manufacturersHeader = explode("|",$manufacturersData[0]);

//create mfg section list
for ($manufacturersCount = 1 ; $manufacturersCount < sizeof($manufacturersData) ; $manufacturersCount++) {
  $manufacturersRow = explode("	",$manufacturersData[$manufacturersCount]);
  if (substr($manufacturersRow[$manufacturerNameIndex],0,1) != "#") {
    $mfgSection[$manufacturersRow[$manufacturerNameIndex]] = trim($manufacturersRow[$manufacturerHeadingIndex]) . "\n";
    $mfgSectionHtm[$manufacturersRow[$manufacturerNameIndex]] = "  <li><b><a href=\"" . trim($manufacturersRow[$manufacturerHtmIndex]) . ".html\">" . $manufacturersRow[$manufacturerNameIndex] . "</a></b></li>\n  <ul>\n";
    $mfgSubsectionHtm[$manufacturersRow[$manufacturerNameIndex]] = "<h3>" . $manufacturersRow[$manufacturerNameIndex] . " Accessories</h3>\n\n<ul>\n";
    }
  }

//open accessories list file
$accessoriesData = file($accessoriesFile);
$accessoriesFound = 0;
$accessoriesHeader = explode("|",$accessoriesData[0]);

//output scripts
$accessoriesByAZ = "_acc_by_az.txt";
$accessoriesByCat = "_acc_by_cat.txt";
$accessoriesByMfg = "_acc_by_mfg.txt";

//ouptut htm files
$accessoriesAZ = $htmDir . "_accessories_az.htm";
$accessoriesCat = $htmDir . "_accessories_cat.htm";
$accessoriesMfg = $htmDir . "_accessories_mfg.htm";

$az = "v*,Accessories by A-Z,accessories_az.html,library/htm/_accessories_az.htm,,,\n\n";
$cat = "v*,Accessories by Category,accessories_cat.html,library/htm/_accessories_cat.htm,,,\n\n";
$mfg = "v*,Accessories by Manufacturer,accessories_mfg.html,library/htm/_accessories_mfg.htm,,,\n\n";

$htmAZ = file_get_contents($htmDir . "accessories_az_preface.htm");
$htmAZ .= "<ul>\n";
$htmCat = file_get_contents($htmDir . "accessories_cat_preface.htm");
$htmCat .= "<ul>\n";
$htmMfg = file_get_contents($htmDir . "accessories_mfg_preface.htm");
$htmMfg .= "<ul>\n";

//add pages to script
for ($accessoriesCount = 1 ; $accessoriesCount < sizeof($accessoriesData) ; $accessoriesCount++) {
  $accessoriesRow = explode("	",$accessoriesData[$accessoriesCount]);
  if (substr($accessoriesRow[$accessoryNameIndex],0,1) != "#") {

    $catCount[trim($accessoriesRow[$accessoryCatIndex])] = TRUE;
    $catSection[$accessoriesRow[$accessoryCatIndex]] .= "v***," . $accessoriesRow[$accessoryNameIndex] . ",nul,../../" .  trim($accessoriesRow[$accessoryProjIndex]) . "/html/index.htm,,,\n";
    $catSectionHtm[$accessoriesRow[$accessoryCatIndex]] .= "    <li><a href=\"../../" . $accessoriesRow[$accessoryProjIndex] . "/html/index.html\">" . $accessoriesRow[$accessoryNameIndex] . " </a></li>\n";    
    $catSubsectionHtm[$accessoriesRow[$accessoryCatIndex]] .= "  <li><a href=\"../../" . $accessoriesRow[$accessoryProjIndex] . "html/index.html\">" . $accessoriesRow[$accessoryNameIndex] . " </a></li>\n";    
    $catList .= $accessoriesRow[$accessoryCatIndex];

    $mfgCount[trim($accessoriesRow[$accessoryMfgIndex])] = TRUE;
    $mfgSection[trim($accessoriesRow[$accessoryMfgIndex])] .= "v***," . $accessoriesRow[$accessoryNameIndex] . ",nul,../../" .  trim($accessoriesRow[$accessoryProjIndex]) . "/html/index.htm,,,\n";
    $mfgSectionHtm[trim($accessoriesRow[$accessoryMfgIndex])] .= "    <li><a href=\"../../" . $accessoriesRow[$accessoryProjIndex] . "/html.index.html\">" . $accessoriesRow[$accessoryNameIndex] . " </a></li>\n";    
    $mfgSubsectionHtm[trim($accessoriesRow[$accessoryMfgIndex])] .= "  <li><a href=\"../../" . $accessoriesRow[$accessoryProjIndex] . "/html/index.html\">" . $accessoriesRow[$accessoryNameIndex] . " </a></li>\n";    
    $mfgList .= $accessoriesRow[$accessoryMfgIndex];
    }
  }

for ($categoriesCount = 1 ; $categoriesCount < sizeof($categoriesData) ; $categoriesCount++) {
  $categoriesRow = explode("	",$categoriesData[$categoriesCount]);
  if (isset($catCount[trim($categoriesRow[$categoryNameIndex])])) {
    $suffix = "";
    if (file_exists($htmDir . "acc_" . trim($categoriesRow[$categoryHtmIndex]) . "_suffix.htm")) {
      $suffix = file_get_contents($htmDir . "acc_" . trim($categoriesRow[$categoryHtmIndex]). "_suffix.htm");
      }
    if (strstr($catList,$categoriesRow[$categoryNameIndex])) {
      $cat .= $catSection[$categoriesRow[$categoryNameIndex]] . "\n";
      $htmCat .= $catSectionHtm[$categoriesRow[$categoryNameIndex]] . "    <p></p>\n    </ul>\n\n";
      $htmCatSub = file_get_contents($htmDir . "acc_" . trim($categoriesRow[$categoryHtmIndex]) . "_preface.htm") . "\n" . $catSubsectionHtm[$categoriesRow[$categoryNameIndex]] . "  </ul>\n\n" . $suffix;
      }
    //write categories files
    $outFile = fopen($htmDir . "_acc_" . trim($categoriesRow[$categoryHtmIndex]) . ".htm","w");
    $outSuccess = fwrite($outFile,$htmCatSub);
    $outSuccess = fclose($outFile);
    }
  }

for ($manufacturersCount = 1 ; $manufacturersCount < sizeof($manufacturersData) ; $manufacturersCount++) {
  $manufacturersRow = explode("	",$manufacturersData[$manufacturersCount]);
  if (isset($mfgCount[trim($manufacturersRow[$manufacturerNameIndex])])) {
    $suffix = "";
    if (file_exists($htmDir . "equip_" . trim($manufacturersRow[$manufacturerHtmIndex]) . "_suffix.htm")) {
      $suffix = file_get_contents($htmDir . "equip_" . trim($manufacturersRow[$manufacturerHtmIndex]). "_suffix.htm");
      }
    if (strstr($mfgList,$manufacturersRow[$manufacturerNameIndex])) {
      $mfg .= $mfgSection[$manufacturersRow[$manufacturerNameIndex]] . "\n";
      $htmMfg .= $mfgSectionHtm[$manufacturersRow[$manufacturerNameIndex]] . "    <p></p>\n    </ul>\n\n";
      $htmMfgSub = file_get_contents($htmDir . "equip_" . trim($manufacturersRow[$manufacturerHtmIndex]) . "_preface.htm") . "\n" . $mfgSubsectionHtm[$manufacturersRow[$manufacturerNameIndex]] . "  </ul>\n\n" . $suffix;
      }
    //write manufacturers files
    $outFile = fopen($htmDir . "_equip_" . trim($manufacturersRow[$manufacturerHtmIndex]) . ".htm","w");
    $outSuccess = fwrite($outFile,$htmMfgSub);
    $outSuccess = fclose($outFile);
    }
  }
sort($accessoriesData,SORT_STRING);
for ($accessoriesCount = 1 ; $accessoriesCount < sizeof($accessoriesData) ; $accessoriesCount++) {
  $accessoriesRow = explode("	",$accessoriesData[$accessoriesCount]);
  if (substr($accessoriesRow[$accessoryNameIndex],0,1) != "#") {
    $az .= "v**," . $accessoriesRow[$accessoryNameIndex] . ",nul,../../" . trim($accessoriesRow[$accessoryProjIndex]) . "/html/index.htm,,,\n";
    $htmAZ .= "  <li><a href=\"../../" . $accessoriesRow[$accessoryProjIndex] . "/html/index.html\">" . $accessoriesRow[$accessoryNameIndex] . " </a></li>\n";
    }
  }

$htmAZ .= "  </ul>\n";
$htmAZ .= file_get_contents($htmDir . "accessories_az_suffix.htm");

//$htmCat .= "  </ul>\n";  additional lists have closing tag
$htmCat .= file_get_contents($htmDir . "accessories_cat_suffix.htm");

$htmMfg .= "  </ul>\n\n";
$htmMfg .= file_get_contents($htmDir . "accessories_mfg_suffix.htm");

//write a-z script
$outFile = fopen($accessoriesByAZ,"w");
$outSuccess = fwrite($outFile,$az);
$outSuccess = fclose($outFile);

//write category script
$outFile = fopen($accessoriesByCat,"w");
$outSuccess = fwrite($outFile,$cat);
$outSuccess = fclose($outFile);

//write manufacturer script
$outFile = fopen($accessoriesByMfg,"w");
$outSuccess = fwrite($outFile,$mfg);
$outSuccess = fclose($outFile);

//write a-z htm file
$outFile = fopen($accessoriesAZ,"w");
$outSuccess = fwrite($outFile,$htmAZ);
$outSuccess = fclose($outFile);

//write cat htm file
$outFile = fopen($accessoriesCat,"w");
$outSuccess = fwrite($outFile,$htmCat);
$outSuccess = fclose($outFile);

//write cat htm file
$outFile = fopen($accessoriesMfg,"w");
$outSuccess = fwrite($outFile,$htmMfg);
$outSuccess = fclose($outFile);

echo $htmAZ;

?>