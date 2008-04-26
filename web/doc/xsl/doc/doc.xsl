<?xml version="1.0" encoding="UTF-8"?>
<!--
 ! User documentation
 !
 ! $Id$
 !-->
<xsl:stylesheet
 version="1.0"
 xmlns:exsl="http://exslt.org/common"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:func="http://exslt.org/functions"
 xmlns:php="http://php.net/xsl"
 xmlns:xp="http://xp-framework.net/xsl"
 extension-element-prefixes="func"
 exclude-result-prefixes="func php exsl xsl xp"
>
  <xsl:include href="doc.inc.xsl"/>

  <xsl:template name="content">
    <table id="main" cellpadding="0" cellspacing="10">
      <tr>
        <td id="content">
          <div id="breadcrumb">
            <a href="{xp:link('home')}">Documentation</a> &#xbb;
            <a href="{xp:link(concat('doc?', $__query))}"><xsl:value-of select="/formresult/documentation/h1"/></a>
          </div>
          <xsl:apply-templates select="/formresult/documentation/*"/>
        </td>
        <td id="context">
          Table of contents
          <ul style="margin-left: 6px">
            <xsl:for-each select="/formresult/documentation/h2">
              <li><a href="#{string(.)}"><xsl:value-of select="."/></a></li>
            </xsl:for-each>
          </ul>
        </td>
      </tr>
    </table>
  </xsl:template>

  <xsl:template name="html-title">
    <xsl:value-of select="/formresult/documentation/h1"/> - 
    XP Framework Documentation
  </xsl:template>
</xsl:stylesheet>