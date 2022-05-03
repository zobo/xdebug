--TEST--
DBGP: return value with 'step_out'
--SKIPIF--
<?php
require __DIR__ . '/../utils.inc';
check_reqs('dbgp');
?>
--FILE--
<?php
require 'dbgp/dbgpclient.php';
$filename = dirname(__FILE__) . '/dbgp-breakpoint-return-function-003.inc';

$commands = array(
	'feature_set -n breakpoint_details -v 1',
	'feature_set -n breakpoint_include_return_value -v 1',
	'step_into',
	'step_into',
	'step_out',
	'context_get',
	'context_get -d 1',
	'property_get -n $__RETURN_VALUE',
	'property_get -n $__RETURN_VALUE->x',
	'step_into',
	'step_into',
	'step_out',
	'context_get',
	'context_get -d 1',
	'property_get -n $__RETURN_VALUE',
	'property_get -n $__RETURN_VALUE->x',
	'detach',
);

dbgpRunFile( $filename, $commands );
?>
--EXPECT--
<?xml version="1.0" encoding="iso-8859-1"?>
<init xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" fileuri="file://dbgp-breakpoint-return-function-003.inc" language="PHP" xdebug:language_version="" protocol_version="1.0" appid=""><engine version=""><![CDATA[Xdebug]]></engine><author><![CDATA[Derick Rethans]]></author><url><![CDATA[https://xdebug.org]]></url><copyright><![CDATA[Copyright (c) 2002-2099 by Derick Rethans]]></copyright></init>

-> feature_set -i 1 -n breakpoint_details -v 1
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="feature_set" transaction_id="1" feature="breakpoint_details" success="1"></response>

-> feature_set -i 2 -n breakpoint_include_return_value -v 1
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="feature_set" transaction_id="2" feature="breakpoint_include_return_value" success="1"></response>

-> step_into -i 3
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_into" transaction_id="3" status="break" reason="ok"><xdebug:message filename="file://dbgp-breakpoint-return-function-003.inc" lineno="25"></xdebug:message></response>

-> step_into -i 4
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_into" transaction_id="4" status="break" reason="ok"><xdebug:message filename="file://dbgp-breakpoint-return-function-003.inc" lineno="22"></xdebug:message></response>

-> step_out -i 5
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_out" transaction_id="5" status="break" reason="ok"><xdebug:message filename="file://dbgp-breakpoint-return-function-003.inc" lineno="25"></xdebug:message><xdebug:return_value><property type="object" classname="Foo" children="1" numchildren="2" page="0" pagesize="32"><property name="x" facet="public" type="int"><![CDATA[42]]></property><property name="y" facet="public" type="float"><![CDATA[2.7]]></property></property></xdebug:return_value></response>

-> context_get -i 6
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="context_get" transaction_id="6" context="0"><property name="$__RETURN_VALUE" fullname="$__RETURN_VALUE" type="object" classname="Foo" children="1" numchildren="2" page="0" pagesize="32" facet="virtual return_value"><property name="x" fullname="$__RETURN_VALUE-&gt;x" facet="public" type="int"><![CDATA[42]]></property><property name="y" fullname="$__RETURN_VALUE-&gt;y" facet="public" type="float"><![CDATA[2.7]]></property></property></response>

-> context_get -i 7 -d 1
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="context_get" transaction_id="7" context="0"><property name="$foo" fullname="$foo" type="uninitialized"></property></response>

-> property_get -i 8 -n $__RETURN_VALUE
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="property_get" transaction_id="8"><property name="$__RETURN_VALUE" fullname="$__RETURN_VALUE" type="object" classname="Foo" children="1" numchildren="2" page="0" pagesize="32"><property name="x" fullname="$__RETURN_VALUE-&gt;x" facet="public" type="int"><![CDATA[42]]></property><property name="y" fullname="$__RETURN_VALUE-&gt;y" facet="public" type="float"><![CDATA[2.7]]></property></property></response>

-> property_get -i 9 -n $__RETURN_VALUE->x
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="property_get" transaction_id="9"><property name="$__RETURN_VALUE-&gt;x" fullname="$__RETURN_VALUE-&gt;x" type="int"><![CDATA[42]]></property></response>

-> step_into -i 10
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_into" transaction_id="10" status="break" reason="ok"><xdebug:message filename="file://dbgp-breakpoint-return-function-003.inc" lineno="27"></xdebug:message></response>

-> step_into -i 11
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_into" transaction_id="11" status="break" reason="ok"><xdebug:message filename="file://dbgp-breakpoint-return-function-003.inc" lineno="15"></xdebug:message></response>

-> step_out -i 12
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="step_out" transaction_id="12" status="break" reason="ok"><xdebug:message filename="file://dbgp-breakpoint-return-function-003.inc" lineno="27"></xdebug:message><xdebug:return_value><property type="float"><![CDATA[113.4]]></property></xdebug:return_value></response>

-> context_get -i 13
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="context_get" transaction_id="13" context="0"><property name="$__RETURN_VALUE" fullname="$__RETURN_VALUE" type="float" facet="virtual return_value"><![CDATA[113.4]]></property></response>

-> context_get -i 14 -d 1
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="context_get" transaction_id="14" context="0"><property name="$foo" fullname="$foo" type="object" classname="Foo" children="1" numchildren="2" page="0" pagesize="32"><property name="x" fullname="$foo-&gt;x" facet="public" type="int"><![CDATA[42]]></property><property name="y" fullname="$foo-&gt;y" facet="public" type="float"><![CDATA[2.7]]></property></property></response>

-> property_get -i 15 -n $__RETURN_VALUE
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="property_get" transaction_id="15"><property name="$__RETURN_VALUE" fullname="$__RETURN_VALUE" type="float"><![CDATA[113.4]]></property></response>

-> property_get -i 16 -n $__RETURN_VALUE->x
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="property_get" transaction_id="16" status="break" reason="ok"><error code="300"><message><![CDATA[can not get property]]></message></error></response>

-> detach -i 17
<?xml version="1.0" encoding="iso-8859-1"?>
<response xmlns="urn:debugger_protocol_v1" xmlns:xdebug="https://xdebug.org/dbgp/xdebug" command="detach" transaction_id="17" status="stopping" reason="ok"></response>
