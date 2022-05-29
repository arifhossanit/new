<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------|
|	$route['default_controller'] = 'welcome';|
|	$route['404_override'] = 'errors/page_missing';
|	my-controller/my-method	-> my_controller/my_method
*/

$route['temp'] = 'Dashboard/temp';
$route['default_controller'] = 'Home';

$route['admin']                                                     = 'Dashboard';
$route['admin/dashboard']                                             = 'Dashboard/dashboard';
$route['admin/app_update']                                             = 'Dashboard/app_update';


//login section
$route['admin/login']                                                 = 'Dashboard/login';
$route['admin/app-login']                                             = 'Dashboard/app_login';

$route['admin/lock']                                                 = 'Dashboard/lockscreen';
$route['admin/logout']                                                 = 'Dashboard/logout';
$route['admin/forgot-password']                                     = 'Dashboard/forgot_password';
$route['generated_forgot_password_link/(:any)']                     = 'Dashboard/generated_forgot_password_link/$1';
$route['admin/nav-permission-test']                                 = 'Dashboard/permission_test';

//Create section
$route['admin/add-branch']                                             = 'Create/add_branch';
$route['admin/add-floor']                                             = 'Create/add_floor';
$route['admin/manage-units']                                         = 'Create/manage_units';
$route['admin/manage-rooms']                                         = 'Create/manage_rooms';
$route['admin/manage-column']                                         = 'Create/manage_column';
$route['admin/manage-beds']                                         = 'Create/manage_beds';
$route['admin/manage-room-types']                                     = 'Create/manage_room_types';
$route['admin/manage-locker-types']                                 = 'Create/manage_locker_types';
$route['admin/manage-locker']                                         = 'Create/manage_locker';
$route['admin/manage-package']                                         = 'Create/manage_package';

$route['admin/manage-package-category']                             = 'Create/manage_package_category';
$route['admin/manage-ipo-category']                                 = 'Create/manage_ipo_category';
$route['admin/manage-agreement-type']                                 = 'Create/manage_agreement_type';

$route['admin/manage-sub-category']                                 = 'Create/manage_sub_category';
$route['admin/manage-services']                                     = 'Create/manage_services';
$route['admin/manage-document-type']                                 = 'Create/document_type';
$route['admin/manage-Payment-method']                                 = 'Create/Payment_method';
$route['admin/card-change-payment']                                 = 'Create/card_change_amount';
$route['admin/check-out-iteams']                                     = 'Create/check_out_iteams';
$route['admin/api/json-api']                                         = 'Create/api_json_api';
$route['admin/manage-payment-type']                                 = 'Create/manage_payment_type';
$route['admin/create/software-learning/add-tutorials']                 = 'Create/software_learning_add_tutorials';

$route['admin/create/award/sales-award']                             = 'Create/award_sales_award';
$route['admin/create/award/employee-ipo-commission-setup']             = 'Create/employee_ipo_commission_setup';
$route['admin/create/award/badge']                                      = 'Create/badge_award';
$route['admin/create/award/member-referal-award']                     = 'Create/member_referal_award';
$route['admin/create/award/investor_facilities_setup']                 = 'Create/investor_facilities_setup';

$route['admin/create/network/router-configuration']                 = 'Create/network_router_configuration';
$route['admin/create/network/network-graph-configuration']             = 'Create/network_graph_configuration';
$route['admin/create/tea-coffee/add-refreshment-item']                 = 'Create/add_refreshment_item';
$route['admin/create/music-player/add-audio-file']                     = 'Create/music_player_add_audio';
$route['admin/create/music-player/add-video-link']                     = 'Create/music_player_add_video';
$route['admin/create/music-player/add-door-ips']                    = 'Create/front_door_add_door_ips';
$route['admin/create/front-office/add-electrict-bill']                = 'Create/add_electrict_bill';
$route['admin/create/front-office/add-house-rent']                    = 'Create/add_house_rent';
$route['admin/create/front-office/add-internet-bill']                = 'Create/add_internet_bill';
$route['admin/create/front-office/add-water-bill']                    = 'Create/add_water_bill';
$route['admin/create/front-office/add-food-cost']                    = 'Create/add_food_cost';


//ipo Sestion
$route['admin/ipo']                                                 = 'Ipo/ipo';
$route['admin/ipo/ipo-member-directory']                             = 'Ipo/ipo_member_directory';
$route['admin/ipo/demo-ipo-member-directory']                         = 'Ipo/demo_ipo_member_directory';
$route['admin/ipo/investment_inquery']                         = 'Ipo/investment_inquery';
$route['admin/ipo/investment_inquery_note']                         = 'Ipo/investment_inquery_note';
$route['admin/ipo/ipo-member-directory-pre']                        = 'Ipo/ipo_member_directory_pre';
$route['ipo-member']                                                = 'Ipo';
$route['ipo-member/login']                                          = 'Ipo/login';
$route['ipo-member/logout']                                         = 'Ipo/logout';
$route['ipo-member/view-profile']                                   = 'Ipo/view_profile';
$route['ipo-member/change-password']                                = 'Ipo/change_password';
$route['ipo-member/exchange-ipo']                                   = 'Ipo/exchange_ipo';
$route['ipo-member/cancel-ipo']                                     = 'Ipo/cancel_ipo';
$route['ipo-member/authorize-pre-ipo-member']                       = 'Ipo/authorize_pre_ipo_member';
$route['ipo-pre-registration']                                      = 'Ipo/pre_member_form';

$route['ipo-member/ipo-referal-aproval']                            = 'Ipo/ipo_referal_aproval';
$route['ipo-member/ipo-referal-member']                             = 'Ipo/ipo_referal_member';
$route['ipo-member/ipo-member-balance-widthdraw']                   = 'Ipo/ipo_member_balance_widthdraw';

$route['admin/ipo/ipo-member-certificate/(:any)']                    = 'Ipo/ipo_member_certificate/$1';

//booking section
$route['admin/booking']                                             = 'Booking/booking';
$route['admin/booking/booking-target-setup']                         = 'Booking/booking_target_setup';
$route['admin/booking/update-booking-target']                         = 'Booking/update_booking_target';

$route['admin/group-booking']                                         = 'Booking/group_booking';
$route['admin/rental-information']                                     = 'Booking/rental_information';
$route['admin/building-overview']                                     = 'Booking/building_overview';
$route['admin/view_building/(:any)']                    = 'building_controller/view_building/$1';
$route['admin/recharge_balance/(:any)'] = 'Booking/recharge_balance/$1'; 
$route['admin/add_balance'] = 'Booking/add_balance';

//CRM section
$route['admin/member-directory']                                     = 'Booking/member_directory';
$route['admin/group-directory']                                     = 'Booking/member_group_directory';
$route['admin/member-directory/edit-delete-member']                 = 'Booking/edit_delete_member';
$route['admin/checkout-booking-directory']                             = 'Booking/checkout_booking_directory';
$route['admin/checkout-members-directory']                             = 'Booking/checkout_members_directory';
$route['admin/pre-book-member-directory']                             = 'Booking/pre_book_member_directory';
$route['admin/pre-book/member-image-reupload']                        = 'Booking/pre_book_member_image_reupload';

//HRM section
$route['admin/hrm/employee-visiting-card']                             = 'Hrm/employee_visiting_card';
$route['admin/hrm/employee-qr-code']                                 = 'Hrm/employee_qr_code';
$route['admin/hrm/employee-id-card']                                 = 'Hrm/employee_id_card';
$route['admin/hrm/ovserbation-id-card']                                 = 'Hrm/ovserbation_id_card';

$route['admin/edit-employee']                                         = 'Hrm/edit_employee';
$route['admin/employ-directory']                                     = 'Hrm/add_employ';
$route['admin/exit-employee-directory']                             = 'Hrm/exit_employee';

$route['admin/hrm/attendance/attencance-form']                         = 'Hrm/attendance_form';
$route['admin/hrm/attendance/missing-attencance-form']                 = 'Hrm/missing_attencance_form';
$route['admin/hrm/attendance/yearly-attendance']                     = 'Hrm/yearly_attendance';
$route['admin/hrm/attendance/attencance-overview']                     = 'Hrm/attendance_overview';
$route['admin/hrm/attendance/attencance-log']                         = 'Hrm/attendance_log';


$route['admin/hrm/payroll/add-increament']                             = 'Hrm/payroll_add_increament';
$route['admin/hrm/payroll/add-decreament']                             = 'Hrm/payroll_add_decreament';
$route['admin/hrm/payroll/set-attendance-bonus']                     = 'Hrm/payroll_set_attendance_bonus';
$route['admin/hrm/payroll/set-department-head']                     = 'Hrm/payroll_set_department_head';
$route['admin/hrm/payroll/increament-approval']                     = 'Hrm/payroll_increament_approval';
$route['admin/hrm/payroll/employee-salary-deduction']                 = 'Hrm/payroll_employee_salary_deduction';
$route['admin/hrm/payroll/employee-extra-salary']                     = 'Hrm/payroll_employee_extra_salary';

$route['admin/hrm/payroll/employee-salary-generate']                 = 'Hrm/payroll_employee_salary_generate';
$route['admin/accounting/expence/employee_salary']                     = 'Hrm/payroll_accounts_employee_salary_generate';

$route['admin/accounts/generate_rank']                                 = 'Reports/generate_rank';

$route['admin/profile/ta_da_request']                                 = 'Hrm/payroll_ta_da_request';

$route['admin/hrm/leave/employee-leave-request']                     = 'Hrm/payroll_employee_leave_request';
$route['admin/hrm/leave/lock-list']                                 = 'Hrm/payroll_employee_locked_leave';
$route['admin/scm/manage-service-product']                          = 'Scm/manage_assigned_service_product';

$route['admin/profile/employee-subordinate-leave-request']             = 'Hrm/employee_subordinate_leave_request';


$route['admin/hrm/leave/leave-application-logs']                     = 'Hrm/leave_application_logs';
$route['admin/hrm/leave/hold-employee-logs']                         = 'Hrm/hold_employee_logs';

$route['admin/profile/employee-own-leave-request']                     = 'Hrm/payroll_employee_own_leave_request';
$route['admin/profile/employee-own-leave-withdraw-request']         = 'Hrm/payroll_employee_own_withdraw_leave_request';

$route['admin/hrm/payroll/fire-eligibility']                             = 'Hrm/fire_eligibility';

$route['admin/hrm/payroll/leave-approval']                             = 'Hrm/payroll_leave_approval';
$route['admin/hrm/payroll/leave-approval-department-head']             = 'Hrm/payroll_leave_approval_department_head';

$route['admin/profile/increase-mobile-allowence']                     = 'Hrm/increase_mobile_allowence';
$route['admin/profile/increase-mobile-allowence-approval']             = 'Hrm/increase_mobile_allowence_approval';
$route['admin/profile/increase-mobile-allowence-approval-submit']   = 'Hrm/increase_mobile_allowence_submit';

$route['admin/hrm/award/employee-performance']                         = 'Hrm/award_employee_performance';
$route['admin/hrm/award/employee-festival-award']                     = 'Hrm/employee_festival_award';
$route['admin/profile/employee-performance-request']                 = 'Hrm/award_employee_performance_from_head';
$route['admin/profile/request-fired-an-employee']                     = 'Hrm/employee_fired_from_head';
$route['admin/hrm/award/performance-approval']                 = 'Hrm/award_performance_approval';
$route['admin/hrm/award/performance-approval/(:any)']                 = 'Hrm/award_performance_approval/$1';
$route['admin/view_candidate_images/(:any)'] = 'Hrm/candidate_images/$1'; 
$route['admin/source_video/(:any)'] = 'Hrm/source_video/$1';
$route['admin/hrm/award/performance-approval-hr']                     = 'Hrm/award_performance_approval_hr';
$route['admin/view_video_display/(:any)'] = 'Hrm/view_video_display/$1'; 

$route['admin/notification/payroll/exit-employee-approval']         = 'Hrm/exit_employee_approval';
$route['admin/notification/payroll/exit-employee-approval-admin']     = 'Hrm/exit_employee_approval';
$route['admin/notification/payroll/fired-employee-chain-approval-hr']     = 'Hrm/fired_employee_chain_approval_hr';




$route['admin/profile/employee-own-resign-request']                 = 'Hrm/employee_own_resign_request';
$route['admin/notification/payroll/employee-recruitment-approval']     = 'Hrm/employee_recruitment_approval';
$route['admin/profile/employee-recruitment-request']                 = 'Hrm/employee_recruitment_request';
$route['admin/notification/payroll/resign-employee-approval']         = 'Hrm/payroll_resign_employee_approval';
$route['admin/notification/payroll/resign-employee-approval-hr']     = 'Hrm/payroll_resign_employee_approval_hr';



$route['admin/hrm/loan/grant-loan']                                 = 'Hrm/loan_grant_loan';
$route['admin/hrm/loan/loan-approval']                                 = 'Hrm/loan_loan_approval';
$route['admin/notification/payroll/employee-ta-da-approval/(:any)'] = 'Hrm/employee_ta_da_aproval/$1';
$route['employee_ta_da_received/(:any)']                             = 'Hrm/employee_self_ta_da_aproval/$1';
$route['admin/profile/employee-fired-request-aproval']                 = 'Hrm/employee_fired_request_aproval';
$route['admin/notification/payroll/accounts-loan-approval']         = 'Hrm/loan_loan_approval_accounts';
$route['admin/notification/payroll/employee-deduction-approval']     = 'Hrm/employee_deduction_approval';

$route['admin/hrm/loan/loan-report']                                 = 'Hrm/loan_loan_report';


$route['admin/hrm/recruitment/today-candidate-attendance']             = 'Hrm/today_candidate_attendance';
$route['admin/hrm/recruitment/recruitment_approved_logs']             = 'Hrm/recruitment_approved_logs';
$route['admin/hrm/profile/employee-leave-witdraw-request']             = 'Hrm/employee_leave_widthdraw_request';
$route['admin/hrm/recruitment/candidate-shortlist']                 = 'Hrm/candidate_shortlist';
$route['admin/hrm/employee-prebook-request']                         = 'Hrm/employee_prebook_request';

$route['admin/manage-roles']                                         = 'Hrm/manage_roles';
$route['admin/manage-department']                                     = 'Hrm/manage_department';
$route['admin/manage-designation']                                     = 'Hrm/manage_designation';
$route['admin/manage-grade']                                         = 'Hrm/manage_grade_intro';
$route['admin/fingure-missing-reason']                                 = 'Hrm/fingure_missing_reason';

// HRM - Profile
$route['admin/profile/award-money-widthdraw']                                         = 'Hrm/award_money_widthdraw';
$route['admin/profile/employee-award-money-transfer']                                 = 'Hrm/employee_award_money_transfer';

$route['admin/profile/change-password']                                             = 'Hrm/change_password';
$route['admin/profile/my-attendents']                                                 = 'Hrm/my_attendents';
$route['admin/profile/subordinate-attendents']                                         = 'Hrm/subordinate_attendents';
$route['admin/profile/visiting-card']                                                 = 'Hrm/visiting_card';
$route['admin/profile/id-card']                                                     = 'Hrm/id_card';
$route['admin/profile/change-profile-picture']                                         = 'Hrm/change_profile_picture';
$route['admin/profile/my-profile']                                                     = 'Hrm/profile_my_profile';
$route['emp_info_from_card/(:any)']                                                 = 'Hrm/emp_info_from_card/$1';

//Accounting
$route['admin/accounting/transaction/checkout-member-list']                         = 'Accounting/checkout_member_list';
$route['admin/accounting/transaction/refunded-member-list']                         = 'Accounting/refunded_member_list';
$route['admin/accounting/expence/ta_da_bill']                                         = 'Accounting/expence_ta_da_bill';

$route['admin/accounting/transaction/ipo-member-widdraw-list']                         = 'Accounting/ipo_member_widdraw_list';


$route['admin/accounting/transaction/ipo-member-list']                                 = 'Accounting/ipo_member_list';
$route['admin/accounting/transaction/employee-widthdraw-list']                         = 'Accounting/employee_widthdraw_list';
$route['admin/accounting/transaction/employee-approved-widdraw-list']                 = 'Accounting/employee_approved_widthdraw_list';
$route['admin/accounting/transaction/check-print']                                     = 'Accounting/check_print';
$route['admin/accounting/transaction/envelope-print']                                 = 'Accounting/envelope_print';
$route['admin/accounting/transaction/employee-salary']                                 = 'Accounting/employee_salary_list';
$route['admin/accounting/transaction/petty-cash']                                     = 'Accounting/petty_cash';
$route['admin/accounting/transaction/advance-petty-cash']                             = 'Accounting/advance_petty_cash';
$route['admin/accounting/transaction/advance-petty-cash-approval']                    = 'Accounting/advance_petty_cash_approval';
$route['admin/accounting/transaction/advance-petty-cash-return-approval']            = 'Accounting/advance_petty_cash_return_approval';
$route['admin/profile/urgent-expense-list']                                            = 'Accounting/urgent_advance_petty_cash_employee_logs';
$route['admin/profile/urgent-expense-return-list']                                    = 'Accounting/urgent_advance_petty_cash_return_employee_logs';
$route['admin/accounting/transaction/view-instant-transaction-buy-something']         = 'Accounting/view_instant_transaction_buy_something';
$route['admin/accounting/transaction/view-instant-transaction-buy-something-slip']   = 'Accounting/instant_transaction_slip';
$route['sms.employee.accept.money/(:any)/(:any)']                                     = 'Accounting/sms_employee_accept_money/$1/$2';
$route['admin/accounting/aproval/loan-aproval']                                     = 'Accounting/accounts_loan_aproval';
$route['admin/accounting/transaction/advance-money-overview-log']                   = 'Accounting/advance_money_overview_log';
$route['admin/accounting/expense/expense-category']                                 = 'Accounting/expense_category';

$route['admin/accounting/accounts/manage-accounts']                                 = 'Accounting/accounts_manage_accounts';
$route['admin/accounting/accounts/chart-of-accounts']                                 = 'Accounting/accounts_chart_of_accounts';
$route['admin/confirm_salary']                                  = 'Accounting/confirm_salary';
$route['admin/send_noty_emp']     = 'Accounting/send_noty_emp';
//Application section
$route['admin/file-manager']                                                         = 'FileManager';
$route['admin/photo-shop']                                                             = 'FileManager/photo_shop';
$route['admin/bkash-link-open']                                                     = 'FileManager/bkash_link_open';
$route['admin/mobile-recharge/grmeenphone']                                         = 'FileManager/mobilerecharge_grmeenphone';
$route['admin/application/document-verification/birth-certificate']                 = 'FileManager/birth_certificate';
$route['admin/application/document-verification/nid-card']                             = 'FileManager/nid_card';

//Settings Sesction
$route['admin/accounting/transaction/check-print'] = 'Accounting/check_print';


//AJAX section
$route['admin/settings/sms/configure-sms'] = 'Settings/configure_sms';
$route['admin/settings/sms/sms-purpase'] = 'Settings/sms_purpase';
$route['admin/settings/sms/sms-template'] = 'Settings/sms_template';

//JSON section
$route['json/data-information/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'Json/data_info/$1/$2/$3/$4/$5/$6/$7/$8';

/**
 * For Raspberry-Pi
 */
$route['json/data-information-pi/(:any)'] = 'Json/data_info_pi/$1';
$route['json/device-information'] = 'Json/get_device_information';
$route['json/per-branch'] = 'Json/card_number_per_branch';
$route['api/employee_coffee_machine'] = 'Json/employee_coffee_machine';

/**
 * For Website
 */
$route['json/pre-book'] = 'Json/pre_book';
$route['json/branches'] = 'Json/branches';
$route['json/branches/(:any)'] = 'Json/branches_where/$1';
$route['json/packages'] = 'Json/packages';
$route['json/packages/(:any)'] = 'Json/packages_where/$1';
$route['json/sms-log'] = 'Json/sms_log';
$route['json/get-otp/(:any)'] = 'Json/get_otp/$1';
$route['json/pre-book-validate'] = 'Json/pre_book_validation';
$route['json/branch-images/(:any)'] = 'Json/branch_images/$1';
$route['json/facilities-icon'] = 'Json/facilities_icons';
$route['json/server-status'] = 'Json/server_status';
$route['json/otp-device'] = 'Json/device_id';
$route['api/accept_salary'] = 'Json/accept_salary';
$route['api/get_salary_data'] = 'Json/get_salary_data';
$route['sms-test'] = 'Json/sms';
$route['api/salary_confirm_emp'] = 'Json/salary_confirm_emp';
$route['api/salary_confirm_emp_view'] = 'Json/salary_confirm_emp_view';
$route['api/get_emp_image'] = 'Json/get_emp_image';
$route['api/resend_otp_salary'] = 'Json/resend_otp_salary';
$route['api/resend_otp_again'] = 'Json/resend_otp_again';
$route['api/change_lobby'] = 'Json/change_lobby';


/**
 * 
 * For Mobile apps
 * 
 */
$route['json/c-information'] = 'Json/contact_information';
$route['json/file'] = 'Json/file_upload';
$route['json/petty-cash'] = 'Json/petty_cash';
$route['json/login'] = 'Json/login';
$route['json/transaction'] = 'Json/transaction';
$route['json/advance-salary'] = 'Json/advance_salary';
$route['json/app-login'] = 'Json/app_login';

$route['json/sse-test'] = 'Welcome/sse_test';
$route['json/notification'] = 'Json/notification_stream';
$route['json/notification/create'] = 'Json/notification_create';
$route['json/notification/show'] = 'Json/notification_show';
$route['json/notification/read'] = 'Json/notification_read';
$route['json/notification/pushed'] = 'Json/notification_push';
$route['json/notification/set'] = 'Json/set_user';

$route['json/version'] = 'Json/version';
$route['json/missing-attendance'] = 'Json/missing_attendance';
$route['json/location-show'] = 'Json/location_stream';

$route['json/service-requisition/insert'] = 'Json/service_request';
$route['json/service-requisition/show'] = 'Json/service_requests_show';
$route['json/service-requisition/approvals'] = 'Json/requisition_approval';
$route['json/service-requisition/update/(:any)'] = 'Json/service_requisition_update/$1';
$route['json/service-requisition'] = 'Json/services_show';
$route['json/car-availability'] = 'Json/check_availability';
$route['json/scheduled-rides'] = 'Json/scheduled_rides';
$route['json/upcoming-ride'] = 'Json/upcoming_ride';
$route['json/upcoming-ride/start/(:any)'] = 'Json/start_ride/$1';
$route['json/upcoming-ride/end/(:any)'] = 'Json/end_ride/$1';

$route['json/employee_ta_da_received/(:any)'] = 'Json/employee_self_ta_da_aproval/$1';
$route['json/ta-da'] = 'Json/ta_da';
$route['json/test'] = 'Json/test';

$route['json/resign-request'] = 'Json/employee_own_resign_request';
$route['json/resign-request/show'] = 'Json/resign_show';
$route['json/resign-request/accept/(:any)'] = 'Json/resign_accept/$1';
$route['json/resign-request/reject/(:any)'] = 'Json/resign_reject/$1';

$route['json/advance-money-request/show'] = 'Json/meney_request_self_pending';
$route['json/advance-money-request/boss-accept'] = 'Json/money_request_boss_accept';
$route['json/advance-money-request/boss-reject'] = 'Json/money_request_boss_reject';
$route['json/advance-money-request/self-accept'] = 'Json/money_request_self_accept';
$route['json/app-password-reset-otp/(:any)'] = 'Json/app_password_reset_otp/$1';
$route['json/app-password-reset'] = 'Json/app_password_reset';
$route['json/app-password-change'] = 'Json/app_password_change';
$route['json/employee-phone-search'] = 'Json/employee_phone_search';
$route['json/exit-employee-search'] = 'Json/exit_employee_search';
$route['json/salary-earned'] = 'Json/salary_earned';

// W/O authentication

$route['json/qr-code/(:any)'] = 'Json/get_qr_code/$1';
$route['json/qr-branches'] = 'Json/qr_branches';

//Communicate
$route['admin/communicate/send-sms'] = 'Communicate/send_sms';

//Reports
$route['admin/scm/employee-review'] = 'Reports/employee_review';
$route['admin/scm/employee-review-show/(:any)/(:any)'] = 'Reports/employee_review_show/$1/$2';
$route['admin/scm/detailed-review/(:any)'] = 'Reports/detailed_review/$1';

$route['admin/report/booking-report'] = 'Reports/booking_report';
$route['admin/report/checkin-today'] = 'Reports/checkin_today';
$route['admin/report/checkout-today'] = 'Reports/checkout_today';
$route['admin/report/rental-report'] = 'Reports/rental_report';
$route['admin/report/renew-report'] = 'Reports/renew_report';
$route['admin/report/ipo-payment-report'] = 'Reports/ipo_payment_report';

$route['admin/report/crm-report/checkout-member-list'] = 'Accounting/checkout_member_list_member';
$route['admin/accounting/transaction/checkout-old-member-list'] = 'Accounting/checkout_old_member_list_member';
$route['admin/accounting/transaction/checkout-old-member-list/insert'] = 'Accounting/checkout_old_member_list_member_insert';
$route['admin/accounting/transaction/checkout-old-paymetnt/insert'] = 'Accounting/checkout_old_member_list_member_payment_insert';

$route['admin/report/crm-report/refunded-member-list'] = 'Accounting/refunded_member_list';
$route['admin/report/crm-report/occupide-member-list'] = 'Reports/occupide_member_list';
$route['admin/report/crm-report/live-request-for-cancel-member-list'] = 'Reports/live_request_for_cancel_member_list';
$route['admin/report/crm-report/live-booked-member-list'] = 'Reports/live_booked_member_list';
$route['admin/report/crm-report/custom-report'] = 'Reports/custom_report';


$route['admin/report/hrm-report/employee-wallet-report'] = 'Reports/hrm_employee_wallet_report';

$route['admin/hrm/report/increament-report'] = 'Reports/hrm_report_increament_report';
$route['admin/hrm/report/increament-report/(:any)'] = 'Reports/hrm_report_increament_report/$1';
$route['admin/hrm/report/decreament-report'] = 'Reports/hrm_report_decreament_report';

$route['admin/report/electrict-bill-report'] = 'Reports/electricity_bill_report';
$route['admin/report/security-deposit-report'] = 'Reports/security_deposit_report';
$route['admin/report/security-deposit-report-debit-credit'] = 'Reports/security_deposit_report_debit_credit';


$route['admin/report/cancel-reminder'] = 'Reports/cancel_reminder';
$route['admin/report/panalty-report'] = 'Reports/panalty_report';

$route['admin/report/request-cancel-report'] = 'Reports/request_cancel_report';
$route['admin/report/auto-cancel-report'] = 'Reports/auto_cancel_report';
$route['admin/report/force-cancel-report'] = 'Reports/force_cancel_report';
$route['admin/report/salf-cancel-report'] = 'Reports/salf_cancel_report';

$route['admin/report/package-change-report'] = 'Reports/package_change_report';
$route['admin/report/bed-change-report'] = 'Reports/bed_change_report';
$route['admin/report/today-collection-report'] = 'Reports/today_collection_report';
$route['admin/report/discount-report'] = 'Reports/discount_report';
$route['admin/report/payment-report'] = 'Reports/payment_report';
$route['admin/report/all-collection-report'] = 'Reports/all_collection_report';
$route['admin/report/bkash-report'] = 'Reports/bkash_report';
$route['admin/report/duplicate-beds-report'] = 'Reports/duplicate_beds_report';
$route['seat_wise_occupency'] = 'Reports/seat_wise_occupency';


$route['admin/report/details-collection-report'] = 'Reports/details_collection_report';
$route['admin/report/branch-revenue'] = 'Reports/branch_revenue_report';


$route['admin/report/shop-report'] = 'Reports/shop_report';
$route['admin/report/dining-report'] = 'Reports/dining_report';
$route['admin/report/visitor-book-report'] = 'Reports/visitor_book_report';

$route['admin/report/communication/auto-sms-logs'] = 'Reports/communication_auto_sms_logs';
$route['admin/report/communication/member-corn-jobs'] = 'Reports/communication_member_corn_jobs';
$route['admin/report/communication/investor-corn-jobs'] = 'Reports/communication_investor_corn_jobs';
$route['admin/report/communication/demo-investor-corn-jobs'] = 'Reports/communication_demo_investor_corn_jobs';

$route['admin/accounting/accounts/account-report/employee-award-insert-logs'] = 'Reports/account_employee_award_insert_logs';

$route['admin/report/tracing-report/all-employee-secreenshot'] = 'Reports/tracing_report_all_employee_secreenshot';
$route['admin/report/tracing-report/employee-login-info'] = 'Reports/tracing_report_employee_login_info';
$route['admin/report/tracing-report/member-login-info'] = 'Reports/tracing_report_member_login_info';


//Fornt Office
$route['admin/front-office/dining-table'] = 'Frontoffice/dining_table';
$route['package-plan'] = 'Frontoffice/package_plan';
$route['admin/front-office/refreshment-iteam'] = 'Frontoffice/refreshment_iteam';
$route['admin/front-office/instant-transaction/buy-something'] = 'Frontoffice/instant_transaction_buy_something';
$route['admin/front-office/instant-transaction/other-transaction'] = 'Frontoffice/instant_transaction_other_transaction';

$route['admin/profile/urgent-expense'] = 'Frontoffice/advance_transaction_buy_something';
$route['admin/profile/advance-money-request'] = 'Frontoffice/advance_money_request';
$route['admin/profile/petty-cash-request'] = 'Frontoffice/petty_cash_request';
$route['admin/profile/loan-money-request'] = 'Frontoffice/loan_money_request';
$route['admin/profile/attendance-adsjustment'] = 'Frontoffice/attendance_adsjustment';
$route['admin/hrm/payroll/missing-attendence-request-logs-hr'] = 'Frontoffice/missing_attendence_request_logs_hr';
$route['admin/profile/attendance-adsjustment-boss-aproval'] = 'Frontoffice/attendance_adsjustment_boss_aproval';

$route['admin/front-office/front-office-setup'] = 'Frontoffice/front_office_setup';
$route['admin/front-office/booking-enquery'] = 'Frontoffice/booking_enquery';
$route['admin/front-office/add-food-menu'] = 'Frontoffice/add_food_menu';
$route['admin/front-office/manage-food-menu'] = 'Frontoffice/manage_food_menu';
$route['admin/front-office/manage-food-menu/menu-delete'] = 'Frontoffice/menu_delete';
$route['admin/front-office/manage-food-menu/menu-update'] = 'Frontoffice/menu_update';
$route['admin/front-office/add-feedback-emoji'] = 'Frontoffice/add_feedback_emoji';
$route['admin/front-office/manage-feedback-emoji'] = 'Frontoffice/manage_feedback_emoji';
$route['member-food-feedback'] = 'Frontoffice/food_feedback_page';

$route['pre-book-and-pre-booking-form'] = 'Frontoffice/pre_book_and_pre_booking_form';
$route['prebook'] = 'Frontoffice/pre_book_and_pre_booking_form';
$route['checkout-verify/(:any)'] = 'Frontoffice/checkout_verify/$1';

$route['front-office/visitor-book/visitor-book'] = 'Frontoffice/visitor_book';


$route['employee-information-form/new-employee-details-form'] = 'Frontoffice/new_employee_details_form';

$route['admin/front-office/video-music-player'] = 'Frontoffice/front_office_music_player';
$route['admin/front-office/audio-music-player'] = 'Frontoffice/front_office_audio_music_player';


//Fornt End
$route['admin/front-end/static-page/terms-condition'] = 'FrontEnd/terms_condition';
$route['admin/front-end/static-page/trems-and-condition-ipo-referal-approval'] = 'FrontEnd/trems_and_condition_ipo_referal_approval';


//Dining Table food check panel
$route['dining-table/member-status-check/(:any)/(:any)'] = 'Dining/member_card_check/$1/$2';
$route['dining-table/front-door-lock/(:any)/(:any)'] = 'Dining/front_door_lock/$1/$2';
$route['old-data/old-member-directory'] = 'Dining/old_member_directory';
$route['Priority-Form'] = 'Dining/priority_form';

//QR CODE
$route['member-booking-information/qr-code/(:any)'] = 'QrcodeScanner/member_booking_information/$1';
$route['member-rental-information/qr-code/(:any)'] = 'QrcodeScanner/member_rental_information/$1';
$route['ipo-member-information/qr-code/(:any)/(:any)'] = 'QrcodeScanner/ipo_information/$1/$2';
$route['employee-rating/qr-code/(:any)'] = 'QrcodeScanner/employee_rating/$1';


// SCM
$route['admin/scm/product-category'] = 'Scm/product_category_view';
$route['admin/scm/product-category/insert'] = 'Scm/insert';
$route['admin/scm/product-category/update'] = 'Scm/update';
$route['admin/scm/product-category/delete'] = 'Scm/delete';

$route['admin/scm/product-brands'] = 'Scm/product_brand_view';
$route['admin/scm/product-brands/brand-insert'] = 'Scm/brand_insert';
$route['admin/scm/product-brands/brand-update'] = 'Scm/brand_update';
$route['admin/scm/product-brands/brand-delete'] = 'Scm/brand_delete';

//buliding Information

$route['admin/add_building_info']   = 'building_controller/add_building_info';
$route['admin/insert_building_info'] = 'building_controller/insert_building_info';
$route['admin/all_building_info'] = 'building_controller/all_building_info';
$route['admin/edit_building/(:any)'] = 'building_controller/edit_building/$1';
$route['admin/delete_building_image/(:any)'] = 'building_controller/delete_building_image/$1';
$route['admin/update_building_info'] = 'building_controller/update_building_info';
$route['admin/print_building/(:any)'] = 'building_controller/print_building/$1';
$route['admin/hrm/add_circular'] = 'Hrm/add_circular';
$route['admin/hrm/all_circular'] = 'Hrm/all_circular';
$route['admin/hrm/insert_circular'] = 'Hrm/insert_circular';
$route['admin/hrm/edit_circular/(:any)'] = 'Hrm/edit_circular/$1';
$route['admin/hrm/update_circular'] = 'Hrm/update_circular';
$route['admin/hrm/delete_circular/(:any)'] = 'Hrm/delete_circular/$1';
$route['admin/hrm/candidate_details/(:any)'] = 'Hrm/candidate_details/$1';
$route['admin/make_short'] = 'Hrm/make_short';
$route['admin/make_interview'] = 'Hrm/make_interview';
$route['admin/save_remark/(:any)'] = 'Hrm/save_remark/$1';

$route['admin/make_final_interview'] = 'Hrm/make_final_interview';
$route['admin/back_primary/(:any)'] = 'Hrm/back_primary/$1';
$route['admin/make_observation'] = 'Hrm/make_observation';
$route['admin/make_final'] = 'Hrm/make_final';

$route['admin/scm/product-category/add-configuration'] = 'Scm/add_configuration';

$route['admin/scm/product-type'] = 'Scm/product_type_view';
$route['admin/scm/product-type/scale-insert'] = 'Scm/scale_insert';
$route['admin/scm/product-type/scale-update'] = 'Scm/scale_update';
$route['admin/scm/product-type/scale-delete'] = 'Scm/scale_delete';
$route['admin/scm/product-type/type-insert'] = 'Scm/type_insert';
$route['admin/scm/product-type/type-update'] = 'Scm/type_update';
$route['admin/scm/product-type/type-delete'] = 'Scm/type_delete';

$route['admin/scm/product-type/extra-specification'] = 'Scm/extra_specification_view';
$route['admin/scm/product-type/extra-specification-insert'] = 'Scm/extra_specification_insert';
$route['admin/scm/product-type/extra-specification-update'] = 'Scm/extra_specification_update';
$route['admin/scm/product-type/extra-specification-delete'] = 'Scm/extra_specification_delete';
$route['admin/scm/product-type/product-unit-insert'] = 'Scm/product_unit_insert';
$route['admin/scm/product-type/product-unit-update'] = 'Scm/product_unit_update';
$route['admin/scm/product-type/product-unit-delete'] = 'Scm/product_unit_delete';

$route['admin/scm/add-product'] = 'Scm/add_product_view';
$route['admin/scm/add-product/insert'] = 'Scm/add_product_insert';
$route['admin/scm/add-product/delete'] = 'Scm/add_product_delete';

$route['admin/scm/edit-product/(:any)'] = 'Scm/edit_product_view/$1';

$route['admin/scm/products-list'] = 'Scm/products_list';
$route['admin/scm/item-stock-managemet'] = 'Scm/item_stock_management';
$route['admin/scm/product-requisition/requisition-type'] = 'Scm/product_requisition_type';
$route['admin/scm/product-requisition/requisition-type/(:any)'] = 'Scm/product_requisition_type/$1';
$route['admin/scm/product-requisition/(:any)'] = 'Scm/product_requisition/$1';
$route['admin/scm/product-requisition/(:any)/(:any)'] = 'Scm/product_requisition/$1/$2';
$route['admin/scm/clear-cart'] = 'Scm/clear_cart';
$route['admin/scm/confirm-product-requisition'] = 'Scm/confirm_product_requisition';
$route['admin/scm/update-product-name-image'] = 'Scm/update_product_name_image';


$route['admin/scm/confirm-product-pre-purchase'] = 'Scm/confirm_product_pre_purchase';
$route['admin/scm/manage-product-purchase'] = 'Scm/manage_product_purchase';
$route['admin/scm/manage-product-purchase/add-vendor'] = 'Scm/add_vendor';
$route['admin/scm/manage-product-purchase/add-vendor-food'] = 'Scm/add_vendor_food';

$route['admin/scm/manage-product-order'] = 'Scm/manage_product_order';
$route['admin/scm/manage-food-product-order'] = 'Scm/manage_food_order';

$route['admin/scm/manage-supplier'] = 'Scm/view_supplier';
$route['admin/scm/manage-supplier/insert'] = 'Scm/insert_supplier';
$route['admin/scm/manage-supplier/delete'] = 'Scm/delete_supplier';

$route['admin/scm/warehouses'] = 'Scm/warehouses';
$route['admin/scm/warehouses/insert'] = 'Scm/insert_warehouses';
$route['admin/scm/warehouse-stock'] = 'Scm/warehouse_stock';

$route['admin/scm/requisitions'] = 'Scm/view_requisitions';
$route['admin/scm/department-requisitions'] = 'Scm/view_department_requisitions';
$route['admin/scm/manage-requisitions/(:any)'] = 'Scm/manage_requisitions/$1';

$route['admin/scm/warehouse-manual-assign'] = 'Scm/manual_assign';

$route['admin/scm/department-send-product'] = 'Scm/department_send_product';

$route['admin/scm/department-product-stock'] = 'Scm/department_product_stock';
$route['admin/scm/department-product-transfer'] = 'Scm/department_product_transfer';
$route['admin/scm/department-product-status'] = 'Scm/department_product_status';

$route['admin/scm/service-product'] = 'Scm/service_product';
$route['admin/scm/service-product/insert'] = 'Scm/service_product_insert';
$route['admin/scm/manage-assigned-services'] = 'Scm/manage_assigned_service_product';
$route['admin/scm/service-requisition'] = 'Scm/service_requisition';
$route['admin/scm/service-requisition-approval'] = 'Scm/service_requisition_approval';
$route['admin/scm/service-requeset'] = 'Scm/service_request';
$route['admin/scm/service-requeset/remove'] = 'Scm/service_request_remove';

$route['admin/scm/other-department-requisition'] = 'Scm/other_department_requisition';
$route['admin/scm/manage-other-department-requisition'] = 'Scm/manage_other_department_requisition';

$route['admin/scm/manage-damaged-product'] = 'Scm/manage_damaged_product';



$route['404_override'] = 'Dashboard/charsochar_error';
$route['translate_uri_dashes'] = FALSE;



// Member Sesction
$route['member'] = 'Memmber_Controller';
$route['member/login'] = 'Memmber_Controller/login';
$route['member/logout'] = 'Memmber_Controller/logout';
$route['member/forgot-password'] = 'Memmber_Controller/forgot_password';

$route['member/change-password'] = 'Memmber_Controller/change_password';
$route['member/request-for-cancel'] = 'Memmber_Controller/request_for_cancel';
$route['member/widthdraw-cancel-request'] = 'Memmber_Controller/widthdraw_cancel_request';
$route['member/get-free-award'] = 'Memmber_Controller/get_free_award';

$route['member/view-profile'] = 'Memmber_Controller/view_profile';

$route['member/tea-coffee/(:any)/(:any)/(:any)'] = 'Memmber_Controller/tea_coffee/$1/$2/$3';


$route['admin/hrm/recruitment/add_department'] = 'Hrm/add_department';
$route['admin/hrm/recruitment/insert_department'] = 'Hrm/insert_department';

$route['admin/hrm/add_circular'] = 'Hrm/add_circular';
$route['admin/hrm/all_circular'] = 'Hrm/all_circular';
$route['admin/hrm/insert_circular'] = 'Hrm/insert_circular';
$route['admin/hrm/edit_circular/(:any)'] = 'Hrm/edit_circular/$1';
$route['admin/hrm/update_circular'] = 'Hrm/update_circular';
$route['admin/hrm/delete_circular/(:any)'] = 'Hrm/delete_circular/$1';





$route['admin/demo_notification'] = 'Hrm/demo_notificaiton';
$route['contacts'] = 'Dashboard/contacts';
$route['refreshment_items'] = 'Dashboard/refreshment_items';
$route['package_wise_member_occupation_count'] = 'Dashboard/package_wise_member_occupation_count';
$route['package_wise_member_occupation_count_daily'] = 'Dashboard/package_wise_member_occupation_count_daily';
$route['daily_occupied_report'] = 'Dashboard/daily_occupied_report';
$route['every_branch_at_a_time_occupied_report'] = 'Dashboard/every_branch_at_a_time_occupied_report';
$route['daily_renew_monthly_report'] = 'Dashboard/daily_renew_monthly_report';


$route['restrat_gate'] = 'Dashboard/restart_gate';
$route['test'] = 'Dashboard/test';


//My Sorry code....
$route['admin/create/complain/complain-category'] = 'Service_review/complain_category';
$route['admin/create/complain/complain-list'] = 'Service_review/complain_list';
$route['admin/create/complain/complain-lists'] = 'Service_review/complain_list_without_action';
$route['admin/create/complain/get_start_time'] = 'Service_review/get_start_time';
$route['admin/create/complain/complain-details'] = 'Service_review/complain_details';
$route['complain-submit'] = 'Service_review/complain_submit';
$route['admin/create/complain/check-member'] = 'Service_review/check_member';
$route['admin/anyversary_report'] = 'Anyversary/anyversary_report';
$route['admin/anyversary_date'] = 'Anyversary/anyversary_date_wise_report';
$route['admin/anniversary_member_profile'] = 'Anyversary/anniversary_member_profile';
$route['admin/anniversary_date_range'] = 'Anyversary/anniversary_date_range';
$route['admin/hrm/document-managment'] = 'Hrm/document_managment';
$route['admin/hrm/document_log'] = 'Hrm/document_log';
$route['admin/hrm/document_image'] = 'Hrm/document_image';
$route['admin/hrm/log_img'] = 'Hrm/log_img';
$route['admin/hrm/award/employee-festival-bonus']  = 'Hrm/employee_festival_bonus';
$route['admin/hrm/award/download-employee-festival-bonus']  = 'Hrm/download_employee_festival_bonus';
$route['admin/hrm/award/employee-festival-bonus-show']  = 'Hrm/employee_festival_bonus_show';
$route['admin/download/contacts']  = 'Service_review/contacts_download';

//miscellaneous routes.
$route['admin/download_all'] = 'Booking/download_all';
$route['admin/profile/attendance-adsjustment-delete/(:any)'] = 'Frontoffice/attendance_adsjustment_delete/$1';
$route['admin/profile/attendance-adsjustment-boss-aproval-delete/(:any)'] = 'Frontoffice/attendance_adsjustment_boss_aproval_delete/$1';
$route['admin/hrm/payroll/missing-attendence-request-logs-hr-delete/(:any)'] = 'Frontoffice/missing_attendence_request_logs_hr_delete/$1';
$route['admin/pre-book-member-directory-search'] = 'Booking/pre_book_member_directory_search';
$route['admin/pre-book-member-directory-search-ajax']  = 'Booking/pre_book_member_directory_search_ajax';
$route['admin/pre-book-member-directory-change-branch']  = 'Booking/pre_book_member_directory_change_branch';



//API's
$route['api/complain_category'] = 'Json/complain_category';
$route['api/member_number'] = 'Json/member_number';
$route['api/inquery_submit'] = 'Json/inquery_submit';
$route['api/store_complain_db'] = 'Json/store_complain_db';
$route['api/onesignal_api'] = 'Json/onesignal_api';
$route['api/get_department_ids'] = 'Json/get_department_ids';
$route['api/document_expiry_notification'] = 'Json/document_expiry_notification';
$route['api/send_notification_to_all'] = 'Json/send_notification_to_all';
$route['json/expense_type'] = 'Json/expense_type';
$route['json/api/advance_transaction_buy_something'] = 'Json/advance_transaction_buy_something';
$route['json/api/check_parking'] = 'Json/check_parking';
$route['json/api/parking-in-out'] = 'Json/parking_in_out';
//End of the world of my Sorry code....

// Task list routes.
$route['admin/s_it/tasks'] = 'Task_list/Task_list_control';
$route['admin/s_it/task-detail'] = 'Task_list/Task_detail_control';

// accounts route.
$route['admin/manage-expense'] = 'Accounts/manage_expense';
$route['admin/view-expenses'] = 'Accounts/view_expenses';
$route['admin/tax-discount'] = 'Accounts/tax_discount';
$route['admin/general-expense-approval'] = 'Accounts/general_exp_approval';
