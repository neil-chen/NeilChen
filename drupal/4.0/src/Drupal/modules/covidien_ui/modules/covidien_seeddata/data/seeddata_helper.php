<?php

/**
 * @file
 * The helper functions used in the sample & seed data processing.
 */
function role_section_access() {
  $section_access = array(
    'Devices Section' => array('No', 'Yes'),
    'Reports Section' => array('No', 'Yes'),
    'User management Tab' => array('No', 'View Only', 'View & Edit'),
    'Hardware catalog Tab' => array('No', 'View Only', 'View & Edit'),
    'Software catalog Tab' => array('No', 'View Only', 'View & Edit'),
    'Document Catalog Tab' => array('No', 'View Only', 'View & Edit'),
    'Configuration Management Tab' => array('No', 'View Only', 'View & Edit'),
    'Limited Release Software' => array('No', 'Yes'),
    'Trainer' => array('No', 'Yes'),
  );
  return $section_access;
}

/**
 * Helper function to build a roles and permission based on given chart
 */
function permissiondata($arg = 'install') {
  if ($arg == 'install') {
    $key = "Limited Release Software";
  } else {
    $key = "In Testing Software visible";
  }
  $web_permissionsdata = array(
    'Application Support' => array(
      'Devices Section' => 'No',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      $key => 'No',
    ),
    'Biomed' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      $key => 'No',
    ),
    'Field Service Technician' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      $key => 'No',
    ),
    'QA' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      $key => 'Yes',
    ),
    'R&D' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View & Edit',
      'Software catalog Tab' => 'View & Edit',
      'Document Catalog Tab' => 'View & Edit',
      'Configuration Management Tab' => 'View & Edit',
      $key => 'Yes',
    ),
    'Sales Rep' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      $key => 'No',
    ),
    'Service Manager' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      $key => 'No',
    ),
    'User Admin' => array(
      'Devices Section' => 'No',
      'Reports Section' => 'No',
      'User management Tab' => 'View & Edit',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      $key => 'No',
    ),
    'CoT Admin' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View & Edit',
      'Software catalog Tab' => 'View & Edit',
      'Document Catalog Tab' => 'View & Edit',
      'Configuration Management Tab' => 'View & Edit',
      $key => 'No',
    ),
    'Service Center Technician' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      $key => 'No',
    ),
    'Marketing' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View & Edit',
      'Configuration Management Tab' => 'View Only',
      $key => 'No',
    ),
  );

  return $web_permissionsdata;
}

function vlex_permissiondata() {
  $vlex_permissionsdata = array(
    'CoT Admin' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View & Edit',
      'Software catalog Tab' => 'View & Edit',
      'Document Catalog Tab' => 'View & Edit',
      'Configuration Management Tab' => 'View & Edit',
      'Limited Release Software' => 'Yes',
      'Trainer' => 'Yes',
    ),
    'Biomed' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      'Limited Release Software' => 'No',
      'Trainer' => 'Yes',
    ),
    'Distributor' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'No',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      'Limited Release Software' => 'No',
      'Trainer' => 'Yes',
    ),
    'Field Service' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      'Limited Release Software' => 'No',
      'Trainer' => 'Yes',
    ),
    'Manufacturing' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'No',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'No',
      'Software catalog Tab' => 'No',
      'Document Catalog Tab' => 'No',
      'Configuration Management Tab' => 'No',
      'Limited Release Software' => 'Yes',
      'Trainer' => 'Yes',
    ),
    'Marketing' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      'Limited Release Software' => 'No',
      'Trainer' => 'Yes',
    ),
    'Quality & Reliability' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'No',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      'Limited Release Software' => 'Yes',
      'Trainer' => 'Yes',
    ),
    'Development Mgr/Eng' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      'Limited Release Software' => 'Yes',
      'Trainer' => 'Yes',
    ),
    'Sales Rep' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View Only',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      'Limited Release Software' => 'No',
      'Trainer' => 'Yes',
    ),
    'Technical Support' => array(
      'Devices Section' => 'Yes',
      'Reports Section' => 'Yes',
      'User management Tab' => 'View & Edit',
      'Hardware catalog Tab' => 'View Only',
      'Software catalog Tab' => 'View Only',
      'Document Catalog Tab' => 'View Only',
      'Configuration Management Tab' => 'View Only',
      'Limited Release Software' => 'Yes',
      'Trainer' => 'Yes',
    ),
  );
  return $vlex_permissionsdata;
}

/**
 * config product line roles is permissiondata() or vlex_permissiondata()
 * @return array
 */
function product_line_roles_fun() {
  return array(
    'Ventilation' => 'permissiondata',
    'Compression' => 'permissiondata',
    'Infrastructure' => 'permissiondata',
    'Stapling' => 'vlex_permissiondata',
    'Patient Monitoring' => 'vlex_permissiondata',
    'Ablation' => 'vlex_permissiondata',
    'Vessel Sealing' => 'vlex_permissiondata',
  );
}
