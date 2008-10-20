<?php
    include ( 'pdf/class.ezpdf.php');
    require_once('local/rafutil.php');

    $headerOptions = array('showHeadings'=>0,
                           'width'=>500);
    $labelOptions = array('showHeadings'=>0,
                          'shaded'=>0,
                          'showLines'=>0,
                          'width'=>500);
    $tableOptions = array('showHeadings'=>0,
                          'shaded'=>0,
                          'showLines'=>2,
                          'width'=>500
                          );

    $cellidx_lookup['HIGH']['LOW']          = 0;
    $cellidx_lookup['HIGH']['MODERATE']     = 1;
    $cellidx_lookup['HIGH']['HIGH']         = 2;
    $cellidx_lookup['MODERATE']['LOW']      = 3;
    $cellidx_lookup['MODERATE']['MODERATE'] = 4;
    $cellidx_lookup['MODERATE']['HIGH']     = 5;
    $cellidx_lookup['LOW']['LOW']           = 6;
    $cellidx_lookup['LOW']['MODERATE']      = 7;
    $cellidx_lookup['LOW']['HIGH']          = 8;

    $p = &$this->poam ; //alias
    $sys = new System();
    $rows = $sys->find($p['system_id']);
    $act_owner = $rows->current()->toArray();

    $organization = new Organization();
    $ret = $organization->find($act_owner['organization_id']);
    $organization = $ret->current()->toArray();

    $sensitivity = calSensitivity(array($act_owner['confidentiality'],
                                        $act_owner['availability'],
                                        $act_owner['integrity']));

    $availability = &$act_owner['availability'];
    $impact = calcImpact($sensitivity, $availability);
    $threat_likelihood = calcThreat($this->poam['threat_level'], $this->poam['cmeasure_effectiveness']);

    $threat_index = $cellidx_lookup[$p['threat_level']][$p['cmeasure_effectiveness']];
    $risk_index = $cellidx_lookup[$threat_likelihood][$impact];

    define('FONTS', LIBS . '/pdf/fonts');

    $pdf = new Cezpdf();
    $pdf->selectFont(FONTS . "/Helvetica.afm");

    $pdf->ezSetMargins(50,110,50,50);

    $pdf->ezText('Risk Analysis Form (RAF)', 20, array('justification'=>'center'));
    $pdf->ezText('', 12, array('justification'=>'center')); //vertical blank
    $pdf->ezText('', 12, array('justification'=>'center'));

    $data = array(array('<b>Finding Information</b>'));
    $pdf->ezTable($data, null, null, $headerOptions);
    $pdf->ezText('', 12, array('justification'=>'center'));

    $data = array(array("<b>Finding Number:</b>", $p['id'],
                        "<b>Finding Source:</b>", strip_tags($p['source_name'])),
                  array("<b>Date Opened</b>", $p['create_ts'],
                        "<b>Date Discovered:</b>", $p['discover_ts']),
                  array("<b>Organization</b>", $organization['name'],
                        "<b>Infomation System:</b>", $this->system_list[$p['system_id']]),
                  array("<b>Asset(s) Affected:</b>", $p['asset_name'],"",""),
                  array("<b>Finding Description:</b>", strip_tags($p['finding_data']),"",""),
                  array("<b>Recommendation:</b>",  strip_tags($p['action_suggested']),"",""),
                  array("<b>Risk Level:</b>",  $p['threat_level'],"",""));
    $pdf->ezTable($data, null, null, $labelOptions);

    $pdf->ezText('', 12, array('justification'=>'center'));
    $data = array(array('<b>Mitigation Strategy</b>'));
    $pdf->ezTable($data, null, null, $headerOptions);
    $pdf->ezText('', 12, array('justification'=>'center'));
    $data = array(array("<b>Course of Action:</b>", strip_tags($p['action_planned']), "", ""),
                  array("<b>Course of Description:</b>", strip_tags($p['action_resources']), "", ""),
                  array("<b>Estimated Completion Date:</b>", $p['action_current_date'], "", "")); 
    $pdf->ezTable($data, null, null, $labelOptions);

    $pdf->ezText('', 12, array('justification'=>'center'));
    $data = array(array('<b>Risk Analysis</b>'));
    $pdf->ezTable($data, null, null, $headerOptions);
    $pdf->ezText('', 12, array('justification'=>'center'));
    $data = array(array("", "<b><i>Security Categorization</i></b>"),
                  array("<b>Security Categorization:</b>", $organization['security_categorization']),
                  array("<b>Security Categorization Description:</b>", "The loss of confidentiality, integrity, or availability could be expected to have a serious adverse effect on organizational operations, organizational assets, or individuals. This is the maximum level of risk exposure based on the Information System Security Categorization data."));
    $pdf->ezTable($data, null, null, $labelOptions);

    $data = array(array("", "<b><i>Overall likelihood Rating</i></b>"));
    $pdf->ezTable($data, null, null, $labelOptions);
    $data = array(array("To derive an overall likelihood rating that indicates the probability that a potential vulnerability may be exercised within the construct of the associated threat environment, the following governing factors must be considered: Threat-source motivation and capability, Nature of the vulnerability, and Existence and effectiveness of current controls."));
    $pdf->ezTable($data, null, null, $labelOptions);

    $data = array(array("<b>Threat:</b>", strip_tags($p['threat_source']), "", ""),
                  array("<b>Threat Level:</b>", $p['threat_level'], "", ""),
                  array("<b>Countermeasures:</b>", strip_tags($p['cmeasure']), "", ""),
                  array("<b>Countermeasures Effectiveness:</b>", strip_tags($p['cmeasure_effectiveness']), "", ""));
    $pdf->ezTable($data, null, null, $labelOptions);

    $data = array(array("<b>                                               Overall Threat Likelihood Table</b>"),
                  array("<b>                                                                       Countermeasure</b>")
);
    $pdf->ezTable($data, null, null, $tableOptions);
    $cell[0] = $threat_index == 0?'<b>high</b>':'high';
    $cell[1] = $threat_index == 1?'<b>moderate</b>':'moderate';
    $cell[2] = $threat_index == 2?'<b>low</b>':'low';
    $cell[3] = $threat_index == 3?'<b>moderate</b>':'moderate';
    $cell[4] = $threat_index == 4?'<b>moderate</b>':'moderate';
    $cell[5] = $threat_index == 5?'<b>low</b>':'low';
    $cell[6] = $threat_index == 6?'<b>low</b>':'low';
    $cell[7] = $threat_index == 7?'<b>low</b>':'low';
    $cell[8] = $threat_index == 8?'<b>low</b>':'low';
    $data = array(array("<b>THREAT SOURCE</b>","<b>LOW</b>","<b>MODERATE</b>","<b>HIGH</b>"),
                  array("<b>HIGH</b>", $cell[0], $cell[1], $cell[2]),
                  array("<b>MODERATE</b>", $cell[3], $cell[4], $cell[5]),
                  array("<b>LOW</b>", $cell[6], $cell[7], $cell[8]));    
    $pdf->ezTable($data, null, null, $tableOptions);
    $overall_impact = calcImpact($p['threat_level'], $p['cmeasure_effectiveness']);
    $data = array(array("Based on the threat likelihood and security categorization of the information system, the finding presents a <b>".$overall_impact."</b> level of risk to agency operations. "));
    $pdf->ezTable($data, null, null, $labelOptions);
    $pdf->ezText('', 12, array('justification'=>'center'));

    $data = array(array("", "<b><i>Overall Risk Level</i></b>"));
    $pdf->ezTable($data, null, null, $labelOptions);

    $data = array(array("<b>                                                Overall Risk Level Analysis</b>"),
                  array("<b>                                                            Security Categorization of Information System</b>")
);
    $pdf->ezTable($data, null, null, $tableOptions);
     
    $cell[0] = $risk_index == 0?'<b>low</b>':'low';
    $cell[1] = $risk_index == 1?'<b>moderate</b>':'moderate';
    $cell[2] = $risk_index == 2?'<b>high</b>':'high';
    $cell[3] = $risk_index == 3?'<b>low</b>':'low';
    $cell[4] = $risk_index == 4?'<b>moderate</b>':'moderate';
    $cell[5] = $risk_index == 5?'<b>moderate</b>':'moderate';
    $cell[6] = $risk_index == 6?'<b>low</b>':'low';
    $cell[7] = $risk_index == 7?'<b>low</b>':'low';
    $cell[8] = $risk_index == 8?'<b>low</b>':'low';
                                                
    $data = array(array("<b>Threat Likelihood</b>","<b>LOW</b>","<b>MODERATE</b>","<b>HIGH</b>"),
                  array("<b>HIGH</b>", $cell[0], $cell[1], $cell[2]),
                  array("<b>MODERATE</b>", $cell[3], $cell[4], $cell[5]),
                  array("<b>LOW</b>", $cell[6], $cell[7], $cell[8]));    
    $pdf->ezTable($data, null, null, $tableOptions);
    $overall_impact = calcImpact($threat_likelihood, $impact);
    $data = array(array("Based on the threat likelihood and security categorization of the information system, the finding presents a <b>".$overall_impact."</b> level of risk to agency operations. "));
    $pdf->ezTable($data, null, null, $labelOptions);
    $pdf->ezText('', 12, array('justification'=>'center'));

    $data = array(array('<b>Risk Level</b>', 'Risk Description and Necessary Actions'),
                  array('<b>High:</b>', 'If an observation or finding is evaluated as a high risk, there is a strong need for corrective measures. An existing system may continue to operate, but a corrective action plan must be put in place as soon as possible.'),
                  array('<b>Moderate:</b>', 'If an observation is rated as medium risk, corrective actions are needed and a plan must be developed to incorporate these actions within a reasonable period of time.'),
                  array('<b>Low:</b>', 'If an observation is described as low risk, the system’s AO must determine whether corrective actions are still required or decide to accept the risk.'));

    $pdf->ezTable($data, null, null, $tableOptions);
    $pdf->ezText('', 12, array('justification'=>'center'));

    $pdf->ezText('', 12, array('justification'=>'center'));
    $footer = 'WARNING: This report is for internal, official use only.  This report contains sensitive computer security related information. Public disclosure of this information would risk circumvention of the law. Recipients of this report must not, under any circumstances, show or release its contents for purposes other than official action. This report must be safeguarded to prevent improper disclosure. Staff reviewing this document must hold a minimum of Public Trust Level 5C clearance.';
    $pdf->ezText($footer, 9, array('justification'=>'left'));

// IE has a bug where it can't display certain mimetypes if a no-cache header is sent,
// so we need to switch the header right before we stream the PDF.
    header('Pragma: private');
    header('Cache-Control: private');
    echo $pdf->ezOutput();