<?php

/** Georgia Southern University Course Search
 ** form_vars.php
 ** This file includes the values for the drop-downs
 ** in each course search form. It is updated externally
 ** along with suggest_data.js.
 */

/* Things included here:
 * Terms, Campus Locations, Levels, Departments, and
 * Sessions, and Subjects.
 */

// Terms
$search_terms = array(
  "201801" => "Spring 2018",
  "201805" => "Summer 2018",
  "201808" => "Fall 2018",
);

// Campus Locations
$search_locations = array(
  "A" => "Main Campus",
  "B" => "Brunswick Center",
  "C" => "Coastal Georgia Center",
  "D" => "Dublin Center",
  "L" => "Liberty Center",
  "U" => "Augusta Center",
  "F" => "Off Campus",
  "GML" => "Georgia On My Line",
  "OL" => "Fully On Line",
  "" => "Any Campus");

// Levels
$search_level = array(
  "" => "Any Level",
  "Lower Division" => "Lower Division",
  "Upper Division" => "Upper Division",
  "Masters Level and Specialist" => "Masters Level and Specialist",
  "Doctoral Level" => "Doctoral Level",
);

// Departments
$search_departments = array(
  "" => "Any Department",
  "1291" => "Africana Studies",
  "1202" => "Art",
  "1510" => "Biology",
  "2108" => "Biostatistics",
  "1511" => "Chemistry and Biochemistry",
  "1905" => "Civil Engineering &amp; Const Mgnt",
  "1205" => "Communication Arts",
  "2109" => "Community Hlth Behavior &amp; Educ",
  "1903" => "Computer Sciences",
  "1243" => "Criminal Justice &amp; Criminology",
  "1405" => "Curriculum Foundations &amp; Readi",
  "1201" => "Dean Liberal Arts &amp; Social Sci",
  "1301" => "Dean, Business Administration",
  "1401" => "Dean, College of Education",
  "1901" => "Dean, College of Engr &amp; IT",
  "1501" => "Dean, Science &amp; Mathematics",
  "1906" => "Electrical Engineering",
  "2110" => "Environmental Health",
  "2113" => "Epidemiology",
  "1341" => "Finance &amp; Economics",
  "1050" => "First-Year Experience",
  "1207" => "Foreign Languages",
  "1512" => "Geology &amp; Geography",
  "2102" => "Health Policy &amp; Mgt",
  "1605" => "Health and Kinesiology",
  "1209" => "History",
  "1008" => "Honors Program",
  "1607" => "Hosp,Tourism &amp; Fam Cons Scien",
  "1391" => "Information Systems",
  "1904" => "Information Technology",
  "1406" => "Leadership, Tech &amp; Human Dev",
  "1125" => "Learning Support",
  "1264" => "Literature &amp; Philosophy",
  "1363" => "Logistics and Supply Chain Mgt",
  "1351" => "Management",
  "1909" => "Manufacturing Engineering",
  "1303" => "Marketing",
  "1513" => "Mathematical Sciences",
  "1907" => "Mechanical Engineering",
  "1212" => "Music",
  "1514" => "Physics",
  "1214" => "Political Sci &amp; Intl Studies",
  "1215" => "Psychology",
  "1241" => "Public &amp; Nonprofit Studies",
  "2105" => "Public Health, General",
  "1504" => "ROTC - Military Science",
  "1302" => "School of Accountancy",
  "1671" => "School of Human Ecology",
  "1604" => "School of Nursing",
  "1216" => "Sociology &amp; Anthropology",
  "1404" => "Teaching and Learning",
  "0000" => "Undeclared Department",
  "1001" => "VP Instruction",
  "1317" => "WebMBA",
  "1263" => "Writing &amp; Linguistics",
);

// Sessions
$search_sessions = array(
  "201608" => array (
    "" => "Any Part of Term",
    "1" => "Full Term (15-AUG-16 - 08-DEC-16)",
    "G01" => "Full Semester GeorgiaOnMyLine (15-AUG-16 - 03-DEC-16)",
    "G02" => "Short Session 1 GeorgiaOnMyLine (15-AUG-16 - 07-OCT-16)",
    "G03" => "Short Session 2 GeorgiaOnMyLine (10-OCT-16 - 06-DEC-16)",
    "P" => "PPB No Drop (15-AUG-16 - 08-DEC-16)",
    "X" => "No Drop Classes (15-AUG-16 - 08-DEC-16)"),
  "201701" => array (
    "" => "Any Part of Term",
    "1" => "Full Term (09-JAN-17 - 05-MAY-17)",
    "G01" => "Full Semester GeorgiaOnMyLine (09-JAN-17 - 27-APR-17)",
    "G02" => "Short Session 1 GeorgiaOnMyLine (09-JAN-17 - 03-MAR-17)",
    "G03" => "Short Session 2 GeorgiaOnMyLine (06-MAR-17 - 27-APR-17)",
    "P" => "PPB No Drop (09-JAN-17 - 05-MAY-17)",
    "X" => "No Drop Classes (09-JAN-17 - 05-MAY-17)"),
  "201705" => array (
    "" => "Any Part of Term",
    "A" => "Term A (15-MAY-17 - 15-JUN-17)",
    "LS" => "Learning Support (19-JUN-17 - 21-JUL-17)",
    "LX" => "No Drop Part of Term L (15-MAY-17 - 13-JUL-17)",
    "AX" => "No Drop Part of Term A (15-MAY-17 - 15-JUN-17)",
    "B" => "Term B (19-JUN-17 - 21-JUL-17)",
    "BX" => "No Drop Part of Term B (19-JUN-17 - 21-JUL-17)",
    "D" => "COBA and JPHCOPH (15-MAY-17 - 28-JUN-17)",
    "E" => "COE Graduate Classes (30-MAY-17 - 13-JUL-17)",
    "EI" => "Eagle Incentive Program (19-JUN-17 - 21-JUL-17)",
    "G01" => "Full Semester GeorgiaOnMyLine (09-MAY-17 - 13-JUL-17)",
    "L" => "Long Term (15-MAY-17 - 13-JUL-17)"
  )
);

// Subjects
$search_subjects = array(
  "AAST" => "AAST Africana Studies",
  "ACCT" => "ACCT Accounting",
  "AL" => "AL-Ling-GOML",
  "AMST" => "AMST American Studies",
  "ANTH" => "ANTH Anthropology",
  "ARAB" => "ARAB Arabic",
  "ART" => "ART Art",
  "ARTH" => "ARTH Art History",
  "ASTR" => "ASTR Astronomy",
  "BIOL" => "BIOL Biology",
  "BIOS" => "BIOS Biostatics",
  "BUSA" => "BUSA Business Administration",
  "CENG" => "CENG Civil Engineering",
  "CHBE" => "CHBE Comm Hlth Behavior &amp; Ed",
  "CHEM" => "CHEM Chemistry",
  "CHFD" => "CHFD Child and Family Devel",
  "CHIN" => "CHIN Chinese",
  "CIED" => "CIED Valdosta State-Franchise",
  "CISM" => "CISM Computer Infor Systems",
  "COED" => "COED PBB Practicum",
  "COHE" => "COHE Community Health",
  "COML" => "COML Comparative Literature",
  "COMM" => "COMM Communication Arts",
  "COMS" => "COMS Communication Studies",
  "COOP" => "COOP Cooperative Education Pro",
  "COUN" => "COUN Counseling Education",
  "CRJU" => "CRJU Criminal Justice",
  "CSCI" => "CSCI Computer Science",
  "ECED" => "ECED Early Childhood Ed",
  "ECON" => "ECON Economics",
  "EDAT" => "EDAT Accomplished Teaching",
  "EDCI" => "EDCI-Education GAState Franchi",
  "EDET" => "EDET Education-GOML",
  "EDLD" => "EDLD Educational Leadership",
  "EDMS" => "EDMS Ed Accplish Teach CSU-GML",
  "EDMT" => "EDMT Educ Math-GOML",
  "EDRD" => "EDRD Georgia State Univ Franch",
  "EDSC" => "EDSC Sci for Teachers",
  "EDUC" => "EDUC Curriculum",
  "EDUF" => "EDUF Educational Foundations",
  "EDUR" => "EDUR Educational Research",
  "EENG" => "EENG Electrical Engineering",
  "EGC" => "EGC East Georgia College",
  "ENGL" => "ENGL English",
  "ENGR" => "ENGR Engineering",
  "ENVH" => "ENVH Environmental Hlth Scienc",
  "ENVS" => "ENVS Environmental Science",
  "EPID" => "EPID Epidemiology",
  "EPRS" => "EPRS Georgia State Univ Franch",
  "EPSF" => "EPSF Education Foundations-GML",
  "EPY" => "EPY ED Psyc GOML",
  "ESED" => "ESED Element - Secondary Educa",
  "ESL" => "ESL English as a Second Lang",
  "ESPY" => "ESPY School Psychology",
  "ETEC" => "ETEC Electronic Technology",
  "EURO" => "European Union",
  "FACS" => "FACS Family and Consumer Sci",
  "FILM" => "FILM Film",
  "FINC" => "FINC Finance",
  "FMAD" => "FMAD Fash Merchan/Apparel Des",
  "FORL" => "FORL Foreign Language",
  "FRCT" => "FRCT Curriculum Theory",
  "FREC" => "FREC Early Childhood",
  "FREN" => "FREN French",
  "FRER" => "FRER Educational Research",
  "FRIT" => "FRIT Instructional Technology",
  "FRLT" => "FRLT Educational Foundations",
  "FRMS" => "FRMS Middle &amp; Secondary Ed",
  "FYE" => "FYE First-Year Experience",
  "GCM" => "GCM Graphic Comm Management",
  "GEOG" => "GEOG Geography",
  "GEOL" => "GEOL Geology",
  "GRMN" => "GRMN German",
  "GSOU" => "GSOU CIR Placeholder Course",
  "GSU" => "GSU GSU",
  "HIST" => "HIST History",
  "HLTH" => "HLTH Health",
  "HNRM" => "HNRM Hotel and Restaurant Mgt",
  "HSPM" => "HSPM Hlth Service Policy Mgnt",
  "HUMN" => "HUMN Humanities",
  "IDS" => "IDS Interdisciplinary Studies",
  "INDS" => "INDS Interior Design",
  "INTS" => "INTS International Studies",
  "IRSH" => "IRSH Irish Studies",
  "ISCI" => "ISCI Science-Teach/Learn",
  "IT" => "IT Information Technology",
  "ITEC" => "ITEC Instructional Tech Ed",
  "JAPN" => "JAPN Japanese",
  "KINS" => "KINS Kinesiology",
  "LAST" => "LAST Latin American Studies",
  "LATN" => "LATN Latin",
  "LEAD" => "LEAD Leadership",
  "LESP" => "LESP Learning Support",
  "LING" => "LING Linguistics",
  "LOGT" => "LOGT Log/Intermodal Transpor.",
  "LSCM" => "LSCM Logistics Supply Chain Mg",
  "LSTD" => "LSTD Legal Studies",
  "MATH" => "MATH Mathematics",
  "MENG" => "MENG Mechanical Engineering",
  "MFGE" => "MFGE Manufacturing Engineering",
  "MGED" => "MGED Middle Grades Education",
  "MGMS" => "MGMS Valdosta State Franchise",
  "MGNT" => "MGNT Management",
  "MKTG" => "MKTG Marketing",
  "MMFP" => "MMFP Multimedia Film &amp; Prod",
  "MMJ" => "MMJ Multimedia Journalism",
  "MSCI" => "MSCI Military Science",
  "MSED" => "MSED Middle Grades &amp; Second Ed",
  "MUSA" => "MUSA Applied Music",
  "MUSC" => "MUSC Music",
  "MUSE" => "MUSE Music Ensemble",
  "NTFS" => "NTFS Nutrition and Food Sc",
  "NURS" => "NURS Nursing",
  "PBAD" => "PBAD Public Administration",
  "PHIL" => "PHIL Philosophy",
  "PHLD" => "PHLD Public Health Leadership",
  "PHYS" => "PHYS Physics",
  "POLS" => "POLS Political Science",
  "PRCA" => "PRCA Public Relations",
  "PSYC" => "PSYC Psychology",
  "PSYG" => "PSYG Psychology-GOML",
  "PUBH" => "PUBH Public Health",
  "READ" => "READ Reading",
  "RECR" => "RECR Recreation",
  "RELS" => "RELS Religious Studies",
  "SCED" => "SCED Secondary Education",
  "SEAC" => "SEAC Valdosta State Franchise",
  "SEGC" => "SEGC Valdosta State Franchise",
  "SERD" => "SERD GOML Valdosta",
  "SMGT" => "SMGT Sport Management",
  "SOAR" => "Student Orientation &amp; Registra",
  "SOCI" => "SOCI Sociology",
  "SPAN" => "SPAN Spanish",
  "SPED" => "SPED Special Education",
  "STAT" => "STAT Statistics",
  "SUST" => "SUST Sustainability",
  "TCGT" => "TCGT General Technology",
  "TCM" => "TCM Construction Management",
  "TEET" => "TEET Elect Engineering Tech",
  "THEA" => "THEA Theatre",
  "TMAE" => "TMAE Applied Engineering",
  "TMFG" => "TMFG Manufacturing Technology",
  "TSEC" => "TSEC Safety and Environ Compl",
  "TSLE" => "TSLE North Georgia-Franchise",
  "UHON" => "UHON University Honors",
  "WBIT" => "WBIT Web BSIT",
  "WGST" => "WGST Women and Gender Studies",
  "WLST" => "WLST Web Legal Studies",
  "WMAC" => "WMAC Web Masters of Accounting",
  "WMBA" => "WMBA Web MBA",
  "WRIT" => "WRIT Writing",
  "YORU" => "YORU Yoruba",
);
