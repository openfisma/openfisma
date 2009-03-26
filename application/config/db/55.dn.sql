--
-- Author:    Mark E Haase <mhaase@endeavorsystems.com>
-- Copyright: (c) 2008 Endeavor Systems, Inc.
-- License:   http://www.openfisma.org/mw/index.php?title=License
-- Version:   $Id$
--

update configurations set description = 'This is a United States Government Computer system. We encourage its use by authorized staff, auditors, and contractors. Activity on this system is subject to monitoring in the course of systems administration and to protect the system from unauthorized use. Users are further advised that they have no expectation of privacy while using this system or in any material on this system. Unauthorized use of this system is a violation of Federal Law and will be punished with fines or imprisonment (P.L. 99-474) Anyone using this system expressly consents to such monitoring and acknowledges that unauthorized use may be reported to the proper authorities.' where `key` like 'use_notification';

update configurations set description = 'SENSITIVE BUT UNCLASSIFIED INFORMATION PROPERTY OF THE UNITED STATES\r\nGOVERNMENT\r\n\r\nDISCLOSURE, COPYING, DISSEMINATION, OR DISTRIBUTION OF SENSITIVE BUT\r\nUNCLASSIFIED INFORMATION TO UNAUTHORIZED USERS IS PROHIBITED.\r\n\r\nPlease dispose of sensitive but unclassified information when no longer\r\nneeded.\r\n\r\nI. Usage Agreement\r\n\r\nThis is a Federal computer system and is the property of the United States\r\nGovernment. It is for authorized use only. Users (authorized or\r\nunauthorized) have no explicit or implicit expectation of privacy in\r\nanything viewed, created, downloaded, or stored on this system, including\r\ne-mail, Internet, and Intranet use. Any or all uses of this system\r\n(including all peripheral devices and output media) and all files on this\r\nsystem may be intercepted, monitored, read, captured, recorded, disclosed,\r\ncopied, audited, and/or inspected by authorized Agency personnel, the\r\nOffice of Inspector General (OIG),and/or other law enforcement personnel,\r\nas well as authorized officials of other agencies. Access or use of this\r\ncomputer by any person, whether authorized or unauthorized, constitutes\r\nconsent to such interception, monitoring, reading, capturing, recording,\r\ndisclosure, copying, auditing, and/or inspection at the discretion of\r\nauthorized Agency personnel, law enforcement personnel (including the\r\nOIG),and/or authorized officials other agencies. Unauthorized use of this\r\nsystem is prohibited and may constitute a violation of 18 U.S.C. 1030 or\r\nother Federal laws and regulations and may result in criminal, civil,\r\nand/or administrative action. By continuing to use this system, you\r\nindicate your awareness of, and consent to, these terms and conditions and\r\nacknowledge that there is no reasonable expectation of privacy in the\r\naccess or use of this computer system.' where `key` like 'behavior_rule';

update configurations set description = '* This is a U.S. Federal government computer system that is FOR OFFICIAL USE ONLY.\n* This system is subject to monitoring. No expectation of privacy is to be assumed.\n* Individuals found performing unauthorized activities are subject to disciplinary action including criminal prosecution.' where `key` like 'privacy_policy';