<?php
error_reporting(0);
ini_set('display_errors', 0);
// START OF SESSIONS
session_start();
//  ERROR REPORTING
// error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
//error_reporting(E_ALL & ~E_NOTICE);

$questions_seq = [
    'Test my business idea' => [
        'Value proposition',
        'functional capability',
        'Customer segments',
        'Proof of concept',
        'delivery and expertise',
        'market intelligence',
        'Revenue streams',
        'Key activities',
        'Key resources',
        'Cost structure'],
    'Get customers & revenue' => ['Customer relationships',
        'Channels',
        'e-commerce',
        'functional capability',
        'Customer segments',
        'Business and customers',
        'Marketing and sales',
        'Revenue streams'
    ],
    'Understand-Find my target market' => ['market intelligence',
        'delivery and expertise',
        'e-commerce',
        'Business and customers',
        'Ownership and mindset',
        'Marketing and sales',
        'Value proposition',
        'Key activities',
        'Customer segments'],
    'Get my business investor ready' => ['Value proposition'
        , 'Customer segments',
        'functional capability',
        'compliance and certification',
        'legal',
        'commercial contracts agreements',
        'Proof of concept',
        'Channels',
        'Revenue streams',
        'Cost structure',
        'Unique selling point',
        'Ownership and mindset',
        'Business and customers',
        'Growth strategy',
        'Financial management'],
    'Know if I can scale my business' => ['Current alternatives',
        'Channels',
        'Key partners',
        'Cost structure',
        'Customer relationships',
        'Business process management',
        'Marketing and sales',
        'Employee satisfaction',
        'Growth strategy',
        'delivery and expertise',
        'market intelligence',
        'Financial management'],
    'Improve my employee performance' => ['Business process management',
        'Ownership and mindset',
        'Employee satisfaction'],
    'Start a business' => ['Value proposition',
        'functional capability',
        'customer segments',
        'Proof of concept']
];

$recommendations_data = [
    'Business Process Management' => [
        'Process development',
        'Process auditing & Review',
        'Non-conformance & Corrective actions management',
        'Communication and tracking'
    ],
    'Marketing & Sales' => [
        'Social Media Marketing',
        'Monitoring and evaluation',
        'Sales planning',
        'Product/Service pricing',
        'Auditing and review',
        'Marketing Plan',
        'Marketing Strategy',
        'Sales funnel',
        'Customer acquisition plan.',
        'Sales personnel'
    ],
    'Talent Management' => [
        'Owner & Management commitment',
        'Founder skills & expertise',
        'Training & content development',
        'Organizational design and development',
        'Employee satisfaction',
        'Employee Skills & performance',
    ],
    'Strategic Planning' => [
        'Lean start-up strategy',
        'Business Plan',
        'Scale strategy',
        'Boot Strapping strategy',
        'Value Proposition canvas',
        'Elevator pitch',
        'CRM',
        'Revenue Models'
    ],
    'Product development' => [
        'SAAS',
        'Equipment & materials',
        'E-commerce',
    ],
    'Market Intelligence' => [
        'Market research',
        'Market segmentation',
        'Competitor Analysis',
        'Ideal customer profile',
        'Unique selling point',
        'Competitive advantage',
        'SAM SOM TAM',
        'Total Addressable Market',
        'Proof of concept'
    ],
    'Financial Management' => [
        'Budgeting and forecasting',
        'Reconciliations',
        'Cash flow management',
        'P&L statement + Balance sheet',
        'Pricing',
        'Costing'
    ],
    'Legal' => [
        'Company law',
        'Corporate law',
        'Labour law',
        'Finance law',
    ]
];

//  DATABASE INITIATION
require_once "includes/class_database.php";
include_once 'includes/class_user.php';
include_once 'includes/class_scores.php';

$db = new database;
$logged_user = new user;
$logged_user_id = $logged_user->get_logged_user_id();
$logged_user_type = $logged_user->get_logged_user_type();
$business_info = $logged_user->business_info($logged_user_id);
$user_info = $logged_user->user_info($logged_user_id);
// $followers = $logged_user->followers($logged_user_id);

include_once 'includes/class_assessments.php';
$assessment = new assessments;
// number of all questions
$num_all_questions = $assessment->num_all_questions();
// number of answered questions
$num_answered_questions = $assessment->num_answered_questions($logged_user_id);
// number of unanswered questions
$num_unanswered_questions = $assessment->num_unanswered($logged_user_id);

$scores = new scores;

//Check whether the session variables are present or not
if((!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) &&
(!isset($_SESSION['SESS_TYPE']) || (trim($_SESSION['SESS_TYPE']) == '')))
{
   header("location: access-denied.php");
   exit();
}

?>
