<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Dirk Diebel <typo3@phpmedia.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'joliprint button' for the 'joliprint' extension.
 *
 * @author	Dirk Diebel <typo3@phpmedia.de>
 * @package	TYPO3
 * @subpackage	tx_joliprint
 */
class tx_joliprint_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_joliprint_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_joliprint_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'joliprint';	// The extension key.
	var $pi_checkCHash = true;
	var $flexConfig = array();
	var $joliPath = 'http://api.joliprint.com/res/joliprint/img/buttons/default/';
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexForm(); 
		
		$this->flexConfig = $this->getFlexData2Array($this->cObj->data['pi_flexform']);
		
		$buttonLabelLeft = 0;
		$buttonLabel = 'joliprint';
		$buttonType = ($this->flexConfig['button']!="")?$this->flexConfig['button']:$this->config['button.']['type'];
		
		switch($buttonType){
			
			case 1:
				$buttonUrl = $this->joliPath.'joliprint-button-big.png';
				break;
			case 2:
				$buttonUrl = $this->joliPath.'joliprint-button-both.png';
				break;
			case 3:
				$buttonUrl = $this->joliPath.'joliprint-icon-small.png';
				$buttonLabelLeft = 1;
				$buttonLabel = ($this->flexConfig['button_label']!="")?$this->flexConfig['button_label']:$this->conf['button.']['label'];
				break;
			case 4:
				$buttonUrl = $this->joliPath.'joliprint-icon.png';
				$buttonLabelLeft = 1;
				$buttonLabel = ($this->flexConfig['button_label']!="")?$this->flexConfig['button_label']:$this->conf['button.']['label'];
				break;
			case 5:
				$buttonUrl = $this->joliPath.'pdf-icone.gif';
				$buttonLabelLeft = 1;
				$buttonLabel = ($this->flexConfig['button_label']!="")?$this->flexConfig['button_label']:$this->conf['button.']['label'];
				break;
			case 6:
				$buttonUrl = ($this->flexConfig['button_icon']!="")?$this->flexConfig['button_icon']:$this->conf['button.']['icon'];
				$buttonLabelLeft = 1;
				$buttonLabel = ($this->flexConfig['button_label']!="")?$this->flexConfig['button_label']:$this->conf['button.']['label'];
				break;
			default:
				$buttonUrl = $this->joliPath.'joliprint-button.png';
				break;
		}
	
		$content='
		<script charset="ISO-8859-1" src="http://api.joliprint.com/joliprint/js/joliprint.js" type="text/javascript"></script>
		<script type="text/javascript">
		$joliprint()';
		if ($buttonLabelLeft==1) $content .= '.set("label","'.$buttonLabel.'").set("labelposition","after")';
		$content .='.set("buttonUrl", "'.$buttonUrl.'").set("service","typo3-plugin").write();</script>';
				
		return $this->pi_wrapInBaseClass($content);
	}

	function init(){

	}

	function getFlexData2Array($flexData){
		$lFlex = array();

		if(is_array($flexData['data'])) {
	 		foreach ( $flexData['data'] as $sheet => $data )
	 			foreach ( $data as $lang => $value )
	 				foreach ( $value as $key => $val )
	 					$lFlex[$key] = $this->pi_getFFvalue($flexData, $key, $sheet);
		}
		return $lFlex;
	}	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/joliprint/pi1/class.tx_joliprint_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/joliprint/pi1/class.tx_joliprint_pi1.php']);
}

?>