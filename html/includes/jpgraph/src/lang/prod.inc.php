<?php
/*=======================================================================
// File: 	PROD.INC.PHP
// Description: Special localization file with the same error messages 
//              for all errors.
// Created: 	2006-02-18
// Ver:		$Id: prod.inc.php 993 2008-03-30 21:17:41Z ljp $
//
// Copyright (c) Aditus Consulting. All rights reserved.
//========================================================================
*/

// The single error message for all errors
DEFINE('DEFAULT_ERROR_MESSAGE','We are sorry but the system could not generate the requested image. Please contact site support to resolve this problem. Problem no: #');

// Note: Format of each error message is array(<error message>,<number of arguments>)
$_jpg_messages = array(

/*
** Headers already sent error. This is formatted as HTML different since this will be sent back directly as text
*/
10  => array('<table border=1><tr><td><font color=darkred size=4><b>JpGraph Error:</b> 
HTTP headers have already been sent.<br>Caused by output from file <b>%s</b> at line <b>%d</b>.</font></td></tr><tr><td><b>Explanation:</b><br>HTTP headers have already been sent back to the browser indicating the data as text before the library got a chance to send it\'s image HTTP header to this browser. This makes it impossible for the library to send back image data to the browser (since that would be interpretated as text by the browser and show up as junk text).<p>Most likely you have some text in your script before the call to <i>Graph::Stroke()</i>. If this texts gets sent back to the browser the browser will assume that all data is plain text. Look for any text, even spaces and newlines, that might have been sent back to the browser. <p>For example it is a common mistake to leave a blank line before the opening "<b>&lt;?php</b>".</td></tr></table>',2),


11 => array(DEFAULT_ERROR_MESSAGE.'11',0),
12 => array(DEFAULT_ERROR_MESSAGE.'12',0),
13 => array(DEFAULT_ERROR_MESSAGE.'13',0),
2001 => array(DEFAULT_ERROR_MESSAGE.'2001',0),
2002 => array(DEFAULT_ERROR_MESSAGE.'2002',0),
2003 => array(DEFAULT_ERROR_MESSAGE.'2003',0),
2004 => array(DEFAULT_ERROR_MESSAGE.'2004',0),
2005 => array(DEFAULT_ERROR_MESSAGE.'2005',0),
2006 => array(DEFAULT_ERROR_MESSAGE.'2006',0),
2007 => array(DEFAULT_ERROR_MESSAGE.'2007',0),
2008 => array(DEFAULT_ERROR_MESSAGE.'2008',0),
2009 => array(DEFAULT_ERROR_MESSAGE.'2009',0),
2010 => array(DEFAULT_ERROR_MESSAGE.'2010',0),
2011 => array(DEFAULT_ERROR_MESSAGE.'2011',0),
2012 => array(DEFAULT_ERROR_MESSAGE.'2012',0),
2013 => array(DEFAULT_ERROR_MESSAGE.'2013',0),
2014 => array(DEFAULT_ERROR_MESSAGE.'2014',0),
3001 => array(DEFAULT_ERROR_MESSAGE.'3001',0),
4002 => array(DEFAULT_ERROR_MESSAGE.'4002',0),
5001 => array(DEFAULT_ERROR_MESSAGE.'5001',0),
5002 => array(DEFAULT_ERROR_MESSAGE.'5002',0),
5003 => array(DEFAULT_ERROR_MESSAGE.'5003',0),
5004 => array(DEFAULT_ERROR_MESSAGE.'5004',0),
6001 => array(DEFAULT_ERROR_MESSAGE.'6001',0),
6002 => array(DEFAULT_ERROR_MESSAGE.'6002',0),
6003 => array(DEFAULT_ERROR_MESSAGE.'6003',0),
6004 => array(DEFAULT_ERROR_MESSAGE.'6004',0),
6005 => array(DEFAULT_ERROR_MESSAGE.'6005',0),
6006 => array(DEFAULT_ERROR_MESSAGE.'6006',0),
6007 => array(DEFAULT_ERROR_MESSAGE.'6007',0),
6008 => array(DEFAULT_ERROR_MESSAGE.'6008',0),
6009 => array(DEFAULT_ERROR_MESSAGE.'6009',0),
6010 => array(DEFAULT_ERROR_MESSAGE.'6010',0),
6011 => array(DEFAULT_ERROR_MESSAGE.'6011',0),
6012 => array(DEFAULT_ERROR_MESSAGE.'6012',0),
6015 => array(DEFAULT_ERROR_MESSAGE.'6015',0),
6016 => array(DEFAULT_ERROR_MESSAGE.'6016',0),
6017 => array(DEFAULT_ERROR_MESSAGE.'6017',0),
6018 => array(DEFAULT_ERROR_MESSAGE.'6018',0),
6019 => array(DEFAULT_ERROR_MESSAGE.'6019',0),
6020 => array(DEFAULT_ERROR_MESSAGE.'6020',0),
6021 => array(DEFAULT_ERROR_MESSAGE.'6021',0),
6022 => array(DEFAULT_ERROR_MESSAGE.'6022',0),
6023 => array(DEFAULT_ERROR_MESSAGE.'6023',0),
6024 => array(DEFAULT_ERROR_MESSAGE.'6024',0),
6025 => array(DEFAULT_ERROR_MESSAGE.'6025',0),
6027 => array(DEFAULT_ERROR_MESSAGE.'6027',0),
6028 => array(DEFAULT_ERROR_MESSAGE.'6028',0),
6029 => array(DEFAULT_ERROR_MESSAGE.'6029',0),
6030 => array(DEFAULT_ERROR_MESSAGE.'6030',0),
6031 => array(DEFAULT_ERROR_MESSAGE.'6031',0),
6032 => array(DEFAULT_ERROR_MESSAGE.'6032',0),
7001 => array(DEFAULT_ERROR_MESSAGE.'7001',0),
8001 => array(DEFAULT_ERROR_MESSAGE.'8001',0),
8002 => array(DEFAULT_ERROR_MESSAGE.'8002',0),
8003 => array(DEFAULT_ERROR_MESSAGE.'8003',0),
8004 => array(DEFAULT_ERROR_MESSAGE.'8004',0),
9001 => array(DEFAULT_ERROR_MESSAGE.'9001',0),
10001 => array(DEFAULT_ERROR_MESSAGE.'10001',0),
10002 => array(DEFAULT_ERROR_MESSAGE.'10002',0),
10003 => array(DEFAULT_ERROR_MESSAGE.'10003',0),
11001 => array(DEFAULT_ERROR_MESSAGE.'11001',0),
11002 => array(DEFAULT_ERROR_MESSAGE.'11002',0),
11003 => array(DEFAULT_ERROR_MESSAGE.'11003',0),
11004 => array(DEFAULT_ERROR_MESSAGE.'11004',0),
11005 => array(DEFAULT_ERROR_MESSAGE.'11005',0),
12001 => array(DEFAULT_ERROR_MESSAGE.'12001',0),
12002 => array(DEFAULT_ERROR_MESSAGE.'12002',0),
12003 => array(DEFAULT_ERROR_MESSAGE.'12003',0),
12004 => array(DEFAULT_ERROR_MESSAGE.'12004',0),
12005 => array(DEFAULT_ERROR_MESSAGE.'12005',0),
12006 => array(DEFAULT_ERROR_MESSAGE.'12006',0),
12007 => array(DEFAULT_ERROR_MESSAGE.'12007',0),
12008 => array(DEFAULT_ERROR_MESSAGE.'12008',0),
12009 => array(DEFAULT_ERROR_MESSAGE.'12009',0),
12010 => array(DEFAULT_ERROR_MESSAGE.'12010',0),
12011 => array(DEFAULT_ERROR_MESSAGE.'12011',0),
12012 => array(DEFAULT_ERROR_MESSAGE.'12012',0),
14001 => array(DEFAULT_ERROR_MESSAGE.'14001',0),
14002 => array(DEFAULT_ERROR_MESSAGE.'14002',0),
14003 => array(DEFAULT_ERROR_MESSAGE.'14003',0),
14004 => array(DEFAULT_ERROR_MESSAGE.'14004',0),
14005 => array(DEFAULT_ERROR_MESSAGE.'14005',0),
14006 => array(DEFAULT_ERROR_MESSAGE.'14006',0),
14007 => array(DEFAULT_ERROR_MESSAGE.'14007',0),
15001 => array(DEFAULT_ERROR_MESSAGE.'15001',0),
15002 => array(DEFAULT_ERROR_MESSAGE.'15002',0),
15003 => array(DEFAULT_ERROR_MESSAGE.'15003',0),
15004 => array(DEFAULT_ERROR_MESSAGE.'15004',0),
15005 => array(DEFAULT_ERROR_MESSAGE.'15005',0),
15006 => array(DEFAULT_ERROR_MESSAGE.'15006',0),
15007 => array(DEFAULT_ERROR_MESSAGE.'15007',0),
15008 => array(DEFAULT_ERROR_MESSAGE.'15008',0),
15009 => array(DEFAULT_ERROR_MESSAGE.'15009',0),
15010 => array(DEFAULT_ERROR_MESSAGE.'15010',0),
15011 => array(DEFAULT_ERROR_MESSAGE.'15011',0),
16001 => array(DEFAULT_ERROR_MESSAGE.'16001',0),
16002 => array(DEFAULT_ERROR_MESSAGE.'16002',0),
16003 => array(DEFAULT_ERROR_MESSAGE.'16003',0),
16004 => array(DEFAULT_ERROR_MESSAGE.'16004',0),
17001 => array(DEFAULT_ERROR_MESSAGE.'17001',0),
17002 => array(DEFAULT_ERROR_MESSAGE.'17002',0),
17004 => array(DEFAULT_ERROR_MESSAGE.'17004',0),
18001 => array(DEFAULT_ERROR_MESSAGE.'18001',0),
18002 => array(DEFAULT_ERROR_MESSAGE.'18002',0),
18003 => array(DEFAULT_ERROR_MESSAGE.'18003',0),
18004 => array(DEFAULT_ERROR_MESSAGE.'18004',0),
18005 => array(DEFAULT_ERROR_MESSAGE.'18005',0),
18006 => array(DEFAULT_ERROR_MESSAGE.'18006',0),
18007 => array(DEFAULT_ERROR_MESSAGE.'18007',0),
18008 => array(DEFAULT_ERROR_MESSAGE.'18008',0),
19001 => array(DEFAULT_ERROR_MESSAGE.'19001',0),
19002 => array(DEFAULT_ERROR_MESSAGE.'19002',0),
19003 => array(DEFAULT_ERROR_MESSAGE.'19003',0),
20001 => array(DEFAULT_ERROR_MESSAGE.'20001',0),
20002 => array(DEFAULT_ERROR_MESSAGE.'20002',0),
20003 => array(DEFAULT_ERROR_MESSAGE.'20003',0),
21001 => array(DEFAULT_ERROR_MESSAGE.'21001',0),
23001 => array(DEFAULT_ERROR_MESSAGE.'23001',0),
23002 => array(DEFAULT_ERROR_MESSAGE.'23002',0),
23003 => array(DEFAULT_ERROR_MESSAGE.'23003',0),
24001 => array(DEFAULT_ERROR_MESSAGE.'24001',0),
24002 => array(DEFAULT_ERROR_MESSAGE.'24002',0),
24003 => array(DEFAULT_ERROR_MESSAGE.'24003',0),
25001 => array(DEFAULT_ERROR_MESSAGE.'25001',0),
25002 => array(DEFAULT_ERROR_MESSAGE.'25002',0),
25003 => array(DEFAULT_ERROR_MESSAGE.'25003',0),
25004 => array(DEFAULT_ERROR_MESSAGE.'25004',0),
25005 => array(DEFAULT_ERROR_MESSAGE.'25005',0),
25006 => array(DEFAULT_ERROR_MESSAGE.'25006',0),
25007 => array(DEFAULT_ERROR_MESSAGE.'25007',0),
25008 => array(DEFAULT_ERROR_MESSAGE.'25008',0),
25009 => array(DEFAULT_ERROR_MESSAGE.'25009',0),
25010 => array(DEFAULT_ERROR_MESSAGE.'25010',0),
25011 => array(DEFAULT_ERROR_MESSAGE.'25011',0),
25012 => array(DEFAULT_ERROR_MESSAGE.'25012',0),
25013 => array(DEFAULT_ERROR_MESSAGE.'25013',0),
25014 => array(DEFAULT_ERROR_MESSAGE.'25014',0),
25015 => array(DEFAULT_ERROR_MESSAGE.'25015',0),
25016 => array(DEFAULT_ERROR_MESSAGE.'25016',0),
25017 => array(DEFAULT_ERROR_MESSAGE.'25017',0),
25018 => array(DEFAULT_ERROR_MESSAGE.'25018',0),
25019 => array(DEFAULT_ERROR_MESSAGE.'25019',0),
25020 => array(DEFAULT_ERROR_MESSAGE.'25020',0),
25021 => array(DEFAULT_ERROR_MESSAGE.'25021',0),
25022 => array(DEFAULT_ERROR_MESSAGE.'25022',0),
25023 => array(DEFAULT_ERROR_MESSAGE.'25023',0),
25024 => array(DEFAULT_ERROR_MESSAGE.'25024',0),
25025 => array(DEFAULT_ERROR_MESSAGE.'25025',0),
25026 => array(DEFAULT_ERROR_MESSAGE.'25026',0),
25027 => array(DEFAULT_ERROR_MESSAGE.'25027',0),
25028 => array(DEFAULT_ERROR_MESSAGE.'25028',0),
25029 => array(DEFAULT_ERROR_MESSAGE.'25029',0),
25030 => array(DEFAULT_ERROR_MESSAGE.'25030',0),
25031 => array(DEFAULT_ERROR_MESSAGE.'25031',0),
25032 => array(DEFAULT_ERROR_MESSAGE.'25032',0),
25033 => array(DEFAULT_ERROR_MESSAGE.'25033',0),
25034 => array(DEFAULT_ERROR_MESSAGE.'25034',0),
25035 => array(DEFAULT_ERROR_MESSAGE.'25035',0),
25036 => array(DEFAULT_ERROR_MESSAGE.'25036',0),
25037 => array(DEFAULT_ERROR_MESSAGE.'25037',0),
25038 => array(DEFAULT_ERROR_MESSAGE.'25038',0),
25039 => array(DEFAULT_ERROR_MESSAGE.'25039',0),
25040 => array(DEFAULT_ERROR_MESSAGE.'25040',0),
25041 => array(DEFAULT_ERROR_MESSAGE.'25041',0),
25042 => array(DEFAULT_ERROR_MESSAGE.'25042',0),
25043 => array(DEFAULT_ERROR_MESSAGE.'25043',0),
25044 => array(DEFAULT_ERROR_MESSAGE.'25044',0),
25045 => array(DEFAULT_ERROR_MESSAGE.'25045',0),
25046 => array(DEFAULT_ERROR_MESSAGE.'25046',0),
25047 => array(DEFAULT_ERROR_MESSAGE.'25047',0),
25048 => array(DEFAULT_ERROR_MESSAGE.'25048',0),
25049 => array(DEFAULT_ERROR_MESSAGE.'25049',0),
25050 => array(DEFAULT_ERROR_MESSAGE.'25050',0),
25051 => array(DEFAULT_ERROR_MESSAGE.'25051',0),
25052 => array(DEFAULT_ERROR_MESSAGE.'25052',0),
25053 => array(DEFAULT_ERROR_MESSAGE.'25053',0),
25054 => array(DEFAULT_ERROR_MESSAGE.'25054',0),
25055 => array(DEFAULT_ERROR_MESSAGE.'25055',0),
25056 => array(DEFAULT_ERROR_MESSAGE.'25056',0),
25057 => array(DEFAULT_ERROR_MESSAGE.'25057',0),
25058 => array(DEFAULT_ERROR_MESSAGE.'25058',0),
25059 => array(DEFAULT_ERROR_MESSAGE.'25059',0),
25060 => array(DEFAULT_ERROR_MESSAGE.'25060',0),
25061 => array(DEFAULT_ERROR_MESSAGE.'25061',0),
25062 => array(DEFAULT_ERROR_MESSAGE.'25062',0),
25063 => array(DEFAULT_ERROR_MESSAGE.'25063',0),
25064 => array(DEFAULT_ERROR_MESSAGE.'25064',0),
25065 => array(DEFAULT_ERROR_MESSAGE.'25065',0),
25066 => array(DEFAULT_ERROR_MESSAGE.'25066',0),
25067 => array(DEFAULT_ERROR_MESSAGE.'25067',0),
25068 => array(DEFAULT_ERROR_MESSAGE.'25068',0),
25069 => array(DEFAULT_ERROR_MESSAGE.'25069',0),
25070 => array(DEFAULT_ERROR_MESSAGE.'25070',0),
25071 => array(DEFAULT_ERROR_MESSAGE.'25071',0),
25072 => array(DEFAULT_ERROR_MESSAGE.'25072',0),
25073 => array(DEFAULT_ERROR_MESSAGE.'25073',0),
25074 => array(DEFAULT_ERROR_MESSAGE.'25074',0),
25075 => array(DEFAULT_ERROR_MESSAGE.'25075',0),
25077 => array(DEFAULT_ERROR_MESSAGE.'25077',0),
25078 => array(DEFAULT_ERROR_MESSAGE.'25078',0),
25079 => array(DEFAULT_ERROR_MESSAGE.'25079',0),
25080 => array(DEFAULT_ERROR_MESSAGE.'25080',0),
25081 => array(DEFAULT_ERROR_MESSAGE.'25081',0),
25082 => array(DEFAULT_ERROR_MESSAGE.'25082',0),
25083 => array(DEFAULT_ERROR_MESSAGE.'25083',0),
25084 => array(DEFAULT_ERROR_MESSAGE.'25084',0),
25085 => array(DEFAULT_ERROR_MESSAGE.'25085',0),
25086 => array(DEFAULT_ERROR_MESSAGE.'25086',0),
25087 => array(DEFAULT_ERROR_MESSAGE.'25087',0),
25088 => array(DEFAULT_ERROR_MESSAGE.'25088',0),
25089 => array(DEFAULT_ERROR_MESSAGE.'25089',0),
25090 => array(DEFAULT_ERROR_MESSAGE.'25090',0),
25091 => array(DEFAULT_ERROR_MESSAGE.'25091',0),
25092 => array(DEFAULT_ERROR_MESSAGE.'25092',0),
25093 => array(DEFAULT_ERROR_MESSAGE.'25093',0),
25094 => array(DEFAULT_ERROR_MESSAGE.'25094',0),
25095 => array(DEFAULT_ERROR_MESSAGE.'25095',0),
25096 => array(DEFAULT_ERROR_MESSAGE.'25096',0),
25097 => array(DEFAULT_ERROR_MESSAGE.'25097',0),
25098 => array(DEFAULT_ERROR_MESSAGE.'25098',0),
25099 => array(DEFAULT_ERROR_MESSAGE.'25099',0),
25100 => array(DEFAULT_ERROR_MESSAGE.'25100',0),
25101 => array(DEFAULT_ERROR_MESSAGE.'25101',0),
25102 => array(DEFAULT_ERROR_MESSAGE.'25102',0),
25103 => array(DEFAULT_ERROR_MESSAGE.'25103',0),
25104 => array(DEFAULT_ERROR_MESSAGE.'25104',0),
25105 => array(DEFAULT_ERROR_MESSAGE.'25105',0),
25106 => array(DEFAULT_ERROR_MESSAGE.'25106',0),
25107 => array(DEFAULT_ERROR_MESSAGE.'25107',0),
25108 => array(DEFAULT_ERROR_MESSAGE.'25108',0),
25109 => array(DEFAULT_ERROR_MESSAGE.'25109',0),
25110 => array(DEFAULT_ERROR_MESSAGE.'25110',0),
25111 => array(DEFAULT_ERROR_MESSAGE.'25111',0),
25112 => array(DEFAULT_ERROR_MESSAGE.'25112',0),
25113 => array(DEFAULT_ERROR_MESSAGE.'25113',0),
25114 => array(DEFAULT_ERROR_MESSAGE.'25114',0),
25115 => array(DEFAULT_ERROR_MESSAGE.'25115',0),
25116 => array(DEFAULT_ERROR_MESSAGE.'25116',0),
25117 => array(DEFAULT_ERROR_MESSAGE.'25117',0),
25118 => array(DEFAULT_ERROR_MESSAGE.'25118',0),
25119 => array(DEFAULT_ERROR_MESSAGE.'25119',0),
25120 => array(DEFAULT_ERROR_MESSAGE.'25120',0),
25121 => array(DEFAULT_ERROR_MESSAGE.'25121',0),
25122 => array(DEFAULT_ERROR_MESSAGE.'25122',0),
25123 => array(DEFAULT_ERROR_MESSAGE.'25123',0),
25124 => array(DEFAULT_ERROR_MESSAGE.'25124',0),
25125 => array(DEFAULT_ERROR_MESSAGE.'25125',0),
25126 => array(DEFAULT_ERROR_MESSAGE.'25126',0),
25127 => array(DEFAULT_ERROR_MESSAGE.'25127',0),
25128 => array(DEFAULT_ERROR_MESSAGE.'25128',0),
25129 => array(DEFAULT_ERROR_MESSAGE.'25129',0),
24003 => array(DEFAULT_ERROR_MESSAGE.'24003',0),
24004 => array(DEFAULT_ERROR_MESSAGE.'24004',0),
24005 => array(DEFAULT_ERROR_MESSAGE.'24005',0),
24006 => array(DEFAULT_ERROR_MESSAGE.'24006',0),
24007 => array(DEFAULT_ERROR_MESSAGE.'24007',0),
24008 => array(DEFAULT_ERROR_MESSAGE.'24008',0),
24009 => array(DEFAULT_ERROR_MESSAGE.'24009',0),
24010 => array(DEFAULT_ERROR_MESSAGE.'24010',0),
24011 => array(DEFAULT_ERROR_MESSAGE.'24011',0),
24012 => array(DEFAULT_ERROR_MESSAGE.'24012',0),
24013 => array(DEFAULT_ERROR_MESSAGE.'24013',0),
24014 => array(DEFAULT_ERROR_MESSAGE.'24014',0),
24015 => array(DEFAULT_ERROR_MESSAGE.'24015',0),
22001 => array(DEFAULT_ERROR_MESSAGE.'22001',0),
22002 => array(DEFAULT_ERROR_MESSAGE.'22002',0),
22004 => array(DEFAULT_ERROR_MESSAGE.'22004',0),
22005 => array(DEFAULT_ERROR_MESSAGE.'22005',0),
22006 => array(DEFAULT_ERROR_MESSAGE.'22006',0),
22007 => array(DEFAULT_ERROR_MESSAGE.'22007',0),
22008 => array(DEFAULT_ERROR_MESSAGE.'22008',0),
22009 => array(DEFAULT_ERROR_MESSAGE.'22009',0),
22010 => array(DEFAULT_ERROR_MESSAGE.'22010',0),
22011 => array(DEFAULT_ERROR_MESSAGE.'22011',0),
22012 => array(DEFAULT_ERROR_MESSAGE.'22012',0),
22013 => array(DEFAULT_ERROR_MESSAGE.'22013',0),
22014 => array(DEFAULT_ERROR_MESSAGE.'22014',0),
22015 => array(DEFAULT_ERROR_MESSAGE.'22015',0),
22016 => array(DEFAULT_ERROR_MESSAGE.'22016',0),
22017 => array(DEFAULT_ERROR_MESSAGE.'22017',0),
22018 => array(DEFAULT_ERROR_MESSAGE.'22018',0),
22019 => array(DEFAULT_ERROR_MESSAGE.'22019',0),
22020 => array(DEFAULT_ERROR_MESSAGE.'22020',0),
13001 => array(DEFAULT_ERROR_MESSAGE.'13001',0),
13002 => array(DEFAULT_ERROR_MESSAGE.'13002',0),
1001 => array(DEFAULT_ERROR_MESSAGE.'1001',0),
1002 => array(DEFAULT_ERROR_MESSAGE.'1002',0),
1003 => array(DEFAULT_ERROR_MESSAGE.'1003',0),
1004 => array(DEFAULT_ERROR_MESSAGE.'1004',0),
1005 => array(DEFAULT_ERROR_MESSAGE.'1005',0),
1006 => array(DEFAULT_ERROR_MESSAGE.'1006',0),
1007 => array(DEFAULT_ERROR_MESSAGE.'1007',0),
1008 => array(DEFAULT_ERROR_MESSAGE.'1008',0),
1009 => array(DEFAULT_ERROR_MESSAGE.'1009',0),
1010 => array(DEFAULT_ERROR_MESSAGE.'1010',0),
1011 => array(DEFAULT_ERROR_MESSAGE.'1011',0),
26001 => array(DEFAULT_ERROR_MESSAGE.'26001',0),
26002 => array(DEFAULT_ERROR_MESSAGE.'26002',0),
26003 => array(DEFAULT_ERROR_MESSAGE.'26003',0),
26004 => array(DEFAULT_ERROR_MESSAGE.'26004',0),
26005 => array(DEFAULT_ERROR_MESSAGE.'26005',0),
26006 => array(DEFAULT_ERROR_MESSAGE.'26006',0),
26007 => array(DEFAULT_ERROR_MESSAGE.'26007',0),
26008 => array(DEFAULT_ERROR_MESSAGE.'26008',0),
26009 => array(DEFAULT_ERROR_MESSAGE.'26009',0),
26010 => array(DEFAULT_ERROR_MESSAGE.'26010',0),
26011 => array(DEFAULT_ERROR_MESSAGE.'26011',0),
26012 => array(DEFAULT_ERROR_MESSAGE.'26012',0),
26013 => array(DEFAULT_ERROR_MESSAGE.'26013',0),
26014 => array(DEFAULT_ERROR_MESSAGE.'26014',0),
26015 => array(DEFAULT_ERROR_MESSAGE.'26015',0),
26016 => array(DEFAULT_ERROR_MESSAGE.'26016',0),

27001 => array(DEFAULT_ERROR_MESSAGE.'27001',0),
27002 => array(DEFAULT_ERROR_MESSAGE.'27002',0),
27003 => array(DEFAULT_ERROR_MESSAGE.'27003',0),
27004 => array(DEFAULT_ERROR_MESSAGE.'27004',0),
27005 => array(DEFAULT_ERROR_MESSAGE.'27005',0),
27006 => array(DEFAULT_ERROR_MESSAGE.'27006',0),
27007 => array(DEFAULT_ERROR_MESSAGE.'27007',0),
27008 => array(DEFAULT_ERROR_MESSAGE.'27008',0),
27009 => array(DEFAULT_ERROR_MESSAGE.'27009',0),
27010 => array(DEFAULT_ERROR_MESSAGE.'27010',0),
27011 => array(DEFAULT_ERROR_MESSAGE.'27011',0),
27012 => array(DEFAULT_ERROR_MESSAGE.'27012',0),
27013 => array(DEFAULT_ERROR_MESSAGE.'27013',0),
27014 => array(DEFAULT_ERROR_MESSAGE.'27014',0),
27015 => array(DEFAULT_ERROR_MESSAGE.'27015',0),
);

?>
