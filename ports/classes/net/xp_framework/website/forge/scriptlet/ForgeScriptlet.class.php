<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'scriptlet.xml.workflow.AbstractXMLScriptlet',
    'xml.DomXSLProcessor'
  );

  /**
   * Website scriptlet for XP::Forge website
   *
   * @see      http://xp-forge.net/
   * @purpose  Scriptlet
   */
  class ForgeScriptlet extends AbstractXMLScriptlet {

    /**
     * Sets the responses XSL stylesheet
     *
     * @param   scriptlet.xml.XMLScriptletRequest request
     * @param   scriptlet.xml.XMLScriptletResponse response
     */
    protected function _setStylesheet($request, $response) {
      $response->setStylesheet(sprintf(
        '%s/%s.xsl',
        $request->getProduct(),
        $request->getStateName()
      ));
    }
  }
?>