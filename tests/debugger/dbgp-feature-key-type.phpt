--TEST--
DBGP: key_type feature
--SKIPIF--
<?php
require __DIR__ . '/../utils.inc';
check_reqs('dbgp');
?>
--FILE--
<?php
require 'dbgp/dbgpclient.php';
$filename = dirname(__FILE__) . '/dbgp-feature-key-type.inc';

$commands = array(
	'step_into',
	'breakpoint_set -t line -n 3',
	'run',
	'feature_get -n key_type',
	'property_get -d 0 -c 0 -n $data',
	'feature_set -n key_type -v 1',
	'feature_get -n key_type',
	'property_get -d 0 -c 0 -n $data',
	'detach',
);

dbgpRunFile( $filename, $commands );
?>
--EXPECT--
<?xml version="1.0" encoding="iso-8859-1"?>
<init xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" fileuri="file://dbgp-feature-key-type.inc" language="PHP" xdebug:language_version="" protocol_version="1.0" appid=""><engine version=""><![CDATA[Xdebug]]></engine><author><![CDATA[Derick Rethans]]></author><url><![CDATA[https://xdebug.org]]></url><copyright><![CDATA[Copyright (c) 2002-2099 by Derick Rethans]]></copyright></init>

-> step_into -i 1
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_into" transaction_id="1" status="break" reason="ok"><xdebug:message filename="file://dbgp-feature-key-type.inc" lineno="2"></xdebug:message></response>

-> breakpoint_set -i 2 -t line -n 3
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="breakpoint_set" transaction_id="2" id="{{PID}}0001"></response>

-> run -i 3
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="run" transaction_id="3" status="break" reason="ok"><xdebug:message filename="file://dbgp-feature-key-type.inc" lineno="3"></xdebug:message></response>

-> feature_get -i 4 -n key_type
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="feature_get" transaction_id="4" feature_name="key_type" supported="1"><![CDATA[0]]></response>

-> property_get -i 5 -d 0 -c 0 -n $data
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="property_get" transaction_id="5"><property name="$data" fullname="$data" type="array" children="1" numchildren="2" page="0" pagesize="32"><property name="0" fullname="$data[0]" type="int"><![CDATA[42]]></property><property name="foo" fullname="$data[&quot;foo&quot;]" type="int"><![CDATA[84]]></property></property></response>

-> feature_set -i 6 -n key_type -v 1
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="feature_set" transaction_id="6" feature="key_type" success="1"></response>

-> feature_get -i 7 -n key_type
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="feature_get" transaction_id="7" feature_name="key_type" supported="1"><![CDATA[1]]></response>

-> property_get -i 8 -d 0 -c 0 -n $data
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="property_get" transaction_id="8"><property name="$data" fullname="$data" type="array" children="1" numchildren="2" page="0" pagesize="32"><property name="0" fullname="$data[0]" xdebug:key_type="int" type="int"><![CDATA[42]]></property><property name="foo" fullname="$data[&quot;foo&quot;]" xdebug:key_type="string" type="int"><![CDATA[84]]></property></property></response>

-> detach -i 9
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="detach" transaction_id="9" status="stopping" reason="ok"></response>
